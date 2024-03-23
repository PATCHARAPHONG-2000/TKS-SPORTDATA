<?php

require_once('../authen.php');
$Database = new Database();
$conn = $Database->connect();

$per = $conn->prepare("SELECT * FROM personnel");
$per->execute();

if (isset($_SESSION['id_city'])) {
    $id_province = $_SESSION['id_city']['province'];
} else {
    $id_province = 'default_status';
}

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
                                <div class="card-header border-0 pt-4" style="float: left;">
                                    <h4>
                                        <i class="fa-solid fa-id-card-clip mr-2"></i>
                                        สร้าง AD Card
                                    </h4>
                                    <a href="#" class="btn btn-info mt-3 text-white" type="button" id="print-selected" target="_blank">
                                        <i class="nav-icon fa-solid fa-print"></i>
                                        Print All
                                    </a>
                                </div>
                                <div class="p-2">
                                    <table id="employeeTable" class="table table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th class="align-middle">
                                                    <input type="checkbox" id="select_all" class="align-middle mt-3">
                                                    <label class=" form-check-label "></label>
                                                </th>
                                                <th class="align-middle">ลำดับ</th>
                                                <th class="align-middle">จังหวัด</th>
                                                <th class="align-middle">ชื่อ</th>
                                                <th class="align-middle">นามสกุล</th>
                                                <th class="align-middle">ตำแหน่ง</th>
                                                <th class="align-middle">รูป</th>
                                                <th class="align-middle">พิมพ์</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $counter = 1;
                                            if ($per->rowCount() > 0) {
                                                while ($person = $per->fetch(PDO::FETCH_ASSOC)) { ?>
                                                    <tr id="<?php echo $person["id"]; ?>">
                                                        <td class="align-middle"><input type="checkbox" class="checkbox" name="idc[]" value="<?php echo $person["id"]; ?>"></td>
                                                        <td class="align-middle">
                                                            <?php echo $counter; ?>
                                                        </td>
                                                        <td class="align-middle">
                                                            <?php echo $person["province"]; ?>
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
                                                            <img src="../../service/uploads/<?php echo $person["image"]; ?>" alt="Profile" style="max-width: 50px;">
                                                        </td>
                                                        <td class="align-middle">
                                                            <a href="adcard.php?id=<?php echo $person["id"]; ?>" target="_blank" class="btn btn-warning text-white"> Print </a>
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
    <!-- datatables -->
    <script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="../../assets/js/superadmin-ad/adcard/sector.js"></script>

</body>

</html>