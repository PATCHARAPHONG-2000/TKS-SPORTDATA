<?php
require_once('../../service/connect.php');
require_once '../../assets/phpspreadsheet/vendor/autoload.php';

$Database = new Database();
$conn = $Database->connect();

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// ดึงข้อมูลจากฐานข้อมูล
$sql = "SELECT * FROM event";
$result = $conn->query($sql);

// สร้าง Spreadsheet object
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// เพิ่มหัวตาราง
$sheet->setCellValue('A1', 'ลำดับ');
$sheet->setCellValue('B1', 'ชื่อแมตท์');
$sheet->setCellValue('C1', 'ID Number');
$sheet->setCellValue('D1', 'ชื่อ');
$sheet->setCellValue('E1', 'นามสกุล');
$sheet->setCellValue('F1', 'อายุ');
$sheet->setCellValue('G1', 'ทีม');
$sheet->setCellValue('H1', 'license');
$sheet->setCellValue('I1', 'ชนิดกีฬา');
$sheet->setCellValue('J1', 'รุ่นอายุ');
$sheet->setCellValue('K1', 'ประเภทเคียกผ้า');
$sheet->setCellValue('L1', 'เพศ');
$sheet->setCellValue('M1', 'คลาส');
$sheet->setCellValue('N1', 'รุ่นน้ำหนัก');
$sheet->setCellValue('O1', 'สายสี');
$sheet->setCellValue('P1', 'แพทเทริน');

// เพิ่มข้อมูลจากฐานข้อมูล
$row = 2; // เริ่มต้นที่แถวที่ 2 เพราะแถวที่ 1 เป็นหัวตาราง
while ($row_data = $result->fetch(PDO::FETCH_ASSOC)) {
    $column = 1;
    foreach ($row_data as $key => $value) {
        if ($key !== 'image') { // ตรวจสอบว่าชื่อคอลัมน์ไม่ใช่ "รูป" หรือ "image"
            $sheet->setCellValueByColumnAndRow($column, $row, $value);
            $column++;
        }
    }
    $row++;
}

// กำหนดชื่อไฟล์ Excel
$filename = 'FILE.xlsx';

// กำหนด header สำหรับการดาวน์โหลดไฟล์ Excel
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

// ใช้ Writer เพื่อบันทึก Spreadsheet เป็นไฟล์ Excel
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
