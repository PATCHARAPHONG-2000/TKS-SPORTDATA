$(document).ready(function () {
  var table = $("#certificate").DataTable({
    paging: true,
    ordering: false,
    searching: true,
    info: true,
    className: "select-checkbox",

    columnDefs: [
      { width: "10%", targets: 1 },
      { width: "15%", targets: 2 },
      { width: "15%", targets: 3 },
      { width: "15%", targets: 4 },
      { width: "20%", targets: 5 },
      { width: "15%", targets: 6 },
    ],
  });

  $("#select_all").on("click", function () {
    $(".checkbox").prop("checked", this.checked);

    // ตรวจสอบสถานะของ "Select All" เพื่อกำหนดการใช้งานของปุ่ม "Print Selected"
    if (this.checked) {
      $("#print-selected").prop("disabled", false);
    } else {
      $("#print-selected").prop("disabled", true);
    }
  });

  $(".checkbox").on("click", function () {
    if ($(".checkbox:checked").length === $(".checkbox").length) {
      $("#select_all").prop("checked", true);
    } else {
      $("#select_all").prop("checked", false);
    }

    // ตรวจสอบสถานะของ "Select All" เพื่อกำหนดการใช้งานของปุ่ม "Print Selected"
    if ($(".checkbox:checked").length > 0) {
      $("#print-selected").prop("disabled", false);
    } else {
      $("#print-selected").prop("disabled", true);
    }
  });

  $("#print-selected").on("click", function () {
    var selectedIds = $(".checkbox:checked")
      .map(function () {
        return $(this).val();
      })
      .get();

    if (selectedIds.length > 0) {
      var url = "../adcard/Certificate?id=" + selectedIds.join(",");
      window.open(url, "_blank");
    } else {
      Swal.fire({
        text: "กรุณาเลือกอย่างน้อยหนึ่งรายการ",
        icon: "warning",
        confirmButtonText: "ตกลง",
      });
    }
  });

  // ตรวจสอบการเลือก checkbox เพื่ออัปเดตสถานะของ select_all
  table.on("draw", function () {
    if ($(".checkbox:checked").length === $(".checkbox").length) {
      $("#select_all").prop("checked", true);
    } else {
      $("#select_all").prop("checked", false);
    }
  });
});
