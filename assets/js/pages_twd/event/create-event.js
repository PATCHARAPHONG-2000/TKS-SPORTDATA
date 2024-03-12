$(document).ready(function () {
  var params = {
    selectedName: getImageName(), // เรียกใช้ฟังก์ชัน JavaScript เพื่อรับค่า $image['name']
  };

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

    let selectedAge = $("#age").val();
    let selectedClass = $("#sp_class").val();
    let selectedWeigth = $("#weight").val();

    if (
      selectedAge &&
      selectedClass &&
      selectedWeigth &&
      params.selectedName &&
      selectedIds.length > 0
    ) {
      $.ajax({
        type: "POST",
        url: "../../service/manager/create-event",
        data: {
          ids: selectedIds,
          class: selectedClass,
          weight: selectedWeigth,
          age: selectedAge,
          name_match: params.selectedName,
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
            location.reload();
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

function fetchWeight() {
  var age = document.getElementById("age").value;
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "../../service/manager/fetch_weight", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function () {
    if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
      var weights = JSON.parse(this.responseText);
      var weightDropdown = document.getElementById("weight");
      weightDropdown.innerHTML = ""; // Clear previous options
      weights.forEach(function (weight) {
        var option = document.createElement("option");
        option.text = weight;
        option.value = weight;
        weightDropdown.appendChild(option);
      });
    }
  };
  xhr.send("age=" + age);
}

function fetchClass() {
  var weight = document.getElementById("weight").value;
  var age = document.getElementById("age").value; // เพิ่มการเก็บค่าอายุ
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "../../service/manager/fetch_class", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function () {
    if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
      var class_r = JSON.parse(this.responseText);
      var classDropdown = document.getElementById("sp_class");
      classDropdown.innerHTML = ""; // Clear previous options
      class_r.forEach(function (sp_class) {
        var option = document.createElement("option");
        option.text = sp_class;
        option.value = sp_class;
        classDropdown.appendChild(option);
      });
    }
  };
  xhr.send("age=" + age); // ส่งค่าอายุไปด้วย
}
