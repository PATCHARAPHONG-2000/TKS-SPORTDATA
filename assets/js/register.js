document
  .getElementById("cookieSetting")
  .addEventListener("change", function (event) {
    if (this.checked) {
      document.cookie = "cookieSetting=1";
    } else {
      document.cookie = "cookieSetting=0";
    }
  });

$(function () {
  $("#formRegister").submit(function (e) {
    e.preventDefault();
    let timerInterval;

    Swal.fire({
      title: "กรุณารอสักครู่ระบบกำลังตรวจสอบ",
      html: "กำลังตรวจสอบ <b></b> ข้อมูล.",
      timer: 2000,
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
      if (result.dismiss === Swal.DismissReason.timer) {
        console.log("I was closed by the timer");
      }
    });

    $.ajax({
      type: "POST",
      url: "service/auth/register.php",
      data: $(this).serialize(),
      dataType: "json",
    }).done(function (resp) {
      console.log(resp);

      if (resp.error) {
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: resp.error,
        });
      } else {
        Swal.fire({
          title: "กรอก OTP ที่ได้รับ",
          input: "text",
          inputAttributes: {
            autocapitalize: "off",
            minlength: 6,
            maxlength: 6,
          },
          confirmButtonText: "ตกลง",
          cancelButtonText: "ยกเลิก",
          showCancelButton: true,
          showLoaderOnConfirm: true,
          preConfirm: (otp) => {
            return new Promise((resolve, reject) => {
              $.ajax({
                url: "service/auth/check_otp.php",
                type: "POST",
                data: {
                  otp: otp,
                },
                dataType: "json",
                success: function (response) {
                  if (response.status) {
                    resolve(response);
                  } else {
                    reject(response.message);
                  }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                  reject("OTP ไม่ถูกต้อง");
                },
              });
            }).catch((error) => {
              Swal.showValidationMessage(error);
            });
          },
          allowOutsideClick: () => !Swal.isLoading(),
        }).then((result) => {
          console.log(resp);
          if (result.isConfirmed) {
            if (result.value.status) {
              Swal.fire({
                icon: "success",
                title: "OTP ถูกต้อง",
                showConfirmButton: false,
                timer: 1000,
              }).then(() => {
                window.location.href = "login";
              });
            } else {
              Swal.fire({
                icon: "error",
                title: "เกิดข้อผิดพลาด กรุณาลองใหม่ภายหลัง",
                text: result.value.message,
              });
            }
          }
        });
      }
    });
  });
});
