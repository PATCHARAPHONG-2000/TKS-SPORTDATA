<?php
require_once('../authen.php');

$per = $conn->prepare("SELECT * FROM event");
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
                                        รายชื่อนักกีฬาที่เข้าร่วมอีเว้นท์
                                    </h4>
                                </div>

                                <div class="p-2">
                                    <table id="index-event" class="table table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th class="align-middle">ลำดับ</th>
                                                <th class="align-middle">ชื่อ</th>
                                                <th class="align-middle">นามสกุล</th>
                                                <th class="align-middle">เพศ</th>
                                                <th class="align-middle">ชนิดกีฬา</th>
                                                <th class="align-middle">รุ่นอายุ</th>
                                                <th class="align-middle">รุ่นน้ำหนัก</th>
                                                <th class="align-middle">รูป</th>
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
                                                            <?php echo $person["firstname"]; ?>
                                                        </td>
                                                        <td class="align-middle">
                                                            <?php echo $person["lastname"]; ?>
                                                        </td>
                                                        <td class="align-middle">
                                                            <?php echo $person["gender"]; ?>
                                                        </td>
                                                        <td class="align-middle">
                                                            <?php echo $person["type_name"]; ?>
                                                        </td>
                                                        <td class="align-middle">
                                                            <?php echo isset($person["age_group"]) ? $person["age_group"] : '-'; ?>
                                                        </td>
                                                        <td class="align-middle">
                                                            <?php echo isset($person["weight"]) ? $person["weight"] : '-'; ?>
                                                        </td>
                                                        <td class="align-middle">
                                                            <?php if ($person["image"] && file_exists("../../service/tksuploads/" . $person["image"])) : ?>
                                                                <img src="../../service/tksuploads/<?php echo $person["image"]; ?>" alt="Profile" style="max-width: 50px;">
                                                            <?php else : ?>
                                                                <img src="../../assets/images/avatar.png" alt="Profile" style="max-width: 50px;">
                                                            <?php endif; ?>
                                                        </td>
                                                        <td class="align-middle">
                                                            <a href="info?id=<?php echo $person['id']; ?>" class="btn btn-info">
                                                                <i class="fas fa-search"></i> ดูข้อมูล
                                                            </a>
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
    <script src="../../assets/js/superadmin_twd/event/index.js"></script>
</body>

</html>