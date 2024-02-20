$(function () {
  if (typeof allowEdit !== "undefined" && allowEdit) {
    console.log("Allow editing");
  } else {
    console.log("Editing not allowed");
  }

  $.ajax({
    type: "GET",
    url: "../../service/managercard/index",
  })
    .done(function (data) {
      let tableData = [];
      let allowEdit = data.response && data.response.length > 0;
      data.response.forEach(function (item, index) {
        if (item.firstname !== null && item.lastname !== null) {
          let editLink = allowEdit ? createEditLink(item.id) : "";
          let deleteButton = allowEdit ? createDeleteButton(item.id) : "";
          tableData.push([
            ++index,
            item.firstname,
            item.lastname,
            item.status,
            `<img src="../../service/uploads/${item.image}" alt="Image" style="max-width: 50px;">`,
            `<div class="btn-group" role="group">
                                ${editLink}
                                ${deleteButton} 
                                <a href="info.php?id=${item.id}" class="btn btn-info">
                                    <i class="fas fa-search"></i> ดูข้อมูล
                                </a>
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

  function createEditLink(id) {
    return `<a href="../manager/form-edit.php?id=${id}" type="button" class="btn btn-warning text-white">
                <i class="far fa-edit"></i> แก้ไข
                </a>`;
  }

  function createDeleteButton(id) {
    let deleteButton = `
                <button type="button" class="btn btn-danger" id="delete" data-id="${id}">
                    <i class="far fa-trash-alt"></i> ลบ
                </button>`;
    return deleteButton;
  }

  function initDataTables(tableData) {
    var table = $("#logs").DataTable({
      data: tableData,

      columns: [
        {
          title: "ลำดับ",
          className: "align-middle",
          orderable: true,
        },
        {
          title: "ชื่อจริง",
          className: "align-middle",
          orderable: true,
        },
        {
          title: "นามสกุล",
          className: "align-middle",
          orderable: true,
        },
        {
          title: "ตำแหน่ง",
          className: "align-middle",
          orderable: false,
        },
        {
          title: "รูปภาพ",
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
          width: "15%",
          targets: 1,
        },
        {
          width: "15%",
          targets: 2,
        },
        {
          width: "25%",
          targets: 3,
        },
        {
          width: "10%",
          targets: 4,
        },
        {
          width: "20%",
          targets: 5,
        },
      ],

      initComplete: function () {
        var column3 = this.api().column(3);
        $(column3.header()).html(
          '<label for="positionFilter">ตำแหน่ง: </label>'
        );
        var select1 = $(
          '<select id="positionFilter" class="dashbordadmin-province-select form-control custom-select"><option value="">ทั้งหมด</option></select>'
        )
          .appendTo($(column3.header()))
          .on("change", function () {
            var val = $.fn.dataTable.util.escapeRegex($(this).val());
            column3.search(val ? "^" + val + "$" : "", true, false).draw();
          });
        column3
          .data()
          .unique()
          .each(function (d) {
            select1.append('<option value="' + d + '">' + d + "</option>");
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
            url: "../../service/managercard/delete.php",
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
    });
  }
});
