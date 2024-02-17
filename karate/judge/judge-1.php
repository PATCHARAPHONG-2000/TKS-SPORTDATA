<?php
require_once('../authen.php');

$Database = new Database();
$conn = $Database->connect();

if (isset($_SESSION['karate']['role'])) {
    $id_Role = $_SESSION['karate']['role'];
} else {
    $id_Role = 'default_status';
}

$sql = $conn->prepare("SELECT * FROM data_score WHERE Role = :role");
$sql->bindParam(':role', $id_Role, PDO::PARAM_STR);
$sql->execute();
$data = $sql->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> TKS SPORTDATA | KARATE</title>
    <link rel="shortcut icon" type="image/x-icon" href="../../assets/images/favicon.ico">
    <!-- stylesheet -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Kanit">
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <link rel="stylesheet" href="../../assets/css/adminlte.min.css">

    <style>
        body {
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            background-color: aqua;
        }
    </style>

</head>

<body class="hold-transition sidebar-mini">

    <div class="content">
        <div class="container-fluid">
            <div class="container-fluid mb-5 mt-3">
                <div class="h1 text-center mb-4">กรรมการ 1</div>
                <div class="h1 text-center mb-4"><?php ?></div>
                <form class="p-2 mb-5" id="formData">
                    <div class="form-group text-center">
                        <input type="number" class="form-control mx-auto" style="height: 2rem; width: 10rem" id="number" tabindex="" step="0.01" min="0" max="10" required autocomplete="off">
                    </div>
                    <div class="form-group text-center">
                        <button type="button" class="btn btn-primary mt-3">ส่งคะแนน</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- scripts -->
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="../../assets/js/adminlte.min.js"></script>

    <script>
        $(function() {
            $("#formData").submit(function(e) {
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: '../service/create.php',
                    data: $(this).serialize(),
                    dataType: "json",
                    success: function(resp) {
                        if (resp.status) {
                            Swal.fire({
                                text: resp.message,
                                icon: 'success',
                                confirmButtonText: 'ตกลง',
                                showConfirmButton: false,
                                timer: 500
                            }).then((result) => {
                                location.assign('./judge-1');
                            });
                        } else {
                            Swal.fire({
                                text: resp.error,
                                icon: 'error',
                                confirmButtonText: 'ตกลง'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr, status, error);
                        Swal.fire({
                            text: 'เกิดข้อผิดพลาดในการส่งข้อมูล',
                            icon: 'error',
                            confirmButtonText: 'ตกลง'
                        });
                    }
                });
            });
        });
    </script>
</body>

</html>