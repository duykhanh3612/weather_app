@extends('layouts.app')
<style>
.weather-history {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 20px;
    width: 100%;
}

.weather-entry {
    width: 100%;
    max-width: 800px; /* Increased width for longer entries */
    margin-bottom: 20px;
    padding: 20px; /* Increased padding for more space */
    border: 1px solid #ddd;
    border-radius: 8px;
    background-color: #f9f9f9;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.weather-entry h3 {
    margin-top: 0;
    font-size: 22px; /* Adjusted font size for the title */
    color: #333;
}

.weather-entry p {
    margin: 8px 0; /* Increased spacing between paragraphs */
    font-size: 18px; /* Adjusted font size for better readability */
    color: #555;
}

.weather-images {
    width: 100px; /* Increased size for better visibility */
    height: 100px; /* Increased size for better visibility */
 
}

.back-button-container {
    margin-bottom: 20px;
    text-align: center;
}

.back-button {
    display: inline-block;
    padding: 15px 30px; /* Increased padding for a more prominent button */
    background-color: #007bff; /* Change this to match your primary button color */
    color: #fff;
    text-align: center;
    text-decoration: none;
    border-radius: 5px;
    font-size: 20px; /* Adjusted font size for better visibility */
    border: none;
    cursor: pointer;
    transition: background-color 0.3s, transform 0.2s;
}

.back-button:hover {
    background-color: #0056b3; /* Darker shade of your primary button color */
    transform: scale(1.05);
}

.error-message, .success-message {
    text-align: center;
    font-size: 18px;
    padding: 15px; /* Increased padding for better spacing */
    border-radius: 5px;
    margin-top: 10px;
    max-width: 800px; /* Ensured consistency with the width of entries */
}

.error-message {
    color: #d9534f;
    background-color: #f9d6d5;
}

.success-message {
    color: #5bc0de;
    background-color: #d0e9f5;
}


</style>
@section('content')
<div class="dashboard">
    <h1 class="dashboard-title">Weather History</h1>
    <div class="weather-history">
        <!-- Back to Dashboard Button -->
        <div class="back-button-container">
            <a href="{{ route('weather.index') }}" class="back-button">Back to Dashboard</a>
        </div>

        @if($history->isEmpty())
            <p>No weather history available for today.</p>
        @else
            @foreach($history as $entry)
                <div class="weather-entry">
                    <h3>{{ $entry['city'] }}</h3>
                    <p>Date: {{ $entry['date'] }}</p>

                    <div class="current-weather">
                        <p>Temperature: {{ $entry['temperature'] }}°C</p>
                        <p>Condition: {{ $entry['condition'] }}</p>
                       
                        <p>Wind Speed: {{ $entry['wind_speed'] }} kph</p>
                        <p>Humidity: {{ $entry['humidity'] }}%</p>
                        @if($entry['icon'])
                            <img src="https:{{ $entry['icon'] }}" alt="Weather Icon" class="weather-images">
                        @endif
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
@endsection

