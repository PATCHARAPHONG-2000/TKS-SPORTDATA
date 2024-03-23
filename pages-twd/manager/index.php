<?php
require_once('../authen.php');

$per = $conn->prepare("SELECT * FROM player");
$per->execute();

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
                                    <table id="sportsperson" class="table table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th class="align-middle">ลำดับ</th>
                                                <th class="align-middle">ชื่อ</th>
                                                <th class="align-middle">นามสกุล</th>
                                                <th class="align-middle">เพศ</th>
                                                <th class="align-middle">อายุ</th>
                                                <th class="align-middle">รูป</th>
                                                <th class="align-middle">จัดการ</th>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $counter = 1;
                                            if ($per->rowCount() > 0) {
                                                while ($person = $per->fetch(PDO::FETCH_ASSOC)) {
                                                    if ($person["team"] === $role) {
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
                                                                <a href="form-edit?id=<?php echo $person['id']; ?>" class="btn btn-warning">
                                                                    <i class="fas fa-search"></i> แก้ไข
                                                                </a>
                                                                <button onclick="deletePerson(<?php echo $person['id']; ?>)" class="btn btn-danger ">
                                                                    <i class="far fa-trash-alt"></i> ลบ
                                                                </button>
                                                            </td>
                                                        </tr>
                                                <?php
                                                        $counter++;
                                                    } // ปิดเงื่อนไข if
                                                } // ปิดลูป while
                                            } else {
                                                ?>
                                                <tr>
                                                    <td colspan="7">ยังไม่มีรายชื่อ</td>
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
    <script src="../../assets/js/pages_twd/manager/index.js"></script>

</body>

</html>