$(document).ready(function () {
  var params = {
    selectedName: getImageName(), // เรียกใช้ฟังก์ชัน JavaScript เพื่อรับค่า $image['name']
  };

  var table = $("#form-create-event").DataTable({
    paging: true,
    ordering: false,
    searching: true,
    info: true,

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
      $(
        "#save, #team_save, #Poomse_save, #Poomse_save_doubles, #Poomse_save_team, #Kiakpa_save, #Dance_battle_save, #DanceBattle_save_team"
      ).prop("disabled", false);
    } else {
      $(
        "#save, #team_save, #Poomse_save, #Poomse_save_doubles, #Poomse_save_team, #Kiakpa_save, #Dance_battle_save, #DanceBattle_save_team"
      ).prop("disabled", true);
    }
  });

  $(".checkbox").on("click", function () {
    if ($(".checkbox:checked").length === $(".checkbox").length) {
      $("#select_all").prop("checked", true);
    } else {
      $("#select_all").prop("checked", false);
    }

    if ($(".checkbox:checked").length > 0) {
      $(
        "#save, #team_save, #Poomse_save, #Poomse_save_doubles, #Poomse_save_team, #Kiakpa_save, #Dance_battle_save, #DanceBattle_save_team"
      ).prop("disabled", false);
    } else {
      $(
        "#save, #team_save, #Poomse_save, #Poomse_save_doubles, #Poomse_save_team, #Kiakpa_save, #Dance_battle_save, #DanceBattle_save_team"
      ).prop("disabled", true);
    }
  });

  $("#save").on("click", function () {
    let selectedIds = $(".checkbox:checked")
      .map(function () {
        return $(this).val();
      })
      .get();

    let selectedEvent = $("#List_event").val();
    let selectedAge = $("#age").val();
    let selectedClass = $("#sp_class").val();
    let selectedWeigth = $("#weight").val();

    if (
      selectedEvent &&
      selectedAge &&
      selectedClass &&
      selectedWeigth &&
      params.selectedName &&
      selectedIds.length > 0
    ) {
      $.ajax({
        type: "POST",
        url: "../../service/pages-twd/event/create",
        data: {
          ids: selectedIds,
          Type_Name: selectedEvent,
          class: selectedClass,
          weight: selectedWeigth,
          age_group: selectedAge,
          name_match: params.selectedName,
        },
        success: function (response) {
          Swal.fire({
            text: "สมัครเรียบร้อย",
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
            text: "เกิดข้อผิดพลาด กรุณาติดต่อเจ้าหน้าที่",
            icon: "error",
            timer: 1000,
            confirmButtonText: "ตกลง",
            timerProgressBar: true,
          }).then((result) => {
            location.reload();
          });
        },
      });
    } else {
      Swal.fire({
        text: "กรุณาเลือกอีเว้นท์ และรายชื่อนักกีฬา?",
        icon: "question",
        confirmButtonText: "ตกลง",
      });
    }
  });

  $("#team_save").on("click", function () {
    let selectedIds = $(".checkbox:checked")
      .map(function () {
        return $(this).val();
      })
      .get();

    let selectedEvent = $("#List_event").val();
    let selectedAge = $("#team_age").val();
    let selectedWeight = $("#team_weight").val();

    if (
      selectedIds.length >= 3 &&
      selectedIds.length <= 5 &&
      selectedAge &&
      selectedEvent &&
      selectedWeight
    ) {
      $.ajax({
        type: "POST",
        url: "../../service/pages-twd/event/create-team",
        data: {
          ids: selectedIds,
          Type_Name: selectedEvent,
          team_age: selectedAge,
          team_weight: selectedWeight,
          name_match: params.selectedName,
        },
        success: function (response) {
          Swal.fire({
            text: "สมัครเรียบร้อย",
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
            text: "เกิดข้อผิดพลาด กรุณาติดต่อเจ้าหน้าที่",
            icon: "error",
            timer: 1000,
            confirmButtonText: "ตกลง",
            timerProgressBar: true,
          }).then((result) => {
            location.reload();
          });
        },
      });
    } else {
      Swal.fire({
        text: "กรุณาเลือกอีเว้นท์ และเลือกระบุนักกีฬาอย่างน้อย 3-5 คน ตามระเบียบการ",
        icon: "question",
        confirmButtonText: "ตกลง",
      });
    }
  });

  $("#Poomse_save").on("click", function () {
    let selectedIds = $(".checkbox:checked")
      .map(function () {
        return $(this).val();
      })
      .get();

    let selectedEvent = $("#List_event").val();
    let selectedAge = $("#Poomse_age").val();
    let selectedColor = $("#Poomse_colorse").val();
    let selectedPattern = $("#Poomse_pattern").val();

    if (
      selectedEvent &&
      selectedAge &&
      selectedColor &&
      selectedPattern &&
      selectedIds.length > 0
    ) {
      $.ajax({
        type: "POST",
        url: "../../service/pages-twd/event/create-poomse",
        data: {
          ids: selectedIds,
          Type_Name: selectedEvent,
          Poomse_age: selectedAge,
          Poomse_colorse: selectedColor,
          Poomse_pattern: selectedPattern,
          name_match: params.selectedName,
        },
        success: function (response) {
          Swal.fire({
            text: "สมัครเรียบร้อย",
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
            text: "เกิดข้อผิดพลาด กรุณาติดต่อเจ้าหน้าที่",
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
        text: "กรุณาเลือกอีเว้นท์ และเลือกนักกีฬา?",
        icon: "question",
        confirmButtonText: "ตกลง",
      });
    }
  });

  $("#Poomse_save_doubles").on("click", function () {
    let selectedIds = $(".checkbox:checked")
      .map(function () {
        return $(this).val();
      })
      .get();

    let selectedEvent = $("#List_event").val();
    let selectedAge = $("#Poomse_age_doubles").val();

    if (
      selectedIds.length >= 2 &&
      selectedIds.length <= 2 &&
      selectedEvent &&
      selectedAge
    ) {
      $.ajax({
        type: "POST",
        url: "../../service/pages-twd/event/create-poomse_doubles",
        data: {
          ids: selectedIds,
          Type_Name: selectedEvent,
          Poomse_age: selectedAge,
          name_match: params.selectedName,
        },
        success: function (response) {
          Swal.fire({
            text: "สมัครเรียบร้อย",
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
            text: "เกิดข้อผิดพลาด กรุณาติดต่อเจ้าหน้าที่",
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
        text: "กรุณาเลือกอีเว้นท์ และเลือกนักกีฬาอย่างน้อย 2 คน ชาย-หญิง",
        icon: "question",
        confirmButtonText: "ตกลง",
      });
    }
  });

  $("#Poomse_save_team").on("click", function () {
    let selectedIds = $(".checkbox:checked")
      .map(function () {
        return $(this).val();
      })
      .get();

    let selectedEvent = $("#List_event").val();
    let selectedAge = $("#Poomse_age_team").val();
    let selectedColor = $("#Poomse_colorse_team").val();

    if (
      selectedIds.length >= 3 &&
      selectedIds.length <= 3 &&
      selectedEvent &&
      selectedAge &&
      selectedColor
    ) {
      $.ajax({
        type: "POST",
        url: "../../service/pages-twd/event/create-poomse_team",
        data: {
          ids: selectedIds,
          Type_Name: selectedEvent,
          Poomse_age: selectedAge,
          Poomse_colorse: selectedColor,
          name_match: params.selectedName,
        },
        success: function (response) {
          Swal.fire({
            text: "สมัครเรียบร้อย",
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
            text: "เกิดข้อผิดพลาด กรุณาติดต่อเจ้าหน้าที่",
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
        text: "กรุณาเลือกอีเว้นท์ และเลือกนักกีฬาอย่างน้อย 3 คน ตามระเบียบการ",
        icon: "question",
        confirmButtonText: "ตกลง",
      });
    }
  });

  $("#Kiakpa_save").on("click", function () {
    let selectedIds = $(".checkbox:checked")
      .map(function () {
        return $(this).val();
      })
      .get();

    let selectedEvent = $("#List_event").val();
    let selectedType = $("#Kiakpa_type").val();
    let selectedAge = $("#Kiakpa_age").val();

    if (
      selectedEvent &&
      selectedAge &&
      selectedType &&
      selectedIds.length > 0
    ) {
      $.ajax({
        type: "POST",
        url: "../../service/pages-twd/event/create-Kiakpa",
        data: {
          ids: selectedIds,
          Type_Name: selectedEvent,
          Kiakpa_age: selectedAge,
          Kiakpa_types: selectedType,
          name_match: params.selectedName,
        },
        success: function (response) {
          Swal.fire({
            text: "สมัครเรียบร้อย",
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
            text: "เกิดข้อผิดพลาด กรุณาติดต่อเจ้าหน้าที่",
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
        text: "กรุณาเลือกอีเว้นท์ และเลือกนักกีฬา?",
        icon: "question",
        confirmButtonText: "ตกลง",
      });
    }
  });

  $("#Dance_battle_save").on("click", function () {
    let selectedIds = $(".checkbox:checked")
      .map(function () {
        return $(this).val();
      })
      .get();

    let selectedEvent = $("#List_event").val();
    let selectedAge = $("#Dancebattleage").val();

    if (selectedEvent && selectedAge && selectedIds.length > 0) {
      $.ajax({
        type: "POST",
        url: "../../service/pages-twd/event/create-dancebattle",
        data: {
          ids: selectedIds,
          Type_Name: selectedEvent,
          Dancebattle_age: selectedAge,
          name_match: params.selectedName,
        },
        success: function (response) {
          Swal.fire({
            text: "สมัครเรียบร้อย",
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
            text: "เกิดข้อผิดพลาด กรุณาติดต่อเจ้าหน้าที่",
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
        text: "กรุณาเลือกอีเว้นท์ และเลือกนักกีฬา?",
        icon: "question",
        confirmButtonText: "ตกลง",
      });
    }
  });

  $("#DanceBattle_save_team").on("click", function () {
    let selectedIds = $(".checkbox:checked")
      .map(function () {
        return $(this).val();
      })
      .get();

    let selectedEvent = $("#List_event").val();

    if (selectedIds.length >= 3 && selectedIds.length <= 5 && selectedEvent) {
      $.ajax({
        type: "POST",
        url: "../../service/pages-twd/event/create-dancebattle-team",
        data: {
          ids: selectedIds,
          Type_Name: selectedEvent,
          name_match: params.selectedName,
        },
        success: function (response) {
          Swal.fire({
            text: "สมัครเรียบร้อย",
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
            text: "เกิดข้อผิดพลาด กรุณาติดต่อเจ้าหน้าที่",
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
        text: "กรุณาเลือกอีเว้นท์ และนักกีฬา 3 ถึง 5 คน ตามนรเะเบียบการ",
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

function fetchData(url, data, callback) {
  var xhr = new XMLHttpRequest();
  xhr.open("POST", url, true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
      callback(JSON.parse(xhr.responseText));
    }
  };
  xhr.send(data);
}

function fetcstatus() {
  var gender = document.getElementById("gender").value;
  var List_event = document.getElementById("List_event").value;
  fetchData(
    "../../service/pages-twd/event/fetchdata/fetch_solo",
    "gender=" + gender + "&List_event=" + List_event,
    function (ageGroups) {
      if (Array.isArray(ageGroups)) {
        var ageDropdown = document.getElementById("age");
        ageDropdown.innerHTML =
          "<option value='' disabled selected>กรุณาเลือกอายุ</option>";
        ageGroups.forEach(function (age) {
          var option = new Option(age, age);
          ageDropdown.add(option);
        });
        clearNextDropdown("weight");
      }
    }
  );
}

function fetchWeight() {
  var age = document.getElementById("age").value;
  var gender = document.getElementById("gender").value;
  fetchData(
    "../../service/pages-twd/event/fetchdata/fetch_solo",
    "age=" + age + "&gender=" + gender,
    function (weights) {
      var weightDropdown = document.getElementById("weight");
      weightDropdown.innerHTML =
        "<option value='' disabled selected>กรุณาเลือกรุ่นน้ำหนัก</option>";
      weights.forEach(function (weight) {
        var option = new Option(weight, weight);
        weightDropdown.add(option);
      });
      clearNextDropdown("sp_class");
    }
  );
}

function fetchClass() {
  var age = document.getElementById("age").value;
  fetchData(
    "../../service/pages-twd/event/fetchdata/fetch_solo",
    "age=" + age,
    function (class_r) {
      var classDropdown = document.getElementById("sp_class");
      classDropdown.innerHTML =
        "<option value='' disabled selected>กรุณาเลือกคลาส</option>";
      class_r.forEach(function (sp_class) {
        var option = new Option(sp_class, sp_class);
        classDropdown.add(option);
      });
    }
  );
}

function fetcstatus_team() {
  var team_gender = document.getElementById("team_gender").value;
  var List_event = document.getElementById("List_event").value;
  fetchData(
    "../../service/pages-twd/event/fetchdata/fetch_team",
    "team_gender=" + team_gender + "&List_event=" + List_event,
    function (ageGroups) {
      if (Array.isArray(ageGroups)) {
        var ageDropdown = document.getElementById("team_age");
        ageDropdown.innerHTML =
          "<option value='' disabled selected>กรุณาเลือกอายุ</option>";
        ageGroups.forEach(function (age) {
          var option = new Option(age, age);
          ageDropdown.add(option);
        });
        clearNextDropdown("team_weight");
      }
    }
  );
}

function fetchWeight_team() {
  var team_age = document.getElementById("team_age").value;
  var team_gender = document.getElementById("team_gender").value;
  fetchData(
    "../../service/pages-twd/event/fetchdata/fetch_team",
    "team_age=" + team_age + "&team_gender=" + team_gender,
    function (weights) {
      var weightDropdown = document.getElementById("team_weight");
      weightDropdown.innerHTML =
        "<option value='' disabled selected>กรุณาเลือกรุ่นน้ำหนัก</option>";
      weights.forEach(function (weight) {
        var option = new Option(weight, weight);
        weightDropdown.add(option);
      });
    }
  );
}

function fetcstatus_Poomse() {
  var Poomse_gender = document.getElementById("Poomse_gender").value;
  var List_event = document.getElementById("List_event").value;
  fetchData(
    "../../service/pages-twd/event/fetchdata/fetch_poomse",
    "Poomse_gender=" + Poomse_gender + "&List_event=" + List_event,
    function (ageGroups) {
      if (Array.isArray(ageGroups)) {
        var ageDropdown = document.getElementById("Poomse_age");
        ageDropdown.innerHTML =
          "<option value='' disabled selected>กรุณาเลือกอายุ</option>";
        ageGroups.forEach(function (age) {
          var option = new Option(age, age);
          ageDropdown.add(option);
        });
        clearNextDropdown("Poomse_weight");
      }
    }
  );
}

function fetchWeight_Poomse() {
  var Poomse_age = document.getElementById("Poomse_age").value;
  var Poomse_gender = document.getElementById("Poomse_gender").value;
  fetchData(
    "../../service/pages-twd/event/fetchdata/fetch_poomse",
    "Poomse_age=" + Poomse_age + "&Poomse_gender=" + Poomse_gender,
    function (weights) {
      var weightDropdown = document.getElementById("Poomse_colorse");
      weightDropdown.innerHTML =
        "<option value='' disabled selected>กรุณาเลือกรุ่นน้ำหนัก</option>";
      weights.forEach(function (weight) {
        var option = new Option(weight, weight);
        weightDropdown.add(option);
      });
      clearNextDropdown("Poomse_pattern", "Poomse_colorse");
    }
  );
}

function fetchcolorse_Poomse() {
  var Poomse_colorse = document.getElementById("Poomse_colorse").value;
  var Poomse_age = document.getElementById("Poomse_age").value;
  fetchData(
    "../../service/pages-twd/event/fetchdata/fetch_poomse",
    "Poomse_colorse=" + Poomse_colorse + "&Poomse_age=" + Poomse_age,
    function (class_r) {
      var classDropdown = document.getElementById("Poomse_pattern");
      classDropdown.innerHTML =
        "<option value='' disabled selected>กรุณาเลือกคลาส</option>";
      class_r.forEach(function (Poomse_pattern) {
        var option = new Option(Poomse_pattern, Poomse_pattern);
        classDropdown.add(option);
      });
    }
  );
}

function fetcstatus_Poomse_doubles() {
  var List_event = document.getElementById("List_event").value;

  if (List_event === "พุมเซ่ คู่ผสม") {
    fetchData(
      "../../service/pages-twd/event/fetchdata/fetch_poomse_doubles",
      "List_event=" + List_event,
      function (Poomse_age_doubles) {
        var classDropdown = document.getElementById("Poomse_age_doubles");
        classDropdown.innerHTML =
          "<option value='' disabled selected>กรุณาเลือกรุ่นน้ำหนัก</option>";
        Poomse_age_doubles.forEach(function (Poomse_age_double) {
          var option = new Option(Poomse_age_double, Poomse_age_double);
          classDropdown.add(option);
        });
      }
    );
  }
}

function fetcstatus_Poomse_team() {
  var Poomse_gender_team = document.getElementById("Poomse_gender_team").value;
  var List_event = document.getElementById("List_event").value;
  fetchData(
    "../../service/pages-twd/event/fetchdata/fetch_poomse_team",
    "Poomse_gender_team=" + Poomse_gender_team + "&List_event=" + List_event,
    function (ageGroups) {
      if (Array.isArray(ageGroups)) {
        var ageDropdown = document.getElementById("Poomse_age_team");
        ageDropdown.innerHTML =
          "<option value='' disabled selected>กรุณาเลือกอายุ</option>";
        ageGroups.forEach(function (age) {
          var option = document.createElement("option");
          option.text = age;
          option.value = age;
          ageDropdown.appendChild(option);
        });
        clearNextDropdown("Poomse_colorse_team");
      }
    }
  );
}

function fetchWeight_Poomse_team() {
  var Poomse_age_team = document.getElementById("Poomse_age_team").value;
  var Poomse_gender_team = document.getElementById("Poomse_gender_team").value;
  fetchData(
    "../../service/pages-twd/event/fetchdata/fetch_poomse_team",
    "Poomse_age_team=" +
      Poomse_age_team +
      "&Poomse_gender_team=" +
      Poomse_gender_team,
    function (colors) {
      var colorDropdown = document.getElementById("Poomse_colorse_team");
      colorDropdown.innerHTML =
        "<option value='' disabled selected>กรุณาเลือกสี</option>";
      colors.forEach(function (color) {
        var option = document.createElement("option");
        option.text = color;
        option.value = color;
        colorDropdown.appendChild(option);
      });
    }
  );
}

function fetcstatus_Kiakpa() {
  var Kiakpa_gender = document.getElementById("Kiakpa_gender").value;
  var List_event = document.getElementById("List_event").value;
  fetchData(
    "../../service/pages-twd/event/fetchdata/fetch_Kiakpa",
    "Kiakpa_gender=" + Kiakpa_gender + "&List_event=" + List_event,
    function (Kiakpa_types) {
      if (Array.isArray(Kiakpa_types)) {
        var KiakpaTypeSelect = document.getElementById("Kiakpa_type");
        KiakpaTypeSelect.innerHTML =
          "<option value='' disabled selected>กรุณาเลือกชนิดกีฬา</option>";
        Kiakpa_types.forEach(function (type) {
          var option = document.createElement("option");
          option.text = type;
          option.value = type;
          KiakpaTypeSelect.appendChild(option);
        });

        clearNextDropdown("Kiakpa_age");
      }
    }
  );
}

function fetcstatus_Kiakpa_type() {
  var Kiakpa_gender = document.getElementById("Kiakpa_gender").value;
  var Kiakpa_type = document.getElementById("Kiakpa_type").value;
  fetchData(
    "../../service/pages-twd/event/fetchdata/fetch_Kiakpa",
    "Kiakpa_gender=" + Kiakpa_gender + "&Kiakpa_type=" + Kiakpa_type,
    function (Kiakpa_ages) {
      if (Array.isArray(Kiakpa_ages)) {
        var KiakpaageSelect = document.getElementById("Kiakpa_age");
        KiakpaageSelect.innerHTML =
          "<option value='' disabled selected>กรุณาเลือกชนิดกีฬา</option>";
        Kiakpa_ages.forEach(function (age) {
          var option = document.createElement("option");
          option.text = age;
          option.value = age;
          KiakpaageSelect.appendChild(option);
        });
      }
    }
  );
}

function fetc_Dance_battle_age() {
  var Dance_battle_gender = document.getElementById(
    "Dance_battle_gender"
  ).value;
  var List_event = document.getElementById("List_event").value;
  fetchData(
    "../../service/pages-twd/event/fetchdata/fetch_dance_battle",
    "Dance_battle_gender=" + Dance_battle_gender + "&List_event=" + List_event,
    function (Dancebattles) {
      if (Array.isArray(Dancebattles)) {
        var DanceBattleSelect = document.getElementById("Dancebattleage");
        DanceBattleSelect.innerHTML =
          "<option value='' disabled selected>กรุณาเลือกชนิดกีฬา</option>";
        Dancebattles.forEach(function (age) {
          var option = document.createElement("option");
          option.text = age;
          option.value = age;
          DanceBattleSelect.appendChild(option);
        });
      }
    }
  );
}

function clearNextDropdown(nextDropdownId) {
  var nextDropdown = document.getElementById(nextDropdownId);
  if (nextDropdown) {
    nextDropdown.innerHTML =
      "<option value='' disabled selected>กรุณาเลือกข้อมูล</option>";
  }
}

function resetTable() {
  var tableRows = document
    .getElementById("form-create-event")
    .querySelectorAll("tbody tr");
  tableRows.forEach(function (row) {
    row.style.display = ""; // แสดงทุกแถว
  });
}

function selectgender() {
  var genders = [
    "gender",
    "team_gender",
    "Poomse_gender",
    "Poomse_gender_team",
    "Kiakpa_gender",
    "Dance_battle_gender",
    "DanceBattle_gender_team",
  ];
  var selectedGenders = genders.map(function (id) {
    return document.getElementById(id).value;
  });
  var tableRows = document
    .getElementById("form-create-event")
    .querySelectorAll("tbody tr");

  for (var i = 0; i < tableRows.length; i++) {
    var genderColumn = tableRows[i].querySelector("td:nth-child(5)");
    if (genderColumn) {
      var gender = genderColumn.innerText.trim();
      var shouldDisplay = selectedGenders.some(function (selectedGender) {
        return selectedGender === gender;
      });
      tableRows[i].style.display = shouldDisplay ? "" : "none";
    }
  }
}

function List_event() {
  resetTable(); // รีเซ็ตตาราง
  var selected_sport = document.getElementById("List_event").value;
  var elements = {
    "ต่อสู้ (เดี่ยว)": "fight",
    "ต่อสู้ ทีม": "fight-team",
    พุมเซ่: "Poomse-Solo",
    "พุมเซ่ คู่ผสม": "Poomse-doubles",
    "พุมเซ่ ทีม": "Poomse-team",
    เคียกพ่า: "Kiakpa",
    "Dance Battle": "Dance_battle",
    "Dance Battle ทีม": "Dance_battle_team",
  };

  Object.keys(elements).forEach(function (sport) {
    var element = document.getElementById(elements[sport]);
    if (selected_sport === sport && element) {
      element.style.display = "flex";
    } else if (element) {
      element.style.display = "none";
    }
  });

  clearDropdowns();
}

function clearDropdowns() {
  document.getElementById("gender").selectedIndex = 0;
  document.getElementById("team_gender").selectedIndex = 0;
  document.getElementById("Poomse_gender").selectedIndex = 0;
  document.getElementById("Poomse_gender_team").selectedIndex = 0;
  document.getElementById("Kiakpa_gender").selectedIndex = 0;
  document.getElementById("Dance_battle_gender").selectedIndex = 0;
  document.getElementById("DanceBattle_gender_team").selectedIndex = 0;
}
