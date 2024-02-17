<?php

require_once('../authen.php');
$Database = new Database();
$conn = $Database->connect();

$per = $conn->prepare("SELECT * FROM player");
$per->execute();

$even = $conn->prepare("SELECT * FROM create_event");
$even->execute();

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
    <title>
        <?php echo isset($_SESSION['id_city']['province']) ? $_SESSION['id_city']['province'] : ''; ?> | TKS SPORULATE
    </title>
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

    <style>
    .card-header {
        display: flex;
        flex-direction: column;
    }

    .form-group {
        display: flex;
        margin-top: 1rem;
        /* ปรับขนาดของช่องว่างตรงนี้ตามต้องการ */
    }

    .id_save {
        margin-top: auto;
        /* ย้ายปุ่มไปอยู่ด้านล่าง */
    }
    </style>
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
                                <div class="card-header border-0 pt-4" style="float: left;">
                                    <h4>
                                        <i class="fa-solid fa-id-card-clip mr-2"></i>
                                        เพิ่มนักกีฬา
                                    </h4>
                                    <div class="mt-3 text-white">
                                        <div class="form-group">
                                            <div class="mr-3">
                                                <label for="clas">คลาส</label>
                                                <select class="form-control" name="clas" id="clas" required>
                                                    <option value="" disabled selected>กรุณาเลือกคลาส</option>
                                                    <?php
                                                        $class = $conn->prepare("SELECT DISTINCT class FROM create_event WHERE class IS NOT NULL");
                                                        $class->execute();

                                                        while ($row = $class->fetch(PDO::FETCH_ASSOC)) {
                                                            echo "<option value='{$row['class']}'>{$row['class']}</option>";
                                                        }
                                                        ?>
                                                </select>
                                            </div>
                                            <div class="mr-3">
                                                <label for="weigth">คลาส</label>
                                                <select class="form-control" name="weigth" id="weigth" required>
                                                    <option value="" disabled selected>กรุณาเลือกรุ่นน้ำหนัก</option>
                                                    <?php
                                                        $weigth = $conn->prepare("SELECT DISTINCT weigth FROM create_event WHERE weigth IS NOT NULL");
                                                        $weigth->execute();

                                                        while ($row = $weigth->fetch(PDO::FETCH_ASSOC)) {
                                                            echo "<option value='{$row['weigth']}'>{$row['weigth']}</option>";
                                                        }
                                                        ?>
                                                </select>
                                            </div>
                                            <div class="id_save">
                                                <a href="#" class="ml-3 btn btn-info mt-4 text-white" type="button"
                                                    id="save">
                                                    <i class="nav-icon fa-solid fa-print"></i>
                                                    บันทึก
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-2">
                                    <table id="form-create-event" class="table table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th class="align-middle">
                                                    <input type="checkbox" id="select_all" class="align-middle mt-3">
                                                    <label class=" form-check-label "></label>
                                                </th>
                                                <th class="align-middle">ลำดับ</th>
                                                <th class="align-middle">ชื่อ</th>
                                                <th class="align-middle">นามสกุล</th>
                                                <th class="align-middle">เพศ</th>
                                                <th class="align-middle">อายุ</th>
                                                <th class="align-middle">รูป</th>
                                                <th class="align-middle">สถานะ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $counter = 1;
                                            if ($per->rowCount() > 0) {
                                                while ($person = $per->fetch(PDO::FETCH_ASSOC)) { ?>
                                            <tr id="<?php echo $person["id"]; ?>">
                                                <td class="align-middle"><input type="checkbox" class="checkbox"
                                                        name="idc[]" value="<?php echo $person["id"]; ?>"></td>
                                                <td class="align-middle">
                                                    <?php echo $counter; ?>
                                                </td>
                                                <td class="align-middle">
                                                    <?php echo $person["firstname"]; ?>
                                                </td>
                                                <td class="align-middle">
                                                    <?php echo $person["lastname"]; ?>
                                                </td>
                                                <td class="align-middle">
                                                    <?php echo $person["status"]; ?>
                                                </td>
                                                <td class="align-middle">
                                                    <?php echo $person["age"]; ?>
                                                </td>
                                                <td class="align-middle">
                                                    <img src="../../service/tksuploads/<?php echo $person["image"]; ?>"
                                                        alt="Profile" style="max-width: 50px;">
                                                </td>
                                                <td class="align-middle">
                                                    <div class="Active"
                                                        style="background-color: <?php echo $person["IsActive"] ? 'green' : 'red'; ?>; width: 7rem; height: 2rem; display: flex; justify-content: center; align-items: center; border-radius: 20px; font-size: 18px; ">
                                                        <?php echo $person["IsActive"] ? 'สมัครแล้ว' : 'ยังไม่สมัคร'; ?>
                                                    </div>
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
    <script src="../../assets/js/event.js"></script>

    <!-- datatables -->
    <script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

</body>

</html>