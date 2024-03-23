<?php

require_once  '../authen.php';

$per = $conn->prepare("SELECT * FROM event WHERE type_name IN (SELECT List_event FROM create_event)");
$per->execute();

if (isset($_POST['eventList'])) {
    $selectedEventList = $_POST['eventList'];

    $per = $conn->prepare("SELECT * FROM event WHERE type_name = :type_name");
    $per->bindParam(':type_name', $selectedEventList);
    $per->execute();
} else {
    $per = $conn->prepare("SELECT * FROM event");
    $per->execute();
}

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

    <link href="../../assets/images/favicon.png" rel="icon">
    <link href="../../assets/images/apple-touch-icon.png" rel="apple-touch-icon">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Kanit">
    <link href="../../assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="../../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="../../assets/css/home.css" rel="stylesheet">

    <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
</head>

<body>

    <section id="topbar" class="d-flex align-items-center">
        <div class="container d-flex justify-content-center justify-content-md-between">
            <div class="contact-info d-flex align-items-center">
            </div>
            <div class="social-links d-none d-md-block">
                <a href="https://www.facebook.com/TKSsoft" class="facebook"><i class="bi bi-facebook"></i></a>
                <a href="https://line.me/ti/p/_EFnRUO5tK" class="line"> <i class="bi bi-line"></i></a>
                <a href="./../../assets/images/LINE.jpg" target="_blank" class="line"> <i class="bi bi-line"></i></a>
                <a href="login-score" class="karate"><img src="../../assets/images/karate-icon.png" alt="" style="width: 15px; height:22px;"></a>
            </div>
        </div>
    </section>

    <header id="header" class="d-flex align-items-center">
        <div class="container d-flex align-items-center justify-content-between">
            <h1 class="logo"><a href="../../">TKS SPORTDATA</a></h1>
            <nav id="navbar" class="navbar">
                <ul>
                    <li><a class="nav-link scrollto active" href="../../#hero">Home</a></li>
                    <li><a class="nav-link scrollto" href="../../#about">About</a></li>
                    <li><a class="nav-link scrollto" href="../../#events">Events</a></li>
                    <li><a class="nav-link scrollto " href="../../#photo">Photo</a></li>
                    <li><a class="nav-link scrollto" href="../../#contact">Contact</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Login
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="login" style="color:black">TKS SPORTDATA</a>
                            <a class="dropdown-item" href="login_ad" style="color:black">AD Card</a>
                        </div>
                    </li>

                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav><!-- .navbar -->
        </div>
    </header>

    <main id="main">

        <div class="content-wrapper pt-3 ">
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card shadow mw-100 hv-100">
                                <div class="card-header border-0 pt-4">
                                    <h1 style="font-weight: bold;">
                                        <?php echo $events["name_match"]; ?>
                                    </h1>
                                    <div id="eventList">
                                        <?php if ($c_event->rowCount() > 0) : ?>
                                            <button class="btn btn-dark  ml-4 eventButton" onclick="showAllEvents()">ทั้งหมด</button>
                                            <?php while ($row = $c_event->fetch(PDO::FETCH_ASSOC)) : ?>
                                                <p class="btn btn-dark mt-3 ml-4 eventButton" onclick="selectEvent('<?php echo $row["List_event"]; ?>')"><?php echo $row["List_event"]; ?></p>
                                            <?php endwhile; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div id="eventTable" class="p-2">
                                    <table id="index-event" class="table table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th class="align-middle" style="background-color: red;">ลำดับ</th>
                                                <th class="align-middle" style="background-color: red;">ทีม</th>
                                                <th class="align-middle" style="background-color: red;">ชื่อ</th>
                                                <th class="align-middle" style="background-color: red;">นามสกุล</th>
                                                <th class="align-middle" style="background-color: red;">เพศ</th>
                                                <th class="align-middle" style="background-color: red;">ชนิดกีฬา</th>
                                                <th class="align-middle" style="background-color: red;">เคียกผ้า</th>
                                                <th class="align-middle" style="background-color: red;">รุ่นอายุ</th>
                                                <th class="align-middle" style="background-color: red;">รุ่นน้ำหนัก</th>
                                                <th class="align-middle" style="background-color: red;">รูป</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $counter = 1;
                                            if ($per->rowCount() > 0) {
                                                while ($person = $per->fetch(PDO::FETCH_ASSOC)) {
                                            ?>
                                                    <tr id="<?php echo $person["id"]; ?>">
                                                        <td class="align-middle text-center">
                                                            <?php echo $counter; ?>
                                                        </td>
                                                        <td class="align-middle">
                                                            <?php echo $person["team"]; ?>
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
                                                            <?php echo !empty($person["kiakpa"]) ? $person["kiakpa"] : '-'; ?>
                                                        </td>
                                                        <td class="align-middle">
                                                            <?php echo $person["age_group"]; ?>
                                                        </td>
                                                        <td class="align-middle">
                                                            <?php echo $person["weight"]; ?>
                                                        </td>
                                                        <td class="align-middle">
                                                            <?php if ($person["image"] && file_exists("service/tksuploads/" . $person["image"])) : ?>
                                                                <img src="service/tksuploads/<?php echo $person["image"]; ?>" alt="Profile" style="max-width: 50px;">
                                                            <?php else : ?>
                                                                <img src="assets/images/avatar.png" alt="Profile" style="max-width: 50px;">
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
                            <li><i class="bx bx-chevron-right"></i> <a href="#hero">Home</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#about">About us</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#photo">Photo</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#contact">Contact</a></li>
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


    <script src="../../assets/vendor/aos/aos.js"></script>
    <script src="../../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="../../assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="../../assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="../../assets/js/main.js"></script>

    <script src="../../plugins/jquery/jquery.min.js"></script>
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="../../assets/js/adminlte.min.js"></script>

    <script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

    <script>
        var table = $("#index-event").DataTable({
            paging: false,
            ordering: false,
            searching: false,
            info: false,

            columnDefs: [{
                    width: "2%",
                    targets: 0
                },
                {
                    width: "5%",
                    targets: 1
                },
                {
                    width: "10%",
                    targets: 2
                },
                {
                    width: "20%",
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
            xhttp.open("GET", "get_events.php?eventList=" + eventList, true);
            xhttp.send();
        }

        function showAllEvents() {
            location.reload();
        }
    </script>


</body>

</html>


<div class="row">

    <?php
    $counter = 1;
    if ($per->rowCount() > 0) {
        while ($person = $per->fetch(PDO::FETCH_ASSOC)) {
    ?>
            <div class="col-lg-3">
                <div class="small-box py-3 p-2 bg-white shadow">
                    <div class="row">
                        <div class="col-md-8 order-md-2"> <!-- เปลี่ยน order -->
                            <div class="inner">
                                <h5>พงสทร โพโสลี</h5>
                                <p class="text-danger">BKK</p>
                                <p>ต่อสู้ (เดี่ยว)</p>
                                <p>-</p>
                                <p>รุ่นยุวชนอายุ 11-12 ปี</p>
                                <p>นํ้าหนักเกิน 46 กก. ขึ้นไป</p>
                            </div>
                        </div>
                        <div class="col-md-4 order-md-1"> <!-- เปลี่ยน order -->
                            <img src="assets/images/avatar.png" style="max-width: 100%;" alt="">
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