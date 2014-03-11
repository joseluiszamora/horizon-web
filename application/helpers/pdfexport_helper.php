<?php

/*
 * Subject          : Export pdf using dompdf
 * Author           : Sanjay
 * Version          : CodeIgniter_2.0.3
 * Warning         : Any change in this file may cause abnormal behaviour of application.
 *
 */

if (!function_exists('exportMeAsDOMPDF')) {

    function exportMeAsDOMPDF($htmView, $fileName) {

        $CI = & get_instance();
        $CI->load->helper(array('dompdf', 'file'));
        $CI->load->helper('file');
        $pdfName = $fileName;
        $pdfData = pdf_create($htmView, $pdfName);
        write_file('ProgressRepost', $pdfData);
    }

}