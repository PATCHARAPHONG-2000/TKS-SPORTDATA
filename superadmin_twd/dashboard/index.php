<?php
require_once('../authen.php');

$Database = new Database();
$conn = $Database->connect();

$per_chart = $conn->prepare("SELECT * FROM event");
$per_chart->execute();

$per_table = $conn->prepare("SELECT * FROM event ORDER BY RAND()");
$per_table->execute();

$data_by_age = array();
$data_by_team = array();

if ($per_chart->rowCount() > 0) {
    while ($person = $per_chart->fetch(PDO::FETCH_ASSOC)) {
        $age_group = getAgeGroup($person['age']);
        $data_by_age[$age_group][] = $person['age'];
        $data_by_team[$person['team']][] = $person['age'];
    }
}

function getAgeGroup($age)
{
    if ($age >= 5 && $age <= 12) {
        return '5-12';
    } elseif ($age >= 13 && $age <= 15) {
        return '13-15';
    } elseif ($age >= 16 && $age <= 18) {
        return '16-18';
    } elseif ($age >= 19 && $age <= 40) {
        return '19-40';
    } else {
        return 'Over 40';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>หน้าหลัก | TKS SOFTVISION</title>
    <link rel="shortcut icon" type="image/x-icon" href="../../assets/images/favicon.ico">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Kanit">
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <link rel="stylesheet" href="../../assets/css/adminlte.min.css">
    <link rel="stylesheet" href="../../assets/css/style.css">
    <!-- Datatables -->
    <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

    <style>
        .List::-webkit-scrollbar {
            width: 0;
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
                                                    รายชื่อนักกีฬา ที่สมัคร
                                                </h4>
                                            </div>
                                            <div class="List p-2" style="max-height: 700px; overflow-y: auto;">
                                                <table id="index-event" class="table table-striped table-hover" style="border-radius: 50%;">
                                                    <tbody>
                                                        <?php
                                                        $counter = 1;
                                                        if ($per_table->rowCount() > 0 && $counter <= 20) {
                                                            $teamChartLabels = array_keys($data_by_team);
                                                            $teamChartData = array_values($data_by_team);
                                                            while ($person = $per_table->fetch(PDO::FETCH_ASSOC)) {
                                                        ?>
                                                                <tr id="<?php echo $person["id"]; ?>">
                                                                    <td class="align-middle">
                                                                        <?php echo $counter; ?>
                                                                    </td>
                                                                    <td class="align-middle" style="max-width: 100px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                                                        <?php echo $person["firstname"]; ?>
                                                                    </td>
                                                                    <td class="align-middle" style="max-width: 100px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                                                        <?php echo $person["lastname"]; ?>
                                                                    </td>
                                                                    <td class="align-middle">
                                                                        <?php echo $person["team"]; ?>
                                                                    </td>
                                                                    <td class="align-middle">
                                                                        <img src="../../service/tksuploads/<?php echo $person["image"]; ?>" alt="Profile" style="max-width: 20px; border-radius: 50%;">
                                                                    </td>
                                                                </tr>
                                                            <?php
                                                                $counter++;
                                                                if ($counter > 20) {
                                                                    break;
                                                                }
                                                            }
                                                        } else {
                                                            ?>
                                                            <tr>
                                                                <td colspan="6">ยังไม่รายชื่อที่สมัคร</td>
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
                                                    <i class="fa-solid fa-transgender"></i>
                                                    ช่วงอายุที่สมัคร
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

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
    </script>
</body>

</html>