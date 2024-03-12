<?php
require_once('../authen.php');

// Establish database connection
$Database = new Database();
$conn = $Database->connect();

// Fetch user profile data
$selectbyidUser = $conn->prepare("SELECT * FROM player_profile WHERE idUser = ?");
$selectbyidUser->execute([$_SESSION['id']]);
$userData = $selectbyidUser->fetch(PDO::FETCH_ASSOC);

$role = isset($_SESSION['role']) ? $_SESSION['role'] : null;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Athlete Management System</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2">
                <?php include '../includes/sidebar.php'; ?> </div>
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        Personal Information
                    </div>
                    <div class="card-body">
                        <img src="<?php echo $userData['image']; ?>" alt="profile image" class="img-thumbnail">
                        <p>Name: <?php echo $userData['name']; ?></p>
                        <p>Email: <?php echo $userData['email']; ?></p>
                        <a href="./" class="btn btn-primary">Back</a>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-header">
                        Select Sport Category
                    </div>
                    <div class="card-body">
                        <select class="form-control" name="Sports_type" id="Sports_type" onchange="fetchSportEvents()">
                            <option value="" disabled selected>Please Select Sport Category</option>
                            <?php
                            $List_event = $conn->prepare("SELECT DISTINCT List_event FROM create_event");
                            $List_event->execute();

                            while ($row = $List_event->fetch(PDO::FETCH_ASSOC)) {
                                echo "<option value='{$row['List_event']}'>{$row['List_event']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div id="fight" class="card mt-3" style="display: none;">
                    <div class="card-header">
                        Event Information
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="age" style="color: black; font-size: 1.0rem;">Age Group</label>
                            <select class="form-control" name="age" id="age" required onchange="fetchWeight()">
                                <option value="" disabled selected>Please Select Age Group</option>
                                <?php
                                $age_group = $conn->prepare("SELECT DISTINCT age_group FROM create_event WHERE age_group IS NOT NULL");
                                $age_group->execute();

                                while ($row = $age_group->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<option value='{$row['age_group