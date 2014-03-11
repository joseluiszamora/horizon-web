<?php
	$this->load->view('template/header_pdf');
	$this->load->view($category."/".$page);
	$this->load->view('template/footer_pdf');
?>
