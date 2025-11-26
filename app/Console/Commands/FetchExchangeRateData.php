<?php

namespace App\Console\Commands;

use App\Models\ExchangeRate;
use App\Models\GoldRate;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class FetchExchangeRateData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-exchange-rate-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch exchange rates and gold rates';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->fetchExchangeRates();
        $this->fetchGoldRates();
        $this->info('Đã cập nhật tỷ giá ngoại tệ và vàng thành công!');
    }

    private function fetchExchangeRates()
    {
        try {
            // Lấy tỷ giá từ API BIDV
            $date = Carbon::now()->format('d/m/Y');
            $time = Carbon::now()->format('His'); // Format: HHmmss (ví dụ: 135050)
            
            // Sử dụng file_get_contents để tránh lỗi SSL
            $url = 'https://bidv.com.vn/ServicesBIDV/ExchangeDetailServlet?date=' . urlencode($date) . '&time=' . $time;
            
            $options = [
                "http" => [
                    "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36\r\n",
                    "timeout" => 10,
                    "ignore_errors" => true
                ],
                "ssl" => [
                    "verify_peer" => false,
                    "verify_peer_name" => false,
                    "allow_self_signed" => true
                ]
            ];
            
            $context = stream_context_create($options);
            $json = @file_get_contents($url, false, $context);
            
            if ($json === false) {
                throw new \Exception('Không thể kết nối đến API BIDV');
            }
            
            $data = json_decode($json, true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('Lỗi parse JSON: ' . json_last_error_msg());
            }
            
            // Cấu trúc dữ liệu từ BIDV:
            // data: mảng các loại tiền tệ
            // - currency: mã tiền tệ (USD, EUR, JPY, GBP)
            // - muaTm: giá mua tiền mặt
            // - muaCk: giá mua chuyển khoản
            // - ban: giá bán
            
            if (isset($data['data']) && is_array($data['data'])) {
                $now = Carbon::now();
                $currenciesMap = [
                    'USD' => 'USD',
                    'EUR' => 'EUR',
                    'JPY' => 'JPY',
                    'GBP' => 'GBP'
                ];
                
                foreach ($data['data'] as $item) {
                    $currencyCode = $item['currency'] ?? '';
                    
                    // Chỉ lấy các loại tiền cần thiết (USD, EUR, JPY, GBP)
                    if (isset($currenciesMap[$currencyCode])) {
                        // Parse giá từ string (ví dụ: "26,174" -> 26174)
                        $buyCash = $this->parseExchangeRate($item['muaTm'] ?? '-');
                        $buyTransfer = $this->parseExchangeRate($item['muaCk'] ?? '-');
                        $sell = $this->parseExchangeRate($item['ban'] ?? '-');
                        
                        // Sử dụng giá chuyển khoản nếu có, nếu không dùng giá tiền mặt
                        $buyRate = $buyTransfer > 0 ? $buyTransfer : $buyCash;
                        
                        // JPY được hiển thị với 2 chữ số thập phân (ví dụ: 165.8)
                        // Cần chuyển đổi sang format chuẩn
                        if ($currencyCode === 'JPY' && $buyRate > 0) {
                            // JPY từ BIDV đã là giá cho 100 JPY, giữ nguyên
                        } else {
                            // Các loại khác: chuyển từ format "26,174" sang số
                            $buyRate = $this->parseExchangeRate($item['muaCk'] ?? $item['muaTm'] ?? '0');
                        }
                        
                        if ($buyRate > 0 && $sell > 0) {
                            ExchangeRate::updateOrCreate(
                                ['currency_code' => $currencyCode],
                                [
                                    'currency_name' => $currenciesMap[$currencyCode],
                                    'buy_rate' => $buyRate,
                                    'sell_rate' => $sell,
                                    'transfer_rate' => $buyRate, // Giá chuyển khoản
                                    'updated_at' => $now,
                                    'created_at' => $now,
                                ]
                            );
                        }
                    }
                }
                
                $this->info('Đã cập nhật tỷ giá ngoại tệ từ BIDV');
                return;
            }
            
            // Fallback: Sử dụng giá mặc định nếu API không hoạt động
            $this->warn('Không thể lấy tỷ giá từ BIDV, sử dụng giá mặc định');
            $this->setDefaultExchangeRates();
        } catch (\Exception $e) {
            $this->error('Lỗi khi lấy tỷ giá ngoại tệ: ' . $e->getMessage());
            $this->setDefaultExchangeRates();
        }
    }

    /**
     * Parse tỷ giá từ string (ví dụ: "26,174" -> 26174 hoặc "165.8" -> 165.8)
     */
    private function parseExchangeRate($value)
    {
        if ($value === '-' || $value === '' || $value === null) {
            return 0;
        }
        
        // Loại bỏ dấu phẩy và chuyển sang số
        $value = str_replace(',', '', trim($value));
        return (float) $value;
    }

    private function setDefaultExchangeRates()
    {
        $now = Carbon::now();
        $defaultRates = [
            ['code' => 'USD', 'name' => 'USD', 'rate' => 24850],
            ['code' => 'EUR', 'name' => 'EUR', 'rate' => 26720],
            ['code' => 'JPY', 'name' => 'JPY', 'rate' => 165.25],
            ['code' => 'GBP', 'name' => 'GBP', 'rate' => 31450],
        ];
        
        foreach ($defaultRates as $rate) {
            ExchangeRate::updateOrCreate(
                ['currency_code' => $rate['code']],
                [
                    'currency_name' => $rate['name'],
                    'buy_rate' => round($rate['rate'] * 0.999, 2),
                    'sell_rate' => round($rate['rate'] * 1.001, 2),
                    'transfer_rate' => $rate['rate'],
                    'updated_at' => $now,
                    'created_at' => $now,
                ]
            );
        }
    }

    private function fetchGoldRates()
    {
        try {
            // Lấy giá vàng SJC từ API chính thức của BTMC (SJC)
            $goldData = $this->fetchGoldFromBTMCAPI();
            
            $now = Carbon::now();
            
            if ($goldData) {
                // Lưu giá vàng SJC cho Hà Nội và TP.HCM
                $locations = ['Hà Nội', 'TP.HCM'];
                
                foreach ($locations as $location) {
                    GoldRate::updateOrCreate(
                        [
                            'type' => 'SJC',
                            'location' => $location,
                        ],
                        [
                            'buy_rate' => $goldData['buy'],
                            'sell_rate' => $goldData['sell'],
                            'unit' => 'lượng',
                            'updated_at' => $now,
                            'created_at' => $now,
                        ]
                    );
                }
                
                $this->info('Đã cập nhật tỷ giá vàng SJC: Mua ' . number_format($goldData['buy'] / 1000000, 1) . ' triệu, Bán ' . number_format($goldData['sell'] / 1000000, 1) . ' triệu');
            } else {
                $this->warn('Không thể lấy giá vàng từ API, sử dụng giá mặc định');
                $this->setDefaultGoldRates();
            }
        } catch (\Exception $e) {
            $this->error('Lỗi khi lấy tỷ giá vàng: ' . $e->getMessage());
            $this->setDefaultGoldRates();
        }
    }

    private function fetchGoldFromBTMCAPI()
    {
        try {
            // API chính thức của BTMC (SJC) để lấy giá vàng
            // Key: 3kd8ub1llcg9t45hnoh8hmn7t5kc2v
            $response = Http::timeout(10)->get('http://api.btmc.vn/api/BTMCAPI/getpricebtmc?key=3kd8ub1llcg9t45hnoh8hmn7t5kc2v');
            
            if ($response->successful()) {
                $data = $response->json();
                
                // Cấu trúc dữ liệu:
                // @n_X: Tên giá vàng
                // @pb_X: Giá mua vào
                // @ps_X: Giá bán ra
                // @d_X: Thời gian nhập giá vàng
                
                if (isset($data['DataList']['Data']) && is_array($data['DataList']['Data'])) {
                    foreach ($data['DataList']['Data'] as $item) {
                        // Tìm item có chứa "VÀNG MIẾNG SJC"
                        foreach ($item as $key => $value) {
                            // Tìm key @n_X chứa "VÀNG MIẾNG SJC"
                            if (strpos($key, '@n_') === 0 && stripos($value, 'VÀNG MIẾNG SJC') !== false) {
                                // Lấy số thứ tự từ key (ví dụ: @n_7 -> 7)
                                $rowNum = str_replace('@n_', '', $key);
                                
                                // Lấy giá mua (@pb_X) và giá bán (@ps_X)
                                $buyKey = '@pb_' . $rowNum;
                                $sellKey = '@ps_' . $rowNum;
                                
                                if (isset($item[$buyKey]) && isset($item[$sellKey])) {
                                    $buyPrice = (int) $item[$buyKey];
                                    $sellPrice = (int) $item[$sellKey];
                                    
                                    // Giá vàng SJC thường từ 14-16 triệu/lượng (14.000.000 - 16.000.000)
                                    if ($buyPrice > 10000000 && $buyPrice < 20000000 && 
                                        $sellPrice > 10000000 && $sellPrice < 20000000 && 
                                        $sellPrice > $buyPrice) {
                                        return [
                                            'buy' => $buyPrice,
                                            'sell' => $sellPrice
                                        ];
                                    }
                                }
                                break; // Đã tìm thấy, không cần duyệt tiếp
                            }
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            $this->error('Lỗi khi lấy từ API BTMC: ' . $e->getMessage());
        }
        
        return null;
    }

    private function scrapeGoldFromWebgia()
    {
        try {
            // Webgia.com cung cấp giá vàng SJC
            $response = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
            ])->timeout(10)->get('https://www.webgia.com/gia-vang/sjc/');
            
            if ($response->successful()) {
                $html = $response->body();
                
                // Tìm giá vàng SJC trong HTML bằng regex
                // Pattern: tìm số có format như 76.500.000 hoặc 76,500,000
                if (preg_match_all('/(\d{1,2}[,\.]\d{3}[,\.]\d{3})/u', $html, $matches)) {
                    $prices = [];
                    foreach ($matches[1] as $match) {
                        $price = $this->parseGoldPrice($match);
                        // Giá vàng SJC thường từ 70-100 triệu/lượng
                        if ($price > 70000000 && $price < 100000000) {
                            $prices[] = $price;
                        }
                    }
                    
                    if (count($prices) >= 2) {
                        // Loại bỏ trùng lặp và sắp xếp
                        $prices = array_unique($prices);
                        sort($prices);
                        // Giá mua thường thấp hơn giá bán
                        return [
                            'buy' => $prices[0],
                            'sell' => end($prices)
                        ];
                    }
                }
                
                // Thử parse từ bảng HTML
                libxml_use_internal_errors(true);
                $dom = new \DOMDocument();
                @$dom->loadHTML('<?xml encoding="UTF-8">' . $html);
                libxml_clear_errors();
                
                $xpath = new \DOMXPath($dom);
                
                // Tìm các cell chứa giá vàng SJC
                $rows = $xpath->query("//table//tr[contains(., 'SJC')]");
                
                foreach ($rows as $row) {
                    $cells = $xpath->query(".//td", $row);
                    if ($cells->length >= 3) {
                        $buyText = trim($cells->item(1)->textContent ?? '');
                        $sellText = trim($cells->item(2)->textContent ?? '');
                        
                        $buy = $this->parseGoldPrice($buyText);
                        $sell = $this->parseGoldPrice($sellText);
                        
                        if ($buy > 70000000 && $buy < 100000000 && $sell > 70000000 && $sell < 100000000) {
                            return ['buy' => $buy, 'sell' => $sell];
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            // Bỏ qua lỗi và thử nguồn khác
        }
        
        return null;
    }

    private function scrapeGoldFromSjc()
    {
        try {
            // Thử scrape từ trang chủ SJC
            $html = $this->fetchHtml('https://sjc.com.vn/');
            
            if ($html) {
                // Tìm giá vàng trong HTML (có thể trong widget hoặc section)
                // Pattern: số triệu/lượng hoặc số với format đặc biệt
                if (preg_match('/SJC.*?(\d{2}[,\.]\d{3}[,\.]\d{3}).*?(\d{2}[,\.]\d{3}[,\.]\d{3})/i', $html, $matches)) {
                    $buy = $this->parseGoldPrice($matches[1] ?? '');
                    $sell = $this->parseGoldPrice($matches[2] ?? '');
                    
                    if ($buy > 0 && $sell > 0) {
                        return ['buy' => $buy, 'sell' => $sell];
                    }
                }
            }
        } catch (\Exception $e) {
            // Bỏ qua lỗi
        }
        
        return null;
    }

    private function parseGoldPrice($text)
    {
        // Chuyển đổi text như "76.500.000" hoặc "76,500,000" thành số
        $text = preg_replace('/[^\d,.]/', '', $text);
        $text = str_replace(['.', ','], '', $text);
        return (int) $text;
    }

    private function fetchHtml($url)
    {
        $options = [
            "http" => [
                "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36\r\n"
            ]
        ];
        $context = stream_context_create($options);
        
        $html = @file_get_contents($url, false, $context);
        return $html ?: null;
    }

    private function setDefaultGoldRates()
    {
        $now = Carbon::now();
        $defaultRates = [
            ['type' => 'SJC', 'location' => 'Hà Nội', 'buy' => 76500000, 'sell' => 76700000],
            ['type' => 'SJC', 'location' => 'TP.HCM', 'buy' => 76500000, 'sell' => 76700000],
        ];
        
        foreach ($defaultRates as $rate) {
            GoldRate::updateOrCreate(
                [
                    'type' => $rate['type'],
                    'location' => $rate['location'],
                ],
                [
                    'buy_rate' => $rate['buy'],
                    'sell_rate' => $rate['sell'],
                    'unit' => 'lượng',
                    'updated_at' => $now,
                    'created_at' => $now,
                ]
            );
        }
    }
}
