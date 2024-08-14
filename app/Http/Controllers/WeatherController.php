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
        return view('weather.index');
    }
    
    public function search(Request $request)
    {
        $city = $request->input('city');
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
    
        $weather = $this->weatherService->getWeather($city, $latitude, $longitude);
    
        if (isset($weather['error'])) {
            return view('weather.index')->with('error', $weather['error']['message']);
        }
    
        session()->put('temporary_weather_data', $weather);
    
        return view('weather.index', compact('weather'));
    }
    
    public function history()
    {
        // Cleanup old records older than 1 minute
        WeatherHistory::where('created_at', '<', now()->subDay())->delete();
        // Retrieve records for today
        $history = WeatherHistory::whereDate('created_at', now()->format('Y-m-d'))->get();
    
        // Extract and format necessary data
        $formattedHistory = $history->map(function($entry) {
            $weatherData = json_decode($entry->weather_data, true);
            $currentWeather = $weatherData['current'] ?? [];
            
            return [
                'city' => $entry->city,
                'date' => $entry->created_at->format('Y-m-d'),
                'temperature' => $currentWeather['temp_c'] ?? 'N/A',
                'condition' => $currentWeather['condition']['text'] ?? 'N/A',
                'wind_speed' => $currentWeather['wind_kph'] ?? 'N/A',
                'humidity' => $currentWeather['humidity'] ?? 'N/A',
                'icon' => $currentWeather['condition']['icon'] ?? null
            ];
        });
    
        return view('weather.history', ['history' => $formattedHistory]);
    }
    
    

    public function storeTemporaryWeather(Request $request)
    {
        $weather = session('temporary_weather_data');
        
        if (!$weather) {
            return redirect()->route('weather.index')->with('error', 'No weather data to save.');
        }
    
        $city = $weather['location']['name'] ?? 'Unknown';
        $formattedData = [
            'city' => $city,
            'weather_data' => json_encode($weather),
        ];
        
        // Cleanup old records older than 1 day
        WeatherHistory::where('created_at', '<', now()->subDay())->delete();
        
        // Get the current date
        $today = now()->format('Y-m-d');
    
        // Check if there's an existing record for the city and date
        $existingRecord = WeatherHistory::where('city', $city)
                                        ->whereDate('created_at', $today)
                                        ->first();
    
        if ($existingRecord) {
            // Update existing record
            $existingRecord->update($formattedData);
            $message = 'Weather data updated successfully.';
        } else {
            // Create new record
            WeatherHistory::create($formattedData);
            $message = 'Weather data saved successfully.';
        }
    
        return redirect()->route('weather.index')->with('message', $message);
    }
    
    

    
    
}


