const registration = {
  // Proprietes availables in our object.
  angelSwitch: null,
  tentCheckBox: null,
  bedroomCheckBox: null,
  shelterCheckBox: null,
  deliveryCheckBox: null,
  showerCheckBox: null,
  waterCheckBox: null,
  breakfastCheckBox: null,
  sandwichCheckBox: null,
  dinnerCheckBox: null,
  powerCheckBox: null,
  init: function () {
    // We get the DOM elements that we need to interate with.
    // We add a listener & a handler on the click event on each of them.

    // Switch to Angel registration element.
    registration.angelSwitch = document.getElementById(
      "registration_form_status"
    );
    // If registration.angelSwitch === true.
    if (registration.angelSwitch) {
      // We add a listener on the click event and we callback the displayAngelData() method.
      registration.angelSwitch.addEventListener(
        "click",
        registration.displayAngelData
      );
      // We check if the angelSwitch is checked.
      if (registration.angelSwitch.checked === true) {
        // If angelSwitch is checked we simulate a click on the angelSwitch.
        registration.angelSwitch.click();
        // With this click we want the angelSwitch to stay check.
        registration.angelSwitch.checked = true;
      }
    }

    // ! START DON'T TOUCH.
    // TODO START : use this code later for improve the services's display.
    // // Service Emplacement de tente icon element.
    // registration.tentCheckBox = document.getElementById(
    //   "emplacement-de-tente"
    // );
    // if (registration.tentCheckBox) {
    //   registration.tentCheckBox.addEventListener(
    //     "click",
    //     registration.handleProfileUpdate
    //   );
    // }

    // // Service Lit icon element.
    // registration.bedroomCheckBox = document.getElementById("lit");
    // if (registration.bedroomCheckBox) {
    //   registration.bedroomCheckBox.addEventListener(
    //     "click",
    //     registration.handleProfileUpdate
    //   );
    // }

    // // Service Abri icon element.
    // registration.shelterCheckBox = document.getElementById("abri");
    // if (registration.shelterCheckBox) {
    //   registration.shelterCheckBox.addEventListener(
    //     "click",
    //     registration.handleProfileUpdate
    //   );;
    // }

    // // Serice Réception de colis icon element.
    // registration.deliveryCheckBox =
    //   document.getElementById("reception-de-colis");

    // if (registration.deliveryCheckBox) {
    //   registration.deliveryCheckBox.addEventListener(
    //     "click",
    //     registration.handleProfileUpdate
    //   );
    // }

    // // Service Douche inco element.
    // registration.showerCheckBox = document.getElementById("douche");
    // if (registration.showerCheckBox) {
    //   registration.showerCheckBox.addEventListener(
    //     "click",
    //     registration.handleProfileUpdate
    //   );
    // }

    // // Service Eau icon element.
    // registration.waterCheckBox = document.getElementById("eau");
    // if (registration.waterCheckBox) {
    //   registration.waterCheckBox.addEventListener(
    //     "click",
    //     registration.handleProfileUpdate
    //   );
    // }

    // // Service Petit déjeuner icon element.
    // registration.breakfastCheckBox = document.getElementById("petit-dejeuner");
    // if (registration.breakfastCheckBox) {
    //   registration.breakfastCheckBox.addEventListener(
    //     "click",
    //     registration.handleProfileUpdate
    //   );
    // }

    // // Servce Sandwich icon element.
    // registration.sandwichCheckBox = document.getElementById("sandwich");
    // if (registration.sandwichCheckBox) {
    //   registration.sandwichCheckBox.addEventListener(
    //     "click",
    //     registration.handleProfileUpdate
    //   );
    // }

    // // Service Diner icon element.
    // registration.dinnerCheckBox = document.getElementById("diner");
    // if (registration.dinnerCheckBox) {
    //   registration.dinnerCheckBox.addEventListener(
    //     "click",
    //     registration.handleProfileUpdate
    //   );
    // }

    // // Serice Prise électrique icon element.
    // registration.powerCheckBox = document.getElementById("prise-electrique");
    // if (registration.powerCheckBox) {
    //   registration.powerCheckBox.addEventListener(
    //     "click",
    //     registration.handleProfileUpdate
    //   );
    // }
    // TODO END.
    // ! END.
  },
  // Method who diplay the angel data if angelSwitch is clicked.
  displayAngelData: function (evt) {
    // We get the DOM element from wich the event occured.
    clickedElement = evt.currentTarget;
    // We get the DOM element on wich the CSS classes will be toggle.
    // We toggle the CSS class with the JS API classList.
    if (clickedElement === registration.angelSwitch) {
      document
        .getElementById("angel_subscription_form")
        .classList.toggle("d-none");
    }
  },
  // Method who toggle CSS classes on a service after is checked.
  validateService: function (evt) {
    selectedService = evt.currentTarget;
    // TODO
  },
};
