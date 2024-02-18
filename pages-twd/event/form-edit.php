<?php
require_once('../authen.php');

$Database = new Database();
$conn = $Database->connect();

$id = $_GET['id'];
$params = array('id' => $id);
$selectbyidUser = $conn->prepare("SELECT * FROM event WHERE id = :id");
$selectbyidUser->execute($params);
$e_event = $selectbyidUser->fetch(PDO::FETCH_ASSOC);

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
                                        <i class="fas fa-user-cog"></i>
                                        แก้ไข || คลาส : รุ่นน้ำหนัก
                                    </h4>
                                    <a href="./" class="btn btn-info my-3 ">
                                        <i class="fas fa-list"></i>
                                        กลับหน้าหลัก
                                    </a>
                                </div>
                                <form id="formData">
                                    <input type="hidden" name="id" value="<?php echo ($_GET['id']); ?>">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mr-3">
                                                    <label for="class">คลาส</label>
                                                    <select class="form-control" name="class" id="class" required>
                                                        <?php
                                                            $query_class = $conn->prepare("SELECT DISTINCT class FROM create_event WHERE class IS NOT NULL");
                                                            $query_class->execute();
                                                            while ($row = $query_class->fetch(PDO::FETCH_ASSOC)) {
                                                                $selected = ($row['class'] == $e_event['class']) ? 'selected' : '';
                                                                echo "<option value='{$row['class']}' $selected>{$row['class']}</option>";
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mr-3">
                                                    <label for="weigth">รุ่นน้ำหนัก</label>
                                                    <select class="form-control" name="weigth" id="weigth" required>
                                                        <?php
                                                            $query_weigth = $conn->prepare("SELECT DISTINCT weigth FROM create_event WHERE weigth IS NOT NULL");
                                                            $query_weigth->execute();
                                                            while ($row = $query_weigth->fetch(PDO::FETCH_ASSOC)) {
                                                                $selected = ($row['weigth'] == $e_event['weigth']) ? 'selected' : '';
                                                                echo "<option value='{$row['weigth']}' $selected>{$row['weigth']}</option>";
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
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
        <?php include_once('../includes/footer.php') ?>
    </div>
    <!-- SCRIPTS -->
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
                url: '../../service/manager/update-event.php',
                data: new FormData($('#formData')[0]),
                processData: false,
                contentType: false,
                success: function(resp) {
                    Swal.fire({
                        icon: 'success',
                        title: 'อัพเดทข้อมูลเรียบร้อยแล้ว',
                        showConfirmButton: false,
                        timer: 1000
                    }).then((result) => {
                        location.assign('./index');
                    });
                },
                error: function(xhr, status, error) {
                    // Handle AJAX request errors
                    console.log('XHR:', xhr);
                    console.log('Status:', status);
                    console.log('Error:', error);

                    Swal.fire({
                        icon: 'error',
                        title: 'Update failed. Please try again.',
                        showConfirmButton: false,
                        timer: 1000
                    }).then((result) => {
                        location.assign('./index');
                    });
                }
            });

        });
    });
    </script>

</body>

</html>