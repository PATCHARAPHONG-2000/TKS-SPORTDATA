<?php
require_once('../authen.php');
$Database = new Database();
$conn = $Database->connect();

$per = $conn->prepare("SELECT * FROM player");
$per->execute();

$id = $_GET['image_id'];
$params = array(':id' => $id);
$selectbyidUser = $conn->prepare("SELECT * FROM data_all WHERE id = :id");
$selectbyidUser->execute($params);
$image = $selectbyidUser->fetch(PDO::FETCH_ASSOC);

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

    <style>
        .card-header {
            display: flex;
            flex-direction: column;
        }

        .form-group {
            display: flex;
        }

        .id_save {
            margin-top: auto;
        }

        /* style="display:none;" */
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
                                    <div class="row">
                                        <h4>
                                            <i class="fa-solid fa-id-card-clip mr-2"></i>
                                            <?php echo $image["name"] ?>
                                        </h4>
                                    </div>
                                    <a href="./" class="btn btn-info my-3 mr-auto">
                                        <i class="fas fa-list"></i>
                                        กลับหน้าหลัก
                                    </a>
                                    <div class="text-white mt-3">
                                        <div class="form-group mb-5">
                                            <div class="mr-3">
                                                <label for="List_event" style="color: black; font-size: 1.0rem;">ประเภทกีฬา</label>
                                                <select class="form-control" name="List_event" id="List_event" required onchange="List_event(), fetcstatus_Poomse_doubles()">
                                                    <option value="" disabled selected>กรุณาประเภทกีฬา</option>
                                                    <?php
                                                    $List_event = $conn->prepare("SELECT DISTINCT List_event FROM create_event WHERE List_event IS NOT NULL");
                                                    $List_event->execute();

                                                    while ($row = $List_event->fetch(PDO::FETCH_ASSOC)) {
                                                        echo "<option value='{$row['List_event']}'>{$row['List_event']}</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group" id="fight" style="display:none;">
                                            <div class="mr-3">
                                                <label for="gender" style="color: black; font-size: 1.0rem;">เพศ</label>
                                                <select class="form-control" name="gender" id="gender" required onchange="fetcstatus(), selectgender()">
                                                    <option value="" disabled selected>กรุณาเลือกเพศ</option>
                                                    <option value="ชาย">ชาย</option>
                                                    <option value="หญิง">หญิง</option>
                                                </select>
                                            </div>
                                            <div class="mr-3">
                                                <label for="age" style="color: black; font-size: 1.0rem;">รุ่นอายุ</label>
                                                <select class="form-control" name="age" id="age" required onchange="fetchWeight()">
                                                    <option value="" disabled selected>กรุณาเลือกอายุ</option>
                                                </select>
                                            </div>
                                            <div class="mr-3">
                                                <label for="weight" style="color: black; font-size: 1.0rem;">รุ่นน้ำหนัก</label>
                                                <select class="form-control" name="weight" id="weight" required onchange="fetchClass()">
                                                    <option value="" disabled selected>กรุณาเลือกรุ่นน้ำหนัก</option>
                                                </select>
                                            </div>
                                            <div class="mr-3">
                                                <label for="sp_class" style="color: black; font-size: 1.0rem;">คลาส</label>
                                                <select class="form-control" name="sp_class" id="sp_class" required>
                                                    <option value="" disabled selected>กรุณาเลือกคลาส</option>
                                                </select>
                                            </div>
                                            <div class="id_save">
                                                <a href="#" class="ml-3 btn btn-info mt-4 text-white" type="button" id="save">
                                                    <i class="nav-icon fa-solid fa-print"></i>
                                                    บันทึก
                                                </a>
                                            </div>
                                        </div>
                                        <div class="form-group" id="fight-team" style="display:none;">
                                            <div class="mr-3">
                                                <label for="team_gender" style="color: black; font-size: 1.0rem;">เพศ</label>
                                                <select class="form-control" name="team_gender" id="team_gender" required onchange="fetcstatus_team(), selectgender()">
                                                    <option value="" disabled selected>กรุณาเลือกเพศ</option>
                                                    <option value="ชาย">ชาย</option>
                                                    <option value="หญิง">หญิง</option>
                                                </select>
                                            </div>
                                            <div class="mr-3">
                                                <label for="team_age" style="color: black; font-size: 1.0rem;">รุ่นอายุ</label>
                                                <select class="form-control" name="team_age" id="team_age" required onchange="fetchWeight_team()">
                                                    <option value="" disabled selected>กรุณาเลือกอายุ</option>
                                                </select>
                                            </div>
                                            <div class="mr-3">
                                                <label for="team_weight" style="color: black; font-size: 1.0rem;">น้ำหนักรวม</label>
                                                <select class="form-control" name="team_weight" id="team_weight" required>
                                                    <option value="" disabled selected>กรุณาเลือกน้ำหนักรวม</option>
                                                </select>
                                            </div>
                                            <div class="id_save">
                                                <a href="#" class="ml-3 btn btn-info mt-4 text-white" type="button" id="team_save">
                                                    <i class="nav-icon fa-solid fa-print"></i>
                                                    บันทึก
                                                </a>
                                            </div>
                                        </div>
                                        <div class="form-group" id="Poomse-Solo" style="display:none;">
                                            <div class="mr-3">
                                                <label for="Poomse_gender" style="color: black; font-size: 1.0rem;">เพศ</label>
                                                <select class="form-control" name="Poomse_gender" id="Poomse_gender" required onchange="fetcstatus_Poomse(), selectgender()">
                                                    <option value="" disabled selected>กรุณาเลือกเพศ</option>
                                                    <option value="ชาย">ชาย</option>
                                                    <option value="หญิง">หญิง</option>
                                                </select>
                                            </div>
                                            <div class="mr-3">
                                                <label for="Poomse_age" style="color: black; font-size: 1.0rem;">รุ่นอายุ</label>
                                                <select class="form-control" name="Poomse_age" id="Poomse_age" required onchange="fetchWeight_Poomse()">
                                                    <option value="" disabled selected>กรุณาเลือกอายุ</option>
                                                </select>
                                            </div>
                                            <div class="mr-3">
                                                <label for="Poomse_colorse" style="color: black; font-size: 1.0rem;">สายสี</label>
                                                <select class="form-control" name="Poomse_colorse" id="Poomse_colorse" required onchange="fetchcolorse_Poomse()">
                                                    <option value="" disabled selected>กรุณาเลือกสายสี</option>
                                                </select>
                                            </div>
                                            <div class="mr-3">
                                                <label for="Poomse_pattern" style="color: black; font-size: 1.0rem;">Pattern</label>
                                                <select class="form-control" name="Poomse_pattern" id="Poomse_pattern" required>
                                                    <option value="" disabled selected>กรุณาเลือก Pattern</option>
                                                </select>
                                            </div>
                                            <div class="id_save">
                                                <a href="#" class="ml-3 btn btn-info mt-4 text-white" type="button" id="Poomse_save">
                                                    <i class="nav-icon fa-solid fa-print"></i>
                                                    บันทึก
                                                </a>
                                            </div>
                                        </div>
                                        <div class="form-group" id="Poomse-doubles" style="display:none;">
                                            <div class="mr-3">
                                                <label for="Poomse_age_doubles" style="color: black; font-size: 1.0rem;">รุ่นอายุ</label>
                                                <select class="form-control" name="Poomse_age_doubles" id="Poomse_age_doubles" required>
                                                    <option value="" disabled selected>กรุณาเลือกอายุ</option>
                                                </select>
                                            </div>
                                            <div class="id_save">
                                                <a href="#" class="ml-3 btn btn-info mt-4 text-white" type="button" id="Poomse_save_doubles">
                                                    <i class="nav-icon fa-solid fa-print"></i>
                                                    บันทึก
                                                </a>
                                            </div>
                                        </div>
                                        <div class="form-group" id="Poomse-team" style="display:none;">
                                            <div class="mr-3">
                                                <label for="Poomse_gender_team" style="color: black; font-size: 1.0rem;">เพศ</label>
                                                <select class="form-control" name="Poomse_gender_team" id="Poomse_gender_team" required onchange="fetcstatus_Poomse_team(), selectgender()">
                                                    <option value="" disabled selected>กรุณาเลือกเพศ</option>
                                                    <option value="ชาย">ชาย</option>
                                                    <option value="หญิง">หญิง</option>
                                                </select>
                                            </div>
                                            <div class="mr-3">
                                                <label for="Poomse_age_team" style="color: black; font-size: 1.0rem;">รุ่นอายุ</label>
                                                <select class="form-control" name="Poomse_age_team" id="Poomse_age_team" required onchange="fetchWeight_Poomse_team()">
                                                    <option value="" disabled selected>กรุณาเลือกอายุ</option>
                                                </select>
                                            </div>
                                            <div class="mr-3">
                                                <label for="Poomse_colorse_team" style="color: black; font-size: 1.0rem;">สายสี</label>
                                                <select class="form-control" name="Poomse_colorse_team" id="Poomse_colorse_team" required>
                                                    <option value="" disabled selected>กรุณาเลือกสายสี</option>
                                                </select>
                                            </div>
                                            <div class="id_save">
                                                <a href="#" class="ml-3 btn btn-info mt-4 text-white" type="button" id="Poomse_save_team">
                                                    <i class="nav-icon fa-solid fa-print"></i>
                                                    บันทึก
                                                </a>
                                            </div>
                                        </div>
                                        <div class="form-group" id="Kiakpa" style="display:none;">
                                            <div class="mr-3">
                                                <label for="Kiakpa_gender" style="color: black; font-size: 1.0rem;">เพศ</label>
                                                <select class="form-control" name="Kiakpa_gender" id="Kiakpa_gender" required onchange="fetcstatus_Kiakpa(), selectgender()">
                                                    <option value="" disabled selected>กรุณาเลือกเพศ</option>
                                                    <option value="ชาย">ชาย</option>
                                                    <option value="หญิง">หญิง</option>
                                                </select>
                                            </div>
                                            <div class="mr-3">
                                                <label for="Kiakpa_type" style="color: black; font-size: 1.0rem;">ชนิดกีฬา</label>
                                                <select class="form-control" name="Kiakpa_type" id="Kiakpa_type" required onchange="fetcstatus_Kiakpa_type()">
                                                    <option value="" disabled selected>กรุณาเลือกชนิดกีฬา</option>
                                                </select>
                                            </div>
                                            <div class="mr-3">
                                                <label for="Kiakpa_age" style="color: black; font-size: 1.0rem;">รุ่นอายุ</label>
                                                <select class="form-control" name="Kiakpa_age" id="Kiakpa_age" required">
                                                    <option value="" disabled selected>กรุณาเลือกอายุ</option>
                                                </select>
                                            </div>
                                            <div class="id_save">
                                                <a href="#" class="ml-3 btn btn-info mt-4 text-white" type="button" id="Kiakpa_save">
                                                    <i class="nav-icon fa-solid fa-print"></i>
                                                    บันทึก
                                                </a>
                                            </div>
                                        </div>
                                        <div class="form-group" id="Dance_battle" style="display:none;">
                                            <div class="mr-3">
                                                <label for="Dance_battle_gender" style="color: black; font-size: 1.0rem;">เพศ</label>
                                                <select class="form-control" name="Dance_battle_gender" id="Dance_battle_gender" required onchange="fetc_Dance_battle_age(), selectgender()">
                                                    <option value="" disabled selected>กรุณาเลือกเพศ</option>
                                                    <option value="ชาย">ชาย</option>
                                                    <option value="หญิง">หญิง</option>
                                                </select>
                                            </div>
                                            <div class="mr-3">
                                                <label for="Dancebattleage" style="color: black; font-size: 1.0rem;">รุ่นอายุ</label>
                                                <select class="form-control" name="Dancebattleage" id="Dancebattleage" required>
                                                    <option value="" disabled selected>กรุณาเลือกอายุ</option>
                                                </select>
                                            </div>
                                            <div class="id_save">
                                                <a href="#" class="ml-3 btn btn-info mt-4 text-white" type="button" id="Dance_battle_save">
                                                    <i class="nav-icon fa-solid fa-print"></i>
                                                    บันทึก
                                                </a>
                                            </div>
                                        </div>
                                        <div class="form-group" id="Dance_battle_team" style="display:none;">
                                            <div class="mr-3">
                                                <label for="DanceBattle_gender_team" style="color: black; font-size: 1.0rem;">เพศ</label>
                                                <select class="form-control" name="DanceBattle_gender_team" id="DanceBattle_gender_team" required onchange="selectgender()">
                                                    <option value="" disabled selected>กรุณาเลือกเพศ</option>
                                                    <option value="ชาย">ชาย</option>
                                                    <option value="หญิง">หญิง</option>
                                                </select>
                                            </div>
                                            <div class="id_save">
                                                <a href="#" class="ml-3 btn btn-info mt-4 text-white" type="button" id="DanceBattle_save_team">
                                                    <i class="nav-icon fa-solid fa-print"></i>
                                                    บันทึก
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="p-2">
                                    <table id="form-create-event" class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th class="align-middle">
                                                    <!-- <input type="checkbox" id="select_all" class="align-middle mt-3">
                                                    <label class="form-check-label"></label> -->
                                                </th>
                                                <th class="align-middle">ลำดับ</th>
                                                <th class="align-middle">ชื่อ</th>
                                                <th class="align-middle">นามสกุล</th>
                                                <th class="align-middle">เพศ</th>
                                                <th class="align-middle">อายุ</th>
                                                <th class="align-middle">รูป</th>
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
                                                            <td class="align-middle"><input type="checkbox" class="checkbox" name="idc[]" value="<?php echo $person["id"]; ?>"></td>
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
                                                }
                                            } else {
                                                ?>
                                                <tr>
                                                    <td colspan="6">ยังไม่รายชื่อ</td>
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
    <script src="../../assets/js/pages_twd/event/create.js"></script>

    <script>
        function getImageName() {
            return "<?php echo $image['name']; ?>";
        }
    </script>

</body>

</html>