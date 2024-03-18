$(document).ready(function () {
  var table = $("#index-event").DataTable({
    paging: true,
    ordering: false,
    searching: true,
    info: true,
    className: "select-checkbox",
    columnDefs: [
      { width: "1%", targets: 0 },
      { width: "2%", targets: 1 },
      { width: "10%", targets: 2 },
      { width: "10%", targets: 3 },
      { width: "5%", targets: 4 },
      { width: "10%", targets: 5 },
      { width: "10%", targets: 6 },
      { width: "10%", targets: 7 },
      { width: "3%", targets: 8 },
      { width: "10%", targets: 9 },
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

      var column7 = this.api().column(7);
      var select7 = $(
        '<select id="column7Filter" class="form-control custom-select"><option value="">ทั้งหมด</option></select>'
      )
        .appendTo($(column7.header()))
        .on("change", function () {
          var val = $.fn.dataTable.util.escapeRegex($(this).val());
          column7.search(val ? "^" + val + "$" : "", true, false).draw();
        });

      column7
        .data()
        .sort()
        .unique()
        .each(function (d) {
          select7.append('<option value="' + d + '">' + d + "</option>");
        });
    },
  });

  $("#selectAll").on("click", function () {
    $(".checkbox").prop("checked", this.checked);
    $("#delete").prop("disabled", !this.checked);
  });

  $(".checkbox").on("click", function () {
    if ($(".checkbox:checked").length === $(".checkbox").length) {
      $("#selectAll").prop("checked", true);
    } else {
      $("#selectAll").prop("checked", false);
    }
    $("#delete").prop("disabled", $(".checkbox:checked").length === 0);
  });

  $(".delete-btn").on("click", function () {
    let eventId;
    if ($(this).data("id")) {
      eventId = $(this).data("id");
    } else {
      eventId = $(".checkbox:checked")
        .map(function () {
          return $(this).val();
        })
        .get();
    }

    Swal.fire({
      text: "คุณแน่ใจหรือไม่ที่จะลบรายการนี้?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "ใช่! ลบเลย",
      cancelButtonText: "ยกเลิก",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: "POST",
          url: "../../service/pages-twd/event/delete",
          data: {
            ids: eventId,
          },
          success: function (response) {
            Swal.fire({
              text: "รายการถูกลบเรียบร้อย",
              icon: "success",
              timer: 1000,
              confirmButtonText: "ตกลง",
              timerProgressBar: true,
            }).then((result) => {
              location.reload();
            });
          },
          error: function (xhr, status, error) {
            Swal.fire({
              text: "เกิดข้อผิดพลาดในการส่งข้อมูล",
              icon: "error",
              timer: 1000,
              confirmButtonText: "ตกลง",
              timerProgressBar: true,
            }).then((result) => {
              location.reload();
            });
          },
        });
      }
    });
  });

  table.on("draw", function () {
    if ($(".checkbox:checked").length === $(".checkbox").length) {
      $("#selectAll").prop("checked", true);
    } else {
      $("#selectAll").prop("checked", false);
    }
  });
});

function deletePerson(personId) {
  Swal.fire({
    text: "คุณแน่ใจหรือไม่ที่จะลบรายการนี้?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "ใช่! ลบเลย",
    cancelButtonText: "ยกเลิก",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        type: "POST",
        url: "../../service/pages-twd/event/delete",
        data: {
          ids: personId,
        },
        success: function (response) {
          Swal.fire({
            text: "รายการถูกลบเรียบร้อย",
            icon: "success",
            timer: 1000,
            confirmButtonText: "ตกลง",
            timerProgressBar: true,
          }).then((result) => {
            location.reload();
          });
        },
        error: function (xhr, status, error) {
          Swal.fire({
            text: "เกิดข้อผิดพลาดในการส่งข้อมูล",
            icon: "error",
            timer: 1000,
            confirmButtonText: "ตกลง",
            timerProgressBar: true,
          }).then((result) => {
            location.reload();
          });
        },
      });
    }
  });
}
