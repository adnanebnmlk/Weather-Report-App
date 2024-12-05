<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather Report</title>
    <link rel="stylesheet" href="Stylee.css">
</head>
<body>
    <div class="container">
        <h1>🌤️ Weather Report</h1>
        <div class="weather-form">
            <label for="city">Choose A City</label>
            <select name="city" id="city" class="city-select">
                <option value="" disabled selected>-- Select a city --</option>
                <option value="Rabat">Rabat</option>
                <option value="Casablanca">Casablanca</option>
                <option value="Marrakech">Marrakech</option>
                <option value="Tangier">Tangier</option>
                <option value="Fez">Fez</option>
                <option value="Agadir">Agadir</option>
                <option value="Salé">Salé</option>
                <option value="Meknes">Meknes</option>
                <option value="Oujda">Oujda</option>
                <option value="Kenitra">Kenitra</option>
                <option value="Tetouan">Tetouan</option>
                <option value="Safi">Safi</option>
                <option value="Beni Mellal">Beni Mellal</option>
                <option value="Khouribga">Khouribga</option>
                <option value="Nador">Nador</option>
            </select>
        </div>

        <div class="result">
            <p id="weather-info">🌤️ Select a city to view the temperature.</p>
        </div>
    </div>

    <script>
        const citySelect = document.getElementById('city');
        const weatherInfo = document.getElementById('weather-info');
        
        const apiKey = 'f56806182176d8c46ddbf6d6e1003640';

        citySelect.addEventListener('change', () => {
            const city = citySelect.value;

            if (city) {
                const url = `https://api.openweathermap.org/data/2.5/weather?q=${city},MA&appid=${apiKey}&units=metric`;

                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        if (data.main && data.weather) {
                            const temp = data.main.temp;
                            const description = data.weather[0].description;
                            const sunriseUTC = data.sys.sunrise;
                            const sunsetUTC = data.sys.sunset;
                            const timezoneOffset = data.timezone;

                            // Convert sunrise and sunset from UTC to local time
                            const sunriseTime = convertUnixToTime(sunriseUTC, timezoneOffset);
                            const sunsetTime = convertUnixToTime(sunsetUTC, timezoneOffset);

                            weatherInfo.innerHTML = `
                                <div class="weather-details">
                                    <h3><span class="label">🌡️ Temperature:</span> <span class='temp'>${temp}°C</span></h3>
                                    <p><span class="label"></span> <span class='desc'>${description}</span></p>
                                    <div class="sun-info">
                                        <p><span class="label">🌅 Sunrise:</span> <span class="time">${sunriseTime}</span></p>
                                        <p><span class="label">🌇 Sunset:</span> <span class="time">${sunsetTime}</span></p>
                                    </div>
                                </div>
                            `;
                        } else {
                            weatherInfo.innerHTML = `❌ Error: Could not find temperature information for <b>${city}</b>.`;
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching weather data:', error);
                        weatherInfo.innerHTML = `⚠️ Error: Unable to fetch data. Please try again.`;
                    });
            }
        });

        // Function to convert Unix timestamp to time in local time zone
        function convertUnixToTime(unixTimestamp, timezoneOffset) {
            const date = new Date((unixTimestamp + timezoneOffset) * 1000); // Convert to milliseconds
            const hours = date.getHours().toString().padStart(2, '0');
            const minutes = date.getMinutes().toString().padStart(2, '0');
            return `${hours}:${minutes}`;
        }
    </script>
</body>
</html>
