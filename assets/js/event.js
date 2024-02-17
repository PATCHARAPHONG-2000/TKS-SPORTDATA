$(document).ready(function () {
  var table = $("#index-event").DataTable({
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
        width: "7%",
        targets: 1,
      },
      {
        width: "13%",
        targets: 2,
      },
      {
        width: "13%",
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
        width: "7%",
        targets: 6,
      },
      {
        width: "16%",
        targets: 7,
      },
      {
        width: "13%",
        targets: 8,
      },
      {
        width: "15%",
        targets: 9,
      },
    ],
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

  $("#delete").on("click", function () {
    let selectedIds = $(".checkbox:checked")
      .map(function () {
        return $(this).val();
      })
      .get();

    if (selectedIds.length === 0) {
      Swal.fire({
        text: "กรุณาเลือกรายการที่ต้องการลบ",
        icon: "warning",
        confirmButtonText: "ตกลง",
      });
      return;
    }

    Swal.fire({
      text: "คุณแน่ใจหรือไม่...ที่จะลบรายการที่เลือก?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "ใช่! ลบเลย",
      cancelButtonText: "ยกเลิก",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: "POST",
          url: "../../service/manager/delete-event.php",
          data: {
            id: selectedIds,
          },
          success: function (response) {
            Swal.fire({
              text: "รายการถูกลบเรียบร้อย",
              icon: "success",
              confirmButtonText: "ตกลง",
              timer: 500,
              timerProgressBar: true,
            }).then((result) => {
              location.assign("./");
            });
          },
          error: function (xhr, status, error) {
            console.error(error);
            Swal.fire({
              text: "เกิดข้อผิดพลาดในการลบข้อมูล",
              icon: "error",
              confirmButtonText: "ตกลง",
            });
          },
        });
      }
    });
  });

  table.on("draw", function () {
    if ($(".checkbox:checked").length === $(".checkbox").length) {
      $("#select_all").prop("checked", true);
    } else {
      $("#select_all").prop("checked", false);
    }
  });

  $(document).on("click", ".delete-btn", function () {
    let id = $(this).data("id");
    let index = $(this).data("index");

    Swal.fire({
      text: "คุณแน่ใจหรือไม่...ที่จะลบรายการนี้?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "ใช่! ลบเลย",
      cancelButtonText: "ยกเลิก",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: "POST",
          url: "../../service/manager/delete-event.php",
          data: {
            id: id,
          },
          success: function (response) {
            Swal.fire({
              text: "รายการของคุณถูกลบเรียบร้อย",
              icon: "success",
              confirmButtonText: "ตกลง",
              timer: 500,
              timerProgressBar: true,
            }).then((result) => {
              location.assign("./");
            });
          },
          error: function (xhr, status, error) {
            console.error(error);
            Swal.fire({
              text: "เกิดข้อผิดพลาดในการลบข้อมูล",
              icon: "error",
              confirmButtonText: "ตกลง",
            });
          },
        });
      }
    });
  });
});

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
        width: "10%",
        targets: 4,
      },
      {
        width: "10%",
        targets: 5,
      },
      {
        width: "20%",
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
          alert("เกิดข้อผิดพลาดในการส่งข้อมูล");
        },
      });
    } else {
      Swal.fire({
        title: "เลือกคลาสและรุ่นน้ำหนัก?",
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
