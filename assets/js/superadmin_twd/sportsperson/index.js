$(document).ready(function () {
  var table = $("#sportsperson").DataTable({
    paging: true,
    ordering: false,
    searching: true,
    info: true,
    columnDefs: [
      { width: "2%", targets: 0 },
      { width: "15%", targets: 1 },
      { width: "15%", targets: 2 },
      { width: "5%", targets: 3 },
      { width: "15%", targets: 4 },
      { width: "15%", targets: 5 },
    ],
    initComplete: function () {
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
    },
  });
});
