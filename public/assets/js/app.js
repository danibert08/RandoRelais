const app = {
  init: function () {
    // We load the component mode.js.
    mode.init();

    // We load the component angelInscrption.js.
    registration.init();

    // We load the component updateUserProfil.js.
    userProfile.init();
  },
};

document.addEventListener("DOMContentLoaded", app.init);
