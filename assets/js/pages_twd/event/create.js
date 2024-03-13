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
      { width: "5%", targets: 0 },
      { width: "10%", targets: 1 },
      { width: "20%", targets: 2 },
      { width: "20%", targets: 3 },
      { width: "7%", targets: 4 },
      { width: "7%", targets: 5 },
      { width: "15%", targets: 6 },
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

function fetcstatus() {
  var gender = document.getElementById("gender").value;
  var List_event = document.getElementById("List_event").value;
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "../../service/manager/fetch_status", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
      var ageGroups = JSON.parse(xhr.responseText);
      if (Array.isArray(ageGroups)) {
        var ageDropdown = document.getElementById("age");
        ageDropdown.innerHTML =
          "<option value='' disabled selected>กรุณาเลือกอายุ</option>"; // Clear previous options
        ageGroups.forEach(function (age) {
          var option = document.createElement("option");
          option.text = age;
          option.value = age;
          ageDropdown.appendChild(option);
        });
        clearNextDropdown("weight");
      }
    }
  };
  xhr.send("gender=" + gender + "&List_event=" + List_event);
}

function fetchWeight() {
  var age = document.getElementById("age").value;
  var gender = document.getElementById("gender").value;
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "../../service/manager/fetch_weight", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function () {
    if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
      var weights = JSON.parse(this.responseText);
      var weightDropdown = document.getElementById("weight");
      weightDropdown.innerHTML =
        "<option value='' disabled selected>กรุณาเลือกรุ่นน้ำหนัก</option>"; // Clear previous options
      weights.forEach(function (weight) {
        var option = document.createElement("option");
        option.text = weight;
        option.value = weight;
        weightDropdown.appendChild(option);
      });
      clearNextDropdown("sp_class");
    }
  };
  xhr.send("age=" + age + "&gender=" + gender);
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
      classDropdown.innerHTML =
        "<option value='' disabled selected>กรุณาเลือกคลาส</option>"; // Clear previous options
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

function fetcstatus_team() {
  var team_gender = document.getElementById("team_gender").value;
  var List_event = document.getElementById("List_event").value;
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "../../service/manager/fetch_status_team", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
      var ageGroups = JSON.parse(xhr.responseText);
      if (Array.isArray(ageGroups)) {
        var ageDropdown = document.getElementById("team_age");
        ageDropdown.innerHTML =
          "<option value='' disabled selected>กรุณาเลือกอายุ</option>"; // Clear previous options
        ageGroups.forEach(function (age) {
          var option = document.createElement("option");
          option.text = age;
          option.value = age;
          ageDropdown.appendChild(option);
        });
        clearNextDropdown("team_weight");
      }
    }
  };
  xhr.send("team_gender=" + team_gender + "&List_event=" + List_event);
}

function fetchWeight_team() {
  var team_age = document.getElementById("team_age").value;
  var team_gender = document.getElementById("team_gender").value;
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "../../service/manager/fetch_weight_team", true); // เพิ่ม .php ให้ถูกต้อง
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function () {
    if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
      var weights = JSON.parse(this.responseText);
      var weightDropdown = document.getElementById("team_weight");
      weightDropdown.innerHTML =
        "<option value='' disabled selected>กรุณาเลือกรุ่นน้ำหนัก</option>"; // Clear previous options
      weights.forEach(function (weight) {
        var option = document.createElement("option");
        option.text = weight;
        option.value = weight;
        weightDropdown.appendChild(option);
      });
      clearNextDropdown("sp_class");
    }
  };
  xhr.send("team_age=" + team_age + "&team_gender=" + team_gender); // แก้ชื่อพารามิเตอร์เป็น team_age และ team_gender
}

