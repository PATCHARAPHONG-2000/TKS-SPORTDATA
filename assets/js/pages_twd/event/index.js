// $(document).ready(function () {
//   var table = $("#index-event").DataTable({
//     paging: true,
//     ordering: false,
//     searching: true,
//     info: true,
//     className: "select-checkbox",
//     columnDefs: [
//       {
//         width: "3%",
//         targets: 0,
//       },
//       {
//         width: "3%",
//         targets: 1,
//       },
//       {
//         width: "10%",
//         targets: 2,
//       },
//       {
//         width: "10%",
//         targets: 3,
//       },
//       {
//         width: "7%",
//         targets: 4,
//       },
//       {
//         width: "13%",
//         targets: 5,
//       },
//       {
//         width: "13%",
//         targets: 6,
//       },
//       {
//         width: "5%",
//         targets: 7,
//       },
//       {
//         width: "5%",
//         targets: 8,
//       },
//       {
//         width: "7%",
//         targets: 9,
//       },
//       {
//         width: "10%",
//         targets: 10,
//       },
//       {
//         width: "10%",
//         targets: 11,
//       },
//     ],
//     initComplete: function () {
//       var column5 = this.api().column(5); // เปลี่ยนจาก column7 เป็น column5
//       $(column5.header()).html(
//         '<label for="positionFilter">รุ่นอายุ: </label>'
//       );
//       var select1 = $(
//         '<select id="positionFilter" class="dashbordadmin-province-select form-control custom-select"><option value="">ทั้งหมด</option></select>'
//       )
//         .appendTo($(column5.header()))
//         .on("change", function () {
//           var val = $.fn.dataTable.util.escapeRegex($(this).val());
//           column5.search(val ? "^" + val + "$" : "", true, false).draw();
//         });
//       column5
//         .data()
//         .unique()
//         .each(function (d) {
//           select1.append('<option value="' + d + '">' + d + "</option>");
//         });
//     },
//   });

//   $("#selectAll").on("click", function () {
//     $(".checkbox").prop("checked", this.checked);
//     $("#delete").prop("disabled", !this.checked);
//   });

//   $(".checkbox").on("click", function () {
//     if ($(".checkbox:checked").length === $(".checkbox").length) {
//       $("#selectAll").prop("checked", true);
//     } else {
//       $("#selectAll").prop("checked", false);
//     }
//     $("#delete").prop("disabled", $(".checkbox:checked").length === 0);
//   });

//   $(".delete-btn").on("click", function () {
//     let eventId;

//     // Check if the button is in the table or not
//     if ($(this).data("id")) {
//       // Button is in the table
//       eventId = $(this).data("id");
//     } else {
//       // Button is not in the table, get selected IDs from checkboxes
//       eventId = $(".checkbox:checked")
//         .map(function () {
//           return $(this).val();
//         })
//         .get();
//     }

//     Swal.fire({
//       text: "คุณแน่ใจหรือไม่ที่จะลบรายการนี้?",
//       icon: "warning",
//       showCancelButton: true,
//       confirmButtonText: "ใช่! ลบเลย",
//       cancelButtonText: "ยกเลิก",
//     }).then((result) => {
//       if (result.isConfirmed) {
//         $.ajax({
//           type: "POST",
//           url: "../../service/pages-twd/event/delete",
//           data: {
//             ids: eventId,
//           },
//           success: function (response) {
//             console.log(response);
//             Swal.fire({
//               text: "รายการถูกลบเรียบร้อย",
//               icon: "success",
//               timer: 1000,
//               confirmButtonText: "ตกลง",
//               timerProgressBar: true,
//             }).then((result) => {
//               location.reload();
//             });
//           },
//           error: function (xhr, status, error) {
//             console.error(error);
//             Swal.fire({
//               text: "เกิดข้อผิดพลาดในการส่งข้อมูล",
//               icon: "error",
//               timer: 1000,
//               confirmButtonText: "ตกลง",
//               timerProgressBar: true,
//             }).then((result) => {
//               location.reload();
//             });
//           },
//         });
//       }
//     });
//   });

//   table.on("draw", function () {
//     if ($(".checkbox:checked").length === $(".checkbox").length) {
//       $("#selectAll").prop("checked", true);
//     } else {
//       $("#selectAll").prop("checked", false);
//     }
//   });
// });

// function deletePerson(personId) {
//   Swal.fire({
//     text: "คุณแน่ใจหรือไม่ที่จะลบรายการนี้?",
//     icon: "warning",
//     showCancelButton: true,
//     confirmButtonText: "ใช่! ลบเลย",
//     cancelButtonText: "ยกเลิก",
//   }).then((result) => {
//     if (result.isConfirmed) {
//       $.ajax({
//         type: "POST",
//         url: "../../service/pages-twd/event/delete",
//         data: {
//           ids: personId,
//         },
//         success: function (response) {
//           console.log(response);
//           Swal.fire({
//             text: "รายการถูกลบเรียบร้อย",
//             icon: "success",
//             timer: 1000,
//             confirmButtonText: "ตกลง",
//             timerProgressBar: true,
//           }).then((result) => {
//             location.reload();
//           });
//         },
//         error: function (xhr, status, error) {
//           console.error(error);
//           Swal.fire({
//             text: "เกิดข้อผิดพลาดในการส่งข้อมูล",
//             icon: "error",
//             // timer: 1000,
//             confirmButtonText: "ตกลง",
//             timerProgressBar: true,
//           }).then((result) => {
//             // location.reload();
//           });
//         },
//       });
//     }
//   });
// }
