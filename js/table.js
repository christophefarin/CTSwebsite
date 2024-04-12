/*
  This JavaScript code uses DataTables, a powerful jQuery plugin for creating interactive tables with advanced features.
  The code initializes three different DataTable instances, customizing each according to specific requirements.
*/

$(document).ready(function () {
  var table1 = $("#tableft").DataTable({
    stateSave: true, // Maintains the state of the table (page, filters, etc.)
    language: {
      url: "datatables/media/french.json",
      select: {
        rows: { _: " %d lignes sélectionnées", 1: " 1 ligne sélectionnée" },
      },
    },
    processing: true,
    serverSide: true,
    order: [],
    ajax: {
      url: "php/fetch.php",
      type: "POST",
      error: function (jqXHR, ajaxOptions, thrownError) {
        alert(
          thrownError +
            "\r\n" +
            jqXHR.statusText +
            "\r\n" +
            jqXHR.responseText +
            "\r\n" +
            ajaxOptions.responseText
        );
      },
    },
    // Select only one line at a time with one click
    select: {
      style: "single",
    },
    columnDefs: [
      { targets: [0, 2, 3, 4], className: "dt-body-right" },
      { targets: [1], className: "dt-body-left" },
      { targets: "_all", className: "dt-head-center" },
      {
        targets: [2, 3, 4],
        visible: false,
        searchable: false,
      },
    ],
    dom: "Blfrtip",
    lengthMenu: [
      [10, 25, 50, -1],
      [10, 25, 50, "All"],
    ],
    fixedColumns: {
      heightMatch: "none",
    },
  });
  var table2 = $("#tabright").DataTable({
    stateSave: true, // Maintains the state of the table (page, filters, etc.)
    language: {
      url: "datatables/media/french.json",
    },
    processing: true,
    serverSide: true,
    ordering: false,
    ajax: {
      url: "php/fetch_cart.php",
      type: "POST",
      error: function (jqXHR, ajaxOptions, thrownError) {
        alert(
          thrownError +
            "\r\n" +
            jqXHR.statusText +
            "\r\n" +
            jqXHR.responseText +
            "\r\n" +
            ajaxOptions.responseText
        );
      },
    },
    columnDefs: [
      { targets: [0, 2, 3, 4, 5], className: "dt-body-right" },
      { targets: [1], className: "dt-body-left" },
      { targets: "_all", className: "dt-head-center" },
      {
        targets: [2, 3, 4],
        visible: false,
        searchable: false,
      },
      {
        targets: 0,
        width: "10%",
        searchable: false,
      },
      {
        targets: 1,
        width: "80%",
      },
      {
        targets: 5,
        width: "10%",
      },
    ],
    dom: "<t>i",
    lengthMenu: [
      [10, 25, 50, -1],
      [10, 25, 50, "All"],
    ],
    fixedColumns: {
      heightMatch: "none",
    },
  });
  // Tabledit plugin configuration for inline editing within table2
  // Event listener on draw.dt event for table2, triggering Tabledit functionality
  $("#tabright").on("draw.dt", function () {
    $("#tabright").Tabledit({
      url: "php/action_cart.php",
      dataType: "json",
      columns: {
        identifier: [0, "id"],
        editable: [[2, "nombre"]],
      },
      hideIdentifier: false,
      restoreButton: false,

      error: function (jqXHR, textStatus, errorThrown) {
        console.log(jqXHR);
        console.log(textStatus);
        console.log(errorThrown);
      },
      onSuccess: function (data, textStatus, jqXHR) {
        // Executed when ajax request is completed
        console.log(data);
        $("#tabright").DataTable().draw(false); // Stay on the same page after a delete or an edit
      },
    });
    dataEmpty();
  });

  var table3 = $("#tableresult").DataTable({
    stateSave: true, // Maintains the state of the table (page, filters, etc.)
    language: {
      url: "datatables/media/french.json",
    },
    processing: true,
    serverSide: true,
    ordering: false,
    searching: false,
    ajax: {
      url: "php/fetch_result.php",
      type: "POST",
      data: function (d) {
        (d.type_cdc = $("#types option:selected").val()),
          (d.hauteur = $("#hauteurs option:selected").val()),
          (d.largeurmax = $("#largeursmax option:selected").val()),
          (d.result_diam = $("#largeurcible").val()),
          (d.result_poids = $("#chargecible").val()),
          (d.result_section = $("#volumecible").val());
      },
      error: function (jqXHR, ajaxOptions, thrownError) {
        alert(
          thrownError +
            "\r\n" +
            jqXHR.statusText +
            "\r\n" +
            jqXHR.responseText +
            "\r\n" +
            ajaxOptions.responseText
        );
      },
    },
    columnDefs: [
      { targets: [0, 2, 3, 4, 5], className: "dt-body-right" },
      { targets: [1], className: "dt-body-left" },
      { targets: "_all", className: "dt-head-center" },
      {
        targets: [2, 3, 4, 5],
        width: "16%",
      },
      {
        targets: 0,
        width: "6%",
      },
      {
        targets: 1,
        width: "30%",
      },
    ],
    dom: "Blrtip",
    lengthMenu: [
      [10, 25, 50, -1],
      [10, 25, 50, "All"],
    ],
    fixedColumns: {
      heightMatch: "none",
    },
  });
});

// Hiding edit and delete buttons when the table is empty
function dataEmpty() {
  if ($("#tabright tbody tr td").hasClass("dataTables_empty")) {
    $(".tabledit-toolbar").hide();
  }
}
