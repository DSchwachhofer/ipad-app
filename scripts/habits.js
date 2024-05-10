var habitsContainer = document.getElementById('habits');

var habitColors = ['#00FFFF', '#FFFF00', '#FF00FF', '#0000FF', '#800080'];
var repetitionOptions = [1, 2, 3, 4, 5, 6];
var durationOptions = ['Day', 'Week', 'Month', ' Year'];

var habitGreenColor = '#39ff14';
var habitRedColor = '#C63300';

var showModal = false;
var habitData

var habitDummyData = JSON.stringify([
  {
    habit: 'Z\u00e4hneputzen',
    color: '#FF00FF',
    repetition: 1,
    duration: 'Day',
    id: 1,
    starttime: 1708503120.496682,
  },
  {
    habit: 'Rasieren',
    color: '#FFFF00',
    repetition: 2,
    duration: 'Week',
    id: 2,
    starttime: 1708342660.136045,
  },
  {
    habit: 'Auto waschen',
    color: '#800080',
    repetition: 6,
    duration: ' Year',
    id: 4,
    starttime: 1692238812.998351,
    percentage: 0,
  },
  {
    habit: 'Yoga',
    color: '#FFFF00',
    repetition: 1,
    duration: 'Week',
    id: 5,
    starttime: 1703074224.586073,
  },
  {
    habit: 'Sport',
    color: '#00FFFF',
    repetition: 3,
    duration: 'Week',
    id: 6,
    starttime: 1708342655.625445,
  },
  {
    habit: 'Backup',
    color: '#FF00FF',
    repetition: 6,
    duration: ' Year',
    id: 7,
    starttime: 1692239551.477464,
    percentage: 0,
  },
  {
    habit: 'Alexandertechnik',
    color: '#FFFF00',
    repetition: 2,
    duration: 'Week',
    id: 8,
    starttime: 1707906749.683358,
  },
  {
    habit: 'Update Everything',
    color: '#FF00FF',
    repetition: 2,
    duration: 'Month',
    id: 9,
    starttime: 1708359414.327056,
    percentage: 1.5385119047619047,
  },
  {
    habit: 'Zehenn\u00e4gel schneiden',
    color: '#0000FF',
    repetition: 2,
    duration: 'Month',
    id: 10,
    starttime: 1707630404.743025,
  },
  {
    habit: 'Pflanze gie\u00dfen',
    color: '#0000FF',
    repetition: 3,
    duration: 'Month',
    id: 11,
    starttime: 1708342688.386422,
  },
  {
    habit: 'Dusche reinigen',
    color: '#0000FF',
    repetition: 2,
    duration: 'Month',
    id: 12,
    starttime: 1708006811.702897,
  },
]);

// ------------- HELPER FUNCTIONS -------------
function sortListOfHabits(habitList) {
  var sortedList = [...habitList];
  sortedList.sort(function (a, b) {
    return b.percentage - a.percentage;
  });
  return sortedList;
}

function getHighestId() {
  var highestUsedId = 0;
  for (var habit of JSON.parse(habitData)) {
    if (habit.id > highestUsedId) {
      highestUsedId = habit.id;
    }
  }
  return highestUsedId + 1;
}

// functions to handle switch button logic
function switchBtn(options, currentVal) {
  // get index of current value.
  var currentIndex = options.findIndex(function (el) {
    return el === currentVal;
  });
  // check if is last index of array.
  if (currentIndex === options.length - 1) {
    //  return value of first index.
    return options[0];
  }
  // return value of next index.
  return options[currentIndex + 1];
}

function repetitionBtnHandler(habit, btnEl) {
  var nextValue = switchBtn(repetitionOptions, habit.repetition);
  btnEl.innerText = nextValue;
  habit.repetition = nextValue;
}

function durationBtnHandler(habit, btnEl) {
  var nextValue = switchBtn(durationOptions, habit.duration);
  btnEl.innerText = nextValue;
  habit.duration = nextValue;
}

function colorBtnHandler(habit, btnEl) {
  var nextValue = switchBtn(habitColors, habit.color);
  btnEl.style.backgroundColor = nextValue;
  habit.color = nextValue;
}

