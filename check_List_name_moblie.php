<?php
require_once  'service/connect.php';

$Database = new Database();
$conn = $Database->connect();

$per = $conn->prepare("SELECT * FROM event ");
$per->execute();

$c_event = $conn->prepare("SELECT DISTINCT List_event FROM create_event");
$c_event->execute();

$event = $conn->prepare("SELECT * FROM event");
$event->execute();
$events = $event->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>TKS SPORTDATA</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <link href="assets/images/favicon.png" rel="icon">
    <link href="assets/images/apple-touch-icon.png" rel="apple-touch-icon">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Kanit">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/css/home.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">

    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

    <style>
        /* เพิ่ม CSS เพื่อให้สามารถปรับขนาดหน้าเว็บได้ในโทรศัพท์ */
        @media only screen and (max-width: 600px) {
            .row {
                display: flex;
                flex-wrap: wrap;
            }

            .small-box {
                width: 100%;
                box-sizing: border-box;
            }

            .col-lg-3 {
                flex: 0 0 100%;
                max-width: 100%;
            }


            .card {
                max-width: 500px;
                /* ปรับขนาดตามที่ต้องการ */
            }

            .card img {
                max-width: 100%;
                height: auto;
            }
        }
    </style>

</head>

<body>

    <section id="topbar" class="d-flex align-items-center">
        <div class="container d-flex justify-content-center justify-content-md-between">
            <div class="contact-info d-flex align-items-center">
            </div>
            <div class="social-links d-none d-md-block">
                <a href="https://www.facebook.com/TKSsoft" class="facebook"><i class="bi bi-facebook"></i></a>
                <a href="https://line.me/ti/p/_EFnRUO5tK" class="line"> <i class="bi bi-line"></i></a>
                <a href="assets/images/LINE.jpg" target="_blank" class="line"> <i class="bi bi-line"></i></a>
                <a href="login-score" class="karate"><img src="assets/images/karate-icon.png" alt="" style="width: 15px; height:22px;"></a>
            </div>
        </div>
    </section>

    <header id="header" class="d-flex align-items-center">
        <div class="container d-flex align-items-center justify-content-between">
            <h1 class="logo"><a href="./">TKS SPORTDATA</a></h1>
            <nav id="navbar" class="navbar">
                <ul>
                    <li><a class="nav-link scrollto active" href="index#hero">Home</a></li>
                    <li><a class="nav-link scrollto" href="index#about">About</a></li>
                    <li><a class="nav-link scrollto" href="index#events">Events</a></li>
                    <li><a class="nav-link scrollto " href="index#photo">Photo</a></li>
                    <li><a class="nav-link scrollto" href="index#contact">Contact</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Login
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="login" style="color:black">TKS SPORTDATA</a>
                            <a class="dropdown-item" href="login_ad" style="color:black">AD Card</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            รายชื่อนักกีฬา
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="check_List_name_pc" style="color:black">สำหรับ คอมพิวเตอร์</a>
                            <a class="dropdown-item" href="check_List_name_moblie" style="color:black">สำหรับ โทรศัพท์</a>
                        </div>
                    </li>
                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav>
        </div>
    </header>

    <main id="main">

        <div class="wrapper">
            <div class="content-wrapper pt-3 p-3">
                <div class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="card shadow mb-2">
                                <h1 style="font-weight: bold;">
                                    <?php echo $events["name_match"]; ?>
                                </h1>
                            </div>
                            <div class="card shadow mb-2">
                                <div class="card-header border-0 pt-4">
                                    <h1 style="font-weight: bold;">
                                        ต่อสู้ (เดี่ยว)
                                    </h1>
                                </div>
                                <div class="p-2 ">
                                    <div class="row">
                                        <?php
                                        $counter = 1;
                                        $per = $conn->prepare("SELECT * FROM event WHERE type_name = 'ต่อสู้ (เดี่ยว)' ");
                                        $per->execute();
                                        if ($per->rowCount() > 0) {
                                            while ($person = $per->fetch(PDO::FETCH_ASSOC)) {
                                        ?>
                                                <div class="col-lg-3 pt-3 mb-5">
                                                    <div class="small-box py-3 p-2 bg-white shadow">
                                                        <div class="row">
                                                            <div class="col-md-8 order-md-2">
                                                                <div class="inner">
                                                                    <h5><?php echo $person["firstname"] . " " . $person["lastname"]; ?></h5>
                                                                    <h6 class="text-danger"> <?php echo $person["team"]; ?></h6>
                                                                    <h6><?php echo !empty($person["age_group"]) ? $person["age_group"] : '-'; ?></h6>
                                                                    <h6><?php echo !empty($person["weight"]) ? $person["weight"] : '-'; ?></h6>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 order-md-1">
                                                                <?php if ($person["image"] && file_exists("service/tksuploads/" . $person["image"])) : ?>
                                                                    <img src="service/tksuploads/<?php echo $person["image"]; ?>" alt="Profile" style="max-width: 100%;  height: 150px; ">
                                                                <?php else : ?>
                                                                    <img src="assets/images/avatar.png" alt="Profile" style="max-width: 100%;  height: 150px; ">
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php
                                                $counter++;
                                            }
                                            ?>
                                        <?php
                                        }
                                        ?>

                                    </div>
                                </div>
                            </div>
                            <div class="card shadow pt-3 mb-2">
                                <div class="card-header border-0 pt-4">
                                    <h1 style="font-weight: bold;">
                                        ต่อสู้ ทีม
                                    </h1>
                                </div>
                                <div class="p-2 ">
                                    <div class="row">
                                        <?php
                                        $counter = 1;
                                        $team = $conn->prepare("SELECT * FROM event WHERE type_name = 'ต่อสู้ ทีม'");
                                        $team->execute();
                                        $current_team = "";
                                        $age_group_weight = array();
                                        if ($team->rowCount() > 0) {
                                            while ($teams = $team->fetch(PDO::FETCH_ASSOC)) {
                                                if ($current_team != $teams["team"]) {
                                                    if ($current_team != "") {

                                                        echo '<div class="col-md-8 order-md-2">';
                                                        echo '<div class="inner">';
                                                        foreach ($age_group_weight as $item) {
                                                            echo "<h6>$item</h6>";
                                                        }
                                                        echo '</div>';
                                                        echo '</div>';
                                                        echo '</div></div></div>';
                                                    }
                                                    // เริ่ม small-box ใหม่
                                                    echo '<div class="col-lg-3 pt-3 mb-5">';
                                                    echo '<div class="small-box py-3 p-2 bg-white shadow">';
                                                    echo '<h1 class="text-danger">' . $teams["team"] . '</h1>';
                                                    echo '<div class="row">';
                                                    $current_team = $teams["team"];
                                                    $age_group_weight = array();
                                                }
                                                // เก็บข้อมูล age_group และ weight เพื่อตรวจสอบค่าที่ซ้ำกัน
                                                $age_weight = $teams["age_group"] . " - " . $teams["weight"];
                                                if (!in_array($age_weight, $age_group_weight)) {
                                                    $age_group_weight[] = $age_weight;
                                                }
                                        ?>
                                                <div class="col-md-8 order-md-2 "> <!-- ตำแหน่งของข้อมูลอื่น ๆ -->
                                                    <div class="inner">
                                                        <h5><?php echo $teams["firstname"] . " " . $teams["lastname"]; ?></h5>
                                                    </div>
                                                </div>
                                        <?php
                                                $counter++;
                                            } // ปิด while loop
                                            // แสดงข้อมูล age_group และ weight ที่ซ้ำกันข้างล่างของรายชื่อทีม
                                            echo '<div class="col-md-8 order-md-2">';
                                            echo '<div class="inner">';
                                            foreach ($age_group_weight as $item) {
                                                echo "<h6>$item</h6>";
                                            }
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div></div></div>';
                                        } else {
                                            echo '<p style="text-align: center; color: red;">ยังไม่มีรายชื่อทีม</p>';
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="card shadow mb-2">
                                <div class="card-header border-0 pt-4">
                                    <h1 style="font-weight: bold;">
                                        พุมเซ่
                                    </h1>
                                </div>
                                <div class="p-2 ">
                                    <div class="row">
                                        <?php
                                        $counter = 1;
                                        $poomse = $conn->prepare("SELECT * FROM event WHERE type_name = 'พุมเซ่' ");
                                        $poomse->execute();
                                        if ($poomse->rowCount() > 0) {
                                            while ($poomses = $poomse->fetch(PDO::FETCH_ASSOC)) {
                                        ?>
                                                <div class="col-lg-3 pt-3 mb-5">
                                                    <div class="small-box py-3 p-2 bg-white shadow">
                                                        <div class="row">
                                                            <div class="col-md-8 order-md-2">
                                                                <div class="inner">
                                                                    <h5><?php echo $poomses["firstname"] . " " . $poomses["lastname"]; ?></h5>
                                                                    <h6 class="text-danger"> <?php echo $poomses["team"]; ?></h6>
                                                                    <h6><?php echo !empty($poomses["age_group"]) ? $poomses["age_group"] : '-'; ?></h6>
                                                                    <h6><?php echo !empty($poomses["pattern"]) ? $poomses["pattern"] : '-'; ?></h6>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 order-md-1 ">
                                                                <?php if ($poomses["image"] && file_exists("service/tksuploads/" . $poomses["image"])) : ?>
                                                                    <img src="service/tksuploads/<?php echo $poomses["image"]; ?>" alt="Profile" style="max-width: 100%; height: 150px;">
                                                                <?php else : ?>
                                                                    <img src="assets/images/avatar.png" alt="Profile" style="max-width: 100%; height: 150px;">
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        <?php
                                                $counter++;
                                            } // ปิด while loop
                                        } else {
                                            echo '<p style="text-align: center; color: red;">ยังไม่มีรายชื่อทีม</p>';
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="card shadow mb-2">
                                <div class="card-header border-0 pt-4">
                                    <h1 style="font-weight: bold;">
                                        พุมเซ่ คู่ผสม
                                    </h1>
                                </div>
                                <div class="p-2 ">
                                    <div class="row">
                                        <?php
                                        $counter = 1;
                                        $team = $conn->prepare("SELECT * FROM event WHERE type_name = 'พุมเซ่ คู่ผสม'");
                                        $team->execute();
                                        $current_team = "";
                                        $age_group_weight = array();
                                        if ($team->rowCount() > 0) {
                                            while ($teams = $team->fetch(PDO::FETCH_ASSOC)) {
                                                if ($current_team != $teams["team"]) {
                                                    if ($current_team != "") {

                                                        echo '<div class="col-md-8 order-md-2">';
                                                        echo '<div class="inner">';
                                                        foreach ($age_group_weight as $item) {
                                                            echo "<h6>$item</h6>";
                                                        }
                                                        echo '</div>';
                                                        echo '</div>';
                                                        echo '</div></div></div>';
                                                    }
                                                    // เริ่ม small-box ใหม่
                                                    echo '<div class="col-lg-3 pt-3 mb-5">';
                                                    echo '<div class="small-box py-3 p-2 bg-white shadow">';
                                                    echo '<h1 class="text-danger">' . $teams["team"] . '</h1>';
                                                    echo '<div class="row">';
                                                    $current_team = $teams["team"];
                                                    $age_group_weight = array();
                                                }
                                                // เก็บข้อมูล age_group และ weight เพื่อตรวจสอบค่าที่ซ้ำกัน
                                                $age_weight = $teams["age_group"] . " - " . $teams["weight"];
                                                if (!in_array($age_weight, $age_group_weight)) {
                                                    $age_group_weight[] = $age_weight;
                                                }
                                        ?>
                                                <div class="col-md-8 order-md-2 "> <!-- ตำแหน่งของข้อมูลอื่น ๆ -->
                                                    <div class="inner">
                                                        <h5><?php echo $teams["firstname"] . " " . $teams["lastname"]; ?></h5>
                                                    </div>
                                                </div>
                                        <?php
                                                $counter++;
                                            } // ปิด while loop
                                            // แสดงข้อมูล age_group และ weight ที่ซ้ำกันข้างล่างของรายชื่อทีม
                                            echo '<div class="col-md-8 order-md-2">';
                                            echo '<div class="inner">';
                                            foreach ($age_group_weight as $item) {
                                                echo "<h6>$item</h6>";
                                            }
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div></div></div>';
                                        } else {
                                            echo '<p style="text-align: center; color: red;">ยังไม่มีรายชื่อทีม</p>';
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="card shadow pt-3 mb-2">
                                <div class="card-header border-0 pt-4">
                                    <h1 style="font-weight: bold;">
                                        พุมเซ่ ทีม
                                    </h1>
                                </div>
                                <div class="p-2 ">
                                    <div class="row">
                                        <?php
                                        $counter = 1;
                                        $team = $conn->prepare("SELECT * FROM event WHERE type_name = 'พุมเซ่ ทีม'");
                                        $team->execute();
                                        $current_team = "";
                                        $current_age_group = "";
                                        if ($team->rowCount() > 0) {
                                            while ($teams = $team->fetch(PDO::FETCH_ASSOC)) {
                                                if ($current_team != $teams["team"] || $current_age_group != $teams["age_group"]) {
                                                    if ($counter > 1) {
                                                        // ปิด small-box ก่อนเริ่มใหม่
                                                        echo '</div></div></div>';
                                                    }
                                                    // เริ่ม small-box ใหม่
                                                    echo '<div class="col-lg-3 pt-3 mb-5">';
                                                    echo '<div class="small-box py-3 p-2 bg-white shadow">';
                                                    echo '<h1 class="text-danger">' . $teams["team"] . '</h1>';
                                                    echo '<div class="row">';
                                                    echo "<h4 class='text-danger'>{$teams['age_group']}</h4>";
                                                    $current_team = $teams["team"];
                                                    $current_age_group = $teams["age_group"];
                                                }
                                        ?>
                                                <div class="col-md-8 order-md-2 ">
                                                    <div class="inner">
                                                        <h5><?php echo $teams["firstname"] . " " . $teams["lastname"]; ?></h5>
                                                    </div>
                                                </div>
                                        <?php
                                                $counter++;
                                            }
                                            // ปิด small-box สุดท้าย
                                            echo '</div></div></div>';
                                        } else {
                                            echo '<p style="text-align: center; color: red;">ยังไม่มีรายชื่อทีม</p>';
                                        }
                                        ?>

                                    </div>
                                </div>
                            </div>
                            <div class="card shadow mb-2">
                                <div class="card-header border-0 pt-4">
                                    <h1 style="font-weight: bold;">
                                        เคียกพ่า
                                    </h1>
                                </div>
                                <div class="p-2 ">
                                    <div class="row">
                                        <?php
                                        $counter = 1;
                                        $poomse = $conn->prepare("SELECT * FROM event WHERE type_name = 'เคียกพ่า' ");
                                        $poomse->execute();
                                        if ($poomse->rowCount() > 0) {
                                            while ($poomses = $poomse->fetch(PDO::FETCH_ASSOC)) {
                                        ?>
                                                <div class="col-lg-3 pt-3 mb-5">
                                                    <div class="small-box py-3 p-2 bg-white shadow">
                                                        <div class="row">
                                                            <div class="col-md-8 order-md-2">
                                                                <div class="inner">
                                                                    <h5><?php echo $poomses["firstname"] . " " . $poomses["lastname"]; ?></h5>
                                                                    <h6 class="text-danger"> <?php echo $poomses["team"]; ?></h6>
                                                                    <h6><?php echo !empty($poomses["kiakpa"]) ? $poomses["kiakpa"] : '-'; ?></h6>
                                                                    <h6><?php echo !empty($poomses["age_group"]) ? $poomses["age_group"] : '-'; ?></h6>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 order-md-1 ">
                                                                <?php if ($poomses["image"] && file_exists("service/tksuploads/" . $poomses["image"])) : ?>
                                                                    <img src="service/tksuploads/<?php echo $poomses["image"]; ?>" alt="Profile" style="max-width: 100%; height: 150px;">
                                                                <?php else : ?>
                                                                    <img src="assets/images/avatar.png" alt="Profile" style="max-width: 100%; height: 150px;">
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        <?php
                                                $counter++;
                                            } // ปิด while loop
                                        } else {
                                            echo '<p style="text-align: center; color: red;">ยังไม่มีรายชื่อทีม</p>';
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="card shadow mb-2">
                                <div class="card-header border-0 pt-4">
                                    <h1 style="font-weight: bold;">
                                        Dance Battle
                                    </h1>
                                </div>
                                <div class="p-2 ">
                                    <div class="row">
                                        <?php
                                        $counter = 1;
                                        $poomse = $conn->prepare("SELECT * FROM event WHERE type_name = 'Dance Battle' ");
                                        $poomse->execute();
                                        if ($poomse->rowCount() > 0) {
                                            while ($poomses = $poomse->fetch(PDO::FETCH_ASSOC)) {
                                        ?>
                                                <div class="col-lg-3 pt-3 mb-5">
                                                    <div class="small-box py-3 p-2 bg-white shadow">
                                                        <div class="row">
                                                            <div class="col-md-8 order-md-2">
                                                                <div class="inner">
                                                                    <h5><?php echo $poomses["firstname"] . " " . $poomses["lastname"]; ?></h5>
                                                                    <h6 class="text-danger"> <?php echo $poomses["team"]; ?></h6>
                                                                    <h6><?php echo !empty($poomses["age_group"]) ? $poomses["age_group"] : '-'; ?></h6>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 order-md-1 ">
                                                                <?php if ($poomses["image"] && file_exists("service/tksuploads/" . $poomses["image"])) : ?>
                                                                    <img src="service/tksuploads/<?php echo $poomses["image"]; ?>" alt="Profile" style="max-width: 100%; height: 150px;">
                                                                <?php else : ?>
                                                                    <img src="assets/images/avatar.png" alt="Profile" style="max-width: 100%; height: 150px;">
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        <?php
                                                $counter++;
                                            } // ปิด while loop
                                        } else {
                                            echo '<p style="text-align: center; color: red;">ยังไม่มีรายชื่อทีม</p>';
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="card shadow mb-2">
                                <div class="card-header border-0 pt-4">
                                    <h1 style="font-weight: bold;">
                                        Dance Battle ทีม
                                    </h1>
                                </div>
                                <div class="p-2 ">
                                    <div class="row">
                                        <?php
                                        $counter = 1;
                                        $team = $conn->prepare("SELECT * FROM event WHERE type_name = 'Dance Battle ทีม'");
                                        $team->execute();
                                        $current_team = "";
                                        $age_group_weight = array();
                                        if ($team->rowCount() > 0) {
                                            while ($teams = $team->fetch(PDO::FETCH_ASSOC)) {
                                                if ($current_team != $teams["team"]) {
                                                    if ($current_team != "") {
                                                        echo '</div></div></div>';
                                                    }
                                                    echo '<div class="col-lg-3 mb-5">';
                                                    echo '<div class="small-box py-3 p-2 bg-white shadow">';
                                                    echo '<h1 class="text-danger">' . $teams["team"] . '</h1>';
                                                    echo '<div class="row">';
                                                    $current_team = $teams["team"];
                                                    $age_group_weight = array();
                                                }
                                        ?>
                                                <div class="col-md-8 order-md-2 ">
                                                    <div class="inner">
                                                        <h5><?php echo $teams["firstname"] . " " . $teams["lastname"]; ?></h5>
                                                    </div>
                                                </div>
                                        <?php
                                                $counter++;
                                            }
                                        } else {
                                            echo '<p style="text-align: center; color: red;">ยังไม่มีรายชื่อทีม</p>';
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
    </main>

    <footer id="footer">
        <div class="footer-top">
            <div class="container">
                <div class="row">

                    <div class="col-lg-4 col-md-6">
                        <div class="footer-info">
                            <h3>TKS SPORTDATA</h3>
                            <p>
                                Anusawari Sub-district <br> Bang Khen District <br> Bangkok 10220, Thailand. <br><br><br>
                                <strong>Phone :</strong> 084-083-8587<br>
                                <strong>Email :</strong> tks.softvision.thai@gmail.com<br>
                            </p>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-6 footer-links">
                        <h4>Useful Links</h4>
                        <ul>
                            <li><i class="bx bx-chevron-right"></i> <a href="index#hero">Home</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="index#about">About us</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="index#photo">Photo</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="index#contact">Contact</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="karate/">Score Karate</a></li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>

        <div class="container">
            <div class="copyright">
                <strong>Copyright &copy; 2023
                    <a href="https://www.facebook.com/PHATCHARAPHONG2000" target="_blank">PATCHARAPHONGDEV</a>.
                </strong> All rights reserved.
            </div>
            <div class="credits">

            </div>
        </div>
    </footer>

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
    <div id="preloader"></div>


    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/js/main.js"></script>

    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="assets/js/adminlte.min.js"></script>

    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

    <script>
        var table = $("#index-event").DataTable({
            paging: false,
            ordering: false,
            searching: true,
            info: false,

            columnDefs: [{
                    width: "2%",
                    targets: 0
                },
                {
                    width: "10%",
                    targets: 1
                },
                {
                    width: "10%",
                    targets: 2
                },
                {
                    width: "10%",
                    targets: 3
                },
                {
                    width: "7%",
                    targets: 4
                },
                {
                    width: "7%",
                    targets: 5
                },
                {
                    width: "15%",
                    targets: 6
                },
            ],
        });


        function selectEvent(eventList) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("index-event").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "service/get_events?eventList=" + eventList, true);
            xhttp.send();
        }

        function showAllEvents() {
            location.reload();
        }
    </script>


</body>

</html>