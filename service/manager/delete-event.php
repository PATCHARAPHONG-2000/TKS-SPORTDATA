<?php
header('Content-Type: application/json');
require_once '../connect.php';

$Database = new Database();
$conn = $Database->connect();

function respondError($message)
{
    echo json_encode(['error' => $message]);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['ids']) && !empty($_POST['ids'])) {
        $ids = $_POST['ids'];
        $idsArray = is_array($ids) ? $ids : explode(',', $ids);

        if (!empty($idsArray)) {
            // Prepare SQL statement to select license from event table
            $sql = "SELECT license FROM event WHERE id IN (" . implode(',', array_fill(0, count($idsArray), '?')) . ")";
            $stmt = $conn->prepare($sql);
            $stmt->execute($idsArray);
            $eventLicenses = $stmt->fetchAll(PDO::FETCH_COLUMN);

            // Delete events
            $placeholders = rtrim(str_repeat('?,', count($idsArray)), ',');
            $deleteSql = "DELETE FROM event WHERE id IN ($placeholders)";
            $deleteStmt = $conn->prepare($deleteSql);
            $deleteStmt->execute($idsArray);

            if ($deleteStmt->rowCount() === 0) {
                respondError('Error deleting event records');
            }

            // Update players
            foreach ($eventLicenses as $license) {
                // Prepare SQL statement to update IsActive in player table
                $updateSql = "UPDATE player SET IsActive = 0 WHERE license = ?";
                $updateStmt = $conn->prepare($updateSql);
                $updateStmt->execute([$license]);

                // Check if the update was successful
                if ($updateStmt->rowCount() === 0) {
                    respondError('Error updating IsActive column in player table');
                }
            }

            echo json_encode([
                'status' => true,
                'message' => 'Delete and update successful'
            ]);
            exit();
        } else {
            respondError('No ids provided');
        }
    } else {
        respondError('No ids provided');
    }
} else {
    respondError('Invalid request method');
}
