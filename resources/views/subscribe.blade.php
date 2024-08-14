<!DOCTYPE html>
<html>
<head>
    <title>Đăng ký</title>
</head>
<body>
    <h1>Đăng ký nhận dự báo thời tiết hàng ngày</h1>

    @if(session('message'))
        <p>{{ session('message') }}</p>
    @endif

    <form action="{{ route('subscribe') }}" method="POST">
        @csrf
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" placeholder="Email của bạn" required>
        <br>
        <label for="city">Thành phố:</label>
        <input type="text" id="city" name="city" placeholder="Thành phố bạn quan tâm" required>
        <br>
        <button type="submit">Đăng ký</button>
    </form>
</body>
</html>
