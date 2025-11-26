<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Models\Post;
use App\Models\Weather;
use App\Models\ExchangeRate;
use App\Models\GoldRate;

class SidebarTheme1Composer
{
    /**
     * Bind data to the view.
     *
     * @param    View  $view
     * @return  void
     */
    public function compose(View $view)
    {
        // Lấy tin mới nhất nếu chưa có
        if (!$view->offsetExists('postNew')) {
            $postNew = Post::query()
                ->where('status', 1)
                ->orderBy('id', 'desc')
                ->take(5)
                ->get();
            $view->with('postNew', $postNew);
        }

        // Lấy dữ liệu thời tiết cho 3 thành phố chính
        $weatherData = Weather::whereIn('province', ['Hà Nội', 'TP. Hồ Chí Minh', 'Đà Nẵng'])
            ->orderByRaw("FIELD(province, 'Hà Nội', 'TP. Hồ Chí Minh', 'Đà Nẵng')")
            ->get()
            ->map(function ($weather) {
                return [
                    'name' => $weather->province === 'TP. Hồ Chí Minh' ? 'TP.HCM' : $weather->province,
                    'temperature' => $weather->temperature ? round($weather->temperature) : null,
                    'description' => $this->getWeatherDescription($weather),
                    'icon' => $this->getWeatherIcon($weather),
                ];
            })->toArray();

        $view->with('weatherData', $weatherData);

        // Lấy dữ liệu tỷ giá ngoại tệ
        $exchangeRates = ExchangeRate::whereIn('currency_code', ['USD', 'EUR', 'JPY', 'GBP'])
            ->orderByRaw("FIELD(currency_code, 'USD', 'EUR', 'JPY', 'GBP')")
            ->get()
            ->map(function ($rate) {
                // JPY hiển thị với 2 chữ số thập phân, các loại khác hiển thị số nguyên
                $decimals = $rate->currency_code === 'JPY' ? 2 : 0;
                return [
                    'code' => $rate->currency_code,
                    'name' => $rate->currency_name,
                    'rate' => $rate->transfer_rate ? number_format($rate->transfer_rate, $decimals, ',', '.') : '--',
                ];
            })->toArray();

        $view->with('exchangeRates', $exchangeRates);

        // Lấy dữ liệu tỷ giá vàng SJC
        $goldRate = GoldRate::where('type', 'SJC')
            ->where('location', 'Hà Nội')
            ->first();

        $goldData = null;
        if ($goldRate) {
            $goldData = [
                'buy' => $goldRate->buy_rate ? number_format($goldRate->buy_rate / 1000000, 1, ',', '.') : '--',
                'sell' => $goldRate->sell_rate ? number_format($goldRate->sell_rate / 1000000, 1, ',', '.') : '--',
                'unit' => $goldRate->unit ?? 'lượng',
            ];
        }

        $view->with('goldData', $goldData);
    }

    /**
     * Lấy mô tả thời tiết dựa trên dữ liệu
     */
    private function getWeatherDescription($weather)
    {
        // Chỉ hiển thị mưa khi thực sự có dữ liệu precipitation > 0
        if ($weather->precipitation && $weather->precipitation > 0) {
            if ($weather->precipitation > 5) {
                return 'Có mưa';
            }
            return 'Có mưa rào';
        }
        
        // Dựa vào nhiệt độ để mô tả thời tiết
        if ($weather->temperature) {
            $temp = $weather->temperature;
            
            if ($temp > 32) {
                return 'Nắng nóng';
            } elseif ($temp > 28) {
                return 'Nắng, có mây';
            } elseif ($temp > 25) {
                return 'Nắng, gió nhẹ';
            } elseif ($temp > 20) {
                return 'Có mây';
            } elseif ($temp > 15) {
                return 'Mát mẻ, có mây';
            } else {
                return 'Lạnh, có mây';
            }
        }
        
        // Nếu không có dữ liệu nhiệt độ
        return 'Có mây';
    }

    /**
     * Lấy icon thời tiết dựa trên dữ liệu
     */
    private function getWeatherIcon($weather)
    {
        // Nếu có mưa
        if ($weather->precipitation && $weather->precipitation > 0) {
            return 'ri-rainy-fill';
        }
        
        // Dựa vào nhiệt độ để chọn icon
        if ($weather->temperature) {
            $temp = $weather->temperature;
            
            if ($temp > 28) {
                return 'ri-sun-fill';
            } elseif ($temp > 20) {
                return 'ri-sun-cloudy-fill';
            } else {
                return 'ri-cloudy-fill';
            }
        }
        
        return 'ri-sun-cloudy-fill';
    }
}

