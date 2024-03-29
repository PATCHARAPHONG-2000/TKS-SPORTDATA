<?php
require_once('../authen.php');

$Database = new Database();
$conn = $Database->connect();

$sql = $conn->prepare("SELECT * FROM setting");
$sql->execute();
$row = $sql->fetch(PDO::FETCH_ASSOC);

$allowEdit = isset($row['name']) && $row['name'] == 'btn-add_data' && isset($row['IsActive']) && $row['IsActive'] == 1;

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?php echo isset($_SESSION['id_city']['province']) ? $_SESSION['id_city']['province'] : ''; ?> | TKS SPORTDATA
    </title>
    <link rel="shortcut icon" type="image/x-icon" href="../../assets/images/favicon.ico">
    <!-- stylesheet -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Kanit">
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <link rel="stylesheet" href="../../assets/css/adminlte.min.css">
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="../../assets/css/datatable.css">


    <!-- Datatables -->
    <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <?php include_once('../includes/sidebar.php') ?>
        <div class="content-wrapper pt-3">
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card shadow">

                                <div class="card-header border-0 pt-4">
                                    <h4>
                                        <i class="fa-regular fa-address-card"></i>
                                        ตวจสอบรายชื่อ
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <table id="logs" class="table table table-striped table-hover" width="100%">
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once('../includes/footer.php') ?>
    </div>

    <!-- scripts -->
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="../../assets/js/adminlte.min.js"></script>
    <!-- datatables -->
    <script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="../../assets/js/pages_ad/dashboard/index.js"></script>
    <script>
    // $(function() {
    //     $.ajax({
    //         type: "GET",
    //         url: "../../service/managercard/index"
    //     }).done(function(data) {
    //         let tableData = []
    //         let allowEdit =
    //             <?php echo (isset($row['name']) && $row['name'] == 'btn-add_data' && isset($row['IsActive']) && $row['IsActive'] == 1) ? 'true' : 'false'; ?>;
    //         data.response.forEach(function(item, index) {
    //             if (item.firstname !== null && item.lastname !== null) {
    //                 let editLink = allowEdit ? createEditLink(item.id) : '';
    //                 let deleteButton = allowEdit ? createDeleteButton(item.id) : '';
    //                 tableData.push([
    //                     ++index,
    //                     item.firstname,
    //                     item.lastname,
    //                     item.status,
    //                     `<img src="../../service/uploads/${item.image}" alt="Image" style="max-width: 50px;">`,
    //                     `<div class="btn-group" role="group">
    //                             ${editLink}
    //                             ${deleteButton} 
    //                             <a href="info.php?id=${item.id}" class="btn btn-info">
    //                                 <i class="fas fa-search"></i> ดูข้อมูล
    //                             </a>
    //                         </div>`
    //                 ]);
    //             }
    //         })
    //         initDataTables(tableData)
    //     }).fail(function() {
    //         Swal.fire({
    //             text: 'ไม่สามารถเรียกดูข้อมูลได้',
    //             icon: 'error',
    //             confirmButtonText: 'ตกลง',
    //         }).then(function() {
    //             location.assign('../dashboard')
    //         })
    //     })

    //     function createEditLink(id) {
    //         return `<a href="../manager/form-edit.php?id=${id}" type="button" class="btn btn-warning text-white">
    //             <i class="far fa-edit"></i> แก้ไข
    //             </a>`;
    //     }

    //     function createDeleteButton(id) {
    //         let deleteButton = `
    //             <button type="button" class="btn btn-danger" id="delete" data-id="${id}">
    //                 <i class="far fa-trash-alt"></i> ลบ
    //             </button>`;
    //         return deleteButton;
    //     }

    //     function initDataTables(tableData) {
    //         var table = $("#logs").DataTable({
    //             data: tableData,

    //             columns: [{
    //                     title: "ลำดับ",
    //                     className: "align-middle",
    //                     orderable: true,
    //                 },
    //                 {
    //                     title: "ชื่อจริง",
    //                     className: "align-middle",
    //                     orderable: true,
    //                 },
    //                 {
    //                     title: "นามสกุล",
    //                     className: "align-middle",
    //                     orderable: true,
    //                 },
    //                 {
    //                     title: "ตำแหน่ง",
    //                     className: "align-middle",
    //                     orderable: false,
    //                 },
    //                 {
    //                     title: "รูปภาพ",
    //                     className: "align-middle",
    //                     orderable: false,
    //                 },
    //                 {
    //                     title: "จัดการ",
    //                     className: "align-middle",
    //                     orderable: false,
    //                 },
    //             ],
    //             columnDefs: [{
    //                     width: "15%",
    //                     targets: 1,
    //                 },
    //                 {
    //                     width: "15%",
    //                     targets: 2,
    //                 },
    //                 {
    //                     width: "25%",
    //                     targets: 3,
    //                 },
    //                 {
    //                     width: "10%",
    //                     targets: 4,
    //                 },
    //                 {
    //                     width: "20%",
    //                     targets: 5,
    //                 },
    //             ],

    //             initComplete: function() {
    //                 var column3 = this.api().column(3);
    //                 $(column3.header()).html(
    //                     '<label for="positionFilter">ตำแหน่ง: </label>'
    //                 );
    //                 var select1 = $(
    //                         '<select id="positionFilter" class="dashbordadmin-province-select form-control custom-select"><option value="">ทั้งหมด</option></select>'
    //                     )
    //                     .appendTo($(column3.header()))
    //                     .on("change", function() {
    //                         var val = $.fn.dataTable.util.escapeRegex($(this).val());
    //                         column3.search(val ? "^" + val + "$" : "", true, false).draw();
    //                     });
    //                 column3
    //                     .data()
    //                     .unique()
    //                     .each(function(d) {
    //                         select1.append('<option value="' + d + '">' + d + "</option>");
    //                     });
    //             },

    //             responsive: {
    //                 details: {
    //                     display: $.fn.dataTable.Responsive.display.modal({
    //                         header: function(row) {
    //                             var data = row.data();
    //                             return "ผู้ใช้งาน: " + data[1];
    //                         },
    //                     }),
    //                     renderer: $.fn.dataTable.Responsive.renderer.tableAll({
    //                         tableClass: "table",
    //                     }),
    //                 },
    //             },
    //             language: {
    //                 lengthMenu: "แสดงข้อมูล _MENU_ แถว",
    //                 zeroRecords: "ยังไม่มีรายชื่อ",
    //                 info: "แสดงหน้า _PAGE_ จาก _PAGES_",
    //                 infoEmpty: "ยังไม่มีรายชื่อ",
    //                 infoFiltered: "(filtered from _MAX_ total records)",
    //                 search: "ค้นหา",
    //                 paginate: {
    //                     previous: "ก่อนหน้านี้",
    //                     next: "หน้าต่อไป",
    //                 },
    //             },
    //         });

    //         $(document).on("click", "#delete", function() {
    //             let id = $(this).data("id");
    //             let index = $(this).data("index");
    //             Swal.fire({
    //                 text: "คุณแน่ใจหรือไม่...ที่จะลบรายการนี้?",
    //                 icon: "warning",
    //                 showCancelButton: true,
    //                 confirmButtonText: "ใช่! ลบเลย",
    //                 cancelButtonText: "ยกเลิก",
    //             }).then((result) => {
    //                 if (result.isConfirmed) {
    //                     $.ajax({
    //                         type: "POST",
    //                         url: "../../service/managercard/delete.php",
    //                         data: {
    //                             id: id,
    //                         },
    //                     }).done(function() {
    //                         Swal.fire({
    //                             text: "รายการของคุณถูกลบเรียบร้อย",
    //                             icon: "success",
    //                             confirmButtonText: "ตกลง",
    //                             timer: 500,
    //                             timerProgressBar: true,
    //                         }).then((result) => {
    //                             location.assign("./");
    //                         });
    //                     });
    //                 }
    //             });
    //         });
    //     }
    // });
    </script>
</body>

</html>