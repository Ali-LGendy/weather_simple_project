<?php
require 'vendor/autoload.php';

use GuzzleHttp\Client;

$weatherApiKey = '6d7e0aa9556cca0598d04d983c2ea90c';

if (empty($_GET['city_id'])) {
    echo "Error: No city was selected. Please go back and select a city.";
    exit;
}

$selectedCityId = $_GET['city_id'];

$httpClient = new Client();

$weatherResponse = $httpClient->request('GET', 'https://api.openweathermap.org/data/2.5/weather', [
    'query' => [
        'id' => $selectedCityId,
        'appid' => $weatherApiKey,
        'units' => 'metric'
    ]
]);

$weatherData = json_decode($weatherResponse->getBody(), true);

$city = $weatherData['name'];
$minTemp = $weatherData['main']['temp_min'];
$maxTemp = $weatherData['main']['temp_max'];
$humidityValue = $weatherData['main']['humidity'];
$wind = $weatherData['wind']['speed'];
$dateTimestamp = $weatherData['dt'];
$weatherIcon = $weatherData['weather'][0]['icon'];
$weatherDesc = $weatherData['weather'][0]['description'];

$formattedDate = date('Y-m-d', $dateTimestamp);
$dayOfWeek = date('l', $dateTimestamp);

$weatherIconUrl = "https://openweathermap.org/img/wn/{$weatherIcon}@2x.png";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Weather Details - <?= htmlspecialchars($city) ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            line-height: 1.6;
        }
        h1 {
            color: #2c3e50;
        }
        .weather-info {
            margin: 20px 0;
        }
        .weather-info li {
            margin-bottom: 8px;
        }
        .back-link {
            display: inline-block;
            margin-top: 20px;
            color: #3498db;
            text-decoration: none;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>Current Weather in <?= htmlspecialchars($city) ?></h1>
    
    <div class="weather-condition">
        <img src="<?= $weatherIconUrl ?>" alt="<?= htmlspecialchars($weatherDesc) ?>"> 
        <strong><?= ucfirst($weatherDesc) ?></strong>
    </div>

    <div class="weather-info">
        <ul>
            <li><strong>Date:</strong> <?= $formattedDate ?></li>
            <li><strong>Day:</strong> <?= $dayOfWeek ?></li>
            <li><strong>Temperature Range:</strong> <?= $minTemp ?> to <?= $maxTemp ?> °C</li>
            <li><strong>Humidity:</strong> <?= $humidityValue ?>%</li>
            <li><strong>Wind Speed:</strong> <?= $wind ?> m/s</li>
        </ul>
    </div>

    <a class="back-link" href="index.php">← Back to city selection</a>
</body>
</html>