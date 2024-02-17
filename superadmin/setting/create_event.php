<?php

require_once('../authen.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SUPERADMIN || TKS SPORTDATA</title>
    <link rel="shortcut icon" type="image/x-icon" href="../../assets/images/favicon.ico">
    <!-- stylesheet -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Kanit">
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <link rel="stylesheet" href="../../plugins/bootstrap-toggle/bootstrap-toggle.min.css">
    <link rel="stylesheet" href="../../plugins/toastr/toastr.min.css">
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
                                        <i class="fa-regular fa-calendar-plus"></i>
                                        อีเว้นท์
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <table id="logs" class="table table table-striped table-hover" width="100%">
                                    </table>
                                </div>
                                <div class="card-body" style="font: 2rem;">
                                    <form id="formdata" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-md-6 px-1 px-md-5">
                                                <div class="form-group">
                                                    <div class="col-sm-10">
                                                        <label for="">เริ่ม เพิ่ม-แก้ไขข้อมูล</label>
                                                        <input type="date" name="start_date" class="form-control"
                                                            min="<?php echo date('Y-m-d'); ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 px-1 px-md-5">
                                                <div class="form-group">
                                                    <div class="col-sm-10">
                                                        <label for="">สิ้นสุด</label>
                                                        <input type="date" name="end_date" class="form-control"
                                                            min="<?php echo date('Y-m-d'); ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="imagePreview" class="text-center mx-auto mt-3"></div>
                                        <div class="card-footer mt-3">
                                            <button type="submit" class="btn btn-primary btn-block mx-auto w-50"
                                                name="submit">บันทึกข้อมูล</button>
                                        </div>
                                    </form>
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
    <script src="../../plugins/bootstrap-toggle/bootstrap-toggle.min.js"></script>
    <script src="../../plugins/toastr/toastr.min.js"></script>
    <!-- datatables -->
    <script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

    <script>
    $(function() {
        $('#formdata').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '../../service/superadmin/setting/image.php',
                data: new FormData(this),
                contentType: false,
                processData: false
            }).done(function(resp) {
                Swal.fire({
                    text: 'เพิ่มข้อมูลเรียบร้อย',
                    icon: 'success',
                    confirmButtonText: 'ตกลง',
                    showConfirmButton: false,
                    timer: 500
                }).then((result) => {
                    location.assign('./image');
                });
            })
        });
    });

    $(function() {
        $.ajax({
            type: 'GET',
            url: '../../service/superadmin/setting/image/index.php',
        }).done(function(data) {
            let tableData = []
            data.response.forEach(function(item, index) {
                if (item.name !== null) {
                    tableData.push([
                        ++index,
                        item.name,
                        `<img src="../../service/superadmin/uploads/${item.image}" alt="Image" style="max-width: 150px;">`,
                        `<input class="toggle-image" data-id="${item.id}" type="checkbox" name="status" 
                            ${item.id ? 'checked' : ''} data-toggle="toggle" data-on="เผยแพร่" 
                            data-off="ปิด" data-onstyle="success" data-style="ios">`,
                        `<div class="btn-group" role="group">
                                <a href="../manager/form-edit-image.php?id=${item.id}" type="button" class="btn btn-warning text-white">
                                    <i class="far fa-edit"></i> แก้ไข
                                </a>
                                <button type="button" class="btn btn-danger" id="delete" data-id="${item.id}" data-index="${index}">
                                    <i class="far fa-trash-alt"></i> ลบ
                                </button>
                        </div>`
                    ]);
                }
            })
            initDataTables(tableData)
        }).fail(function() {
            Swal.fire({
                text: 'ไม่สามารถเรียกดูข้อมูลได้',
                icon: 'error',
                confirmButtonText: 'ตกลง',
            }).then(function() {
                location.assign('../dashboard')
            })
        })

        function initDataTables(tableData) {
            var table = $('#logs').DataTable({
                data: tableData,
                order: false,

                columns: [{
                        title: "ลำดับ",
                        className: "align-middle",
                        orderable: false
                    },
                    {
                        title: "ชื่ออีเว้นท์",
                        className: "align-middle",
                        orderable: false
                    },
                    {
                        title: "รูป",
                        className: "align-middle",
                        orderable: false
                    },
                    {
                        title: "เปิด/ปิด",
                        className: "align-middle",
                        orderable: false
                    },
                    {
                        title: "จัดการ",
                        className: "align-middle",
                        orderable: false
                    }
                ],
                columnDefs: [{
                        width: '25%',
                        targets: 1
                    },
                    {
                        width: '25%',
                        targets: 2
                    },
                    {
                        width: '25%',
                        targets: 3
                    }
                ],
                fnDrawCallback: function() {
                    $('.toggle-image').bootstrapToggle();
                    $('.toggle-image').change(function() {
                        var imageon = $(this).data('id');
                        var isActive = $(this).prop('checked') ? 1 : 0;

                        $.ajax({
                            type: 'POST',
                            url: '../../service/superadmin/setting/image_create.php',
                            data: {
                                imageon: imageon,
                                isActive: isActive
                            },
                            success: function(response) {
                                console.log(response);
                                var actionMessage = isActive ? 'เปิด' : 'ปิด';
                                toastr.success('รายการถูก' + actionMessage +
                                    'เรียบร้อย');
                            },
                            error: function(error) {
                                console.error('Error:', error);
                                toastr.error(
                                    'เกิดข้อผิดพลาดในการปรับปรุงข้อมูล');
                            }
                        });
                    });
                },
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
                    "zeroRecords": "ยังไม่ข้อมูล",
                    "info": "แสดงหน้า _PAGE_ จาก _PAGES_",
                    "infoEmpty": "ยังไม่ข้อมูล",
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
                            url: "../../service/superadmin/setting/image_delete.php",
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
                                location.assign('./image');
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