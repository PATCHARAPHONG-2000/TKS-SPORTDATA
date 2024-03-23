$(document).ready(function () {
  var table = $("#users").DataTable({
    paging: true,
    ordering: false,
    searching: true,
    info: true,
    columnDefs: [
      { width: "5%", targets: 0 },
      { width: "10%", targets: 1 },
      { width: "10%", targets: 2 },
      { width: "5%", targets: 3 },
      { width: "10%", targets: 4 },
      { width: "15%", targets: 5 },
      { width: "10%", targets: 6 },
    ],
  });
});