var habits = {
  // ------------------- CREATE AND EDIT HABITS
  // renders UI to create/edit habits

  createEditHabit(data) {
    showModal = true;
    var repetitionBtnText = repetitionOptions[0];
    var durationBtnText = durationOptions[0];
    var colorBtnColor =
      habitColors[Math.floor(Math.random() * habitColors.length)];
    var newHabit = {
      habit: '',
      color: colorBtnColor,
      repetition: 1,
      duration: 'Day',
      id: getHighestId(),
    };
    if (data.type === 'edit') {
      repetitionBtnText = data.habitData.repetition;
      durationBtnText = data.habitData.duration;
      colorBtnColor = data.habitData.color;
      newHabit = Object.assign({}, data.habitData);
    }

    habitsContainer.innerHTML = '';
    // create Header:
    var headerText = '';
    if (data.type === 'edit') {
      headerText = 'Edit "' + data.habitData.habit + '":';
    } else {
      headerText = 'Create New Habit:';
    }

    var header = document.createElement('p');
    header.setAttribute('class', 'task');
    header.innerText = headerText;
    habitsContainer.appendChild(header);

    var uiContainer = document.createElement('div');
    uiContainer.setAttribute('class', 'habit-ui-container');
    habitsContainer.appendChild(uiContainer);

    var habitInputDiv = document.createElement('div');
    habitInputDiv.setAttribute(
      'class',
      'habit-ui-div-style habit-ui-inner-div habit-input-div'
    );

    var durationDiv = document.createElement('div');
    durationDiv.setAttribute(
      'class',
      'habit-ui-button-container habit-ui-inner-div'
    );

    var colorDiv = document.createElement('div');
    colorDiv.setAttribute(
      'class',
      'habit-ui-color-div habit-ui-inner-div button'
    );
    colorDiv.style.backgroundColor = colorBtnColor;

    var buttonDiv = document.createElement('div');
    buttonDiv.setAttribute(
      'class',
      'habit-ui-inner-div habit-ui-button-container'
    );

    uiContainer.appendChild(habitInputDiv);
    uiContainer.appendChild(durationDiv);
    uiContainer.appendChild(colorDiv);
    uiContainer.appendChild(buttonDiv);

    // create input to define habit name
    var habitInput = document.createElement("input");
    habitInput.setAttribute("class", "habit-input");
    habitInput.setAttribute("placeholder", "type name");
    if (data.type === "edit") {
      habitInput.setAttribute("value", data.habitData.habit);
    }

    // create duration ui
    var repetitionButton = document.createElement("div");
    repetitionButton.setAttribute(
      "class",
      "habit-rep-button habit-ui-div-style button"
    );
    repetitionButton.innerText = repetitionBtnText;

    var repetitionText = document.createElement("div");
    repetitionText.setAttribute("class", "habit-rep-text-div");
    repetitionText.innerText = "per";

    var durationButton = document.createElement("div");
    durationButton.setAttribute(
      "class",
      "habit-rep-button habit-ui-div-style button"
    );
    durationButton.innerText = durationBtnText;

    // create ok and cancel Buttons
    var cancelBtn = document.createElement("div");
    cancelBtn.setAttribute(
      "class",
      "habit-ui-button habit-ui-div-style button"
    );
    cancelBtn.innerText = "Cancel";
    var okBtn = document.createElement("div");
    okBtn.setAttribute("class", "habit-ui-button habit-ui-div-style button");
    okBtn.innerText = "Ok";

    var deleteBtn = document.createElement("div");
    deleteBtn.setAttribute(
      "class",
      "habit-ui-button habit-ui-div-style button"
    );
    deleteBtn.innerText = "Delete";

    habitInputDiv.appendChild(habitInput);
    durationDiv.appendChild(repetitionButton);
    durationDiv.appendChild(repetitionText);
    durationDiv.appendChild(durationButton);

    // show ok and delete button for edits
    if (data.type === "edit") {
      buttonDiv.appendChild(okBtn);
      buttonDiv.appendChild(deleteBtn);

      okBtn.addEventListener("click", function () {
        newHabit.habit = habitInput.value;
        showModal = false;
        habits.printHabitList(habitData);
        habits.editHabitsServer(JSON.stringify(newHabit));
      });

      deleteBtn.addEventListener("click", function () {
        // console.log("DELETE HABIT");
        showModal = false;
        habits.printHabitList(habitData);
        habits.deleteHabitHandler(data.habitData);
      });
    } else {
      // show ok and cancel button
      buttonDiv.appendChild(okBtn);
      buttonDiv.appendChild(cancelBtn);

      cancelBtn.addEventListener("click", function () {
        showModal = false;
        habits.printHabitList(habitData);
      });

      okBtn.addEventListener("click", function () {
        newHabit.habit = habitInput.value;
        showModal = false;
        habits.printHabitList(habitData);
        habits.editHabitsServer(JSON.stringify(newHabit));
      });
    }

    // event listeners for buttons:
    repetitionButton.addEventListener(
      "click",
      repetitionBtnHandler.bind(this, newHabit, repetitionButton)
    );

    durationButton.addEventListener(
      "click",
      durationBtnHandler.bind(this, newHabit, durationButton)
    );
    colorDiv.addEventListener(
      "click",
      colorBtnHandler.bind(this, newHabit, colorDiv)
    );
  },

  printHabitList(habitServerData) {
    habitData = habitServerData;
    var habitParsedData = JSON.parse(habitData)
    if (showModal) {
      return;
    }

    habitsContainer.innerHTML = '';

    var headerEl = document.createElement('div');
    headerEl.setAttribute('class', 'habit-inner-div');
    habitsContainer.appendChild(headerEl);

    //create header
    var header = document.createElement('p');
    header.setAttribute('class', 'task');
    header.innerText = 'Habits:';
    headerEl.appendChild(header);

    //create add symbol
    var headerAdd = document.createElement('p');
    headerAdd.setAttribute('class', 'task button');
    headerAdd.innerText = '+';
    headerEl.appendChild(headerAdd);

    var sortedHabits = sortListOfHabits(habitParsedData);
    for (var habit of sortedHabits) {
      this.showHabit(habit);
    }

    headerAdd.addEventListener('click', this.createNewHabitHandler);
  },

  showHabit(habit) {
    // create div for habbit.
    var habitDiv = document.createElement('div');
    habitsContainer.appendChild(habitDiv);

    // create inner div to style text and gear symbol
    var innerDiv = document.createElement('div');
    innerDiv.setAttribute('class', 'habit-inner-div');
    habitDiv.appendChild(innerDiv);

    // create p element inside
    var habitEL = document.createElement('p');
    habitEL.setAttribute('class', 'habit-p button');
    if (habit.percentage > 1) {
      habitEL.style.color = habitRedColor;
    }
    // habitEL.style.color = habit.color;
    habitEL.innerText = '□ ' + habit.habit;
    innerDiv.appendChild(habitEL);

    // create gear symbol.
    habitGearEl = document.createElement('p');
    habitGearEl.setAttribute('class', 'habit-p button');
    if (habit.percentage > 1) {
      habitGearEl.style.color = habitRedColor;
    }
    habitGearEl.innerHTML = '✎';
    innerDiv.appendChild(habitGearEl);

    // create chart bar
    var habitBar = document.createElement('div');
    habitBar.setAttribute('class', 'habit-bar');
    habitBar.style.width = 5 + habit.percentage * 95 + '%';
    if (habit.percentage >= 0.9 && habit.percentage <= 1) {
      habitBar.style.backgroundColor = habitGreenColor;
    } else if (habit.percentage > 1) {
      habitBar.style.backgroundColor = habitRedColor;
      habitBar.style.width = '100%';
    } else {
      habitBar.style.backgroundColor = habit.color;
    }
    habitDiv.appendChild(habitBar);

    habitEL.addEventListener(
      'click',
      this.completeHabitHandler.bind(this, habit)
    );

    habitGearEl.addEventListener(
      'click',
      this.editHabitHandler.bind(this, habit)
    );
  },

  createNewHabitHandler() {
    console.log('createNewHabitHandler');
    habits.createEditHabit({ type: 'create' });
  },

  editHabitHandler(habit) {
    console.log('editHabitHandler', habit);
    habits.createEditHabit({ type: "edit", habitData: habit });
  },

  completeHabitHandler(habit) {
    console.log('completeHabitHandler', habit);
  },

  deleteHabitHandler(habit) {
    console.log('deleteHabitHandler', habit);
  },

  editHabitsServer(habit) {
    console.log('editHabitsServer', habit);
  },
};

habits.printHabitList(habitDummyData);
