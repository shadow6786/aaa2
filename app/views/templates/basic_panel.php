<?php
	$this->load->view("templates/panel/basic_metas");
	$this->load->view("templates/panel/basic_top");
	$this->load->view("templates/panel/basic_title");
	$this->load->view("templates/panel/basic_sidebar");
	$this->load->view($main_content);
	$this->load->view("templates/panel/basic_footer");
	$this->load->view('templates/public/extra_scripts', $scripts);