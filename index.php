<?php
$cityData = file_get_contents('city.list.json');
$cityList = json_decode($cityData, true);

$egyptianCities = array_filter($cityList, fn($city) => $city['country'] == 'EG');
// print_r($cityList);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Egypt Weather App</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        select {
            padding: 5px;
            margin-right: 10px;
        }
        button {
            padding: 5px 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>Egyptian Weather</h1>
    <p>Select a city to view current weather conditions:</p>
    
    <form action="service.php" method="GET">
        <label for="city_select">City:</label>
        <select name="city_id" id="city_select">
            <?php foreach ($egyptianCities as $city): ?>
                <option value="<?= $city['id'] ?>"><?= $city['name'] ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Check Weather</button>
    </form>
</body>
</html>