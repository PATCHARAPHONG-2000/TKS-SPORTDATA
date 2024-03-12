<?php

require_once('../authen.php');
$Database = new Database();
$conn = $Database->connect();

$per = $conn->prepare("SELECT * FROM player");
$per->execute();

$even = $conn->prepare("SELECT * FROM create_event");
$even->execute();

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
        /* ย้ายปุ่มไปอยู่ด้านล่าง */
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
                                        <!-- <div class="form-group mb-5">
                                            <div class="mr-3">
                                                <label for="Sports_type"
                                                    style="color: black; font-size: 1.0rem;">ประเภทกีฬา</label>
                                                <select class="form-control" name="Sports_type" id="Sports_type"
                                                    required onchange="Sports_type()">
                                                    <option value="" disabled selected>กรุณาประเภทกีฬา</option>
                                                    
                                                        $List_event = $conn->prepare("SELECT DISTINCT List_event FROM create_event WHERE List_event IS NOT NULL");
                                                        $List_event->execute();

                                                        while ($row = $List_event->fetch(PDO::FETCH_ASSOC)) {
                                                            echo "<option value='{$row['List_event']}'>{$row['List_event']}</option>";
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div> -->
                                        <div class="form-group" id="fight">
                                            <div class="mr-3">
                                                <label for="age"
                                                    style="color: black; font-size: 1.0rem;">รุ่นอายุ</label>
                                                <select class="form-control" name="age" id="age" required
                                                    onchange="fetchWeight()">
                                                    <option value="" disabled selected>กรุณาเลือกอายุ</option>
                                                    <?php
                                                        $age_group = $conn->prepare("SELECT DISTINCT age_group FROM create_event WHERE age_group IS NOT NULL");
                                                        $age_group->execute();

                                                        while ($row = $age_group->fetch(PDO::FETCH_ASSOC)) {
                                                            echo "<option value='{$row['age_group']}'>{$row['age_group']}</option>";
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="mr-3">
                                                <label for="weight"
                                                    style="color: black; font-size: 1.0rem;">รุ่นน้ำหนัก</label>
                                                <select class="form-control" name="weight" id="weight" required
                                                    onchange="fetchClass()">
                                                    <option value="" disabled selected>กรุณาเลือกรุ่นน้ำหนัก</option>
                                                </select>
                                            </div>
                                            <div class="mr-3" >
                                                <label for="sp_class"
                                                    style="color: black; font-size: 1.0rem;">คลาส</label>
                                                <select class="form-control" name="sp_class" id="sp_class"  required>
                                                    <option value="" disabled selected>กรุณาเลือกคลาส</option>
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
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $counter = 1;
                                            if ($per->rowCount() > 0) {
                                                while ($person = $per->fetch(PDO::FETCH_ASSOC)) {
                                                    if ($person["team"] === $role) {
                                                        if ($person["IsActive"] == 0) {
                                            ?>
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
                                            </tr>
                                            <?php
                                                            $counter++;
                                                        }
                                                    }
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
    <script src="../../assets/js/pages_twd/event/create-event.js"></script>

    <script>
    function getImageName() {
        return "<?php echo $image['name']; ?>";
    }

    function Sports_type() {
        var selected_sport = document.getElementById("Sports_type").value;
        var fight_div = document.getElementById("fight");
        var fight_team_div = document.getElementById("fight-team");
        var Poomsae_general_M_div = document.getElementById("Poomsae-general-M");
        var Poomsae_general_F_div = document.getElementById("Poomsae-general-F");
        var Poomsae_Mix_Doubles_div = document.getElementById("Poomsae-Mix-Doubles");
        var Poomsae_team_M_div = document.getElementById("Poomsae-team-M");
        var Poomsae_team_F_div = document.getElementById("Poomsae-team-F");
        var Poomsae_free_sty_M_div = document.getElementById("Poomsae-free-sty-M");
        var Poomsae_free_sty_F_div = document.getElementById("Poomsae-free-sty-F");
        var Poomsae_free_sty_Mix_Doubles_div = document.getElementById(
            "Poomsae-free-sty-Mix-Doubles"
        );

        fight_div.style.display = "none";
        fight_team_div.style.display = "none";
        Poomsae_general_M_div.style.display = "none";
        Poomsae_general_F_div.style.display = "none";
        Poomsae_Mix_Doubles_div.style.display = "none";
        Poomsae_team_M_div.style.display = "none";
        Poomsae_team_F_div.style.display = "none";
        Poomsae_free_sty_M_div.style.display = "none";
        Poomsae_free_sty_F_div.style.display = "none";
        Poomsae_free_sty_Mix_Doubles_div.style.display = "none";

        // แสดงเฉพาะองค์ประกอบที่ถูกเลือก
        if (selected_sport == "ต่อสู้ (เดี่ยว)") {
            fight_div.style.display = "flex";
        } else if (selected_sport == "Fight-team") {
            fight_team_div.style.display = "flex";
        } else if (selected_sport == "Poomsae-general-M") {
            Poomsae_general_M_div.style.display = "flex";
        } else if (selected_sport == "Poomsae-general-F") {
            Poomsae_general_F_div.style.display = "flex";
        } else if (selected_sport == "Poomsae-Mix-Doubles") {
            Poomsae_Mix_Doubles_div.style.display = "flex";
        } else if (selected_sport == "Poomsae-team-M") {
            Poomsae_team_M_div.style.display = "flex";
        } else if (selected_sport == "Poomsae-team-F") {
            Poomsae_team_F_div.style.display = "flex";
        } else if (selected_sport == "Poomsae-free-sty-M") {
            Poomsae_free_sty_M_div.style.display = "flex";
        } else if (selected_sport == "Poomsae-free-sty-F") {
            Poomsae_free_sty_F_div.style.display = "flex";
        } else if (selected_sport == "Poomsae-free-sty-Mix-Doubles") {
            Poomsae_free_sty_Mix_Doubles_div.style.display = "flex";
        }
    }
    </script>

</body>

</html>