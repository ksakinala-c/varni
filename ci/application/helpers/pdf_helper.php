<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function pdf_create($html, $filename='file', $stream=true) {
    # dompdf should be within composer autoload path, with autoload files for
    # dompdf_config.inc.php also
    
    $dompdf = new DOMPDF();
    $dompdf->load_html($html);
    $dompdf->render();
    if ($stream) {
        $dompdf->stream($filename .".pdf", array("Attachment" => false));
    } else {
        return $dompdf->output();
    }
}
