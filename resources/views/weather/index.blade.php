@extends('layouts.app')

@section('content')
<div class="dashboard">
    <h1 class="dashboard-title">Weather Dashboard</h1>
    <div class="weather-dashboard">
        <div class="search-form">
            <h2>Enter A City Name</h2>
            <form method="POST" action="{{ route('weather.search') }}" id="search-form" class="form_s">
                @csrf
                <input type="text" name="city" placeholder="E.g., Ha noi, London, Tokyo" required class="search-input">
                <button type="submit" class="search-button">Search</button>
            </form>

            <button id="location-button" class="location-button">Use Current Location</button>
            
            <!-- Subscription Form -->
            <div class="subscription-form">
                <h2>Get Daily Time Forecast</h2>
                <form method="POST" action="{{ route('subscribe') }}" class="form_s">
                    @csrf
                    <input type="email" name="email" placeholder="Enter your email" required class="search-input">
                    <input type="text" name="city" placeholder="Enter your city" required class="search-input">
                    <button type="submit" class="search-button">Register</button>
                </form>
                <!-- Display flash messages -->
                @if(session('message'))
                    <p id="success-message" class="success-message">{{ session('message') }}</p>
                @endif
                @if(session('error'))
                    <p id="error-message" class="error-message">{{ session('error') }}</p>
                @endif
            </div>
            <!-- Save and History Buttons -->
            <div class="weather-controls">
                    <form method="POST" action="{{ route('weather.storeTemporaryWeather') }}">
                        @csrf
                        <button type="submit" class="save-weather-button">Save Current Weather</button>
                    </form>
                   <button class="view-history-button" > <a href="{{ route('weather.history') }}" >View Saved Weather History</a></button>
                </div>
        </div>
        <div class="weather-content">
            @if(isset($error))
                <p class="error-message">{{ $error }}</p>
            @else
                @php
                    $weather = session('temporary_weather_data');
                @endphp

                @if(is_array($weather) && isset($weather['current']) && isset($weather['current']['condition']['icon']))
                    @php
                        $currentIconUrl = 'https:' . $weather['current']['condition']['icon'];
                    @endphp
                    <div class="current-weather">
                        <div class="current-weather-info">
                            <div class="left-side">
                                <h3>
                                    {{ $weather['location']['name'] ?? 'N/A' }},
                                    {{ $weather['location']['country'] ?? 'N/A' }}
                                    ({{ $weather['location']['localtime'] ?? 'N/A' }})
                                </h3>
                                <p>Temperature: {{ $weather['current']['temp_c'] ?? 'N/A' }}°C</p>
                                <p>Wind: {{ $weather['current']['wind_kph'] ?? 'N/A' }} kph</p> 
                                <p>Humidity: {{ $weather['current']['humidity'] ?? 'N/A' }}%</p>
                            </div>
                            <div class="right-side">
                                <p>Conditions: {{ $weather['current']['condition']['text'] ?? 'N/A' }}</p>
                                <img src="{{ $currentIconUrl }}" alt="Weather Image" class="weather-image">
                            </div>
                        </div>
                    </div>

                    @if(isset($weather['forecast']['forecastday']) && is_array($weather['forecast']['forecastday']))
                        <div class="forecast">
                            <h4>4-Day Forecast</h4>
                            <div id="forecast-container" class="forecast-container">
                                @foreach($weather['forecast']['forecastday'] as $index => $day)
                                    <div class="forecast-day" data-index="{{ $index + 1 }}">
                                        @php
                                            $dayIconUrl = 'https:' . $day['day']['condition']['icon'];
                                        @endphp
                                        <p>Date: {{ $day['date'] ?? 'N/A' }}</p>
                                        <img src="{{ $dayIconUrl }}" alt="Weather Image" class="forecast-image">
                                        <p>Temperature: {{ $day['day']['avgtemp_c'] ?? 'N/A' }}°C</p>
                                        <p>Wind Speed: {{ $weather['current']['wind_kph'] ?? 'N/A' }} kph</p> 
                                        <p>Humidity: {{ $day['day']['avghumidity'] ?? 'N/A' }}%</p>
                                        <p>Conditions: {{ $day['day']['condition']['text'] ?? 'N/A' }}</p>
                                    </div>
                                @endforeach
                            </div>
                            <div class="forecast-controls">
                                <button id="prev-button" class="forecast-button" onclick="changeForecast(-1)">Previous</button>
                                <button id="next-button" class="forecast-button" onclick="changeForecast(1)">Next</button>
                            </div>
                        </div>
                    @endif
                @else
                    <p class="error-message">Weather data is not available.</p>
                @endif

                
            @endif
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const forecastContainer = document.getElementById('forecast-container');
        const forecastDays = Array.from(forecastContainer.children);
        let currentIndex = 0;
        const itemsPerPage = 4;

        function updateForecast() {
            forecastDays.forEach((day, index) => {
                day.style.display = (index >= currentIndex && index < currentIndex + itemsPerPage) ? 'block' : 'none';
            });
        }

        function changeForecast(step) {
            currentIndex += step * itemsPerPage;
            if (currentIndex < 0) currentIndex = 0;
            if (currentIndex >= forecastDays.length) currentIndex = forecastDays.length - itemsPerPage;
            updateForecast();
        }

        document.getElementById('prev-button').addEventListener('click', () => changeForecast(-1));
        document.getElementById('next-button').addEventListener('click', () => changeForecast(1));

        updateForecast(); // Initial call to show the first set of items

        // Use Current Location Button Functionality
        document.getElementById('location-button').addEventListener('click', function() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            console.log('Latitude:', position.coords.latitude);
            console.log('Longitude:', position.coords.longitude);
                    const latitude = position.coords.latitude;
                    const longitude = position.coords.longitude;

                    // Create hidden input fields for latitude and longitude
                    let form = document.getElementById('search-form');
                    let latInput = document.createElement('input');
                    let lonInput = document.createElement('input');
                    latInput.type = 'hidden';
                    lonInput.type = 'hidden';
                    latInput.name = 'latitude';
                    lonInput.name = 'longitude';
                    latInput.value = latitude;
                    lonInput.value = longitude;
                    form.appendChild(latInput);
                    form.appendChild(lonInput);

                    form.submit(); // Submit the form with latitude and longitude
                }, function(error) {
                    console.error('Error getting location:', error);
                    alert('Unable to retrieve your location.');
                });
            } else {
                alert('Geolocation is not supported by this browser.');
            }
        });

        // Display flash messages if any
        const successMessage = document.getElementById('success-message');
        const errorMessage = document.getElementById('error-message');
        
        if (successMessage) {
            setTimeout(() => successMessage.remove(), 5000); // Remove message after 5 seconds
        }

        if (errorMessage) {
            setTimeout(() => errorMessage.remove(), 5000); // Remove message after 5 seconds
        }
    });
</script>
@endsection

