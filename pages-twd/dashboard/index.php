<?php
require_once('../authen.php');

include_once('../../assets/php/pages-twd/dashboard/index.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo isset($_SESSION['team']['role']) ? $_SESSION['team']['role'] : ''; ?> | TKS SPORTDATA</title>
    <link rel="shortcut icon" type="image/x-icon" href="../../assets/images/favicon.ico">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Kanit">
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../../assets/css/adminlte.min.css">
    <link rel="stylesheet" href="../../assets/css/style.css">

    <!-- Datatables -->
    <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

    <style>
    .td {
        width: 20%;
    }

    .id {
        width: 20px;
    }
    </style>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <?php include_once('../includes/sidebar.php') ?>
        <div class="content-wrapper pt-3">
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card shadow">
                                <div class="card-body row">
                                    <div class="col-md-6">
                                        <div class="card p-3 mr-2">
                                            <div class="card-header border-0">
                                                <h4>
                                                    <i class="fa-solid fa-person"></i>
                                                    รายชื่อนักกีฬาที่ได้เหรียญทอง
                                                </h4>
                                            </div>
                                            <div class="List p-2" style="max-height: 700px; overflow-y: auto;">
                                                <table id="index-event" class="table table-striped table-hover"
                                                    style="border-radius: 50%;">
                                                    <tbody>
                                                        <?php
                                                        $counter = 1;
                                                        $isActiveCounter = 0; 
                                                        if ($player->rowCount() > 0 && $counter <= 20) {
                                                            $teamChartLabels = array_keys($data_by_team);
                                                            $teamChartData = array_values($data_by_team);
                                                            while ($person = $player->fetch(PDO::FETCH_ASSOC)) {
                                                                if ($person["IsActive"] != 1) {
                                                                    continue;
                                                                }
                                                                ?>
                                                        <tr id="<?php echo $person["id"]; ?>">
                                                            <td class="id align-middle">
                                                                <?php echo $counter; ?>
                                                            </td>
                                                            <td class="td align-middle"
                                                                style="max-width: 100px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                                                <?php echo $person["firstname"]; ?>
                                                            </td>
                                                            <td class="td align-middle"
                                                                style="max-width: 100px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                                                <?php echo $person["lastname"]; ?>
                                                            </td>
                                                            <td class="td align-middle">
                                                                <?php echo $person["team"]; ?>
                                                            </td>
                                                            <td class="td align-middle">
                                                                <img src="../../service/tksuploads/<?php echo $person["image"]; ?>"
                                                                    alt="Profile"
                                                                    style="width: 30px; height: 30px; border-radius: 50%;">
                                                            </td>
                                                        </tr>
                                                        <?php
                                                                $counter++;
                                                                if ($counter > 20) {
                                                                    break;
                                                                }
                                                            }
                                                        }
                                                        if ($isActiveCounter == 0) { // ตรวจสอบว่าไม่มีข้อมูลที่ IsActive เป็น 1
                                                            ?>
                                                        <tr>
                                                            <td colspan="5">ยังไม่มีรายชื่อนักกีฬาที่ได้เหรียญทอง</td>
                                                        </tr>
                                                        <?php
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card p-3 mb-2">
                                            <div class="card-header border-0">
                                                <h4>
                                                    <i class="fa-solid fa-coins"></i>
                                                    จำนวนนักกีฬาที่ได้เหรียญทอง
                                                </h4>
                                            </div>
                                            <div class="card-body">
                                                <canvas id="myChart"></canvas>
                                            </div>
                                        </div>
                                        <div class="card p-3">
                                            <div class="card-header border-0">
                                                <h4>
                                                    <i class="fa-solid fa-people-group"></i>
                                                    รายชื่อทีมที่สมัครมา
                                                </h4>
                                            </div>
                                            <div class="card-body">
                                                <canvas id="teamChart"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once('../includes/footer.php') ?>
    </div>

    <script src="../../plugins/jquery/jquery.min.js"></script>
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/js/adminlte.min.js"></script>
    <script src="../../plugins/chart.js/Chart.min.js"></script>
    <script src="../../plugins/chartjs-plugin-datalabels/dist/chartjs-plugin-datalabels.min.js"></script>

    <!-- datatables -->
    <script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

    <script>
    const ctx = document.getElementById('myChart');

    const ageChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode(array_keys($data_by_age)); ?>,
            datasets: [{
                label: 'จำนวนผู้สมัครตามอายุ',
                data: <?php echo json_encode(array_map('count', $data_by_age)); ?>,
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    const teamCtx = document.getElementById('teamChart');

    const teamChart = new Chart(teamCtx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($teamChartLabels); ?>,
            datasets: [{
                label: 'จำนวนผู้สมัครตามทีม',
                data: <?php echo json_encode(array_map('count', $teamChartData)); ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // $(document).ready(function () {
    //     var table = $("#index-event").DataTable({
    //         paging: true,
    //         ordering: false,
    //         searching: true,
    //         info: true,
    //         className: "select-checkbox",

    //         columnDefs: [
    //             {
    //                 width: "5%",
    //                 targets: 0,
    //             },
    //             {
    //                 width: "7%",
    //                 targets: 1,
    //             },
    //             {
    //                 width: "13%",
    //                 targets: 2,
    //             },
    //             {
    //                 width: "13%",
    //                 targets: 3,
    //             },
    //             {
    //                 width: "7%",
    //                 targets: 4,
    //             },

    //         ],
    //     });
    // });
    </script>


</body>

</html>