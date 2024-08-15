# Weather App
 
This is a Laravel-based weather application that retrieves and displays weather data from WeatherAPI. The app allows users to search for current weather conditions by city name or use their current location, save weather history, and subscribe to weather updates.

## Features

- Search for weather by city or use the current location.
- Display current weather and 4-day forecast.
- Save and display weather history.
- Subscribe to weather updates via email.

## Requirements

- PHP 8.1 or 8.2
- Composer
- Laravel 10
- Docker (optional)

## Demo

https://weather-app-xtot.onrender.com/

Render spins down a Free web service that goes 15 minutes without receiving inbound traffic. Render spins the service back up whenever it next receives a request to process.

Spinning up a service takes up to a minute, which causes a noticeable delay for incoming requests until the service is back up and running. For example, a browser page load will hang temporarily.

Please wait for the first launch of the website!

## Installation

1. **Clone the repository**
2. 
    ```bash
    git clone https://github.com/duykhanh3612/weather_app.git
    cd weather_app
    ```

3. **Set up environment variables**

    Copy the `.env.example` file to `.env`:

    ```bash
    cp .env.example .env
    ```

    Update the `.env` file with your database credentials, WeatherAPI key, and other necessary configurations:

    ```dotenv
    APP_NAME=Laravel
    APP_ENV=local
    APP_KEY=base64:your_app_key_here
    APP_DEBUG=true
    APP_URL=http://localhost
    PORT=9000

    DB_CONNECTION=mysql
    DB_HOST=lim.h.filess.io
    DB_PORT=3307
    DB_DATABASE=weatherforecast_southsmile
    DB_USERNAME=weatherforecast_southsmile
    DB_PASSWORD=db00118637c7ffbc15f8e2003b3eca411b966558

    WEATHER_API_KEY=your_weatherapi_key_here

    MAIL_MAILER=smtp
    MAIL_HOST=smtp.gmail.com
    MAIL_PORT=587
    MAIL_USERNAME=your_email@gmail.com
    MAIL_PASSWORD=your_email_password
    MAIL_FROM_ADDRESS=your_email@gmail.com
    MAIL_FROM_NAME="${Weather-app}"
    ```

4. **Install dependencies**

    Run the following command to install PHP dependencies:

    ```bash
    composer install
    ```

5. **Generate application key**

    Generate the application key using the following command:

    ```bash
    php artisan key:generate
    ```

6. **Run database migrations**

    Set up the database by running migrations:

    ```bash
    php artisan migrate
    ```

7. **Serve the application**

    Start the Laravel development server:

    ```bash
    php artisan serve
    ```

    Visit `[http://127.0.0.1:8000]` in your browser to access the application.

## Thanks for watching

