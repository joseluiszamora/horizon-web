<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
function pdf_create($html, $filename='', $stream=TRUE)
{
    ini_set('memory_limit', '-1');

    require_once("dompdf/dompdf_config.inc.php");

    $dompdf = new DOMPDF();
    $dompdf->load_html($html);
    $dompdf->set_paper("letter", "landscape");
    $dompdf->render();

    $canvas = $dompdf->get_canvas();
    $font = Font_Metrics::get_font("helvetica", "bold");

    // set page footer date time
    date_default_timezone_set("America/La_Paz");
    $week_days = array ("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado");
    $months = array ("", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
    $year_now = date ("Y");
    $month_now = date ("n");
    $day_now = date ("j");
    $week_day_now = date ("w");
    $date = $day_now . " de " . $months[$month_now] . " de " . $year_now;

    $canvas->page_text(50, 585, "Pagina {PAGE_NUM} de {PAGE_COUNT}"."      ".$date."  ".date('H:i'), $font, 6, array(0,0,0));

    if ($stream) {
        $dompdf->stream($filename.".pdf");
    } else {
        return $dompdf->output();
    }
}
?>