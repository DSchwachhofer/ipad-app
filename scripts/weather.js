var weatherEl = document.getElementById('weather-text');
var weatherIconEl = document.getElementById('weather-icon');

var xhr = new XMLHttpRequest();

function printWeather(temp, icon) {
  if (temp === '--') {
    weatherEl.innerHTML = 'no server';
    weatherEl.style.left = 0;
    weatherIconEl.classList.add('none');
    // bigWeatherEl.innerHTML = '-';
  } else {
    weatherIconEl.classList.remove('none');
    weatherEl.style.left = '5%';
    var iconPath = './assets/weather-icons/' + icon + '.png';
    weatherEl.innerHTML = Math.round(temp) + '°C';
    weatherIconEl.src = iconPath;
    // bigWeatherEl.innerText = temp + '°C';
    // bigWeatherIconEl.src = iconPath;
  }
}

function getWeather() {
  try {
    xhr.open('GET', '../utilitypages/weatherserver.php', true);
    xhr.onreadystatechange = function () {
      if (xhr.readyState == 4 && xhr.status == 200) {
        try {
          var data = JSON.parse(xhr.responseText);
          var temp = data.main.temp;
          var icon = data.weather[0].icon;
          printWeather(temp, icon);
        } catch (e) {
          console.log(xhr);
          console.error('Error parsing JSON: ', e);
          printWeather('--', '--');
        }
      }
    };
    xhr.send();
  } catch (e) {
    console.error('Request error: ', e);
  }
  setTimeout(getWeather, 5 * 60 * 1000);
}

getWeather();