<?php
$Database = new Database();
$conn = $Database->connect();
function isActive($data)
{
    $array = explode('/', $_SERVER['REQUEST_URI']);
    $key = array_search("pages-ad", $array);
    $name = $array[$key + 1];
    return $name === $data ? 'active' : '';
}

$sql = $conn->prepare("SELECT * FROM setting WHERE name = 'btn-twd_event' ORDER BY id");
$sql->execute();
$event = $sql->fetch(PDO::FETCH_ASSOC);

if (isset($_SESSION['team']['role'])) {
    $role = $_SESSION['team']['role'];
} else {
    $role = 'default_status';
}

?>
<link rel="stylesheet" href="../../assets/css/sidebar.css">

<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">

    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars fa-2x"></i></a>
        </li>
        <li class="nav-item text-center">
            <p class="nav-link" style="font-size: 20px; font-weight: bold; color: black; " disabled>
                <?php echo isset($_SESSION['team']['role']) ? $_SESSION['team']['role'] : ''; ?>
            </p>
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
                    <a href="../manager/" class="nav-link <?php echo isActive('manager') ?>">
                        <i class="nav-icon fa-solid fa-user"></i>
                        <p>รายชื่อนักกีฬา</p>
                    </a>
                </li>
                <div>
                    <hr>
                </div>
                <?php if (isset($event['IsActive']) && $event['IsActive'] == 1) { ?>
                    <li class="nav-item ad-data" <?php echo isActive('index') ?>>
                        <a href="../event/" class="nav-link" id="active-link">
                            <i class="nav-icon fa-brands fa-elementor fa-xl "></i>
                            <p>สมัครแมตท์</p>
                        </a>
                    </li>
                <?php } else { ?>
                    <li class="nav-item ad-data" <?php echo isActive('index') ?>>
                        <a href="#" class="nav-link" style="pointer-events: none; cursor: default; color: gray;" onclick="return false;">
                            <i class="nav-icon fa-brands fa-elementor fa-xl"></i>
                            <p>สมัครแมตท์</p>
                        </a>
                    </li>
                <?php } ?>
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