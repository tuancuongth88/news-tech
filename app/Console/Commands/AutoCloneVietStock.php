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
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:auto-clone-cafebiz';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
//        $data = $this->getDetailContent('https://cafebiz.vn/dong-thai-la-cua-ngan-collagen-sau-khi-bi-yeu-cau-kiem-tra-lat-lai-hoat-dong-kinh-doanh-moi-giat-minh-17625052616181738.chn');
//        $data = $this->getDetailContent('http://vietstock.vn/2025/06/ngay-19062025-10-co-phieu-nong-duoi-goc-nhin-ptkt-cua-vietstock-585-1319362.htm');
//        $data = nl2br($data); // Chuyển đổi ký tự xuống dòng thành <br> để hiển thị trong HTML
//        dd($data);
        $this->getTinMoi();
        $this->getListCategory();
    }

    public function getListCategory()
    {
        $categories = Category::query()->whereNotNull('parent_id')->get();
        foreach ($categories as $category) {
            $this->getDescriptionCategory($category);
        }
    }

    private function getDescriptionCategory(Category $category)
    {
        try{
            $listPost = $this->getListPostByCategory($category);
            $response = Http::get($category->rss_url);
            $content = $response->body();
            if (!str_starts_with(trim($content), '<?xml')) {
                Log::info('Not a valid XML content'. substr($content, 0, 500)); // xem nội dung đầu tiên
            }
            // Parse RSS
            $rss = simplexml_load_string($content, 'SimpleXMLElement', LIBXML_NOCDATA);
            foreach ($rss->channel->item as $item) {
                $slug = $category->id.'-'.Str::slug((string) $item->title);
                $content = $this->getDetailContent($item->link);
                if (!in_array($slug, $listPost) && !empty($content)) {
                    $items = [
                        'title' => (string) $item->title,
                        'link' => (string) $item->link,
                        'slug' => $slug,
                        'description' => strip_tags((string) $item->description),
                        'content' => $this->getDetailContent($item->link),
                        'feture' => $this->extractImage((string) $item->description),
                        'post_type' => 'text',
                        'hot' => 0,
                        'status' => 1,
                        'user_id' => 1,
                        'category_id' => $category->id,
                    ];
                    Post::create($items);
                }
            }
        }catch (\Exception $exception){
            dd($exception);
        }
    }

    private function getListPostByCategory(Category $category)
    {
        $listPost = Post::query()
            ->where('category_id', $category->id)
            ->where('created_at', '>=', now()->subDays(2)) // Lấy bài viết trong 2 ngày qua
            ->select('id', 'title', 'slug')
            ->get()->pluck('slug')->toArray();
        return $listPost;
    }

    private function extractImage($description)
    {
        // Trích xuất URL ảnh từ chuỗi HTML trong CDATA
        preg_match('/<img[^>]+src=["\']([^"\']+)["\']/', $description, $matches);
        return $matches[1] ?? null;
    }

    public function getDetailContent($url) {
        try {
            // Bước 1: Lấy HTML
            $options = [
                "http" => [
                    "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64)\r\n"
                ]
            ];
            $context = stream_context_create($options);
            $html = file_get_contents($url, false, $context);
            // Bước 2: Tạo DOM
            libxml_use_internal_errors(true);
            $dom = new \DOMDocument();
            $dom->loadHTML($html, LIBXML_NOERROR);
            libxml_clear_errors();

            // Bước 3: Tìm nội dung chính
            $xpath = new \DOMXPath($dom);
            $contentNodeList = $xpath->query("//*[contains(@id, 'vst_detail')]");
            if ($contentNodeList->length === 0) {
                return 'Không tìm thấy nội dung';
            }
            $contentNode = $contentNodeList->item(0);

            // Bước 4: Xoá <script>, <style>
            foreach (['script', 'style'] as $tag) {
                $tags = $contentNode->getElementsByTagName($tag);
                for ($i = $tags->length - 1; $i >= 0; $i--) {
                    $tags->item($i)->parentNode->removeChild($tags->item($i));
                }
            }
            // ❌ Xoá phần tử có class 'source'
            $sourceNodes = (new \DOMXPath($dom))->query(".//*[contains(@class, 'source')]", $contentNode);
            foreach ($sourceNodes as $node) {
                $node->parentNode->removeChild($node);
            }
            $cleanText = $dom->saveHTML($contentNode);
//        // Bước 5: Xoá mọi attribute như class, style, onclick...
//        $removeAttributes = function ($node) use (&$removeAttributes) {
//            if ($node->hasAttributes()) {
//                while ($node->attributes->length) {
//                    $node->removeAttributeNode($node->attributes->item(0));
//                }
//            }
//            if ($node->hasChildNodes()) {
//                foreach ($node->childNodes as $child) {
//                    if ($child instanceof \DOMElement) {
//                        $removeAttributes($child);
//                    }
//                }
//            }
//        };
//        $removeAttributes($contentNode);
//
//        // Bước 6: Lấy HTML sạch
//        $cleanHtml = $dom->saveHTML($contentNode);
//
//        // Bước 7: Làm sạch nội dung dạng chuỗi
//        $cleanText = strip_tags($cleanHtml); // bỏ mọi thẻ HTML
//        $cleanText = html_entity_decode($cleanText); // decode HTML entity
//        $cleanText = preg_replace('/[\x{A0}\s]+/u', ' ', $cleanText); // loại bỏ nhiều khoảng trắng & NBSP
//        $cleanText = preg_replace("/\n{2,}/", "\n", $cleanText); // xóa dòng trống thừa
//        $cleanText = trim($cleanText); // trim đầu đuôi
//          $cleanText = preg_replace('/<a\s+href="[^"]*">(.*?)<\/a>/i', '$1', $html);
          $cleanText = str_replace('Vietstock', 'Chúng tôi', $cleanText); // thay thế từ khóa
            return $cleanText;
        }catch (\Exception $exception) {
            $this->getDetailContent($url);
        }
    }

    public function getTinMoi()
    {
        $paginate = [
            'item' => 30,
            'row' => 1
        ];
        $data = Http::post('https://vietstock.vn/_Partials/NewsNewUpdatePaging', $paginate);
        $categoryTinMoi = Category::query()->where('slug', 'tin-moi')->first();
        $listPost = $this->getListPostByCategory($categoryTinMoi);
        if ($data->json()['Data']){
            foreach ($data->json()['Data'] as $newHot){
                $slug = $categoryTinMoi->id.'-'.Str::slug($newHot['Title']);
                if (!in_array($slug, $listPost)) {
                    $cleaned = preg_replace('/<p\s+class="p(?:Title|Head)">.*?<\/p>\s*/is', '', $newHot['Content']);
                    $items = [
                        'title' => (string) $newHot['Title'],
                        'slug' => $slug,
                        'description' => $newHot['Head'],
                        'content' => $cleaned,
                        'feture' => $newHot['HeadImageUrl'],
                        'post_type' => 'text',
                        'hot' => 1,
                        'status' => 1,
                        'user_id' => 1,
                        'category_id' => $categoryTinMoi->id,
                    ];
                    Post::create($items);
                }
            }
        }
    }

}
