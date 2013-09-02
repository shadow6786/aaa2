<?php
	$this -> load -> view('templates/public/basic_top');
	$this -> load -> view('templates/public/basic_logo');
	$this -> load -> view('templates/public/basic_menu');
	if($showslider == TRUE)
		$this -> load -> view('templates/public/basic_slider');
	
	$this -> load -> view('templates/public/basic_content');
	$this -> load -> view($main_content);
	$this -> load -> view('templates/public/basic_endcontent');
	$this -> load -> view('templates/public/basic_footer');
	$this -> load -> view('templates/public/basic_endpage');
	$this -> load -> view('templates/public/basic_palett');
  	$this -> load -> view('templates/public/extra_scripts', $scripts);
?>