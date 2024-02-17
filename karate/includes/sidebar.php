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
    .flex-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
</style>

<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars fa-2x"></i></a>
        </li>
    </ul>
</nav>

<aside class="main-sidebar sidebar-light-info elevation-4">
    <a href="../dashboard/" class="brand-link">
        <img src="../../assets/images/logo.png" alt="Admin Logo" class="brand-image ">
        <span class="brand-text font-weight-light">TKS SOFTVISION</span>
    </a>

    <div class="sidebar mt-3 pb-3 mb-3 d-flex">

        <nav class="mt-3 pb-3 mb-3 d-flex">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="#" class="nav-link d-flex align-items-center">
                        <i class="nav-icon fas fa-igloo"></i>
                        <p class="mr-2">เลือก JUDGE</p>
                        <i class="ml-auto fas fa-caret-down"></i>
                    </a>
                    <ul class="nav nav-treeview collapse">
                        <li class="nav-item">
                            <a href="../dashboard/" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>7 JUDGE</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../dashboard/Judge-5" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>5 JUDGE</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="http://127.0.0.1/TKS-SPORTDATA/karate/score/" target="_blank" class="nav-link">
                        <i class="nav-icon fas fa-user-cog"></i>
                        <p>เปิด Score</p>
                    </a>
                </li>
                <li class="nav-header">กรรมการ</li>
                <li class="nav-item">
                    <a href="../judge/judge-1" target="_blank" class="nav-link">
                        <i class="nav-icon fas fa-user-cog"></i>
                        <p>กรรมการคนที่ 1</p>
                    </a>
                </li>
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