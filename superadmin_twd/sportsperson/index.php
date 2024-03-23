<?php
require_once('../authen.php');

$per = $conn->prepare("SELECT * FROM player");
$per->execute();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TKS SOFTVISION</title>
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
            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card shadow">
                                <div class="card-header border-0 pt-4">
                                    <h4>
                                        <i class="fas fa-users"></i>
                                        รายชื่อนักกีฬาทั้งหมด
                                    </h4>
                                </div>

                                <div class="p-2">
                                    <table id="sportsperson" class="table table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th class="align-middle">ลำดับ</th>
                                                <th class="align-middle">ชื่อ</th>
                                                <th class="align-middle">นามสกุล</th>
                                                <th class="align-middle">เพศ</th>
                                                <th class="align-middle">อายุ</th>
                                                <th class="align-middle">ทีม</th>
                                                <th class="align-middle">license</th>
                                                <th class="align-middle">รูป</th>
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
                                                            <?php echo $person["firstname"] ?>
                                                        </td>
                                                        <td class="align-middle">
                                                            <?php echo $person["lastname"] ?>
                                                        </td>
                                                        <td class="align-middle">
                                                            <?php echo $person["status"] ?>
                                                        </td>
                                                        <td class="align-middle">
                                                            <?php echo $person["age"] ?>
                                                        </td>
                                                        <td class="align-middle">
                                                            <?php echo $person["team"] ?>
                                                        </td>
                                                        <td class="align-middle">
                                                            <?php echo isset($person["license"]) ? $person["license"] : '-'; ?>
                                                        </td>
                                                        <td class="align-middle">
                                                            <?php if ($person["image"] && file_exists("../../service/tksuploads/" . $person["image"])) : ?>
                                                                <img src="../../service/tksuploads/<?php echo $person["image"]; ?>" alt="Profile" style="max-width: 50px;">
                                                            <?php else : ?>
                                                                <img src="../../assets/images/avatar.png" alt="Profile" style="max-width: 50px;">
                                                            <?php endif; ?>
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
    <script src="../../assets/js/superadmin_twd/sportsperson/index.js"></script>
</body>

</html>