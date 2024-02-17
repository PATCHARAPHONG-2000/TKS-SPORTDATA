<?php
require_once('../authen.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>จัดการผู้ดูแลระบบ | AppzStory</title>
    <link rel="shortcut icon" type="image/x-icon" href="../../assets/images/favicon.ico">
    <!-- stylesheet -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Kanit">
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <link rel="stylesheet" href="../../assets/css/adminlte.min.css">
    <link rel="stylesheet" href="../../assets/css/style.css">
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
                                        <i class="fa-solid fa-person"></i>
                                        รายชื่อนักกีฬา
                                    </h4>
                                    <a href="form-create.php" class="btn btn-primary mt-3">
                                        <i class="fas fa-plus"></i>
                                        เพิ่มข้อมูล
                                    </a>
                                </div>
                                <div class="card-body">
                                    <table id="logs" class="table table-hover" width="100%">
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

    <script>
    $(function() {
        $.ajax({
            type: "GET",
            url: "../../service/manager/index.php"
        }).done(function(data) {
            let tableData = [];

            data.response.forEach(function(item, index) {
                if (item.firstname !== null && item.lastname !== null) {
                    let editLink = createEditLink(item.id);
                    let deleteButton = createDeleteButton(item.id);
                    tableData.push([
                        ++index,
                        item.firstname,
                        item.lastname,
                        item.status,
                        item.age,
                        `<img src="../../service/tksuploads/${item.image}" alt="Image" style="max-width: 50px;">`,
                        `<div class="btn-group" role="group">
                                ${editLink}
                                ${deleteButton}
                                <a href="info.php?id=${item.id}" class="btn btn-info">
                                    <i class="fas fa-search"></i> ดูข้อมูล
                                </a>
                            </div>`
                    ]);
                }
            });
            initDataTables(tableData);
        }).fail(function() {
            Swal.fire({
                text: 'ไม่สามารถเรียกดูข้อมูลได้',
                icon: 'error',
                confirmButtonText: 'ตกลง',
            }).then(function() {
                location.assign('../dashboard');
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
            $('#logs').DataTable({
                data: tableData,
                "ordering": false,
                columns: [{
                        title: "ลำดับ",
                        className: "align-middle"
                    },
                    {
                        title: "ชื่อ",
                        className: "align-middle"
                    },
                    {
                        title: "นามสกุล",
                        className: "align-middle"
                    },
                    {
                        title: "เพศ",
                        className: "align-middle"
                    },
                    {
                        title: "อายุ",
                        className: "align-middle"
                    },
                    {
                        title: "image",
                        className: "align-middle"
                    },
                    {
                        title: "จัดการ",
                        className: "align-middle"
                    }
                ],

                columnDefs: [{
                        width: '10%',
                        targets: 0
                    },
                    {
                        width: '20%',
                        targets: 1
                    },
                    {
                        width: '20%',
                        targets: 2
                    },
                    {
                        width: '10%',
                        targets: 3
                    },
                    {
                        width: '10%',
                        targets: 4
                    },
                    {
                        width: '15%',
                        targets: 5
                    },
                    {
                        width: '20%',
                        targets: 6
                    },
                ],

                responsive: {
                    details: {
                        display: $.fn.dataTable.Responsive.display.modal({
                            header: function(row) {
                                var data = row.data();
                                return 'ผู้ใช้งาน: ' + data[1];
                            }
                        }),
                        renderer: $.fn.dataTable.Responsive.renderer.tableAll({
                            tableClass: 'table'
                        })
                    }
                },
                language: {
                    "lengthMenu": "แสดงข้อมูล _MENU_ แถว",
                    "zeroRecords": "ไม่พบข้อมูลที่ต้องการ",
                    "info": "แสดงหน้า _PAGE_ จาก _PAGES_",
                    "infoEmpty": "ไม่พบข้อมูลที่ต้องการ",
                    "infoFiltered": "(filtered from _MAX_ total records)",
                    "search": 'ค้นหา',
                    "paginate": {
                        "previous": "ก่อนหน้านี้",
                        "next": "หน้าต่อไป"
                    }
                }
            });

            $(document).on('click', '#delete', function() {
                let id = $(this).data('id');
                let index = $(this).data('index');
                Swal.fire({
                    text: "คุณแน่ใจหรือไม่...ที่จะลบรายการนี้?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'ใช่! ลบเลย',
                    cancelButtonText: 'ยกเลิก'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: "../../service/manager/delete.php",
                            data: {
                                id: id
                            },
                        }).done(function() {
                            Swal.fire({
                                text: 'รายการของคุณถูกลบเรียบร้อย',
                                icon: 'success',
                                confirmButtonText: 'ตกลง',
                                timer: 500,
                                timerProgressBar: true,
                            }).then((result) => {
                                location.assign('./');
                            })
                        });
                    }
                });
            });
        }


    });
    </script>
</body>

</html>