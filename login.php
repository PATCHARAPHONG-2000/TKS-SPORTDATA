<?php
require_once 'service/connect.php';
$Database = new Database();
$conn = $Database->connect();

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>TKS SPORTDATA</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.ico">

    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <link href="assets/css/home.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/login.css">

</head>

<body>

    <section id="topbar" class="d-flex align-items-center">
        <div class="container d-flex justify-content-center justify-content-md-between">
            <div class="contact-info d-flex align-items-center">
            </div>
            <div class="social-links d-none d-md-block">
                <a href="https://www.facebook.com/TKSsoft" target="_blank" class="facebook"><i
                        class="bi bi-facebook"></i></a>
                <a href="https://line.me/ti/p/_EFnRUO5tK" target="_blank" class="line"> <i class="bi bi-line"></i></a>
                <a href="login-score" class="karate"><img src="assets/images/karate-icon.png" alt=""
                        style="width: 15px; height:22px;"></a>
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
                        <a class="nav-link scrollto dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Login
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="login" style="color:black">TKS DATASPORT</a>
                            <a class="dropdown-item" href="login_ad" style="color:black">AD Card</a>
                        </div>
                    </li>

                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav>
        </div>
    </header>

    <main id="main">

        <section class="vh-100 login " id="login">
            <div class="container  ">
                <div class="row d-flex justify-content-center ">
                    <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                        <div class="card " style="border-radius: 1rem;">
                            <div class="card-body  align-items-center">

                                <form id="formLogin" autocomplete="off">
                                    <div class="mb-md-5 ">

                                        <h2 class="fw-bold mb-5 text-uppercase text-center">Login</h2>

                                        <div class="form-outline form-white mb-4 position-relative">
                                            <input type="email" id="email" name="email"
                                                class="form-control form-control-lg" placeholder="Email" required />
                                        </div>

                                        <div class="form-outline form-white mb-3 position-relative">
                                            <input type="password" id="password" name="password"
                                                class="form-control form-control-lg" placeholder="Password" required />
                                            <i class="fa-regular fa-eye position-absolute px-2 end-0 top-50 translate-middle-y"
                                                style="cursor: pointer;" id="show_pass"></i>
                                        </div>

                                        <p class="small mb-4 pb-lg-2 ms-2"><a class="-50" id="resetpassword"
                                                href="">Forgot password?</a></p>

                                        <div class="mt-4 pt-2 text-center">
                                            <button class="btn align-items-center" name="login"
                                                type="submit">Login</button>
                                        </div>

                                    </div>

                                </form>
                                <div>
                                    <p class="mb-0 text-center">ยังไม่มีบัญชีใช่ไหม?
                                        <a href="register" class="-50 fw-bold sign-up-button" id="signUpLink">Sign
                                            Up</a>
                                    </p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <footer id="footer">
        <div class="footer-top">
            <div class="container">
                <div class="row">

                    <div class="col-lg-4 col-md-6">
                        <div class="footer-info">
                            <h3>TKS SPORTDATA</h3>
                            <p>
                                Anusawari Sub-district <br> Bang Khen District <br> Bangkok 10220, Thailand.
                                <br><br><br>
                                <strong>Phone :</strong> 084-083-8587<br>
                                <strong>Email :</strong> tks.softvision.thai@gmail.com<br>
                            </p>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-6 footer-links">
                        <h4>Useful Links</h4>
                        <ul>
                            <li><i class="bx bx-chevron-right"></i> <a href="index.php#hero">Home</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="index.php#about">About us</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="index.php#portfolio">Photo</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="index.php#contact">Contact</a></li>
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

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>
    <div id="preloader"></div>

    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://kit.fontawesome.com/86e67b6ecc.js" crossorigin="anonymous"></script>

    <script src="assets/js/main.js"></script>>
    <!-- <script src="assets/js/login.js"></script> -->
    <script src="assets/js/reset_password.js"></script>

    <script>
    $("#formLogin").submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "service/auth/login.php",
            data: $(this).serialize(),
            dataType: "json",
        }).done(function(resp) {
            if (resp.error) {
                console.log(resp);
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: resp.error,
                    confirmButtonColor: "#FF0000", // สีแดง
                });
            } else {
                console.log(resp);
                let timerInterval;
                Swal.fire({
                    title: "กำลังเข้าสู่ระบบ",
                    html: "กำลังตรวจสอบ <b></b> ข้อมูล.",
                    timer: 1500,
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading();
                        const b = Swal.getHtmlContainer().querySelector("b");
                        timerInterval = setInterval(() => {
                            b.textContent = Swal.getTimerLeft();
                        }, 100);
                    },
                    willClose: () => {
                        clearInterval(timerInterval);
                    },
                }).then((result) => {
                    if (result
                        .isDismissed
                    ) { // แก้ไขจาก result.dismiss === Swal.DismissReason.timer เป็น result.isDismissed
                        console.log("I was closed by the timer");
                        if (resp.email ===
                            "tkd") { // แก้ไขจาก resp.email === "tkd" เป็น resp.role === "tkd"
                            location.href = "pages-twd/";
                        } else if (resp.role ===
                            "superadmin"
                        ) { // แก้ไขจาก resp.email === "SPAM" เป็น resp.role === "SPAM"
                            location.href = "superadmin_twd/";
                        }
                    }
                });
            }

        });
    });

    document.getElementById("show_pass").addEventListener("click", function() {
        var x = document.getElementById("password");
        if (x.type === "password") {
            x.type = "text";
            document.getElementById("show_pass").classList.remove("fa-eye");
            document.getElementById("show_pass").classList.add("fa-eye-slash");
        } else {
            x.type = "password";
            document.getElementById("show_pass").classList.remove("fa-eye-slash");
            document.getElementById("show_pass").classList.add("fa-eye");
        }
    });
    </script>
</body>

</html>