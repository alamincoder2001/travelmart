<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(dirname(__FILE__) . '/dompdf/autoload.inc.php');
use Dompdf\Dompdf;
class Pdf
{
    function createPDF($html, $filename=''){
        $dompdf = new DOMPDF();
        $dompdf->load_html($html);
        $download=TRUE;
        $paper='A4';
        $orientation='portrait' ;
        $dompdf->set_paper($paper, $orientation);
        $dompdf->render();
        $output = $dompdf->output();
        file_put_contents('uploads/'.$filename.'.pdf', $output);
    }
}
?>