<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AutoCloneVietStock extends Command
{
    protected $signature = 'app:auto-clone-vietstock';
    protected $description = 'Automatically clone VietStock data';

    public function handle()
    {
        $this->processTinMoi();
        $this->processCategories();
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
            $existingSlugs = $this->getRecentPostSlugs();
            $rssContent = $this->fetchRssContent($category->rss_url);

            if (!$rssContent) {
                Log::info('Invalid RSS content for category: ' . $category->id);
                return;
            }

            $rss = simplexml_load_string($rssContent, 'SimpleXMLElement', LIBXML_NOCDATA);
            foreach ($rss->channel->item as $item) {
                $slug = $this->generateSlug((string) $item->title);
                if (!in_array($slug, $existingSlugs)) {
                    $content = $this->fetchDetailContent((string) $item->link);
                    if ($content) {
                        $this->createPost($category->id, $item, $slug, $content);
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

    private function createPost($categoryId, $item, $slug, $content)
    {
        try {
            Post::create([
                'title' => property_exists($item, 'title') ? (string) $item->title : 'No Title',
                'link' => property_exists($item, 'link') ? (string) $item->link : '',
                'slug' => $slug,
                'description' => property_exists($item, 'description') ? strip_tags((string) $item->description) : '',
                'content' => $content,
                'feture' => property_exists($item, 'feture') ? $item->feture : (property_exists($item, 'description') ? $this->extractImage((string) $item->description) : null),
                'post_type' => 'text',
                'hot' => 0,
                'status' => 1,
                'user_id' => 1,
                'category_id' => $categoryId,
            ]);
        } catch (\Exception $exception) {
            dd($exception, $item);
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
        $existingSlugs = $this->getRecentPostSlugs();

        if ($response->json()['Data']) {
            foreach ($response->json()['Data'] as $newHot) {
                $slug = $this->generateSlug($newHot['Title']);
                if (!in_array($slug, $existingSlugs)) {
                    $cleanedContent = preg_replace('/<p\s+class="p(?:Title|Head)">.*?<\/p>\s*/is', '', $newHot['Content']);
                    $newHot['description'] =  $newHot['Head'];
                    $newHot['feture'] =  $newHot['HeadImageUrl'];
                    $newHot['title'] =  $newHot['Title'];
                    $this->createPost($categoryTinMoi->id, (object) $newHot, $slug, $cleanedContent);
                }
            }
        }
    }
}
