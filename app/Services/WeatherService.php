<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WeatherService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = env('WEATHER_API_KEY');
    }

    public function getWeather($city = null, $latitude = null, $longitude = null)
    {
        $params = [
            'key' => $this->apiKey,
            'days' => 12
        ];

        if ($city) {
            $params['q'] = $city;
        } elseif ($latitude && $longitude) {
            $params['q'] = "{$latitude},{$longitude}";
        }

        $response = Http::get('http://api.weatherapi.com/v1/forecast.json', $params);

        $data = $response->json();
        
        // Kiểm tra và xử lý dữ liệu
        if (isset($data['location'])) {
            // Trả về dữ liệu location và current
            return $data;
        } else {
            // Trả về thông báo lỗi nếu không có location
            return [
                'error' => [
                    'code' => 1006,
                    'message' => 'No matching location found.'
                ]
            ];
        }
    }
}
