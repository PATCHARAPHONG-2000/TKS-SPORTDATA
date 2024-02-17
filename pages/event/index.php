<?php 
    require_once('../authen.php'); 
    $Database = new Database();
    $conn = $Database->connect();

    $per = $conn->prepare("SELECT * FROM event");
    $per->execute();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>จัดการสมาชิก | AppzStory</title>
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
                                    <div>
                                        <a href="form-create.php" class="btn btn-primary mt-3 mr-3">
                                            <i class="fas fa-plus"></i>
                                            เพิ่มนักกีฬา
                                        </a>
                                        <a href="#" class="btn btn-info mt-3 text-white" type="button" id="delete">
                                            <i class="nav-icon fa-solid fa-print"></i>
                                            ลบรายการที่เลือก
                                        </a>
                                    </div>
                                </div>

                                <div class="p-2">
                                    <table id="index-event" class="table table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th class="align-middle">
                                                    <input type="checkbox" id="selectAll" class="align-middle mt-3">
                                                    <label class=" form-check-label "></label>
                                                </th>
                                                <th class="align-middle">ลำดับ</th>
                                                <th class="align-middle">ชื่อ</th>
                                                <th class="align-middle">นามสกุล</th>
                                                <th class="align-middle">เพศ</th>
                                                <th class="align-middle">อายุ</th>
                                                <th class="align-middle">คลาส</th>
                                                <th class="align-middle">รุ่นน้ำหนัก</th>
                                                <th class="align-middle">รูป</th>
                                                <th class="align-middle">จัดการ</th>
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
                                                    <?php echo $person["class"]; ?>
                                                </td>
                                                <td class="align-middle">
                                                    <?php echo $person["weigth"]; ?>
                                                </td>
                                                <td class="align-middle">
                                                    <img src="../../service/tksuploads/<?php echo $person["image"]; ?>"
                                                        alt="Profile" style="max-width: 50px;">
                                                </td>
                                                <td class="align-middle">
                                                    <button type="button" class="btn btn-danger delete-btn"
                                                        data-id="<?php echo $person["id"]; ?>">
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
                                <!-- <div class="card-body">
                                    <table id="logs" class="table table-hover" width="100%">
                                    </table>
                                </div> -->
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
    <script src="../../assets/js/event.js"></script>

</body>

</html>