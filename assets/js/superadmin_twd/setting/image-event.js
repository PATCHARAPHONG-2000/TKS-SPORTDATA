function displayFileName() {
  var input = document.getElementById("customFile");
  var fileName = input.files[0].name;
  var label = document.querySelector(".custom-file-label");
  label.innerText = fileName;

  // แสดงรูปภาพ
  var preview = document.getElementById("imagePreview");
  preview.innerHTML = ""; // ล้างข้อมูลที่มีอยู่ก่อนหน้า
  var img = document.createElement("img");
  img.src = URL.createObjectURL(input.files[0]);
  img.style.maxWidth = "50%";
  img.style.height = "auto";
  preview.appendChild(img);
}

$(function () {
  $("#formdata").on("submit", function (e) {
    e.preventDefault();
    $.ajax({
      type: "POST",
      url: "../../service/superadmin_ad/setting/image/image",
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
        location.assign("./image");
      });
    });
  });
});

$(function () {
  $.ajax({
    type: "GET",
    url: "../../service/superadmin_ad/setting/image/index",
  })
    .done(function (data) {
      let tableData = [];
      data.response.forEach(function (item, index) {
        if (item.name !== null) {
          tableData.push([
            ++index,
            item.name,
            `<img src="../../service/superadmin_twd/setting/uploads/${item.image}" alt="Image" style="max-width: 150px;">`,
            `<input class="toggle-image" data-id="${
              item.id
            }" type="checkbox" name="status" 
                            ${
                              item.id ? "checked" : ""
                            } data-toggle="toggle" data-on="เผยแพร่" 
                            data-off="ปิด" data-onstyle="success" data-style="ios">`,
            `<div class="btn-group" role="group">
                                <a href="../manager/form-edit-image.php?id=${item.id}" type="button" class="btn btn-warning text-white">
                                    <i class="far fa-edit"></i> แก้ไข
                                </a>
                                <button type="button" class="btn btn-danger" id="delete" data-id="${item.id}" data-index="${index}">
                                    <i class="far fa-trash-alt"></i> ลบ
                                </button>
                            </div>`,
          ]);
        }
      });
      initDataTables(tableData);
    })
    .fail(function () {
      Swal.fire({
        text: "ไม่สามารถเรียกดูข้อมูลได้",
        icon: "error",
        confirmButtonText: "ตกลง",
      }).then(function () {
        location.assign("../dashboard");
      });
    });

  function initDataTables(tableData) {
    var table = $("#logs").DataTable({
      data: tableData,
      order: false,

      columns: [
        {
          title: "ลำดับ",
          className: "align-middle",
          orderable: false,
        },
        {
          title: "ชื่ออีเว้นท์",
          className: "align-middle",
          orderable: false,
        },
        {
          title: "รูป",
          className: "align-middle",
          orderable: false,
        },
        {
          title: "เปิด/ปิด",
          className: "align-middle",
          orderable: false,
        },
        {
          title: "จัดการ",
          className: "align-middle",
          orderable: false,
        },
      ],
      columnDefs: [
        {
          width: "25%",
          targets: 1,
        },
        {
          width: "25%",
          targets: 2,
        },
        {
          width: "25%",
          targets: 3,
        },
      ],
      fnDrawCallback: function () {
        $(".toggle-image").bootstrapToggle();
        $(".toggle-image").change(function () {
          var imageon = $(this).data("id");
          var isActive = $(this).prop("checked") ? 1 : 0;

          $.ajax({
            type: "POST",
            url: "../../service/superadmin_ad/setting/image/image_create",
            data: {
              imageon: imageon,
              isActive: isActive,
            },
            success: function (response) {
              console.log(response);

              // แจ้งเตือนเมื่อรายการถูกเปิดหรือปิด
              var actionMessage = isActive ? "เปิด" : "ปิด";
              toastr.success("รายการถูก" + actionMessage + "เรียบร้อย");
            },
            error: function (error) {
              console.error("Error:", error);
              toastr.error("เกิดข้อผิดพลาดในการปรับปรุงข้อมูล");
            },
          });
        });
      },
      responsive: {
        details: {
          display: $.fn.dataTable.Responsive.display.modal({
            header: function (row) {
              var data = row.data();
              return "ผู้ใช้งาน: " + data[1];
            },
          }),
          renderer: $.fn.dataTable.Responsive.renderer.tableAll({
            tableClass: "table",
          }),
        },
      },
      language: {
        lengthMenu: "แสดงข้อมูล _MENU_ แถว",
        zeroRecords: "ยังไม่มีรายชื่อ",
        info: "แสดงหน้า _PAGE_ จาก _PAGES_",
        infoEmpty: "ยังไม่มีรายชื่อ",
        infoFiltered: "(filtered from _MAX_ total records)",
        search: "ค้นหา",
        paginate: {
          previous: "ก่อนหน้านี้",
          next: "หน้าต่อไป",
        },
      },
    });

    $(document).on("click", "#delete", function () {
      let id = $(this).data("id");
      let index = $(this).data("index");
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
            url: "../../service/superadmin_ad/setting/image/image_delete",
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
              location.assign("./image");
            });
          });
        }
      });
    });
  }
});
