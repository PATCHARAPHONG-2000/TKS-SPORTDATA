<?php
require_once './service/connect.php';

$Database = new Database();
$conn = $Database->connect();

if (isset($_GET['eventList'])) {
    $selectedEventList = $_GET['eventList'];

    // ดึงข้อมูลจากตาราง event โดยเลือกเฉพาะข้อมูลที่ตรงกับ eventList ที่ได้รับมา
    $per = $conn->prepare("SELECT * FROM event WHERE type_name = :type_name");
    $per->bindParam(':type_name', $selectedEventList);
    $per->execute();

    $html = '<div class="p-2">';
    $html .= '<table id="index-event" class="table table table-striped table-hover">';
    $html .= '<thead>';
    $html .= '<tr>';
    $html .= '<th class="align-middle" style="background-color: red;">ลำดับ</th>';
    $html .= '<th class="align-middle" style="background-color: red;">ชื่อ</th>';
    $html .= '<th class="align-middle" style="background-color: red;">นามสกุล</th>';
    $html .= '<th class="align-middle" style="background-color: red;">เพศ</th>';
    $html .= '<th class="align-middle" style="background-color: red;">ชนิดกีฬา</th>';
    $html .= '<th class="align-middle" style="background-color: red;">เคียกผ้า</th>';
    $html .= '<th class="align-middle" style="background-color: red;">รุ่นอายุ</th>';
    $html .= '<th class="align-middle" style="background-color: red;">รุ่นน้ำหนัก</th>';
    $html .= '<th class="align-middle" style="background-color: red;">รูป</th>';
    $html .= '</tr>';
    $html .= '</thead>';
    $html .= '<tbody>';

    $counter = 1;
    if ($per->rowCount() > 0) {
        while ($person = $per->fetch(PDO::FETCH_ASSOC)) {
            $html .= '<tr id="' . $person["id"] . '">';
            $html .= '<td class="align-middle">' . $counter . '</td>';
            $html .= '<td class="align-middle">' . $person["firstname"] . '</td>';
            $html .= '<td class="align-middle">' . $person["lastname"] . '</td>';
            $html .= '<td class="align-middle">' . $person["gender"] . '</td>';
            $html .= '<td class="align-middle">' . $person["type_name"] . '</td>';
            $html .= '<td class="align-middle">' . (!empty($person["kiakpa"]) ? $person["kiakpa"] : '-') . '</td>';
            $html .= '<td class="align-middle">' . $person["age_group"] . '</td>';
            $html .= '<td class="align-middle">' . $person["weight"] . '</td>';
            $html .= '<td class="align-middle">';
            $html .= ($person["image"] && file_exists("../../service/tksuploads/" . $person["image"])) ?
                '<img src="../../service/tksuploads/' . $person["image"] . '" alt="Profile" style="max-width: 50px;">' :
                '<img src="../../assets/images/avatar.png" alt="Profile" style="max-width: 50px;">';
            $html .= '</td>';
            $html .= '</tr>';
            $counter++;
        }
    } else {
        $html .= '<tr><td colspan="8">ยังไม่มีข้อมูล</td></tr>';
    }

    $html .= '</tbody>';
    $html .= '</table>';
    $html .= '</div>';

    echo $html;
}
