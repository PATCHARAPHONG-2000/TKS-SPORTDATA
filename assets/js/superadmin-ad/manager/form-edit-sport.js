const fileInput = document.getElementById("customFile");
const customFileLabel = $(fileInput).next(".custom-file-label");

fileInput.addEventListener("change", (event) => {
  const file = event.target.files[0];

  if (!file) {
    resetFileInput();
    return;
  }

  const maxSizeInBytes = 5 * 1024 * 1024; // 5 MB

  if (file.size > maxSizeInBytes) {
    showFileSizeExceedWarning();
    resetFileInput();
    return;
  }

  const fileName = file.name;
  customFileLabel.html(fileName);
});

function resetFileInput() {
  fileInput.value = "";
  customFileLabel.html("");
}

function showFileSizeExceedWarning() {
  Swal.fire({
    title: "ขนาดไฟล์เกิน",
    text: "ขนาดไฟล์ภาพของคุณเกิน 5 MB กรุณาเลือกใหม่",
    icon: "warning",
  });
}

$(function () {
  $("#formData").submit(function (e) {
    e.preventDefault();
    $.ajax({
      type: "POST",
      url: "../../service/superadmin_ad/sport/update.php",
      data: new FormData($("#formData")[0]),
      processData: false,
      contentType: false,
      success: function (resp) {
        Swal.fire({
          icon: "success",
          title: "อัพเดทข้อมูลเรียบร้อยแล้ว",
          showConfirmButton: false,
          timer: 1000,
        }).then((result) => {
          location.assign("../sport/");
        });
      },
      error: function (xhr, status, error) {
        // Handle AJAX request errors
        console.log("XHR:", xhr);
        console.log("Status:", status);
        console.log("Error:", error);

        Swal.fire({
          icon: "error",
          title: "Update failed. Please try again.",
          showConfirmButton: false,
          timer: 1000,
        }).then((result) => {
          location.assign("../sport/");
        });
      },
    });
  });
});
