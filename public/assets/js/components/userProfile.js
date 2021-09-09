const userProfile = {
  // Proprietes availables in our object.
  modifyButton: null,
  saveButton: null,
  deleteButton: null,
  deletePicureButton: null,
  angelSwitch: null,
  pictureField: null,
  uploadField: null,
  firstNameField: null,
  lastNameField: null,
  emailField: null,
  passWordField: null,
  phoneNumberField: null,
  zipCodeField: null,
  cityField: null,
  servicesField: null,
  angelFields: null,
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
    // We add a listener & a handler on the click evt on each of them.

    // Switch to become Angel element.
    userProfile.angelSwitch = document.getElementById(
      "user_profile_currentStatus"
    );

    // Form fields related to the angel.
    userProfile.angelFields = document.getElementById(
      "angel_subscription_form"
    );

    // If userProfile.angelSwitch === true.
    if (userProfile.angelSwitch) {
      // We add a listener on the click event and we callback the displayAngelData() method.
      userProfile.angelSwitch.addEventListener(
        "click",
        userProfile.displayAngelData
      );
      // We check if the angelSwitch is checked.
      if (userProfile.angelSwitch.checked === true) {
        // If angelSwitch is checked we simulate a click on the angelSwitch.
        userProfile.angelSwitch.click();
        // With this click we want the angelSwitch to stay check.
        userProfile.angelSwitch.checked = true;
        // We toggle the CSS class with the JS API classList.
        userProfile.angelFields.classList.toggle("d-none");
      }
    }

    // Modify button element.
    userProfile.modifyButton = document.getElementById("modify-button");
    // If modifyButton === true.
    if (userProfile.modifyButton) {
      // We add a listener on the click event and we callback the handleProfilUpdate() method.
      userProfile.modifyButton.addEventListener(
        "click",
        userProfile.handleProfileUpdate
      );
    }

    // Save button element.
    userProfile.saveButton = document.getElementById("save-button");
    // If modifyButton === true.
    if (userProfile.saveButton) {
      // We add a listener on the click event and we callback the handleProfilUpdate() method.
      userProfile.saveButton.addEventListener(
        "click",
        userProfile.handleProfileUpdate
      );
    }

    // Delete button element.
    userProfile.deleteButton = document.getElementById("delete-button");
    // If modifyButton === true.
    if (userProfile.deleteButton) {
      // We add a listener on the click event and we callback the handleProfilUpdate() method.
      userProfile.deleteButton.addEventListener(
        "click",
        userProfile.handleProfileUpdate
      );
    }

    // Delete picture button element.
    userProfile.deletePicureButton = document.getElementById(
      "delete-picture-button"
    );
    if (userProfile.deletePicureButton) {
      // We add a listener on the click event and we callback the handleProfilUpdate() method.
      userProfile.deletePicureButton.addEventListener(
        "click",
        userProfile.handleProfileUpdate
      );
    }

    // Form fields elements.
    userProfile.uploadField = document.getElementById("user_profile_upload");
    userProfile.pictureField = document.getElementById("user_profile_picture");
    userProfile.firstNameField = document.getElementById(
      "user_profile_firstName"
    );
    userProfile.lastNameField = document.getElementById(
      "user_profile_lastName"
    );
    userProfile.emailField = document.getElementById("user_profile_email");
    userProfile.phoneNumberField = document.getElementById(
      "user_profile_phoneNumber"
    );
    userProfile.zipCodeField = document.getElementById("user_profile_zipCode");
    userProfile.cityField = document.getElementById("user_profile_city");
    userProfile.servicesField = document.getElementById(
      "user_profile_services"
    );

    // ! START DON'T TOUCH.
    // TODO START : use this code later for improve the services's display.
    // // Service Emplacement de tente icon element.
    // userProfile.tentCheckBox = document.getElementById(
    //   "emplacement-de-tente"
    // );
    // if (userProfile.tentCheckBox) {
    //   userProfile.tentCheckBox.addEventListener(
    //     "click",
    //     userProfile.handleProfileUpdate
    //   );
    // }

    // // Service Lit icon element.
    // userProfile.bedroomCheckBox = document.getElementById("lit");
    // if (userProfile.bedroomCheckBox) {
    //   userProfile.bedroomCheckBox.addEventListener(
    //     "click",
    //     userProfile.handleProfileUpdate
    //   );
    // }

    // // Service Abri icon element.
    // userProfile.shelterCheckBox = document.getElementById("abri");
    // if (userProfile.shelterCheckBox) {
    //   userProfile.shelterCheckBox.addEventListener(
    //     "click",
    //     userProfile.handleProfileUpdate
    //   );;
    // }

    // // Serice Réception de colis icon element.
    // userProfile.deliveryCheckBox =
    //   document.getElementById("reception-de-colis");

    // if (userProfile.deliveryCheckBox) {
    //   userProfile.deliveryCheckBox.addEventListener(
    //     "click",
    //     userProfile.handleProfileUpdate
    //   );
    // }

    // // Service Douche inco element.
    // userProfile.showerCheckBox = document.getElementById("douche");
    // if (userProfile.showerCheckBox) {
    //   userProfile.showerCheckBox.addEventListener(
    //     "click",
    //     userProfile.handleProfileUpdate
    //   );
    // }

    // // Service Eau icon element.
    // userProfile.waterCheckBox = document.getElementById("eau");
    // if (userProfile.waterCheckBox) {
    //   userProfile.waterCheckBox.addEventListener(
    //     "click",
    //     userProfile.handleProfileUpdate
    //   );
    // }

    // // Service Petit déjeuner icon element.
    // userProfile.breakfastCheckBox = document.getElementById("petit-dejeuner");
    // if (userProfile.breakfastCheckBox) {
    //   userProfile.breakfastCheckBox.addEventListener(
    //     "click",
    //     userProfile.handleProfileUpdate
    //   );
    // }

    // // Servce Sandwich icon element.
    // userProfile.sandwichCheckBox = document.getElementById("sandwich");
    // if (userProfile.sandwichCheckBox) {
    //   userProfile.sandwichCheckBox.addEventListener(
    //     "click",
    //     userProfile.handleProfileUpdate
    //   );
    // }

    // // Service Diner icon element.
    // userProfile.dinnerCheckBox = document.getElementById("diner");
    // if (userProfile.dinnerCheckBox) {
    //   userProfile.dinnerCheckBox.addEventListener(
    //     "click",
    //     userProfile.handleProfileUpdate
    //   );
    // }

    // // Serice Prise électrique icon element.
    // userProfile.powerCheckBox = document.getElementById("prise-electrique");
    // if (userProfile.powerCheckBox) {
    //   userProfile.powerCheckBox.addEventListener(
    //     "click",
    //     userProfile.handleProfileUpdate
    //   );
    // }
    // TODO END.
    // ! END.
  },
  // Method who, after a click on the modifyButton, allow the uer to acces the form's fields to modify is data.
  handleProfileUpdate: function (evt) {
    // We get the DOM element from wich the event occured.
    clickedElement = evt.currentTarget;

    // If selectedElement is modifyButton.
    if (clickedElement == userProfile.modifyButton) {
      // We call our method.
      userProfile.handleDisplayNone();

      // If the form fields elements exist.
      if (
        userProfile.angelSwitch &&
        userProfile.firstNameField &&
        userProfile.lastNameField &&
        userProfile.emailField &&
        userProfile.phoneNumberField &&
        userProfile.zipCodeField &&
        userProfile.cityField &&
        userProfile.servicesField
      ) {
        // We call our methods.
        userProfile.removeDisabledAttribute();
        userProfile.setPlaceholderAttribute();
      }
    }
  },
  // Method who display the form fields for the User::ANGEL_STATUS.
  displayAngelData: function (evt) {
    // We get the DOM element from wich the event occured.
    clickedElement = evt.currentTarget;
    // We get the DOM element on wich the CSS classes will be toggle.
    // We toggle the CSS class with the JS API classList.
    if (clickedElement === userProfile.angelSwitch) {
      userProfile.angelFields.classList.toggle("d-none");
    }
  },
  // Method who add and toggle the display none class on our DOM elements.
  handleDisplayNone: function () {
    // We get the DOM element on wich the CSS classes will be toggle.
    // We get the toggle the CSS class with the JS API classList.

    // We add the CSS class display none to modifyButton.
    userProfile.modifyButton.classList.add("d-none");
    // We toggle the CSS class display none to saveButton.
    userProfile.saveButton.classList.toggle("d-none");
    // We toggle the CSS class display none to delete-button.
    userProfile.deleteButton.classList.toggle("d-none");
    // We toggle the CSS class display none to delete-picture-button.
    userProfile.deletePicureButton.classList.toggle("d-none");
    // We toggle the CSS class display none to uploadedField.
    userProfile.uploadField.classList.toggle("d-none");
  },
  // Method who, after a click on the userProfile.modifyButton, remove the disabled attribute on the form fields.
  removeDisabledAttribute: function () {
    // We remove the HTML's attribute disabled.
    userProfile.angelSwitch.removeAttribute("disabled");
    userProfile.firstNameField.removeAttribute("disabled");
    userProfile.firstNameField.removeAttribute("disabled");
    userProfile.lastNameField.removeAttribute("disabled");
    userProfile.emailField.removeAttribute("disabled");
    userProfile.phoneNumberField.removeAttribute("disabled");
    userProfile.zipCodeField.removeAttribute("disabled");
    userProfile.cityField.removeAttribute("disabled");

    // We get all the checkbox in the block userProfile.servicesField
    let servicesFieldCheckboxes =
      userProfile.servicesField.querySelectorAll('[type="checkbox"]');

    // For each checkbox among servicesFieldCheckboxes.
    for (let serviceCheckbox of servicesFieldCheckboxes) {
      // We remove the HTML's attributes disabled.
      serviceCheckbox.removeAttribute("disabled");
    }
  },
  // Method who set plaholders on the form fields related to the User::ANGEL_STATUS if they don't contains data.
  setPlaceholderAttribute: function () {
    // If the form filed have the placeholder attribute.
    if (
      userProfile.phoneNumberField.hasAttribute("placeholder") &&
      userProfile.zipCodeField.hasAttribute("placeholder") &&
      userProfile.cityField.hasAttribute("placeholder")
    ) {
      // We do nothing.
      return;
    } // Else they don't have the placeholder attribute.
    else {
      // We set placeholders to them.
      userProfile.phoneNumberField.setAttribute(
        "placeholder",
        "Numéro de téléphone"
      );
      userProfile.zipCodeField.setAttribute("placeholder", "Code postal");
      userProfile.cityField.setAttribute("placeholder", "Commune");
    }
  },
};
