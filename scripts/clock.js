var dateTimeEl = document.getElementById('date-time');

function getDateTime() {
  var t = new Date();
  var hours = utilities.formatTime(t.getHours());
  var minutes = utilities.formatTime(t.getMinutes());
  var day = utilities.formatTime(t.getDate());
  var month = utilities.formatTime(t.getMonth() + 1);
  var year = utilities.formatTime(t.getFullYear());

  // var dateTime = day + "." + month + "." + year + " " + hours + ":" + minutes
  var dateTime = hours + ':' + minutes;

  dateTimeEl.innerText = dateTime;
}

function startClock() {
  setInterval(getDateTime, 1000);
}

startClock();