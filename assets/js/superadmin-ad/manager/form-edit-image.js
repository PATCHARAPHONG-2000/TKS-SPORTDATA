function displayFileName() {
  var input = document.getElementById("customFile");
  var fileName = input.files[0].name;
  var label = document.querySelector(".custom-file-label");
  label.innerText = fileName;

  var preview = document.getElementById("imagePreview");
  preview.innerHTML = "";
  var img = document.createElement("img");
  img.src = URL.createObjectURL(input.files[0]);
  img.style.maxWidth = "50%";
  img.style.height = "auto";
  preview.appendChild(img);
}

// Call the displayFileName() function when the file input changes
document
  .getElementById("customFile")
  .addEventListener("change", displayFileName);

$(function () {
  $("#formData").submit(function (e) {
    e.preventDefault();
    $.ajax({
      type: "POST",
      url: "../../service/superadmin_ad/setting/image/image-update.php",
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
          location.assign("../setting/image.php");
        });
      },
      error: function (xhr, status, error) {
        console.log("XHR:", xhr);
        console.log("Status:", status);
        console.log("Error:", error);

        Swal.fire({
          icon: "error",
          title: "Update failed. Please try again.",
          showConfirmButton: false,
          timer: 1000,
        }).then((result) => {
          location.assign("../setting/image.php");
        });
      },
    });
  });
});
