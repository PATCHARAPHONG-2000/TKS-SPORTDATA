<?php

require_once('../authen.php');
require_once __DIR__ . '../../../assets/MPDF/vendor/autoload.php';

if (isset($_GET['id'])) {
    $ids = explode(',', $_GET['id']);

    $defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
    $fontDirs = $defaultConfig['fontDir'];

    $defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
    $fontData = $defaultFontConfig['fontdata'];

    $mpdf = new \Mpdf\Mpdf([
        'fontDir' => array_merge($fontDirs, [
            __DIR__ . '/tmp',
        ]),
        'format' => [101.6, 152.4],
        'fontdata' => $fontData + [
            'sarabun' => [
                'R' => 'THSarabunNew.ttf',
                'I' => 'THSarabunNew Italic.ttf',
                'B' => 'THSarabunNew Bold.ttf',
                'BI' => 'THSarabunNew BoldItalic.ttf'
            ]
        ],
        'default_font' => 'sarabun'
    ]);

    $mpdf->AddPageByArray([
        'margin-left' => 0,
        'margin-right' => 10,
        'margin-top' => 0,
        'margin-bottom' => 0,
    ]);

    $counter = 0;

    foreach ($ids as $id) {
        $params = array('id' => $id);
        $selectbyidUser = $conn->prepare("SELECT * FROM event WHERE id = :id");
        $selectbyidUser->execute($params);
        $row = $selectbyidUser->fetch(PDO::FETCH_ASSOC);

        $html = ' <div class="mt-4 mb-4 " style="margin: 0; padding: 0; width: 4in; height: 6in; background-color: white;">
                        <img src="../../service/uploads/' . $row['image'] . '" alt="" style="margin-left: 2.1rem; margin-top: 8rem; width: 90px; height: 120px;">
                        <div style="margin-left: 2.1rem; margin-top: 0.2rem; font-size: 1.5rem; width: 25rem; height:auto; font-weight: bold;">
                            <p style="margin: 0;  ">' . $row['firstname'] . ' ' . $row['lastname'] . '</p>
                            <p style="margin: 0; margin-top: -0.5rem; ">' . $row['team'] . '</p>
                            <a style="margin: 0; margin-top: -1.0rem; ">' . $row['age_group'] . '</a>
                        </div>
                    </div>';

        $mpdf->WriteHTML($html);
        $counter++;
    }

    $mpdf->Output("CERTIFICATE.pdf", \Mpdf\Output\Destination::INLINE);
} else {
    echo 'Invalid ID.';
}
