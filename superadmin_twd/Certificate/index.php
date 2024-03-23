<?php

require_once('../authen.php');
$Database = new Database();
$conn = $Database->connect();

$player = $conn->prepare("SELECT * FROM event");
$player->execute();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TKS SOFTVISION</title>
    <link rel="shortcut icon" type="image/x-icon" href="../../assets/images/favicon.ico">

    <!-- stylesheet -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Kanit">
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <link rel="stylesheet" href="../../assets/css/adminlte.min.css">
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="../../assets/css/datatable.css">

    <!-- Datatables -->
    <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

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
                                    <h4>
                                        <i class="fa-solid fa-id-card-clip mr-2"></i>
                                        ปริ้นใบประกาศ
                                    </h4>
                                    <a href="#" class="btn btn-info mt-3 text-white" type="button" id="print-selected" target="_blank">
                                        <i class="nav-icon fa-solid fa-print"></i>
                                        Print All
                                    </a>
                                </div>
                                <div class="p-2">
                                    <table id="certificate" class="table table table-striped table-hover">
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
                                                <th class="align-middle">รูป</th>
                                                <th class="align-middle">พิมพ์</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $counter = 1;
                                            if ($player->rowCount() > 0) {
                                                while ($players = $player->fetch(PDO::FETCH_ASSOC)) { ?>
                                                    <tr id="<?php echo $players["id"]; ?>">
                                                        <td class="align-middle"><input type="checkbox" class="checkbox" name="idc[]" value="<?php echo $players["id"]; ?>"></td>
                                                        <td class="align-middle">
                                                            <?php echo $counter; ?>
                                                        </td>
                                                        <td class="align-middle">
                                                            <?php echo $players["firstname"]; ?>
                                                        </td>
                                                        <td class="align-middle">
                                                            <?php echo $players["lastname"]; ?>
                                                        </td>
                                                        <td class="align-middle">
                                                            <?php echo $players["gender"]; ?>
                                                        </td>
                                                        <td class="align-middle">
                                                            <?php if ($players["image"] && file_exists("../../service/tksuploads/" . $players["image"])) : ?>
                                                                <img src="../../service/tksuploads/<?php echo $players["image"]; ?>" alt="Profile" style="max-width: 50px;">
                                                            <?php else : ?>
                                                                <img src="../../assets/images/avatar.png" alt="Profile" style="max-width: 50px;">
                                                            <?php endif; ?>
                                                        </td>
                                                        <td class="align-middle">
                                                            <a href="../adcard/Certificate?id=<?php echo $players["id"]; ?>" target="_blank" class="btn btn-warning text-white"> Print </a>
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
    <!-- <script src="../../assets/js/superadmin_twd/adcard/index.js"></script> -->

    <script>
        $(document).ready(function() {
            var table = $("#certificate").DataTable({
                paging: true,
                ordering: false,
                searching: true,
                info: true,
                className: "select-checkbox",

                columnDefs: [{
                        width: "10%",
                        targets: 1
                    },
                    {
                        width: "15%",
                        targets: 2
                    },
                    {
                        width: "15%",
                        targets: 3
                    },
                    {
                        width: "15%",
                        targets: 4
                    },
                    {
                        width: "20%",
                        targets: 5
                    },
                    {
                        width: "15%",
                        targets: 6
                    },
                ],
            });

            $("#select_all").on("click", function() {
                $(".checkbox").prop("checked", this.checked);

                // ตรวจสอบสถานะของ "Select All" เพื่อกำหนดการใช้งานของปุ่ม "Print Selected"
                if (this.checked) {
                    $("#print-selected").prop("disabled", false);
                } else {
                    $("#print-selected").prop("disabled", true);
                }
            });

            $(".checkbox").on("click", function() {
                if ($(".checkbox:checked").length === $(".checkbox").length) {
                    $("#select_all").prop("checked", true);
                } else {
                    $("#select_all").prop("checked", false);
                }

                // ตรวจสอบสถานะของ "Select All" เพื่อกำหนดการใช้งานของปุ่ม "Print Selected"
                if ($(".checkbox:checked").length > 0) {
                    $("#print-selected").prop("disabled", false);
                } else {
                    $("#print-selected").prop("disabled", true);
                }
            });

            $("#print-selected").on("click", function() {
                var selectedIds = $(".checkbox:checked")
                    .map(function() {
                        return $(this).val();
                    })
                    .get();

                if (selectedIds.length > 0) {
                    var url = "../adcard/Certificate.php?id=" + selectedIds.join(",");
                    window.open(url, "_blank");
                } else {
                    Swal.fire({
                        text: "กรุณาเลือกอย่างน้อยหนึ่งรายการ",
                        icon: "warning",
                        confirmButtonText: "ตกลง",
                    });
                }
            });

            // ตรวจสอบการเลือก checkbox เพื่ออัปเดตสถานะของ select_all
            table.on("draw", function() {
                if ($(".checkbox:checked").length === $(".checkbox").length) {
                    $("#select_all").prop("checked", true);
                } else {
                    $("#select_all").prop("checked", false);
                }
            });
        });
    </script>

</body>

</html>