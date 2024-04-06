/*
  This function dynamically creates an alert message with customizable parameters.

  Parameters:
  - title: Title text for the alert.
  - summary: Summary text for the alert.
  - details: Detailed information for the alert.
  - severity: Severity level of the alert (options: danger, success, info, warning).
  - dismissible: Boolean flag indicating whether the alert can be dismissed (false or true).
  - autoDismiss: Boolean flag indicating whether the alert should automatically dismiss after a set time (false or true).
  - appendToId: ID of the parent div where the alert will be appended.
  - divId: ID for the message div of the alert.

  Usage: createAlert(title, summary, details, severity, dismissible, autoDismiss, appendToId, divId);

  Notes:
  - Icons are associated with each severity level using iconMap object.
  - The alert is styled based on severity and other options provided.
  - Icons are prepended to title, summary, and details if applicable.
  - If the alert is dismissible, a close button is added.
  - The alert is appended to the specified parent div.
  - If autoDismiss is enabled, the alert will fade out and be removed after 5 seconds.
*/

function createAlert(
  title, //text
  summary, //text
  details, //text
  severity, //danger, success, info, warning
  dismissible, //false,true
  autoDismiss, //false,true
  appendToId, //parent div id
  divId //message div id
) {
  var iconMap = {
    info: "fa-solid fa-circle-info",
    success: "fa-solid fa-circle-check",
    warning: "fa-solid fa-triangle-exclamation",
    danger: "fa-solid fa-circle-exclamation",
  };

  var iconAdded = false;

  var alertClasses = ["alert", "animated", "flipInX"];
  alertClasses.push("alert-" + severity.toLowerCase());

  if (dismissible) {
    alertClasses.push("alert-dismissible");
  }

  var msgIcon = $("<i />", {
    class: iconMap[severity],
  });

  var msg = $("<div />", {
    class: alertClasses.join(" "),
    id: divId,
  });

  if (title) {
    var msgTitle = $("<h4 />", {
      html: title,
    }).appendTo(msg);

    if (!iconAdded) {
      msgTitle.prepend(msgIcon);
      iconAdded = true;
    }
  }

  if (summary) {
    var msgSummary = $("<strong />", {
      class: "my-0",
      html: summary,
    }).appendTo(msg);

    if (!iconAdded) {
      msgSummary.prepend(msgIcon);
      iconAdded = true;
    }
  }

  if (details) {
    var msgDetails = $("<p />", {
      class: "my-0",
      html: details,
    }).appendTo(msg);

    if (!iconAdded) {
      msgDetails.prepend(msgIcon);
      iconAdded = true;
    }
  }

  if (dismissible) {
    var msgClose = $("<span />", {
      html: '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>',
    }).appendTo(msg);
  }

  $("#" + appendToId).prepend(msg);

  if (autoDismiss) {
    setTimeout(function () {
      msg.addClass("flipOutX");
      setTimeout(function () {
        msg.remove();
      }, 1000);
    }, 5000);
  }
}
