var walkingEl = document.getElementById('walking');

function printWalking(distance) {
  if(distance === '--') {
    walkingEl.innerHTML = 'no server';
  } else {
    walkingEl.innerHTML = distance + " km";
  }
}

function getWalking() {
  var xhr = new XMLHttpRequest();
  try {
    xhr.open('GET', '../utilitypages/walkingserver.php', true);
    xhr.onreadystatechange = function () {
      if (xhr.readyState == 4 && xhr.status == 200) {
        try {
          var distance = JSON.parse(xhr.responseText);
          printWalking(distance);
        } catch (e) {
          console.error('Error parsing JSON: ', e);
          printWalking('--');
        }
      }
    };
    try {
      xhr.send();
    } catch (e) {
      console.error('Error sending request: ', e);
    }
  } catch (e) {
    console.error('Request error: ', e);
  }
  setTimeout(getWalking, 5 * 60 * 1000);
}

getWalking();