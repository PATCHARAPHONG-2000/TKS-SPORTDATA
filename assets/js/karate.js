$("#formLogin").submit(function (e) {
  e.preventDefault();
  $.ajax({
    type: "POST",
    url: "service/auth/login-score.php",
    data: $(this).serialize(),
    dataType: "json",
  }).done(function (resp) {
    if (resp.error) {
      Swal.fire({
        icon: "error",
        title: "Oops...",
        text: resp.error,
        confirmButtonColor: "#FF0000",
      });
    } else {
      if (resp.users === "karate") {
        let timerInterval;
        Swal.fire({
          title: "กำลังเข้าสู่ระบบ",
          html: "กำลังตรวจสอบ <b></b> ข้อมูล.",
          timer: 1000,
          timerProgressBar: true,
          didOpen: () => {
            Swal.showLoading();
            const timer = Swal.getPopup().querySelector("b");
            timerInterval = setInterval(() => {
              timer.textContent = `${Swal.getTimerLeft()}`;
            }, 100);
          },
          willClose: () => {
            clearInterval(timerInterval);
          },
        }).then((result) => {
          if (result.dismiss === Swal.DismissReason.timer) {
            location.href = "karate/";
          }
        });
      } else {
        console.log("Role not recognized");
      }
    }
  });
});

function clearTableData() {
  Swal.fire({
    title: "คุณต้องการลบข้อมูลใช่ไหม",
    text: "คุณจะไม่สามารถย้อนกลับได้! || เช็คให้แน่ใจว่าคุณได้ดาวโหลดตารางคะแนนเรียบร้อยแล้ว",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "ใช่, ฉันต้องการลบ!",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        type: "POST",
        url: "../service/delete.php",
        dataType: "json",
      }).done(function (resp) {
        Swal.fire({
          text: "ลบข้อมูลเรียบร้อย",
          icon: "success",
          confirmButtonText: "ตกลง",
          showConfirmButton: false,
          timer: 500,
        }).then((result) => {
          location.assign("./");
        });
      });
    }
  });
}

function moveToNextInput(event, nextInputId) {
  if (event.key === "Enter") {
    event.preventDefault();
    document.getElementById(nextInputId).focus();
  }
}

function checkAndSum() {
  const name = document.getElementById("name").value;

  const numbers = Array.from(
    {
      length: 7,
    },
    (_, i) => parseFloat(document.getElementById(`number${i + 1}`).value)
  );
  const number = [...numbers];
  const sumOfAllNumbers = numbers.reduce((acc, value) => acc + value, 0);
  const minValue = Math.min(...numbers);
  const maxValue = Math.max(...numbers);

  if (
    numbers.filter((value) => value === minValue).length > 1 &&
    numbers.filter((value) => value === maxValue).length > 1
  ) {
    const hasMaxValue = numbers.includes(maxValue);
    const hasMinValue = numbers.includes(minValue);
    if (hasMaxValue && hasMinValue) {
      numbers.splice(numbers.indexOf(minValue), 1);
      numbers.splice(numbers.indexOf(maxValue), 1);
    }
  } else {
    numbers.splice(numbers.indexOf(minValue), 1);
    numbers.splice(numbers.indexOf(maxValue), 1);
  }

  const finalSum = numbers.reduce((acc, value) => acc + value, 0);
  saveScores(name, number, sumOfAllNumbers, finalSum);
}

function saveScores(name, numbers, sumOfAllNumbers, finalSum) {
  $.ajax({
    type: "POST",
    url: "../service/create.php",
    data: {
      name: name,
      scores: numbers,
      totalSum: sumOfAllNumbers,
      finalSum: finalSum,
    },
    dataType: "json",
    success: function (resp) {
      if (resp.status) {
        Swal.fire({
          text: resp.message,
          icon: "success",
          confirmButtonText: "ตกลง",
          showConfirmButton: false,
          timer: 500,
        }).then((result) => {
          location.assign("./");
        });
      } else {
        Swal.fire({
          text: resp.error,
          icon: "error",
          confirmButtonText: "ตกลง",
        });
      }
    },
    error: function (xhr, status, error) {
      Swal.fire({
        text: "เกิดข้อผิดพลาดในการส่งข้อมูล",
        icon: "error",
        confirmButtonText: "ตกลง",
      });
    },
  });
}
