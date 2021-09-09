const mode = {
  // Proprietes availables in the object.
  backgroundColorByDefault: null,
  backgroundColor: [],
  switch: null,
  clickedSwitch: null,
  body: null,
  // variables used for teh  background of admin's tables
  darkTableBg: "dark",
  darkTableBg1: "darktable",
  lightTableBg: "table-striped",
  lightTableBg1: null,
  table: null,
  // -----------------------------------------------
  headerHome: null,
  headerShared: null,

  init: function () {
    // We get the DOM elements that we need to interate with.
    mode.switch = document.getElementById("switch-mode-checkbox");
    // If mode.switch === true.
    if (mode.switch) {
      // We add a listener and a handler on the click evt.
      mode.switch.addEventListener(
        "click",
        mode.handleSelectBackgroundColorSwitch
      );
    }
    // We get all the DOM elements that will be impacted by the handleSelectBackgroundColorSwitch() method.

    // The body element.
    mode.body = document.body;
    // get the table element by his ID
    mode.table = document.getElementById("mode");
    // The headers elements.
    mode.headerHome = document.querySelector(".header-home");
    mode.headerShared = document.querySelector(".header-shared");
    // Connection form elements
    mode.connectionForm = document.getElementById("connection-form");
    mode.createAccount = document.getElementById("create-account");
    mode.lostPassword = document.getElementById("lost-password");
    mode.pipe = document.getElementById("pipe");

    // When the app is loaded we load to the page the backgroundColor wich is backup in localSatorage.
    mode.loadMode();

    // When the app is loaded we check or uncheck the switch according to the localStorage data.
    mode.handleSwitchChecked();
  },
  // Method who get the backgroundColor wich is back up in localStorage and call the switchBackgroundColor() method to change the color with the value of backgroundColor.
  loadMode: function () {
    // We get the value backup in localStorage.
    mode.backgroundColor = localStorage.getItem("mode");

    // If backgroundColor is dark.
    if (mode.backgroundColor && mode.backgroundColor === "dark") {
      // We call the switchBackgroundColor() method to change the color with the value of backgroundColor.
      mode.switchBackgroundColor(
        mode.backgroundColor,
        mode.darkTableBg,
        mode.darkTableBg1
      );
    } // Else backgroundColor === false.
    else {
      // We set a value by default to the mode key in localStorage.
      backgroundColorByDefault = localStorage.setItem("mode", "light");
      // We call the switchBackgroundColor() method to change the color with the value of backgroundColor.
      mode.switchBackgroundColor(
        mode.backgroundColorByDefault,
        mode.lightTableBg,
        mode.lightTableBg1
      );
    }
  },
  handleSelectBackgroundColorSwitch: function (evt) {
    // We get the DOM element from wich the event occured.
    mode.clickedSwitch = evt.currentTarget;
    // If the mode backup in localStorage have the light value.
    if (localStorage.getItem("mode") === "light") {
      // We backup in localStorage the new value of the mode.
      localStorage.setItem("mode", "dark");
      // We set the value dark to backgroundColor.
      mode.backgroundColor = "dark";
      // We call the switchBackgroundColor() method to change the background color with the backgroundColor in argument.
      mode.switchBackgroundColor(
        mode.backgroundColor,
        mode.darkTableBg,
        mode.darkTableBg1
      );
    } // Else if the mode backup in localStorage have the dark value.
    else if (localStorage.getItem("mode") === "dark") {
      // We backup in localStorage the new value of the mode.
      localStorage.setItem("mode", "light");
      // We set the value light to backgroundColor.
      mode.backgroundColor = "light";
      // We call the switchBackgroundColor() method to change the background color with the backgroundColor in argument.
      mode.switchBackgroundColor(
        mode.backgroundColor,
        mode.lightTableBg,
        mode.lightTableBg1
      );
    }
  },
  // Method who check or uncheck the switch according to the localStorage data.
  handleSwitchChecked: function () {
    // We get the value backup in localStorage.
    mode.backgroundColor = localStorage.getItem("mode");

    // If backgroundColor === true.
    if (mode.backgroundColor) {
      // If this the value of mode is light.
      if (mode.backgroundColor === "light") {
        // The switch must be not checked so we uncheck him.
        mode.switch.checked = false;
      } // Else the value of mode is dark.
      else {
        // The switch must be checked because the user check him to swtich to the dark mode. So we check him.
        mode.switch.checked = true;
      }
    } // Else we dont have a mode item in localStorage.
    else {
      // We uncheck the switch.
      mode.switch.checked = false;
    }
  },
  // Metho who switch the backgroundImage of the headers according to the localStorage data.
  switchBackgroundImage: function () {
    // We get the value backup in localStorage.
    mode.backgroundColor = localStorage.getItem("mode");

    // If headerHome === true.
    if (mode.headerHome) {
      // If backgroundColor === true.
      if (mode.backgroundColor) {
        // If this the value of mode is light.
        if (mode.backgroundColor == "light") {
          // We display the light mode backgroundImage to the headerHome.
          mode.headerHome.style.backgroundImage =
            "url('/assets/images/background/background-header.jpg')";
        } // Else the value of mode is dark.
        else {
          // We display the dark mode backgroundImage to the headerHome.
          mode.headerHome.style.backgroundImage =
            "url('/assets/images/background/background-header-dark-mode.jpg')";
        }
      } // Else we dont have a mode item in localStorage.
      else {
        // We display the light mode backgroundImage to the headerHome.
        mode.headerHome.style.backgroundImage =
          "url('/assets/images/background/background-header.jpg')";
      }
    } // If headerShared === true.
    else if (mode.headerShared) {
      if (mode.backgroundColor) {
        // If this the value of mode is light.
        if (mode.backgroundColor == "light") {
          // Change connection form colors
          mode.changeConnectionForm(mode.backgroundColor);
          // We display the light mode backgroundImage to the headerShared.
          mode.headerShared.style.backgroundImage =
            "url('/assets/images/background/background-header.jpg')";
        } // Else the value of mode is dark.
        else {
          // Change connection form colors
          mode.changeConnectionForm(mode.backgroundColor);
          // We display the dark mode backgroundImage to the headerShared.
          mode.headerShared.style.backgroundImage =
            "url('/assets/images/background/background-header-dark-mode.jpg')";
        }
      } // Else we dont have a mode item in localStorage.
      else {
        // We display the light mode backgroundImage to the headerShared.
        mode.headerShared.style.backgroundImage =
          "url('/assets/images/background/background-header.jpg')";
      }
    }
  },
  // Method to change the connection form colors (background, text color, etc...)
  changeConnectionForm: function (currentBackgroundColor) {
    // If current mode is 'dark', change the connection form background to white, remove the white border and set links color to black.
    if (
      mode.connectionForm &&
      mode.createAccount &&
      mode.lostPassword &&
      mode.pipe
    ) {
      if (currentBackgroundColor == "light") {
        mode.connectionForm.classList.remove("dark");
        mode.connectionForm.classList.remove("border-secondary");
        mode.createAccount.classList.remove("text-white");
        mode.lostPassword.classList.remove("text-white");
        mode.pipe.classList.add("text-success");
      }
      // If current mode is 'light', change the connection form background to dark, add a white border and set links color to green.
      else {
        mode.connectionForm.classList.add("dark");
        mode.connectionForm.classList.add("border-secondary");
        mode.connectionForm.classList.add("text-white");
        mode.createAccount.classList.add("text-white");
        mode.lostPassword.classList.add("text-white");
        mode.pipe.classList.remove("text-success");
      }
    }
  },
  // Method who switch the current backgroundColor to a newBackgroundColor.
  switchBackgroundColor: function (
    newBackgroundColor,
    newTableBg,
    newTableBg1
  ) {
    // We use the JS API classList to interact with the classes of the DOM elements.
    mode.body.classList.remove("dark", "light");
    if (mode.table) {
      mode.table.classList.remove("dark", "darktable", "table-striped");
    }

    // If the backgroundColor is different than the backgroundColorByDefault.
    if (newBackgroundColor !== mode.backgroundColorByDefault) {
      // We toggle the correspondent class to the body.
      mode.body.classList.add(newBackgroundColor);
      if (mode.table) {
        mode.table.classList.add(newTableBg);
        mode.table.classList.add(newTableBg1);
      }
    }

    // When we switch the backgroundColor we call the switchBackgroundImage() method to swtich the backgroundImage of the headers.
    mode.switchBackgroundImage();
  },
};
