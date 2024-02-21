<?php
    require_once('../authen.php');

    $Database = new Database();
    $conn = $Database->connect();

    $per = $conn->prepare("SELECT * FROM player ORDER BY RAND()");
    $per->execute();
    
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>หน้าหลัก | TKS SOFTVISION</title>
    <link rel="shortcut icon" type="image/x-icon" href="../../assets/images/favicon.ico">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Kanit">
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <link rel="stylesheet" href="../../assets/css/adminlte.min.css">
    <link rel="stylesheet" href="../../assets/css/style.css">
    <!-- Datatables -->
    <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

    <style>
    .List::-webkit-scrollbar {
        width: 0;
    }

    .List_name {
        width: auto;
        height: 35px;
        background-color: white;
        border-radius: 20px;
    }

    .first {
        margin-right: 10px;
        width: 100px;
        /* ล็อคความกว้างของช่อง firstname และ lastname */
        overflow: hidden;
        text-overflow: ellipsis;
        /* แสดงข้อความเดียวกันถ้าเกินความยาว */
        white-space: nowrap;
        /* ไม่ขึ้นบรรทัดใหม่ */
    }

    .last {
        margin-right: 40px;
        width: 100px;
        /* ล็อคความกว้างของช่อง firstname และ lastname */
        overflow: hidden;
        text-overflow: ellipsis;
        /* แสดงข้อความเดียวกันถ้าเกินความยาว */
        white-space: nowrap;
        /* ไม่ขึ้นบรรทัดใหม่ */
    }

    .team {
        margin-right: 10px;
        width: 100px;
        /* ล็อคความกว้างของช่อง firstname และ lastname */
        overflow: hidden;
        text-overflow: ellipsis;
        /* แสดงข้อความเดียวกันถ้าเกินความยาว */
        white-space: nowrap;
        /* ไม่ขึ้นบรรทัดใหม่ */
    }

    .image {
        max-width: auto;
        max-height: 30px;
        border-radius: 50%;
        margin-top: 2.5px;
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
                        <div class="col-lg-12">
                            <div class="card shadow">
                                <div class="card-body">
                                    <div class="card  p-3" style="width:500px; height:700px;">
                                        <div class="card-header border-0 ">
                                            <h4>
                                                <i class="fa-solid fa-person"></i>
                                                รายชื่อนักกีฬา
                                            </h4>
                                        </div>
                                        <div class="List p-2" style="overflow-y: auto;">
                                            <?php
                                                $counter = 1;
                                                if ($per->rowCount() > 0) {
                                                    while ($person = $per->fetch(PDO::FETCH_ASSOC)) {
                                            ?>
                                            <div class="List_name shadow mb-4">
                                                <div class="row">
                                                    <div style="display: flex; align-items: center;">
                                                        <h5 style="margin-left: 20px; margin-right: 30px;">
                                                            <?php echo $counter; ?></h5>
                                                        <p class="mt-2 first"><?php echo $person["firstname"]; ?></p>
                                                        <p class="mt-2 last"><?php echo $person["lastname"]; ?></p>
                                                        <p class="mt-2 team"><?php echo $person["team"]; ?></p>
                                                    </div>
                                                    <div>
                                                        <img src="../../service/tksuploads/<?php echo $person["image"]; ?>"
                                                            alt="" class="image">
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                                    $counter++;
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>

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

</body>

</html>