<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AutoCloneVietStock extends Command
{
    protected $signature = 'app:auto-clone-vietstock';
    protected $description = 'Automatically clone VietStock data';

    private $postsToInsert = [];
    private $existingSlugs = null;

    public function handle()
    {
        // Lấy danh sách slugs một lần duy nhất và chuyển thành hash map để tìm kiếm nhanh hơn
        $slugs = $this->getRecentPostSlugs();
        $this->existingSlugs = array_flip($slugs);
        
        $this->processTinMoi();
        $this->processCategories();
        
        // Insert tất cả posts cùng lúc
        $this->batchInsertPosts();
        
        $this->deletePostOld();
    }

    private function processCategories()
    {
        $categories = Category::query()->whereNotNull('parent_id')->get();
        foreach ($categories as $category) {
            $this->processCategoryPosts($category);
        }
    }

    private function processCategoryPosts(Category $category)
    {
        try {
            $rssContent = $this->fetchRssContent($category->rss_url);

            if (!$rssContent) {
                Log::info('Invalid RSS content for category: ' . $category->id);
                return;
            }

            $rss = simplexml_load_string($rssContent, 'SimpleXMLElement', LIBXML_NOCDATA);
            foreach ($rss->channel->item as $item) {
                $slug = $this->generateSlug((string) $item->title);
                if (!isset($this->existingSlugs[$slug])) {
                    $content = $this->fetchDetailContent((string) $item->link);
                    if ($content) {
                        $item->hot = 0;
                        $this->preparePostData($category->id, $item, $slug, $content);
                    }
                }
            }
        } catch (\Exception $exception) {
            Log::error('Error processing category posts: ' . $exception->getMessage());
        }
    }

    private function fetchRssContent($url)
    {
        $response = Http::get($url);
        $content = $response->body();
        return str_starts_with(trim($content), '<?xml') ? $content : null;
    }

    private function generateSlug($title)
    {
        return Str::slug($title) . '-' . time();
    }

    private function preparePostData($categoryId, $item, $slug, $content)
    {
        $now = now();
        $this->postsToInsert[] = [
            'title' => property_exists($item, 'title') ? (string) $item->title : 'No Title',
            'slug' => $slug,
            'description' => property_exists($item, 'description') ? strip_tags((string) $item->description) : '',
            'content' => $content,
            'feture' => property_exists($item, 'feture') ? $item->feture : (property_exists($item, 'description') ? $this->extractImage((string) $item->description) : null),
            'post_type' => 'text',
            'hot' => property_exists($item, 'hot') ? $item->hot : 0,
            'status' => 1,
            'user_id' => 1,
            'category_id' => $categoryId,
            'view' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ];
        
        // Thêm slug vào danh sách để tránh trùng lặp trong cùng một lần chạy
        $this->existingSlugs[$slug] = true;
    }

    private function batchInsertPosts()
    {
        if (empty($this->postsToInsert)) {
            return;
        }

        try {
            // Chia nhỏ thành các batch để tránh query quá lớn
            $chunks = array_chunk($this->postsToInsert, 100);
            foreach ($chunks as $chunk) {
                DB::table('posts')->insert($chunk);
            }
            
            $this->info('Đã insert ' . count($this->postsToInsert) . ' posts thành công.');
            $this->postsToInsert = [];
        } catch (\Exception $exception) {
            Log::error('Error batch inserting posts: ' . $exception->getMessage());
        }
    }

    private function getRecentPostSlugs()
    {
        return Post::query()
            ->where('created_at', '>=', now()->subDays(2))
            ->pluck('slug')
            ->toArray();
    }

    private function extractImage($description)
    {
        preg_match('/<img[^>]+src=["\']([^"\']+)["\']/', $description, $matches);
        return $matches[1] ?? null;
    }

    private function fetchDetailContent($url)
    {
        try {
            $html = $this->fetchHtml($url);
            $dom = $this->createDomDocument($html);
            $contentNode = $this->getContentNode($dom);

            if (!$contentNode) {
                return 'Content not found';
            }

            $this->removeUnwantedTags($contentNode, ['script', 'style']);
            $this->removeUnwantedClasses($dom, $contentNode, ['source', 'pSource', 'pAuthor','pPublishTimeSource']);

            $cleanText = $dom->saveHTML($contentNode);
            return str_replace('Vietstock', 'Chúng tôi', $cleanText);
        } catch (\Exception $exception) {
            Log::error('Error fetching detail content: ' . $exception->getMessage());
            return null;
        }
    }

    private function fetchHtml($url)
    {
        $options = [
            "http" => [
                "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64)\r\n"
            ]
        ];
        $context = stream_context_create($options);
        return file_get_contents($url, false, $context);
    }

    private function createDomDocument($html)
    {
        libxml_use_internal_errors(true);
        $dom = new \DOMDocument();
        $dom->loadHTML($html, LIBXML_NOERROR);
        libxml_clear_errors();
        return $dom;
    }

    private function getContentNode($dom)
    {
        $xpath = new \DOMXPath($dom);
        $contentNodeList = $xpath->query("//*[contains(@id, 'vst_detail')]");
        return $contentNodeList->length > 0 ? $contentNodeList->item(0) : null;
    }

    private function removeUnwantedTags($node, $tags)
    {
        foreach ($tags as $tag) {
            $elements = $node->getElementsByTagName($tag);
            for ($i = $elements->length - 1; $i >= 0; $i--) {
                $elements->item($i)->parentNode->removeChild($elements->item($i));
            }
        }
    }

    private function removeUnwantedClasses($dom, $node, $classes)
    {
        $xpath = new \DOMXPath($dom);
        foreach ($classes as $class) {
            $nodes = $xpath->query(".//*[contains(@class, '$class')]", $node);
            foreach ($nodes as $n) {
                $n->parentNode->removeChild($n);
            }
        }
    }

    private function processTinMoi()
    {
        $paginate = ['item' => 30, 'row' => 1];
        $response = Http::post('https://vietstock.vn/_Partials/NewsNewUpdatePaging', $paginate);
        $categoryTinMoi = Category::query()->where('slug', 'tin-moi')->first();

        if (!$categoryTinMoi) {
            return;
        }

        if ($response->json()['Data']) {
            foreach ($response->json()['Data'] as $newHot) {
                $slug = $this->generateSlug($newHot['Title']);
                if (!isset($this->existingSlugs[$slug])) {
                    $cleanedContent = preg_replace('/<p\s+class="p(?:Title|Head)">.*?<\/p>\s*/is', '', $newHot['Content']);
                    $newHot['description'] =  $newHot['Head'];
                    $newHot['feture'] =  $newHot['HeadImageUrl'];
                    $newHot['title'] =  $newHot['Title'];
                    $newHot['hot'] =  1;
                    $this->preparePostData($categoryTinMoi->id, (object) $newHot, $slug, $cleanedContent);
                }
            }
        }
    }

    private function deletePostOld()
    {
        Post::query()->where('created_at', '<', now()->subDays(5))->delete();
    }
}
