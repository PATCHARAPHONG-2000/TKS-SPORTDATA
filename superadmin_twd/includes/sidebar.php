<?php
function isActive($data)
{
    $array = explode('/', $_SERVER['REQUEST_URI']);
    $key = array_search("pages", $array);
    $name = $array[$key + 1];
    return $name === $data ? 'active' : '';
}
?>

<style>
    .nav-link[disabled] {
        pointer-events: none;
        /* ปิดการใช้งานการคลิก */
        color: gray;
        /* เปลี่ยนสีของข้อความ */
        cursor: not-allowed;
        /* เปลี่ยนเคอร์เซอร์เมาส์ */
    }
</style>

<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars fa-2x"></i></a>
        </li>
    </ul>

</nav>
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-light-info elevation-4">
    <a href="../dashboard/" class="brand-link">
        <img src="../../assets/images/logo.png" alt="Admin Logo" class="brand-image ">
        <span class="brand-text font-weight-light">TKS SPORTDATA</span>
    </a>
    <div class="sidebar mt-3 pb-3 mb-3 d-flex">
        <nav class="mt-3 pb-3 mb-3 d-flex">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="../dashboard/" class="nav-link <?php echo isActive('dashboard') ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>หน้าหลัก</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../sportsperson/" class="nav-link <?php echo isActive('dashboard') ?>">
                        <i class="nav-icon fas fa-users-rectangle"></i>
                        <p>รายชื่อนักกีฬาทั้งหมด</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../event/" class="nav-link <?php echo isActive('dashboard') ?>">
                        <i class="nav-icon fas fa-users-rectangle"></i>
                        <p>รายชื่อนักกีฬาที่สมัคร</p>
                    </a>
                </li>
                <div>
                    <hr>
                </div>
                <li class="nav-header">สมาชิก</li>
                <li class="nav-item">
                    <a href="../users/" class="nav-link">
                        <i class="nav-icon fa-solid fa-hospital-user fa-xl2 mr-2"></i>
                        <p>รายชื่อสมาชิก</p>
                    </a>
                </li>
                <div>
                    <hr>
                </div>
                <li class="nav-header">จัดการ</li>
                <li class="nav-item">
                    <a href="../Certificate/" class="nav-link">
                        <i class="nav-icon fa-solid fa-certificate fa-xl2 mr-2"></i>
                        <p>Certificate</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../users/" class="nav-link">
                        <i class="nav-icon fa-solid fa-id-card fa-xl2 mr-2"></i>
                        <p>AD Card</p>
                    </a>
                </li>
                <div>
                    <hr>
                </div>
                <li class="nav-header mt-1" style="font-size: 1.10rem;">ตั้งค่า</li>
                <li class="nav-item">
                    <a href="../setting/image-event" class="nav-link">
                        <i class="nav-icon fa-solid fa-calendar-plus fa-xl2 mr-2"></i>
                        <p>เพิ่มแบร์นเนอร์</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../setting/create_event" class="nav-link">
                        <i class="nav-icon fa-solid fa-calendar-plus fa-xl2 mr-2"></i>
                        <p>เพิ่มอัเว้นท์</p>
                    </a>
                </li>
                <div>
                    <hr>
                </div>
                <li class="nav-header">บัญชีของเรา</li>
                <li class="nav-item">
                    <a id="logout" class="nav-link" onclick="confirmLogout()">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>ออกจากระบบ</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://kit.fontawesome.com/86e67b6ecc.js" crossorigin="anonymous"></script>
<script>
    function confirmLogout() {
        Swal.fire({
            title: 'ต้องการออกจากระบบหรือไม่?',
            text: 'หากคุณออกจากระบบ คุณจะต้องเข้าสู่ระบบใหม่เพื่อเข้าถึงบัญชีของคุณ',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '../logout.php';
            }
        });
    }
</script>