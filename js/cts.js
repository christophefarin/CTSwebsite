/*
  These functions sends an AJAX request to the server to retrieve data based on a specified value and updates the HTML content of an element with the received data.

  Functionality:
  - Initiates an AJAX request to the server.
  - Sends a POST request to a php file.
  - Handles the response on success by updating the HTML content of the html element with the received data.
  - Logs errors to the console if the request fails.

  Events:
  - Executes when the DOM is fully loaded and ready or on a function call

  Dependencies:
  - Requires jQuery library for AJAX functionality.

  Key Components:
  - `type`: Specifies the type of HTTP request (POST in this case).
  - `url`: The target resource URL for the AJAX request.
  - `success`: Function to execute upon successful completion of the AJAX request, updating the content of the element with the ID "types".
  - `error`: Function to handle errors, logging details to the console.

  Execution:
  - Upon document ready or on a function call, triggers the AJAX request to fetch data from the specified URL.
*/

// Get cable tray types
$(document).ready(function () {
  $.ajax({
    type: "POST",
    url: "php/get_type_cdc.php",
    success: function (data) {
      $("#types").html(data);
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log(jqXHR);
      console.log(textStatus);
      console.log(errorThrown);
    },
  });
});

// Get heights of cable tray selected
function getHauteur(val) {
  $.ajax({
    type: "POST",
    url: "php/get_hauteur.php",
    data: "type_cdc=" + val,
    success: function (data) {
      $("#hauteurs").html(data);
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log(jqXHR);
      console.log(textStatus);
      console.log(errorThrown);
    },
  });
}

// Get the widths of the cable tray selected in the input select html element named "largeursmin"
function getLargeurMin(val) {
  var typeCdc = $("#types option:selected").val(); // Retrieve the value of the "types" element selected
  $.ajax({
    type: "POST",
    url: "php/get_largeur_min.php",
    data: "hauteur=" + val + "&type_cdc=" + typeCdc,
    success: function (data) {
      $("#largeursmin").html(data);
      getLargeurmax();
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log(jqXHR);
      console.log(textStatus);
      console.log(errorThrown);
    },
  });
}

// Get the widths of the cable tray selected in the input select html element named "largeursmax"
function getLargeurmax() {
  var typeCdc = $("#types option:selected").val(); // Retrieve the value of the "types" element selected
  var hauteur = $("#hauteurs option:selected").val(); // Retrieve the value of the "hauteurs" element selected
  $.ajax({
    type: "POST",
    url: "php/get_largeur_max.php",
    data: "hauteur=" + hauteur + "&type_cdc=" + typeCdc,
    success: function (data) {
      $("#largeursmax").html(data);
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log(jqXHR);
      console.log(textStatus);
      console.log(errorThrown);
    },
  });
}

// Cable tray height Check and Calculations
function calculs() {
  var hauteurCdc = parseInt($("#hauteurs option:selected").val()); // Retrieve the value of the "hauteurs" element selected and conversion to integer
  var reserve = document.getElementById("reserve").value; // Retrieve the value of the "reserve" element
  var nbCouches = document.getElementById("nbcouches").value; // Retrieve the value of the "reserve" element of the number of cable layers in the cable tray
  var largeursMin = parseInt($("#largeursmin option:selected").val()); // Retrieve the value of the "largeursmin" element selected and conversion to integer
  console.log(hauteurCdc);
  console.log(reserve);
  console.log(nbCouches);
  console.log(largeursMin);
  $.ajax({
    type: "POST",
    url: "php/get_calculs.php",
    success: function (data) {
      console.log(data);
      let tableau = JSON.parse(data); // Conversion to array format
      console.log(tableau);
      console.log(tableau[0]); // Sum of the diameters of the selected cables
      console.log(tableau[1]); // Sum of weights of selected cables
      console.log(tableau[2]); // Sum of sections of selected cables
      console.log(tableau[3]); // Maximum diameter among the selected cables
      // Checking if the height of the cable tray is sufficient
      var maxDiametre = tableau[3];
      if (hauteurCdc < maxDiametre) {
        lowHauteur(); // Alert message management function
      } else {
        $("#divMsgControlhauteur.alert").alert("close");
      }
      // Addition of the reserve in the amounts
      var coefReserve = 1 + reserve / 100;
      var resultPoids = (tableau[1] * coefReserve).toFixed(2); // Round to 2 digits after the decimal point
      var resultSection = (tableau[2] * coefReserve).toFixed(2); // Round to 2 digits after the decimal point
      if ((nbCouches > 0) & (nbCouches != "")) {
        resultDiametre = Math.max(
          (tableau[0] * coefReserve) / nbCouches,
          largeursMin
        );
      } else {
        resultDiametre = largeursMin;
      }
      console.log(coefReserve);
      console.log(resultDiametre);
      console.log(resultPoids);
      console.log(resultSection);
      // Display the values
      document.getElementById("largeurcible").value = resultDiametre;
      document.getElementById("chargecible").value = resultPoids;
      document.getElementById("volumecible").value = resultSection;
      // Launching the function for updating the results table with the calculated parameters
      $("#tableresult").DataTable().ajax.reload();
      //focus on the result div
      window.location = "#result";
      // Reset the noresult message
      $("#divMsgNoresult.alert").alert("close");
      // Displaying a message if the result table is empty
      setTimeout(noResult, 1000); // Timed execution of the alert message management function
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log(jqXHR);
      console.log(textStatus);
      console.log(errorThrown);
    },
  });
}

