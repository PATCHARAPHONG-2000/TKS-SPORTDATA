$("#resetpassword").click(function (e) {
  e.preventDefault();
  Swal.fire({
    title: "กรุณากรอกอีเมลของคุณ",
    input: "text",
    inputAttributes: {
      autocapitalize: "off",
    },
    showCancelButton: true,
    confirmButtonText: "ยืนยัน",
    cancelButtonText: "ออก",
    showLoaderOnConfirm: true,
    preConfirm: (email) => {
      window.currentEmail = email;
      if (!email) {
        Swal.showValidationMessage("กรุณาป้อนอีเมล");
      } else {
        return new Promise((resolve, reject) => {
          $.ajax({
            url: "service/auth/reset_pw_email",
            type: "POST",
            data: {
              email: email,
            },
            dataType: "json",
            success: function (response) {
              if (response.status) {
                resolve(response);
              } else {
                reject(response.message);
              }
            },
          });
        }).catch((error) => {
          Swal.showValidationMessage(error);
        });
      }
    },
    allowOutsideClick: false,
  }).then((result) => {
    console.log(result);
    if (result.isConfirmed) {
      Swal.fire({
        title: "ยืนยัน OTP",
        input: "text",
        inputAttributes: {
          autocapitalize: "off",
          maxlength: 6,
        },
        showCancelButton: true,
        confirmButtonText: "ยืนยัน",
        showLoaderOnConfirm: true,
        preConfirm: (otp) => {
          return new Promise((resolve, reject) => {
            $.ajax({
              url: "service/auth/reset_pw_otp",
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
                console.log(xhr.responseText);
                reject(thrownError);
              },
            });
          }).catch((error) => {
            Swal.showValidationMessage("กรอก OTP ");
          });
        },
        allowOutsideClick: false,
      }).then((otpResult) => {
        if (otpResult.isConfirmed) {
          Swal.fire({
            title: "กรอกรหัสผ่านใหม่",
            html: `<div class="mb-md-5 position-relative">
                <div class="form-outline form-white mb-4">
                    <input type="password" name="password" id="password"
                        class="form-control form-control-lg" placeholder="รหัสผ่านใหม่" required />
                    <label
                        class="checkbox-label position-absolute start-0 top-100 translate-middle-y mt-4">
                        <input class="checkbox " type="checkbox" onclick="myFunction()">
                        Show Password
                    </label>
                </div>
                <div class="form-outline form-white">
                    <input type="password" name="c_password" id="c_password"
                        class="form-control form-control-lg" placeholder="ยืนยันรหัสผ่าน" required />
                </div>
            </div>`,
            confirmButtonText: "เปลี่ยนรหัสผ่าน",
            focusConfirm: false,
            preConfirm: () => {
              const password = Swal.getPopup().querySelector("#password").value;
              const c_password =
                Swal.getPopup().querySelector("#c_password").value;
              if (!password || !c_password) {
                Swal.showValidationMessage(`กรุณากรอกรหัสผ่านทั้งสองช่อง`);
              } else if (password !== c_password) {
                Swal.showValidationMessage("รหัสผ่านไม่ตรงกัน");
              } else if (password.length < 8 || c_password.length < 8) {
                Swal.showValidationMessage(
                  "รหัสผ่านต้องมีความยาวอย่างน้อย 8 ตัวอักษร"
                );
              }
              return {
                password: password,
                c_password: c_password,
              };
            },
            allowOutsideClick: false,
          }).then((result) => {
            if (result.value) {
              const { password, c_password } = result.value;
              $.ajax({
                url: "service/auth/reset_pw_otp",
                type: "POST",
                data: {
                  new_password: password,
                  confirm_password: c_password,
                  email: window.currentEmail,
                },
                dataType: "json",
                success: function (response) {
                  if (response.status) {
                    Swal.fire({
                      title: "สำเร็จ!",
                      text: "คุณได้เปลี่ยนรหัสผ่านของคุณเรียบร้อยแล้ว",
                      icon: "success",
                    }).then(() => {
                      window.location.href = "index.php";
                    });
                  } else {
                    Swal.fire({
                      title: "ผิดพลาด!",
                      text: response.message,
                      icon: "error",
                    });
                  }
                },
                error: function () {
                  Swal.fire({
                    title: "ผิดพลาด!",
                    text: "มีข้อผิดพลาดเกิดขึ้นในการเปลี่ยนรหัสผ่านของคุณ โปรดลองใหม่",
                    icon: "error",
                  });
                },
              });
            }
          });
        }
      });
    }
  });
});

function myFunction() {
  var passwordInputs = document.getElementsByName("password");
  var cPasswordInputs = document.getElementsByName("c_password");

  for (var i = 0; i < passwordInputs.length; i++) {
    if (passwordInputs[i].type === "password") {
      passwordInputs[i].type = "text";
    } else {
      passwordInputs[i].type = "password";
    }
  }

  for (var i = 0; i < cPasswordInputs.length; i++) {
    if (cPasswordInputs[i].type === "password") {
      cPasswordInputs[i].type = "text";
    } else {
      cPasswordInputs[i].type = "password";
    }
  }
}
