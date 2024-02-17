<?php

ob_start();
require_once 'service/connect.php';
$Database = new Database();
$conn = $Database->connect();
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
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link rel="stylesheet" href="plugins/toastr/toastr.min.css">

    <link href="assets/css/home.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/login.css">

    <style>
    ::placeholder {
        font-size: 15px;
    }

    .form-label {
        color: #000000;
        font-weight: 500;
    }
    </style>

</head>

<body class="loginpage">

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

        <section class="vh-100 register " id="register">
            <div class="container  ">
                <div class="row d-flex justify-content-center ">
                    <div class="col-12 col-md-8 col-lg-9 col-xl-7">
                        <div class="card " style="border-radius: 1rem;">
                            <div class="card-body  align-items-center">

                                <form id="formRegister" autocomplete="off">

                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <div class="form-outline">
                                                <label for="firstName" class="form-label">First Name</label>
                                                <input type="text" id="firstName" name="firstName" placeholder="ชื่อ"
                                                    class="form-control form-control-lg" required
                                                    value="<?php echo isset($_POST['firstName']) ? htmlspecialchars($_POST['firstName']) : ''; ?>" />
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-4">
                                            <div class="form-outline">
                                                <label for="lastName" class="form-label">Last Name</label>
                                                <input type="text" id="lastName" name="lastname" placeholder="นามสกุล"
                                                    class="form-control form-control-lg" required
                                                    value="<?php echo isset($_POST['lastname']) ? htmlspecialchars($_POST['lastname']) : ''; ?>" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-4 d-flex align-items-center">
                                            <div class="form-outline datepicker w-100">
                                                <label for="team" class="form-label">Team</label>
                                                <input type="text" id="team" name="team" placeholder="ทีม"
                                                    class="form-control form-control-lg" required
                                                    value="<?php echo isset($_POST['team']) ? htmlspecialchars($_POST['team']) : ''; ?>" />
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-6  gender">
                                            <h6 class="form-label mb-2 pb-1 mt-2">Gender </h6>
                                            <div class="form-check form-check-inline mt-2">
                                                <input class="form-check-input" type="radio" name="gender"
                                                    id="femaleGender" value="Female" required
                                                    <?php echo (isset($_POST['gender']) && $_POST['gender'] == 'Female') ? 'checked' : ''; ?> />
                                                <label class="form-check-label" for="femaleGender">Female</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="gender"
                                                    id="maleGender" value="Male" required
                                                    <?php echo (isset($_POST['gender']) && $_POST['gender'] == 'Male') ? 'checked' : ''; ?> />
                                                <label class="form-check-label" for="maleGender">Male</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-4 pb-2">
                                            <div class="form-outline">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="email" id="email" name="email" placeholder="อีเมล"
                                                    class="form-control form-control-lg" required
                                                    value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" />
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-4 pb-2">
                                            <div class="form-outline">
                                                <label for="tell" class="form-label">Phone Number</label>
                                                <input type="tel" id="tell" name="tell" placeholder="เบอร์โทร"
                                                    class="form-control form-control-lg" minlength="10" maxlength="10"
                                                    required pattern="[0-9]{10}"
                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                                    value="<?php echo isset($_POST['tell']) ? htmlspecialchars($_POST['tell']) : ''; ?>" />

                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-4 pb-2">
                                            <div class="form-outline">
                                                <label for="password" class="form-label">Password</label>
                                                <input type="password" id="password" name="password"
                                                    placeholder="รหัสผ่าน" class="form-control form-control-lg"
                                                    required />
                                                <span id="passwordHelpInline" class="form-text ms-2">
                                                    รหัสผ่านของคุณ ต้องมีอย่างน้อย 8 ตัวขึ้นไป
                                                </span>
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-4 pb-2">
                                            <div class="form-outline">
                                                <label for="c_password" class="form-label">Confirm Password</label>
                                                <input type="password" id="c_password" name="c_password"
                                                    placeholder="ยืนยันรหัสผ่าน" class="form-control form-control-lg"
                                                    required />
                                            </div>
                                        </div>
                                    </div>

                                    <input type="hidden" id="cookieSetting" name="cookieSetting" value="0">

                                    <div class="mt-2 pt-2 text-center">
                                        <button class="btn align-items-center" name="signup"
                                            type="submit">สมัครสมาชิก</button>
                                    </div>
                                </form>
                                <div>
                                    <p class="mb-0 mt-4 text-center">มีบัญชีอยู่แล้วใช่ไหม? <a href="login"
                                            class="fw-bold login-button ms-2" id="loginLink">Login</a></p>
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
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="plugins/toastr/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="assets/js/main.js"></script>
    <script src="assets/js/register.js"></script>

</body>

</html>