function fetcstatus_Poomse() {
  var gender = document.getElementById("Poomse_gender").value;
  var List_event = document.getElementById("List_event").value; // ต้องกำหนด id ใน HTML
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "../../service/manager/fetch_status", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
      var ageGroups = JSON.parse(xhr.responseText);
      if (Array.isArray(ageGroups)) {
        var ageDropdown = document.getElementById("Poomse_age"); // ต้องกำหนด id ใน HTML
        ageDropdown.innerHTML =
          "<option value='' disabled selected>กรุณาเลือกอายุ</option>"; // Clear previous options
        ageGroups.forEach(function (age) {
          var option = document.createElement("option");
          option.text = age;
          option.value = age;
          ageDropdown.appendChild(option);
        });
        clearNextDropdown("Poomse_weight");
      }
    }
  };
  xhr.send("gender=" + gender + "&List_event=" + List_event);
}

function fetchWeight_Poomse() {
  var age = document.getElementById("Poomse_age").value;
  var gender = document.getElementById("Poomse_gender").value;
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "../../service/manager/fetch_weight", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function () {
    if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
      var weights = JSON.parse(this.responseText);
      var weightDropdown = document.getElementById("Poomse_weight");
      weightDropdown.innerHTML =
        "<option value='' disabled selected>กรุณาเลือกรุ่นน้ำหนัก</option>"; // Clear previous options
      weights.forEach(function (weight) {
        var option = document.createElement("option");
        option.text = weight;
        option.value = weight;
        weightDropdown.appendChild(option);
      });
      clearNextDropdown("sp_class");
    }
  };
  xhr.send("age=" + age + "&gender=" + gender);
}

function fetchClass() {
  var weight = document.getElementById("Poomse_weight").value;
  var age = document.getElementById("Poomse_age").value; // เพิ่มการเก็บค่าอายุ
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "../../service/manager/fetch_class", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function () {
    if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
      var class_r = JSON.parse(this.responseText);
      var classDropdown = document.getElementById("sp_class");
      classDropdown.innerHTML =
        "<option value='' disabled selected>กรุณาเลือกคลาส</option>"; // Clear previous options
      class_r.forEach(function (sp_class) {
        var option = document.createElement("option");
        option.text = sp_class;
        option.value = sp_class;
        classDropdown.appendChild(option);
      });
    }
  };
  xhr.send("age=" + age);
}

function fetcstatus_Poomse() {
  var Poomse_gender = document.getElementById("Poomse_gender").value;
  var List_event = document.getElementById("List_event").value; // ต้องกำหนด id ใน HTML
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "../../service/manager/fetch_status_poomse", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
      var ageGroups = JSON.parse(xhr.responseText);
      if (Array.isArray(ageGroups)) {
        var ageDropdown = document.getElementById("Poomse_age"); // ต้องกำหนด id ใน HTML
        ageDropdown.innerHTML =
          "<option value='' disabled selected>กรุณาเลือกอายุ</option>"; // Clear previous options
        ageGroups.forEach(function (age) {
          var option = document.createElement("option");
          option.text = age;
          option.value = age;
          ageDropdown.appendChild(option);
        });
        clearNextDropdown("Poomse_colorse");
      }
    }
  };
  xhr.send("Poomse_gender=" + Poomse_gender + "&List_event=" + List_event);
}

function fetchWeight_Poomse() {
  var Poomse_age = document.getElementById("Poomse_age").value;
  var Poomse_gender = document.getElementById("Poomse_gender").value;
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "../../service/manager/fetch_weight_poomse", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function () {
    if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
      var weights = JSON.parse(this.responseText);
      var weightDropdown = document.getElementById("Poomse_colorse");
      weightDropdown.innerHTML =
        "<option value='' disabled selected>กรุณาเลือกรุ่นน้ำหนัก</option>"; // Clear previous options
      weights.forEach(function (weight) {
        var option = document.createElement("option");
        option.text = weight;
        option.value = weight;
        weightDropdown.appendChild(option);
      });
      clearNextDropdown("sp_class");
    }
  };
  xhr.send("Poomse_age=" + Poomse_age + "&Poomse_gender=" + Poomse_gender);
}

