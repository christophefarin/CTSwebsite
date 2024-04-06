/*
  This code snippet sets up an event listener that triggers when a row is selected in a DataTable.
  The selected row's data is then sent via AJAX to "action_cart.php" for processing.
  If the AJAX request is successful, it reloads another DataTable (#tabright) to refresh the cart display.

  - Initiates upon document load
  - Utilizes jQuery to interact with DOM elements
  - Uses DataTables library to manage tabular data
  - Handles row selection event in the DataTable
  - Sends row data via AJAX POST request to "action_cart.php"
  - Displays console logs for debugging
  - Handles errors in the AJAX request and logs them
  - Refreshes another DataTable (#tabright) upon successful AJAX response
*/
$(document).ready(function () {
  var table = $("#tableft").DataTable();

  // Event listener for selecting a row in the DataTable
  table.on("select", function (e, dt, type, indexes) {
    var rowData = table.row(dt).data();
    rowData.push("add");
    console.log(rowData);

    $.ajax({
      url: "php/action_cart.php",
      type: "POST",
      data: {
        id: rowData[0],
        type_cable: rowData[1],
        diam_ext: rowData[2],
        poids: rowData[3],
        section_utile: rowData[4],
        action: rowData[5],
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.error(jqXHR);
        console.error(textStatus);
        console.error(errorThrown);
      },
      success: function (response) {
        console.log(response);
        $("#tabright").DataTable().ajax.reload(); // Refresh the cart
      },
    });
  });
});
