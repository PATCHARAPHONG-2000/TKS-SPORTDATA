<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>TKS SPORTDATA</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.ico">
    <!-- stylesheet -->

    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">

    <!-- Template Main CSS File -->
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

<body>

    <main id="main">

        <section class="vh-100 login " id="login">
            <div class="container  ">
                <div class="row d-flex justify-content-center ">
                    <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                        <div class="card " style="border-radius: 1rem;">
                            <div class="card-body  align-items-center">

                                <div class="mb-md-5 position-relative" style="border-radius: 5rem;">
                                    <div class="form-outline form-white mb-4">
                                        <input type="password" name="password"
                                            class="swal2-input form-control form-control-lg" placeholder="รหัสผ่านใหม่"
                                            required />
                                        <label
                                            class="checkbox-label position-absolute start-0 top-100 translate-middle-y mt-4">
                                            <input class="checkbox ms-4 " type="checkbox" onclick="myFunction()">
                                            Show
                                            Password
                                        </label>
                                    </div>
                                    <div class="form-outline form-white">
                                        <input type="password" name="c_password"
                                            class="swal2-input form-control form-control-lg"
                                            placeholder="ยืนยันรหัสผ่าน" required />
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://kit.fontawesome.com/86e67b6ecc.js" crossorigin="anonymous"></script>


    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>
    <script src="assets/js/login.js"></script>
    <script type="text/javascript" src="assets/js/reset_password.js"></script>


    <script>
    function myFunction() {
        var passwordInputs = document.getElementsByName("password");
        var cPasswordInputs = document.getElementsByName("c_password");

        for (var i = 0; i < passwordInputs.length; i++) {
            if (passwordInputs[i].type === "password") {
                passwordInputs[i].type = "text";
            } else {
                passwordInputs[i].type = "password";
            }
        }

        for (var i = 0; i < cPasswordInputs.length; i++) {
            if (cPasswordInputs[i].type === "password") {
                cPasswordInputs[i].type = "text";
            } else {
                cPasswordInputs[i].type = "password";
            }
        }
    }
    </script>

</body>

</html>