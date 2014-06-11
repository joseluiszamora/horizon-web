<?php
	$this->load->view('liquidation/header_pdf_1');
	$this->load->view($category."/".$page);
	$this->load->view('liquidation/footer_pdf');
?>