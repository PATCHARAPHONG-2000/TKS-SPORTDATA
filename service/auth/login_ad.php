<?php
header('Content-Type: application/json');
require_once '../connect.php';

$Database = new Database();
$conn = $Database->connect();

function respondError($message) {
    echo json_encode(['error' => $message]);
    exit();
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $users = $_POST["user"];
    $password = $_POST["password"];

    try {
        // Check the role of the user in the users_t table
        $stmt = $conn->prepare("SELECT * FROM users_t WHERE users = :users");
        $stmt->bindParam(':users', $users);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if($user) {
            if(password_verify($password, $user['password'])) {
                // User exists in the users_t table, and the password is correct
                $_SESSION['AD_ID'] = $user['id'];
                $_SESSION['AD_USERNAME'] = $user['users'];
                $_SESSION['AD_ROLE'] = $user['Role'];

                $TW = [
                    'BKK10000', 'SPK10270', 'NBI11000', 'PTE12000', 'NKT26000', 'PJB25000', 'SBW27000', 'CTO24000', 'CHB20000', 'CHT22000', 
                    'RAY21000', 'TRT23000', 'SSE75000', 'SMK74000', 'KBI71000', 'SPB72000', 'CNT17000', 'UTI61000', 'SBR16000', 'LRI15000', 
                    'SRI18000', 'AGT14000', 'AYA13000', 'NPT73000', 'RBR70000', 'PBI76000', 'PKN77000', 'NMA30000', 'BRM31000', 'SRN32000', 
                    'SSK33000', 'UBN34000', 'CPM36000', 'KKN40000', 'MSN44000', 'RET45000', 'YSR35000', 'ACN37000', 'MKN49000', 'KKN46000', 
                    'LEY42000', 'NBL38000', 'UDN41000', 'SKR47000', 'NMP48000', 'NKH43000', 'BKK96000', 'CPN86000', 'RNG85000', 'SRT84000', 
                    'PNA82000', 'KBI81000', 'PKT83000', 'NST80000', 'TRG92000', 'PLG93000', 'STN91000', 'SKA90000', 'PTN94000', 'YLA95000', 
                    'NRT96000', 'CGY50000', 'LPN51000', 'LPG52000', 'UTD53000', 'PRE54000', 'NAN55000', 'PYO56000', 'CRI57000', 'MHS58000', 
                    'NWS60000', 'KGC62000', 'TAK63000', 'SKT64000', 'PHS65000', 'PCT66000', 'PBR67000',
                ];


                $kkt = [
                    'KKTP1',
                    'KKTP2',
                    'KKTP3',
                    'KKTP4',
                    'KKTP5',
                ];
                $SP = [
                    'SPGOLF','SPARCH','SPFTBL','SPFUTS','SPVOLYB','SPTEKB','SPTENN','SPWMNG','SPSTEN','SPTENI','SPBDMT','SPBASK','SPTKWD','SPKADO','SPJUDO',
                    'SPBRDG','SPSILT','SPAERB','SPCHSS','SPBILR','SPPTNQ','SPESPT','SPKABD','SPWDBL','SPABXN','SPMUTH','SPVOLY','SPHNDL','SPWREST','SPYCHT',
                    'SPJUDO','SPCYCL','SPWTLF','SPARCH','SPROWG','SPHCKY','SPRUGB','SPFENC','SPMOTC','SPJTSK','SPROLS','SPGYMN','SPFGRS','SPEXTR','SPTRAT','SPDRAU','SPKCKB',
                ];
                
                $TWD = in_array($user['users'], $TW);
                $SPO = in_array($user['Role'], $SP);
                $KKTP = in_array($user['Role'], $kkt);

                if($_SESSION['AD_ROLE'] == 'superadmin') {
                    $_SESSION['id_city'] = [
                        'province' => $user['province'],
                        'users' => $user['users'],
                        'area' => $user['area'],
                    ];
                    echo json_encode([
                        'status' => true,
                        'users' => 'userad',
                        'role' => 'superadmin',
                        'province' => $_SESSION['id_city']['province'],
                        'message' => 'Admin Login Success'
                    ]);
                    exit();
                } else if($TWD) {
                    $_SESSION['id_city'] = [
                        'province' => $user['province'],
                        'users' => $user['users'],
                        'area' => $user['area'],
                    ];

                    echo json_encode([
                        'status' => true,
                        'users' => 'userad',
                        'role' => 'userad',
                        'province' => $_SESSION['id_city']['province'],
                        'message' => 'Admin Login Success'
                    ]);
                    exit();
                } else if($KKTP) {
                    $_SESSION['id_city'] = [
                        'province' => $user['province'],
                        'users' => $user['users'],
                        'area' => $user['area'],
                    ];

                    echo json_encode([
                        'status' => true,
                        'users' => 'userad',
                        'role' => 'users',
                        'province' => $_SESSION['id_city']['province'],
                        'message' => 'Admin Login Success'
                    ]);
                    exit();
                } else if($SPO) {
                    $_SESSION['id_city'] = [
                        'province' => $user['province'],
                    ];

                    echo json_encode([
                        'status' => true,
                        'users' => 'sport',
                        'role' => 'sport',
                        'province' => $_SESSION['id_city']['province'],
                        'message' => 'Admin Login Success'
                    ]);
                    exit();
                } else {
                    respondError('ไม่มีสิทธิ์เข้าใช้งาน');
                }
            } else {
                respondError('Incorrect password');
            }
        } else {
            respondError('ไม่มี Username นี้ในระบบ');
        }
    } catch (PDOException $e) {
        respondError("An error occurred. Please try again later.");
    }
}
?>