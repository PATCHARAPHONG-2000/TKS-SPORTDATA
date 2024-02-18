$(document).ready(function () {
  var table = $("#form-create-event").DataTable({
    paging: true,
    ordering: false,
    searching: true,
    info: true,
    className: "select-checkbox",

    columnDefs: [
      {
        width: "5%",
        targets: 0,
      },
      {
        width: "10%",
        targets: 1,
      },
      {
        width: "20%",
        targets: 2,
      },
      {
        width: "20%",
        targets: 3,
      },
      {
        width: "7%",
        targets: 4,
      },
      {
        width: "7%",
        targets: 5,
      },
      {
        width: "15%",
        targets: 6,
      },
      {
        width: "15%",
        targets: 7,
      },
    ],
  });

  $("#select_all").on("click", function () {
    $(".checkbox").prop("checked", this.checked);

    if (this.checked) {
      $("#save").prop("disabled", false);
    } else {
      $("#save").prop("disabled", true);
    }
  });

  $(".checkbox").on("click", function () {
    if ($(".checkbox:checked").length === $(".checkbox").length) {
      $("#select_all").prop("checked", true);
    } else {
      $("#select_all").prop("checked", false);
    }

    if ($(".checkbox:checked").length > 0) {
      $("#save").prop("disabled", false);
    } else {
      $("#save").prop("disabled", true);
    }
  });

  $("#save").on("click", function () {
    let selectedIds = $(".checkbox:checked")
      .map(function () {
        return $(this).val();
      })
      .get();

    let selectedClass = $("#clas").val();
    let selectedWeigth = $("#weigth").val();

    if (selectedClass && selectedWeigth && selectedIds.length > 0) {
      $.ajax({
        type: "POST",
        url: "../../service/manager/create-event.php",
        data: {
          ids: selectedIds,
          class: selectedClass,
          weigth: selectedWeigth,
        },
        success: function (response) {
          console.log(response);
          Swal.fire({
            text: "รายการของคุณถูกบันทึกเรียบร้อย",
            icon: "success",
            timer: 1000,
            confirmButtonText: "ตกลง",
            timerProgressBar: true,
          }).then((result) => {
            location.assign("./");
          });
        },
        error: function (xhr, status, error) {
          console.error(error);
          Swal.fire({
            text: "เกิดข้อผิดพลาดในการส่งข้อมูล",
            icon: "error",
            timer: 1000,
            confirmButtonText: "ตกลง",
            timerProgressBar: true,
          }).then((result) => {
            location.assign("./");
          });
        },
      });
    } else {
      Swal.fire({
        text: "กรุณาเลือกคลาสและรุ่นน้ำหนักและรายชื่อนักกีฬา?",
        icon: "question",
        confirmButtonText: "ตกลง",
      });
    }
  });

  table.on("draw", function () {
    if ($(".checkbox:checked").length === $(".checkbox").length) {
      $("#select_all").prop("checked", true);
    } else {
      $("#select_all").prop("checked", false);
    }
  });
});
