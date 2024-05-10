var powerTextEl = document.getElementById('power-text');

var xhr = new XMLHttpRequest();

function printPower(power) {
  powerTextEl.classList.add('green');
  powerTextEl.classList.remove('red');
  if (power > -100) {
    if (power < 0) {
      powerTextEl.classList.add('red');
      powerTextEl.classList.remove('green');
    }
    powerTextEl.textContent = Number.parseFloat(power).toFixed(2) + 'kw';
  } else {
    powerTextEl.textContent = 'no server';
  }
}

function getPower() {
  try{
    xhr.open('GET', '../utilitypages/solarserver.php', true);
    xhr.onreadystatechange = function () {
      if (xhr.readyState == 4 && xhr.status == 200) {
        try {
          var data = JSON.parse(xhr.responseText);
          console.log(data);
          // printPower(power);
        } catch (e) {
          console.error('Error parsing JSON: ', e);
          printPower(-100);
        }
      }
    };
    xhr.send();
  } catch (e) {
    console.error('Request error: ', e);
  }

  setTimeout(getPower, 5 * 60 * 1000);
}

// getPower();