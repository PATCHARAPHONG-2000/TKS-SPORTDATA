<?php
$Database = new Database();
$conn = $Database->connect();

if (isset($_SESSION['team']['role'])) {
    $role = $_SESSION['team']['role'];
} else {
    $role = 'default_status';
}

$player = $conn->prepare("SELECT * FROM player WHERE team = :role");
$player->bindParam(':role', $role);
$player->execute();


$per_chart = $conn->prepare("SELECT * FROM player WHERE team = :role");
$per_chart->bindParam(':role', $role);
$per_chart->execute();


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
