<?php
require_once('../authen.php');

$per = $conn->prepare("SELECT * FROM data_all");
$per->execute();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SUPERADMIN || TKS SPORTDATA</title>
    <link rel="shortcut icon" type="image/x-icon" href="../../assets/images/favicon.ico">
    <!-- Stylesheets -->
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
                                        เปลี่ยรูปอีเว้นท์
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <!-- <table id="logs" class="table table table-striped table-hover" width="100%">
                                    </table> -->
                                    <table id="index-event" class="table table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th class="align-middle">ลำดับ</th>
                                                <th class="align-middle">ชื่อแมตท์</th>
                                                <th class="align-middle">รูปแบร์นเนอร์</th>
                                                <th class="align-middle">เปิด/ปิด</th>
                                                <th class="align-middle">จัดการ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $counter = 1;
                                            if ($per->rowCount() > 0) {
                                                while ($person = $per->fetch(PDO::FETCH_ASSOC)) {
                                            ?>
                                                    <tr id="<?php echo $person["id"]; ?>">
                                                        <td class="align-middle">
                                                            <?php echo $counter; ?>
                                                        </td>
                                                        <td class="align-middle">
                                                            <?php echo $person["name"]; ?>
                                                        </td>
                                                        <td class="align-middle">
                                                            <img src="../../service/superadmin_twd/setting/uploads/<?php echo $person["image"]; ?>" alt="Profile" style="max-width: 150px;">
                                                        </td>
                                                        <td class="align-middle">
                                                            <input class="toggle-image" data-id="<?php echo $person['id']; ?>" type="checkbox" name="status" <?php echo isset($person['IsActive']) && $person['IsActive'] == 1 ? "checked" : ""; ?> data-toggle="toggle" data-on="เผยแพร่" data-off="ปิด" data-onstyle="success" data-style="ios">
                                                        </td>
                                                        <td class="align-middle">
                                                            <a href="./form-edit-image.php?id=<?php echo $person['id']; ?>" type="button" class="btn btn-warning text-white">
                                                                <i class="far fa-edit"></i> แก้ไข
                                                            </a>
                                                            <button type="button" id="delete" class="btn btn-danger delete-btn" data-id="<?php echo $person['id']; ?>">
                                                                <i class="far fa-trash-alt"></i> ลบ
                                                            </button>
                                                        </td>
                                                    </tr>
                                                <?php
                                                    $counter++;
                                                }
                                            } else {
                                                ?>
                                                <tr>
                                                    <td colspan="7">ยังไม่รายชื่อ</td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="card-body " style="font: 2rem;">
                                    <form id="formdata" id="originalCardBody" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-md-6 px-1 px-md-5">
                                                <div class="form-group">
                                                    <label for="eventsname">ชื่ออีเว้นท์<span style="color: red;">*</span></label>
                                                    <input type="text" class="form-control" name="eventsname" id="eventsname" placeholder="ชื่อ" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6 px-1 px-md-5">
                                                <div class="form-group">
                                                    <label for="customFile">รูปแบร์นเนอร์ <span style="color: red;">*</span></label>
                                                    <div class="custom-file mb-2 mt-2">
                                                        <input name="image" type="file" class="custom-file-input" id="customFile" accept="image/*" required onchange="displayFileName()">
                                                        <label class="custom-file-label" for="customFile">เลือกรูปภาพ</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="imagePreview" class="text-center mx-auto mt-3"></div>
                                        <div class="card-footer mt-3">
                                            <button type="submit" class="btn btn-primary btn-block mx-auto w-50" name="submit">บันทึกข้อมูล</button>
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

    <!-- Scripts -->
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="../../plugins/bootstrap-toggle/bootstrap-toggle.min.js"></script>
    <script src="../../plugins/toastr/toastr.min.js"></script>
    <script src="../../assets/js/adminlte.min.js"></script>

    <!-- Custom Scripts -->
    <script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function() {
            $("#formdata").on("submit", function(e) {
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    url: "../../service/superadmin_twd/setting/image/image",
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                }).done(function(resp) {
                    Swal.fire({
                        text: "เพิ่มข้อมูลเรียบร้อย",
                        icon: "success",
                        confirmButtonText: "ตกลง",
                        showConfirmButton: false,
                        timer: 500,
                    }).then((result) => {
                        location.assign("./image-event");
                    });
                });
            });

            $(".toggle-image").bootstrapToggle();
            $(".toggle-image").change(function() {
                var imageon = $(this).data("id");
                var isActive = $(this).prop("checked") ? 1 : 0;

                $.ajax({
                    type: "POST",
                    url: "../../service/superadmin_twd/setting/image/image_create",
                    data: {
                        imageon: imageon,
                        isActive: isActive,
                    },
                    success: function(response) {
                        var actionMessage = isActive ? "เปิด" : "ปิด";
                        toastr.success("รายการถูก" + actionMessage + "เรียบร้อย");
                    },
                    error: function(error) {
                        toastr.error("เกิดข้อผิดพลาดในการปรับปรุงข้อมูล");
                    },
                });
            });


        });


        $(document).on("click", "#delete", function() {
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
                        url: "../../service/superadmin_twd/setting/image/image_delete",
                        data: {
                            id: id,
                        },
                    }).done(function() {
                        Swal.fire({
                            text: "รายการของคุณถูกลบเรียบร้อย",
                            icon: "success",
                            confirmButtonText: "ตกลง",
                            timer: 500,
                            timerProgressBar: true,
                        }).then((result) => {
                            location.assign("./image-event.php");
                        });
                    });
                }
            });
        });

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
    </script>

</body>

</html>