<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Nosotros extends CI_Controller {

	public function index()
	{
		$this->data = array(
						"main_content"=> "public/nosotros",
						"showslider" => false,
						"scripts" => null,
						"css" => array("css/compiled/basic.css")
					);
		$this->load->view('templates/basic_template',$this->data);
	}

}

/* End of file nuestra-empresa */
/* Location: .//C/wamp/www/aaa/app/controllers/web/nuestra-empresa */