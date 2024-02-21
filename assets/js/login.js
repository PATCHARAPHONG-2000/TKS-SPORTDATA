$("#formLogin").submit(function (e) {
  e.preventDefault();
  $.ajax({
    type: "POST",
    url: "service/auth/login.php",
    data: $(this).serialize(),
    dataType: "json",
  }).done(function (resp) {
    if (resp.error) {
      console.log(resp);
      Swal.fire({
        icon: "error",
        title: "Oops...",
        text: resp.error,
        confirmButtonColor: "#FF0000", // สีแดง
      });
    } else {
      console.log(resp);
      let timerInterval;
      Swal.fire({
        title: "กำลังเข้าสู่ระบบ",
        html: "กำลังตรวจสอบ <b></b> ข้อมูล.",
        timer: 1500,
        timerProgressBar: true,
        didOpen: () => {
          Swal.showLoading();
          const b = Swal.getHtmlContainer().querySelector("b");
          timerInterval = setInterval(() => {
            b.textContent = Swal.getTimerLeft();
          }, 100);
        },
        willClose: () => {
          clearInterval(timerInterval);
        },
      }).then((result) => {
        if (result.isDismissed) {
          console.log("I was closed by the timer");
          if (resp.role === "tkd") {
            location.href = "pages-twd/";
          } else if (resp.role === "superadmin") {
            location.href = "superadmin_twd/";
          }
        }
      });
    }
  });
});

document.getElementById("show_pass").addEventListener("click", function () {
  var x = document.getElementById("password");
  if (x.type === "password") {
    x.type = "text";
    document.getElementById("show_pass").classList.remove("fa-eye");
    document.getElementById("show_pass").classList.add("fa-eye-slash");
  } else {
    x.type = "password";
    document.getElementById("show_pass").classList.remove("fa-eye-slash");
    document.getElementById("show_pass").classList.add("fa-eye");
  }
});
