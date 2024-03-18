<?php
require_once '../../service/connect.php';
$Database = new Database();
$conn = $Database->connect();
if (!isset($_SESSION['AD_ID'])) {
    header('Location: ../../login.php');
}
