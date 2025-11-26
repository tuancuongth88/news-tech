<?php

namespace App\Console\Commands;

use App\Models\Weather;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class FetchWeatherData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-weather-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch weather data for all provinces and save to DB';

    protected $appId = '1d4ecf4ec7d95e4140f17a0406267d34';
    
    protected $provinces = [
        ['name' => 'Hà Nội', 'lat' => 21.0245, 'lon' => 105.8412],
        ['name' => 'TP. Hồ Chí Minh', 'lat' => 10.8231, 'lon' => 106.6297],
        ['name' => 'Đà Nẵng', 'lat' => 16.0544, 'lon' => 108.2022],
        // Chỉ lấy 3 thành phố chính để hiển thị trong sidebar
    ];
    /**
     * Execute the console command.
     */
    public function handle()
    {
        foreach ($this->provinces as $province) {
            $lat = $province['lat'];
            $lon = $province['lon'];
            $name = $province['name'];

            // API OpenWeatherMap - sử dụng lat/lon (khuyến nghị thay vì city name vì geocoder đã deprecated)
            // Thêm units=metric để lấy nhiệt độ Celsius và lang=vi để lấy mô tả tiếng Việt
            $url = "https://api.openweathermap.org/data/2.5/weather?lat={$lat}&lon={$lon}&appid={$this->appId}&units=metric&lang=vi";

            $response = Http::timeout(10)->get($url);
            
            if ($response->successful()) {
                $data = $response->json();

                // Parse dữ liệu từ OpenWeatherMap theo tài liệu
                // main.temp: nhiệt độ (Celsius với units=metric)
                // main.humidity: độ ẩm (%)
                // main.pressure: áp suất (hPa)
                // wind.speed: tốc độ gió (m/s)
                // rain.1h: lượng mưa trong 1 giờ (mm/h)
                // weather[0].main: trạng thái (Rain, Snow, Clouds, Clear, etc.)
                // weather[0].description: mô tả thời tiết (đã được dịch sang tiếng Việt với lang=vi)

                $main = $data['main'] ?? null;
                $wind = $data['wind'] ?? null;
                $weather = $data['weather'][0] ?? null;
                $rain = $data['rain'] ?? null;
                $snow = $data['snow'] ?? null;
                $coord = $data['coord'] ?? null;

                if ($main) {
                    // Lấy lượng mưa (nếu có)
                    // Ưu tiên rain.1h, nếu không có thì dùng rain.3h
                    $precipitation = null;
                    if ($rain && isset($rain['1h'])) {
                        $precipitation = $rain['1h'];
                    } elseif ($rain && isset($rain['3h'])) {
                        $precipitation = $rain['3h'];
                    } elseif ($snow && isset($snow['1h'])) {
                        // Nếu có tuyết, cũng tính là precipitation
                        $precipitation = $snow['1h'];
                    } elseif ($weather && (stripos($weather['main'], 'Rain') !== false || stripos($weather['main'], 'Snow') !== false)) {
                        // Nếu có mưa/tuyết nhưng không có dữ liệu lượng mưa, đặt giá trị nhỏ để hiển thị
                        $precipitation = 0.1;
                    }

                    Weather::updateOrCreate(
                        [
                            'province' => $name,
                            'latitude' => $coord['lat'] ?? $lat,
                            'longitude' => $coord['lon'] ?? $lon,
                        ],
                        [
                            'time' => Carbon::now(),
                            'temperature' => $main['temp'] ?? null,
                            'humidity' => $main['humidity'] ?? null,
                            'wind_speed' => $wind['speed'] ?? null,
                            'precipitation' => $precipitation,
                        ]
                    );

                    $temp = $main['temp'] ?? 'N/A';
                    $desc = $weather['description'] ?? '';
                    $this->info("Saved weather for $name: {$temp}°C - {$desc}");
                }
            } else {
                $errorMsg = $response->json()['message'] ?? $response->status();
                $this->error("Failed for $name: {$errorMsg}");
            }
        }
    }
}