/*
  This function Compares the maximum width with the minimum width and checks for the existence of the alert element.
  If the maximum width is less than the minimum width and no existing alert is present, displays a danger alert.
  If the maximum width is greater than or equal to the minimum width, logs a message indicating valid values and closes any existing alert.
  Logs a message if there is already an existing alert.
*/
function controlValue() {
  var largeurMin = parseInt($("#largeursmin option:selected").val()); // Retrieve the value of the "largeursmin" element selected and conversion to integer
  var largeurMax = parseInt($("#largeursmax option:selected").val()); // Retrieve the value of the "largeursmax" element selected and conversion to integer
  var alertIsOn = document.getElementById("divMsgControlValue"); // Retrieve the value of the "divMsgControlValue" element
  if (
    (largeurMax < largeurMin) &
    (alertIsOn === null || alertIsOn === undefined)
  ) {
    createAlert(
      "",
      " La largeur max doit être supérieure ou égale à la largeur min",
      "",
      "danger",
      true,
      false,
      "pageMessages",
      "divMsgControlValue"
    );
  } else if (largeurMax >= largeurMin) {
    console.log("Les valeurs min et max sont ok");
    $("#divMsgControlValue.alert").alert("close");
  } else {
    console.log("Il existe déjà une alert");
    console.log(alertIsOn);
  }
}

/*
  This function checks if the selection of cables is empty in a DataTable.
  If the table is empty and no previous alert exists, it displays an informational message to the user.
  Otherwise, it logs a message indicating that either an alert already exists or there is a selection of cables.
*/
function selVide() {
  oTable = $("#tabright").dataTable();
  var oSettings = oTable.fnSettings();
  var alertIsOn = document.getElementById("divMsgSelvide");
  if (
    (oSettings.fnRecordsTotal() <= 0) &
    (alertIsOn === null || alertIsOn === undefined)
  ) {
    createAlert(
      "",
      " Votre sélection de câbles est vide",
      "",
      "info",
      false,
      true,
      "pageMessages",
      "divMsgSelvide"
    );
  } else {
    console.log("Il existe déjà une alert ou une sélection");
    console.log(alertIsOn);
  }
}

/*
  This function checks if the result table is empty and displays a warning message accordingly.
  If the table with ID "tableresult" does not have any data (as indicated by the presence of the class "dataTables_empty"), and if the alert element is not already displayed, it creates a new alert with a warning message.
  Otherwise, it logs a message to the console indicating that an alert already exists or that the result table is not empty.
*/
function noResult() {
  var alertIsOn = document.getElementById("divMsgNoresult");
  if (
    $("#tableresult tbody tr td").hasClass("dataTables_empty") &
    (alertIsOn === null || alertIsOn === undefined)
  ) {
    createAlert(
      "",
      " Pas de résultat, veuillez réessayer avec d'autres données",
      "",
      "warning",
      true,
      false,
      "pageMessages",
      "divMsgNoresult"
    );
  } else {
    console.log(
      "Il existe déjà une alert ou le tableau de résultat n'est pas vide"
    );
    console.log(alertIsOn);
  }
}

/*
  This function checks if the height of the cable tray is sufficient.
  If such an alert does not exist (alertIsOn is null or undefined), it calls the createAlert function to display a danger alert message indicating that the height of the cable tray is less than the diameter of at least one cable.
  If the alert element already exists, it logs a message to the console saying that there is already an alert present or that the cable tray height is sufficient.
*/
function lowHauteur() {
  var alertIsOn = document.getElementById("divMsgControlhauteur");
  if (alertIsOn === null || alertIsOn === undefined) {
    createAlert(
      "",
      " La hauteur du chemin de câble est inférieure au diamètre d'au moins un câble",
      "",
      "danger",
      true,
      false,
      "pageMessages",
      "divMsgControlhauteur"
    );
  } else {
    console.log(
      "Il existe déjà une alert ou la hauteur du chemin de câbles est suffisante"
    );
    console.log(alertIsOn);
  }
}

/*
  This function checks the validity of a form named "formdata".
  If the form is valid, it logs a message indicating that the form is okay, performs calculations using the calculs() function, and returns.
  If the form is not valid, it logs a message indicating that the form is not okay and creates an alert using the createAlert() function.
*/
function CheckValidation() {
  var isValidForm = document.forms["formdata"].checkValidity();
  if (isValidForm) {
    console.log("formulaire ok");
    calculs();
    return;
  } else {
    console.log("formulaire non ok");
    createAlert(
      "",
      " Veuillez choisir les caractéristiques du chemin de câbles",
      "",
      "info",
      false,
      true,
      "pageMessages",
      "divMsgCheckValidation"
    );
    return false;
  }
}
