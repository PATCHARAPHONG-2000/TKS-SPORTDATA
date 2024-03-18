$(document).ready(function () {
  var table = $("#index-event").DataTable({
    paging: true,
    ordering: false,
    searching: true,
    info: true,
    columnDefs: [
      {
        width: "2%",
        targets: 0,
      },
      {
        width: "15%",
        targets: 1,
      },
      {
        width: "15%",
        targets: 2,
      },
      {
        width: "5%",
        targets: 3,
      },
      {
        width: "15%",
        targets: 4,
      },
      {
        width: "15%",
        targets: 5,
      },
    ],
    initComplete: function () {
      var column4 = this.api().column(4);
      var select4 = $(
        '<select id="column4Filter" class="form-control custom-select"><option value="">ทั้งหมด</option></select>'
      )
        .appendTo($(column4.header()))
        .on("change", function () {
          var val = $.fn.dataTable.util.escapeRegex($(this).val());
          column4.search(val ? "^" + val + "$" : "", true, false).draw();
        });

      column4
        .data()
        .sort()
        .unique()
        .each(function (d) {
          select4.append('<option value="' + d + '">' + d + "</option>");
        });

      var column5 = this.api().column(5);
      var select5 = $(
        '<select id="column5Filter" class="form-control custom-select"><option value="">ทั้งหมด</option></select>'
      )
        .appendTo($(column5.header()))
        .on("change", function () {
          var val = $.fn.dataTable.util.escapeRegex($(this).val());
          column5.search(val ? "^" + val + "$" : "", true, false).draw();
        });

      column5
        .data()
        .sort()
        .unique()
        .each(function (d) {
          select5.append('<option value="' + d + '">' + d + "</option>");
        });

      var column6 = this.api().column(6);
      var select6 = $(
        '<select id="column6Filter" class="form-control custom-select"><option value="">ทั้งหมด</option></select>'
      )
        .appendTo($(column6.header()))
        .on("change", function () {
          var val = $.fn.dataTable.util.escapeRegex($(this).val());
          column6.search(val ? "^" + val + "$" : "", true, false).draw();
        });

      column6
        .data()
        .sort()
        .unique()
        .each(function (d) {
          select6.append('<option value="' + d + '">' + d + "</option>");
        });
    },
  });
});

function showAthletes() {
  var selectedName = document.getElementById("name_match").value;
  var table = document.getElementById("index-event");
  var rows = table.getElementsByTagName("tr");
  for (var i = 0; i < rows.length; i++) {
    var cells = rows[i].getElementsByTagName("td");
    if (cells.length > 0) {
      var matchName = cells[4].innerHTML; // Assuming ชื่อแมตท์ is the 5th column (index 4)
      if (matchName === selectedName || selectedName === "") {
        rows[i].style.display = "";
      } else {
        rows[i].style.display = "none";
      }
    }
  }
}
