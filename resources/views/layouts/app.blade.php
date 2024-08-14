<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather App</title>
    <link rel="stylesheet" href="{{ asset('/css/app.css') }}"rel="stylesheet">
</head>
<style>
    html, body {
    height: 100%;
    margin: 0;
    padding: 0;
    overflow-x: hidden; /* Prevent horizontal scrolling */
}

body {
    background-color: #324e69; /* Light sky blue background */
    font-family: Arial, sans-serif;
    display: flex;
    flex-direction: column;
}
.container{
height: 100%;
}


.weather-dashboard {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    max-width: 100%;
    flex: 1;
    height: auto;
    margin: 20px auto;
    padding: 20px;
    background-color: #f8f9fa;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.search-form {
    background-color: #e6f0ff;
    padding: 10px;
    width: 29%; /* Occupies 1/3 of the total width */
    /* display: flex;
    flex-direction: column; */
    padding: 15px;
    border-radius: 10px;
    align-items: center; 
    max-width: 90%;
}


.form_s{
width: 100%;
}
.search-input, .search-button, .location-button {
    width: 100%; /* Ensure that the elements take 90% of the parent div width */
    max-width: 100%; /* Make sure the elements take up 90% of their container */
    box-sizing: border-box; /* Include padding and border in the element's total width and height */
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    transition: border-color 0.3s ease;
}
.location-button{
    width: 100%;
}

.dashboard-title {
    margin: 20px auto;
    text-align: center;
    color: rgb(255, 255, 255);
    margin-bottom: 20px;
    padding: 15px;
    
    border-radius: 8px;
}

.search-input:focus {
    border-color: #003366;
    outline: none;
}

.search-button, .location-button {
    background-color: #145da5;
    color: #fff;
    border: none;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s ease;
}

.search-button:hover, .location-button:hover {
    background-color: #324e69;
}

.or-divider {
    text-align: center;
    margin: 20px 0;
    color: #555;
    font-size: 16px;
}

.weather-content {
    width: 68%; /* Adjusts to fit next to the search form */
    margin: 0 auto;
}

.current-weather {
    display: flex;
    justify-content: space-between; /* Align text on the left and image on the right */
    background-color: #e6f0ff;
    padding: 15px;
    border-radius: 10px;
    margin-bottom: 20px;
    box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.1);
}
.current-weather-info {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex: 2;
    color: white;
    padding: 20px;
    border-radius: 10px;
    text-align: left;
    background-color: #324e69;
    text-align: justify;
    
}
.left-side {
    flex: 1; /* Take up available space */
}

.right-side {
    text-align: right; /* Ensure the text and image are aligned to the right */
    flex: 0 0 auto; /* Prevent shrinking or growing */
}
.weather-image {
    flex: 1;
    width: 100px;
    height: 100px;
    margin-left: 20px;
}

.forecast-container {
    display: flex;
    justify-content: space-around;
    width: 100%;
}

.forecast {
   
        background-color: #e6f0ff;
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 20px;
        box-shadow:  4px 4px 8px rgba(0, 0, 0, 0.1);
    
}

.forecast-day {
   
    background-color: #9eadaf;
    padding: 15px;
    border-radius: 8px;
    text-align: center;
    width: calc(25% - 20px); /* Adjust width to fit 4 items in a row with spacing */
    margin: 10px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.forecast-day:hover {
    transform: scale(1.05);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
}

.forecast-day img {
    width: 60px;
    height: 60px;
    margin-top: 5px;
}

.forecast-controls {
    display: flex;
    justify-content: center;
    margin-top: 20px;
}

.forecast-button {
    background-color: #145da5;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    margin: 0 10px;
    font-size: 16px;
    transition: background-color 0.3s ease;
}

.forecast-button:hover {
    background-color: #00509e;
}

/* Base styles for small screens (mobile phones) */
@media (max-width: 767px) {
    .weather-dashboard {
        flex-direction: column; /* Stack elements vertically */
        align-items: center;
        padding: 10px;
    }

    .search-form, .weather-content {
        width: 100%;
        margin: 0;
    }

    .search-form {
        width: 100%;
        margin-bottom: 20px;
    }

    .weather-content {
        width: 100%;
    }

    .current-weather {
        flex-direction: column; /* Stack text and image vertically */
        text-align: center;
    }

    .current-weather-info {
        text-align: center;
    }

    .left-side, .right-side {
        text-align: center;
        margin-bottom: 10px;
    }

    .weather-image {
        margin-left: 0; /* Remove left margin on mobile */
        margin-top: 10px;
    }

    .forecast-container {
        flex-direction: column; /* Stack forecast items vertically */
        align-items: center;
    }

    .forecast-day {
        width: 80%; /* Adjust width for better fit */
        margin: 10px 0; /* Add vertical margin */
    }

    .forecast-controls {
        flex-direction: column; /* Stack buttons vertically */
    }

    .forecast-button {
        margin: 10px 0; /* Add vertical margin */
    }
}

/* Styles for tablets and small laptops */
@media (min-width: 768px) and (max-width: 1024px) {
    .weather-dashboard {
        flex-direction: row; /* Default to row layout for tablets */
    }

    .search-form, .weather-content {
        width: 100%;
    }

    .search-form {
        width: 30%;
    }

    .weather-content {
        width: 70%;
    }

    .current-weather {
        flex-direction: row; /* Keep elements side by side */
    }

    .forecast-container {
        flex-wrap: wrap; /* Allow wrapping of forecast items */
        justify-content: space-between;
    }

    .forecast-day {
        width: calc(50% - 20px); /* Two items per row with spacing */
    }
}

/* Styles for larger screens (laptops and desktops) */
@media (min-width: 1025px) {
    .weather-dashboard {
        flex-direction: row; /* Default to row layout for larger screens */
    }

    .search-form, .weather-content {
        width: 100%;
    }

    .search-form {
        width: 29%;
    }

    .weather-content {
        width: 68%;
    }

    .current-weather {
        flex-direction: row; /* Keep elements side by side */
    }

    .forecast-container {
        flex-wrap: nowrap; /* Prevent wrapping of forecast items */
    }

    .forecast-day {
        width: calc(25% - 20px); /* Four items per row with spacing */
    }
}
.save-weather-button, .view-history-button {
    background-color: #145da5;
    color: #fff;
    border: none;
    cursor: pointer;
    font-size: 16px;
    padding: 10px;
    border-radius: 5px;
    width: 100%;
    margin-bottom: 10px;
    transition: background-color 0.3s ease;
}

.save-weather-button:hover, .view-history-button:hover {
    background-color: #444a59;
}
.view-history-button {
    background-color: #145da5;
    color: #fff;
    border: none;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s ease;
    text-align: center;
    padding: 10px; /* Adjust padding to match other buttons */
    border-radius: 5px;
    box-sizing: border-box;
}

.view-history-button a {
    color: #fff;
    text-decoration: none;
    display: inline-block;
    width: 100%;
    height: 100%;
    line-height: normal;
}

.view-history-button:hover {
    background-color: #444a59;
}


.view-history-button:hover {
    background-color: #444a59;
}

</style>
<body>
    <div class="container">
        @yield('content')
    </div>
</body>
</html>
