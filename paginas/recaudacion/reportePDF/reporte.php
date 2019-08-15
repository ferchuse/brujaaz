<?php 
    require('../../../vendor/pdf/mpdf.php');
    ob_start();
    require_once ('index.html');
    $plantilla_html = ob_get_clean();
    $plantilla_html .= $_POST['tableData'];
    $mpdf = new mPDF('c','A4','true','utf-8');

    $mpdf->writeHTML($plantilla_html);
    $mpdf->Output('AbonoGeneralUnidades.pdf', 'I');
?>