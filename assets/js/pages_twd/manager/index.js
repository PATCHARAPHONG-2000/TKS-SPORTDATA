$(document).ready(function () {
  var table = $("#sportsperson").DataTable({
    paging: true,
    ordering: false,
    searching: true,
    info: true,
    columnDefs: [
      { width: "10%", targets: 0 },
      { width: "15%", targets: 1 },
      { width: "15%", targets: 2 },
      { width: "10%", targets: 3 },
      { width: "10%", targets: 4 },
      { width: "10%", targets: 5 },
      { width: "15%", targets: 6 },
    ],
  });
});

function deletePerson(id) {
  Swal.fire({
    text: "คุณแน่ใจหรือไม่...ที่จะลบรายการนี้?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "ใช่! ลบเลย",
    cancelButtonText: "ยกเลิก",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        type: "POST",
        url: "../../service/pages-twd/delete",
        data: {
          id: id,
        },
      }).done(function () {
        Swal.fire({
          text: "รายการของคุณถูกลบเรียบร้อย",
          icon: "success",
          confirmButtonText: "ตกลง",
          timer: 500,
          timerProgressBar: true,
        }).then((result) => {
          location.assign("./");
        });
      });
    }
  });
}
