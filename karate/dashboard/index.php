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

usort($data, function ($a, $b) {
    return $b['finalsum'] - $a['finalsum'];
});

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
                                <div class="container-fuild row">
                                    <div class="container col-md-5 form mb-5">
                                        <h2 class="mt-3 text-center">กรอกคะแนน</h2>
                                        <form class="p-2" id="formData" enctype="multipart/form-data">
                                            <div class="mb-2">
                                                <label for="name" style="font-size: 15px">ชื่อ-นามสกุล<span
                                                        style="color: red;">*</span></label>
                                                <input type="text" class="form-control" style="height: 2rem;"
                                                    name="name" id="name" placeholder="ชื่อ" required
                                                    autocomplete="name">
                                            </div>
                                            <?php for ($i = 1; $i <= 7; $i++) { ?>
                                            <div class="">
                                                <label for="number<?php echo $i; ?>" style="font-size: 10px"
                                                    class="form-label">JUDGE
                                                    <?php echo $i; ?>:
                                                </label>
                                                <input type="number" class="form-control" style="height: 2rem;"
                                                    id="number<?php echo $i; ?>" tabindex="<?php echo $i; ?>"
                                                    step="0.01" min="0" max="10" required
                                                    onkeydown="moveToNextInput(event, '<?php echo ($i === 7) ? 'number7' : 'number' . ($i + 1); ?>')"
                                                    autocomplete="off">
                                            </div>
                                            <?php } ?>
                                            <button type="button" class="btn btn-primary mt-3"
                                                onclick="checkAndSum()">SUM</button>
                                            <button type="button" class="btn btn-secondary ml-2 mt-3"
                                                onclick="clearTableData()">Clear</button>
                                        </form>
                                    </div>
                                    <div class="container col-md-5">
                                        <h2 class=" text-center mt-3 mb-4">ตารางคะแนน</h2>
                                        <table id="employeeTable" class="table table table-striped table-hover mt-5">
                                            <thead>
                                                <tr>
                                                    <th class="align-middle">ลำดับ</th>
                                                    <th class="align-middle">ชื่อ</th>
                                                    <th class="align-middle">คะแนน</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $counter = 1;
                                                foreach ($data as $score) {

                                                ?>
                                                <tr id="<?php echo $score["id"]; ?>">
                                                    <td class="align-middle">
                                                        <?php echo $counter; ?>
                                                    </td>
                                                    <td class="align-middle">
                                                        <?php echo $score["Name"]; ?>
                                                    </td>
                                                    <td class="align-middle">
                                                        <?php echo $score["finalsum"]; ?>
                                                    </td>
                                                </tr>
                                                <?php
                                                    $counter++;
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                        <div class="mt-5">
                                            <a href="excel" target="_blank" class="btn btn-primary">โหลดตารางคะแนน</a>
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
    <script src="../../assets/js/karate.js"></script>

</body>

</html>