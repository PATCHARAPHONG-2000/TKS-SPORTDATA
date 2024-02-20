$(function () {
  $.ajax({
    type: "GET",
    url: "../../service/superadmin_ad/sport/index.php",
  })
    .done(function (data) {
      let tableData = [];
      data.response.forEach(function (item, index) {
        if (item.firstname !== null && item.lastname !== null) {
          tableData.push([
            ++index,
            item.province,
            item.firstname,
            item.lastname,
            item.status,
            `<img src="../../service/uploads/${item.image}" alt="Image" style="max-width: 50px;">`,
            `<div class="btn-group" role="group">
                  <a href="../manager/form-edit-sport.php?id=${item.id}" type="button" class="btn btn-warning text-white">
                      <i class="far fa-edit"></i> แก้ไข
                  </a>
                  <button type="button" class="btn btn-danger" id="delete" data-id="${item.id}" data-index="${index}">
                      <i class="far fa-trash-alt"></i> ลบ
                  </button>
                  <a href="info.php?id=${item.id}" class="btn btn-info" >
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
          title: "จังหวัดที่อยู่",
          className: "align-middle",
          orderable: false,
        },
        {
          title: "ชื่อ",
          className: "align-middle",
          orderable: false,
        },
        {
          title: "นามสกุล",
          className: "align-middle",
          orderable: false,
        },
        {
          title: "ตำแหน่ง",
          className: "align-middle ",
          orderable: false,
        },
        {
          title: "รูป",
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
          width: "20%",
          targets: 1,
        },
        {
          width: "15%",
          targets: 2,
        },
        {
          width: "15%",
          targets: 3,
        },
        {
          width: "20%",
          targets: 4,
        },
        {
          width: "10%",
          targets: 5,
        },
        {
          width: "15%",
          targets: 6,
        },
      ],

      initComplete: function () {
        var column1 = this.api().column(1);
        $(column1.header()).html('<label for="posi">ประเภทกีฬา: </label>');
        var select1 = $(
          '<select id="posi" class="form-control custom-select"><option value="">ทั้งหมด</option></select>'
        )
          .appendTo($(column1.header()))
          .on("change", function () {
            var val = $.fn.dataTable.util.escapeRegex($(this).val());
            column1.search(val ? "^" + val + "$" : "", true, false).draw();
          });
        column1
          .data()
          .unique()
          .sort()
          .each(function (d) {
            select1.append('<option value="' + d + '">' + d + "</option>");
          });
        // Filter for "ตำแหน่ง" column
        var column4 = this.api().column(4);
        $(column4.header()).html(
          '<label for="positionFilter">ตำแหน่ง: </label>'
        );
        var select4 = $(
          '<select id="positionFilter" class="dashbordsuper-province-select form-control custom-select"><option value="">ทั้งหมด</option></select>'
        )
          .appendTo($(column4.header()))
          .on("change", function () {
            var val = $.fn.dataTable.util.escapeRegex($(this).val());
            column4.search(val ? "^" + val + "$" : "", true, false).draw();
          });
        column4
          .data()
          .unique()
          .sort()
          .each(function (d) {
            select4.append('<option value="' + d + '">' + d + "</option>");
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
            url: "../../service/superadmin_ad/sport/delete.php",
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
