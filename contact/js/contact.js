/*
This code ensures that when the document is fully loaded, it sets up an event listener for form submission on the element with the ID "contact-form".
When the form is submitted, it calls the controlSend() function to handle the form data and send it asynchronously to a server-side script for processing.
*/
$(document).ready(function () {
  $("#contact-form").submit(function (event) {
    // cancels the form submission
    event.preventDefault();
    controlSend();
  });

  /*
  This function sends a POST request to a PHP script (mail.php) using AJAX.
  It collects form data (name, email, message, and reCaptcha response) from specific input fields on the webpage.
  Upon successful completion of the AJAX request, it processes the response data as follows:
  - If the response contains code equal to 0, it triggers an alert with a warning message using the alertsendmail function.
  - If the response does not have code equal to 0, it closes any existing error alerts.
  - If the response contains code equal to 1, it triggers an alert with a success message using the alertsendmail function, clears the form inputs, and resets the reCaptcha.
  - If the response does not have code equal to 1, it closes any existing success alerts.
  In case of an error during the AJAX request, it logs the details in the console.
  The function interacts with the DOM to handle form submission, display alerts, and interact with Google reCaptcha for validation.
  */
  function controlSend() {
    formData = {
      name: $("input[name=name]").val(),
      email: $("input[name=email]").val(),
      message: $("textarea[name=message]").val(),
      grecaptcharesponse: grecaptcha.getResponse(),
    };
    console.log(formData);
    $.ajax({
      type: "POST",
      url: "contact/mail.php",
      data: formData,
      success: function (data) {
        console.log(data);
        if (data.code === 0) {
          alertSendMail(data.message, "warning", "errorSendmail");
        } else {
          console.log(data.message);
          $("#errorSendmail.alert").alert("close");
        }
        if (data.code === 1) {
          alertSendMail(data.message, "success", "okSendmail");
          $("#contact-form")
            .closest("form")
            .find("input[type=text], input[type=email], textarea")
            .val("");
          grecaptcha.reset(); // Reset Captcha
        } else {
          console.log(data.message);
          $("#okSendmail.alert").alert("close");
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.log(jqXHR);
        console.log(textStatus);
        console.log(errorThrown);
      },
    });
  }
});

/*
This function is used to display an alert message on the web page if a specific condition is met.
It checks if an element with a given ID exists, and if not, it creates an alert message in the event of an error or success in sending the email.
*/
function alertSendMail(msg, severity, divMsgAlertSendmail) {
  var alertIsOn = document.getElementById(divMsgAlertSendmail);
  if (alertIsOn === null || alertIsOn === undefined) {
    createAlert(
      "",
      " " + msg,
      "",
      severity,
      true,
      false,
      "pageMessages",
      divMsgAlertSendmail
    );
  } else {
    console.log("Il existe déjà une alert");
    console.log(alertIsOn);
  }
}
