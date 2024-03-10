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
  $("#formData").on("submit", function (e) {
    e.preventDefault();
    $.ajax({
      type: "POST",
      url: "../../service/managercard/create.php",
      data: new FormData(this),
      contentType: false,
      processData: false,
    }).done(function (resp) {
      Swal.fire({
        text: "เพิ่มข้อมูลเรียบร้อย",
        icon: "success",
        confirmButtonText: "ตกลง",
        showConfirmButton: false,
        timer: 500,
      }).then((result) => {
        location.assign("./form-create");
      });
    });
  });
});
