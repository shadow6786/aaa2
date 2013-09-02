<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contacto extends CI_Controller {

	public function index()
	{
		$this->data = array(
						"main_content"=> "public/contacto",
						"showslider" =>false,
						"scripts" => null
					);
		$this->load->view('templates/basic_template',$this->data);
	}

}

/* End of file contacto.php */
/* Location: .//C/wamp/www/aaa/app/controllers/web/contacto.php */