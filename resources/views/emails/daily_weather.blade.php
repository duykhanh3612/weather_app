<!DOCTYPE html>
<html>
<head>
    <title>Dự báo thời tiết hàng ngày</title>
</head>
<body>
    <h1>Dự báo thời tiết hàng ngày</h1>
    <p>Chào bạn,</p>
    <p>Dưới đây là dự báo thời tiết cho thành phố {{ $weather['location']['name'] }}:</p>
    <p>Temperature: {{ $weather['current']['temp_c'] }}°C</p>
    <p>Feels Like: {{ $weather['current']['feelslike_c'] }}°C</p>
    <p>Humidity: {{ $weather['current']['humidity'] }}%</p>
    <p>Conditions: {{ $weather['current']['condition']['text'] }}</p>
    <img src="https:{{ $weather['current']['condition']['icon'] }}" alt="Weather Image">
</body>
</html>
