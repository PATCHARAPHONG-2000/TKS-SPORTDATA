$(document).ready(function () {
  var table = $("#employeeTable").DataTable({
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
      { width: "10%", targets: 7 },
    ],

    initComplete: function () {
      var column4 = this.api().column(5);
      $(column4.header()).html('<label for="posi4">ตำแหน่ง: </label>'); // Update "for" attribute
      var select4 = $(
        '<select id="posi4" class="form-control custom-select"><option value="">ทั้งหมด</option></select>'
      )
        .appendTo($(column4.header()))
        .on("change", function () {
          var val = $.fn.dataTable.util.escapeRegex($(this).val());
          column4.search(val ? "^" + val + "$" : "", true, false).draw();
        });
      column4
        .data()
        .unique()
        .sort()
        .each(function (d) {
          select4.append('<option value="' + d + '">' + d + "</option>");
        });

      var column5 = this.api().column(2);
      $(column5.header()).html('<label for="province">ประเภทกีฬา: </label>');
      var select5 = $(
        '<select id="province" class="form-control custom-select"><option value="">ทั้งหมด</option></select>'
      )
        .appendTo($(column5.header()))
        .on("change", function () {
          var val = $.fn.dataTable.util.escapeRegex($(this).val());
          column5.search(val ? "^" + val + "$" : "", true, false).draw();
        });
      column5
        .data()
        .unique()
        .sort()
        .each(function (d) {
          select5.append('<option value="' + d + '">' + d + "</option>");
        });
    },
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
      var url = "adcard-sport.php?id=" + selectedIds.join(",");
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
