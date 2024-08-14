<?php

namespace App\Http\Controllers;

use App\Models\WeatherHistory;
use Illuminate\Http\Request;
use App\Services\WeatherService;

class WeatherController extends Controller
{
    protected $weatherService;

    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    public function index()
    {
        $defaultCity = 'London';
        $weather = $this->weatherService->getWeather($defaultCity);

        return view('weather.index', compact('weather'));
    }

    public function search(Request $request)
    {
        $city = $request->input('city');
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
    
        $weather = $this->weatherService->getWeather($city, $latitude, $longitude);
    // dd($weather);
        // Kiểm tra nếu có lỗi trong dữ liệu trả về
        if (isset($weather['error'])) {
            return view('weather.index')->with('error', $weather['error']['message']);
        }
    
        // Lưu dữ liệu thời tiết vào session (lưu tạm thời)
        session()->put('temporary_weather_data', $weather);
    
        // Tùy chọn: Lưu dữ liệu thời tiết vào lịch sử
        WeatherHistory::create([
            'city' => $city ?: 'Current Location',
            'weather_data' => json_encode($weather)
        ]);
        return view('weather.index', compact('weather'));
    }
    

    public function history()
    {
        $history = WeatherHistory::whereDate('created_at', now()->format('Y-m-d'))->get();
        return view('weather.history', compact('history'));
    }

    public function storeTemporaryWeather(Request $request)
    {
        $city = $request->input('city') ?: 'Current Location';
        $weatherData = $request->session()->get('temporary_weather_data');

        if ($weatherData) {
            WeatherHistory::create([
                'city' => $city,
                'weather_data' => json_encode($weatherData)
            ]);
        }

        return redirect()->route('weather.index');
    }

}
