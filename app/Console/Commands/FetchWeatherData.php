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

    protected $provinces = [
        ['name' => 'Hà Nội', 'lat' => 21.0285, 'lng' => 105.8542],
        ['name' => 'TP. Hồ Chí Minh', 'lat' => 10.7769, 'lng' => 106.7009],
        ['name' => 'Đà Nẵng', 'lat' => 16.0471, 'lng' => 108.2062],
        ['name' => 'Hải Phòng', 'lat' => 20.8449, 'lng' => 106.6881],
        ['name' => 'Cần Thơ', 'lat' => 10.0452, 'lng' => 105.7469],
        ['name' => 'An Giang', 'lat' => 10.5216, 'lng' => 105.1259],
        ['name' => 'Bà Rịa - Vũng Tàu', 'lat' => 10.5410, 'lng' => 107.2428],
        ['name' => 'Bắc Giang', 'lat' => 21.2730, 'lng' => 106.1946],
        ['name' => 'Bắc Kạn', 'lat' => 22.1470, 'lng' => 105.8348],
        ['name' => 'Bạc Liêu', 'lat' => 9.2941, 'lng' => 105.7211],
        ['name' => 'Bắc Ninh', 'lat' => 21.1822, 'lng' => 106.0506],
        ['name' => 'Bến Tre', 'lat' => 10.2434, 'lng' => 106.3758],
        ['name' => 'Bình Định', 'lat' => 13.7820, 'lng' => 109.2193],
        ['name' => 'Bình Dương', 'lat' => 11.3254, 'lng' => 106.4770],
        ['name' => 'Bình Phước', 'lat' => 11.7512, 'lng' => 106.7235],
        ['name' => 'Bình Thuận', 'lat' => 11.0904, 'lng' => 108.0721],
        ['name' => 'Cà Mau', 'lat' => 9.1795, 'lng' => 105.1500],
        ['name' => 'Cao Bằng', 'lat' => 22.6657, 'lng' => 106.2570],
        ['name' => 'Đắk Lắk', 'lat' => 12.7100, 'lng' => 108.2378],
        ['name' => 'Đắk Nông', 'lat' => 12.2644, 'lng' => 107.6098],
        ['name' => 'Điện Biên', 'lat' => 21.3860, 'lng' => 103.0230],
        ['name' => 'Đồng Nai', 'lat' => 10.9587, 'lng' => 106.8456],
        ['name' => 'Đồng Tháp', 'lat' => 10.4642, 'lng' => 105.6324],
        ['name' => 'Gia Lai', 'lat' => 13.8079, 'lng' => 108.1092],
        ['name' => 'Hà Giang', 'lat' => 22.8251, 'lng' => 104.9836],
        ['name' => 'Hà Nam', 'lat' => 20.5412, 'lng' => 105.9220],
        ['name' => 'Hà Tĩnh', 'lat' => 18.3333, 'lng' => 105.9000],
        ['name' => 'Hậu Giang', 'lat' => 9.7579, 'lng' => 105.6417],
        ['name' => 'Hoà Bình', 'lat' => 20.8526, 'lng' => 105.3376],
        ['name' => 'Hưng Yên', 'lat' => 20.6460, 'lng' => 106.0511],
        ['name' => 'Khánh Hòa', 'lat' => 12.2388, 'lng' => 109.1967],
        ['name' => 'Kiên Giang', 'lat' => 10.0089, 'lng' => 105.0764],
        ['name' => 'Kon Tum', 'lat' => 14.3490, 'lng' => 108.0000],
        ['name' => 'Lai Châu', 'lat' => 22.3897, 'lng' => 103.4587],
        ['name' => 'Lâm Đồng', 'lat' => 11.5753, 'lng' => 108.1429],
        ['name' => 'Lạng Sơn', 'lat' => 21.8528, 'lng' => 106.7615],
        ['name' => 'Lào Cai', 'lat' => 22.4851, 'lng' => 103.9706],
        ['name' => 'Long An', 'lat' => 10.5359, 'lng' => 106.4125],
        ['name' => 'Nam Định', 'lat' => 20.4389, 'lng' => 106.1621],
        ['name' => 'Nghệ An', 'lat' => 19.2342, 'lng' => 104.9200],
        ['name' => 'Ninh Bình', 'lat' => 20.2539, 'lng' => 105.9745],
        ['name' => 'Ninh Thuận', 'lat' => 11.5753, 'lng' => 108.9984],
        ['name' => 'Phú Thọ', 'lat' => 21.3454, 'lng' => 105.3131],
        ['name' => 'Phú Yên', 'lat' => 13.0892, 'lng' => 109.0929],
        ['name' => 'Quảng Bình', 'lat' => 17.6048, 'lng' => 106.3487],
        ['name' => 'Quảng Nam', 'lat' => 15.5736, 'lng' => 108.4740],
        ['name' => 'Quảng Ngãi', 'lat' => 15.1205, 'lng' => 108.8000],
        ['name' => 'Quảng Ninh', 'lat' => 21.0064, 'lng' => 107.2925],
        ['name' => 'Quảng Trị', 'lat' => 16.8189, 'lng' => 107.1021],
        ['name' => 'Sóc Trăng', 'lat' => 9.6038, 'lng' => 105.9803],
        ['name' => 'Sơn La', 'lat' => 21.3259, 'lng' => 103.9188],
        ['name' => 'Tây Ninh', 'lat' => 11.3112, 'lng' => 106.0987],
        ['name' => 'Thái Bình', 'lat' => 20.4463, 'lng' => 106.3365],
        ['name' => 'Thái Nguyên', 'lat' => 21.5936, 'lng' => 105.8441],
        ['name' => 'Thanh Hóa', 'lat' => 19.8067, 'lng' => 105.7852],
        ['name' => 'Thừa Thiên Huế', 'lat' => 16.4637, 'lng' => 107.5909],
        ['name' => 'Tiền Giang', 'lat' => 10.3712, 'lng' => 106.3598],
        ['name' => 'Trà Vinh', 'lat' => 9.8120, 'lng' => 106.2993],
        ['name' => 'Tuyên Quang', 'lat' => 21.8236, 'lng' => 105.2182],
        ['name' => 'Vĩnh Long', 'lat' => 10.2536, 'lng' => 105.9724],
        ['name' => 'Vĩnh Phúc', 'lat' => 21.3089, 'lng' => 105.6040],
        ['name' => 'Yên Bái', 'lat' => 21.7056, 'lng' => 104.8790],
    ];
    /**
     * Execute the console command.
     */
    public function handle()
    {
        foreach ($this->provinces as $province) {
            $lat = $province['lat'];
            $lng = $province['lng'];
            $name = $province['name'];

            $url = "https://api.open-meteo.com/v1/forecast?latitude={$lat}&longitude={$lng}&hourly=precipitation_probability,precipitation&current=temperature_2m,relative_humidity_2m,wind_speed_10m&timezone=auto";

            $response = Http::get($url);
            if ($response->successful()) {
                $data = $response->json();

                $current = $data['current'] ?? null;
                $hourly = $data['hourly'] ?? null;

                if ($current && $hourly) {
                    // Lấy giờ hiện tại (giống định dạng trong API: 2025-07-03T10:00)
                    $currentHour = Carbon::now($data['timezone'] ?? 'Asia/Ho_Chi_Minh')->format('Y-m-d\TH:00');

                    // Tìm index của giờ hiện tại trong hourly
                    $index = array_search($currentHour, $hourly['time']);

                    $precipitation = $index !== false ? ($hourly['precipitation'][$index] ?? null) : null;
                    $precipitation_probability = $index !== false ? ($hourly['precipitation_probability'][$index] ?? null) : null;

                    Weather::updateOrCreate(
                        [
                            'province' => $name,
                            'latitude' => $lat,
                            'longitude' => $lng,
                        ],
                        [
                            'time' => Carbon::parse($current['time']),
                            'temperature' => $current['temperature_2m'] ?? null,
                            'humidity' => $current['relative_humidity_2m'] ?? null,
                            'wind_speed' => $current['wind_speed_10m'] ?? null,
                            'precipitation' => $precipitation,
                            'precipitation_probability' => $precipitation_probability,
                        ]
                    );

                    $this->info("Saved weather for $name");
                }
            } else {
                $this->error("Failed for $name");
            }
        }
    }
}