function fetchcolorse_Poomse() {
  var Poomse_colorse = document.getElementById("Poomse_colorse").value;
  var Poomse_age = document.getElementById("Poomse_age").value; // เพิ่มการเก็บค่าอายุ
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "../../service/manager/fetch_colorse_poomse", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function () {
    if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
      var Poomse_pattern = JSON.parse(this.responseText);
      var classDropdown = document.getElementById("Poomse_pattern");
      classDropdown.innerHTML =
        "<option value='' disabled selected>กรุณาเลือกคลาส</option>"; // Clear previous options
      Poomse_pattern.forEach(function (Poomse_pattern) {
        var option = document.createElement("option");
        option.text = Poomse_pattern;
        option.value = Poomse_pattern;
        classDropdown.appendChild(option);
      });
    }
  };
  xhr.send("Poomse_colorse=" + Poomse_colorse + "&Poomse_age=" + Poomse_age);
}

function clearNextDropdown(nextDropdownId) {
  var nextDropdown = document.getElementById(nextDropdownId);
  if (nextDropdown) {
    nextDropdown.innerHTML =
      "<option value='' disabled selected>กรุณาเลือกข้อมูล</option>";
  }
}

function selectgender() {
  var selectedGender = document.getElementById("gender").value;
  var selectedTeamGender = document.getElementById("team_gender").value;
  var selectedPoomseGender = document.getElementById("Poomse_gender").value;
  var tableRows = document
    .getElementById("form-create-event")
    .getElementsByTagName("tbody")[0]
    .getElementsByTagName("tr");

  for (var i = 0; i < tableRows.length; i++) {
    var genderColumn = tableRows[i].getElementsByTagName("td")[4];
    if (genderColumn) {
      var gender = genderColumn.innerText.trim();
      if (selectedGender === "ชาย" && gender !== "ชาย") {
        tableRows[i].style.display = "none";
      } else if (selectedGender === "หญิง" && gender !== "หญิง") {
        tableRows[i].style.display = "none";
      } else if (selectedTeamGender === "ชาย" && gender !== "ชาย") {
        tableRows[i].style.display = "none";
      } else if (selectedTeamGender === "หญิง" && gender !== "หญิง") {
        tableRows[i].style.display = "none";
      } else if (selectedPoomseGender === "ชาย" && gender !== "ชาย") {
        tableRows[i].style.display = "none";
      } else if (selectedPoomseGender === "หญิง" && gender !== "หญิง") {
        tableRows[i].style.display = "none";
      } else {
        tableRows[i].style.display = "";
      }
    }
  }
}

function List_event() {
  var selected_sport = document.getElementById("List_event").value;
  var fight_div = document.getElementById("fight");
  var fight_team_div = document.getElementById("fight-team");
  var fight_poomse_div = document.getElementById("Poomse-Solo");

  fight_div.style.display = "none";
  fight_team_div.style.display = "none";
  fight_poomse_div.style.display = "none";

  // แสดงเฉพาะองค์ประกอบที่ถูกเลือก
  if (selected_sport == "ต่อสู้ (เดี่ยว)") {
    fight_div.style.display = "flex";
  } else if (selected_sport == "ต่อสู้ ทีม") {
    fight_team_div.style.display = "flex";
  } else if (selected_sport == "พุมเซ่") {
    fight_poomse_div.style.display = "flex";
  }

  // เรียกใช้ฟังก์ชันเพื่อล้างข้อมูล dropdown
  clearDropdowns();
}

function clearDropdowns() {
  // ล้างข้อมูลใน dropdown ที่เกี่ยวข้อง
  document.getElementById("age").innerHTML =
    "<option value='' disabled selected>กรุณาเลือกอายุ</option>";
  document.getElementById("weight").innerHTML =
    "<option value='' disabled selected>กรุณาเลือกรุ่นน้ำหนัก</option>";
  document.getElementById("sp_class").innerHTML =
    "<option value='' disabled selected>กรุณาเลือกคลาส</option>";
}
