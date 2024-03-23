<?php
require_once('../authen.php');

if (isset($_SESSION['team']['role'])) {
    $role = $_SESSION['team']['role'];
} else {
    $role = 'default_status';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo isset($_SESSION['team']['role']) ? $_SESSION['team']['role'] : ''; ?> | TKS SPORTDATA</title>
    <link rel="shortcut icon" type="image/x-icon" href="../../assets/images/favicon.ico">
    <!-- stylesheet -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Kanit">
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <link rel="stylesheet" href="../../assets/css/adminlte.min.css">
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <?php include_once('../includes/sidebar.php') ?>
        <div class="content-wrapper pt-3">
            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card shadow">
                                <div class="card-header border-0 pt-4">
                                    <h4>
                                        <i class="fa-solid fa-user-plus"></i>
                                        เพิ่มรายชื่อนักกีฬา
                                    </h4>
                                    <a href="./" class="btn btn-info my-3 ">
                                        <i class="fas fa-list"></i>
                                        กลับหน้าหลัก
                                    </a>
                                </div>
                                <form id="formData">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 px-1 px-md-5">
                                                <div class="form-group">
                                                    <label for="firstname">ชื่อ <span style="color: red;">*</span></label>
                                                    <input type="text" class="form-control" name="firstname" id="firstname" placeholder="ชื่อ" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="permission">เพศ <span style="color: red;">*</span></label>
                                                    <select class="form-control" name="status" id="permission" required>
                                                        <option value disabled selected>เลือกเพศ</option>
                                                        <option value="male">ชาย</option>
                                                        <option value="female">หญิง</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="age">อายุ <span style="color: red;">*</span></label>
                                                    <select class="form-control" name="age" id="age" required>
                                                        <option value="" disabled selected>กรุณาเลือกอายุ</option>
                                                        <?php
                                                        for ($i = 1; $i <= 100; $i++) {
                                                            echo "<option value=\"$i\">$i</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 px-1 px-md-5">
                                                <div class="form-group">
                                                    <label for="lastname">นามสกุล <span style="color: red;">*</span></label>
                                                    <input type="text" class="form-control" name="lastname" id="lastname" placeholder="นามสกุล" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="license">License Number</label>
                                                    <input type="text" class="form-control" name="license" id="license" placeholder="License Number">
                                                </div>
                                                <div class="form-group">
                                                    <label for="customFile">รูปโปรไฟล์ </label>
                                                    <div class="custom-file mb-2">
                                                        <input name="image" type="file" class="custom-file-input" id="customFile" accept="image/*">
                                                        <label class="custom-file-label" for="customFile">เลือกรูปภาพ</label>
                                                    </div>
                                                    <p for="" style="font-size: 12px; color: red;" class="mt-2 mb-1">*
                                                        ขนาดไฟล์ภาพไม่เกิน 5 MB</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary btn-block mx-auto w-50" name="submit">บันทึกข้อมูล</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once('../includes/footer.php') ?>
    </div>
    <!-- SCRIPTS -->
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="../../assets/js/adminlte.min.js"></script>
    <script src="https://kit.fontawesome.com/86e67b6ecc.js" crossorigin="anonymous"></script>

    <script>
        const fileInput = document.getElementById('customFile');
        const customFileLabel = $(fileInput).next('.custom-file-label');

        fileInput.addEventListener('change', (event) => {
            const file = event.target.files[0];

            if (!file) {
                resetFileInput();
                return;
            }
            const maxSizeInBytes = 5 * 1024 * 1024; // 5 MB

            if (file.size > maxSizeInBytes) {
                showFileSizeExceedWarning();
                resetFileInput();
                return;
            }

            const fileName = file.name;
            customFileLabel.html(fileName);
        });

        function resetFileInput() {
            fileInput.value = '';
            customFileLabel.html('');
        }

        function showFileSizeExceedWarning() {
            Swal.fire({
                title: "ขนาดไฟล์เกิน",
                text: "ขนาดไฟล์ภาพของคุณเกิน 5 MB กรุณาเลือกใหม่",
                icon: "warning",
            });
        }

        $(function() {
            $('#formData').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: '../../service/pages-twd/create',
                    data: new FormData(this),
                    contentType: false,
                    processData: false
                }).done(function(resp) {
                    Swal.fire({
                        text: 'เพิ่มข้อมูลเรียบร้อย',
                        icon: 'success',
                        confirmButtonText: 'ตกลง',
                        showConfirmButton: false,
                        timer: 1000
                    }).then((result) => {
                        location.assign('./form-create');
                    });
                })
            });
        });
    </script>
</body>

</html>