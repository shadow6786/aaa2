<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Productos extends CI_Controller {

	public function index()
	{
		$this->data = array(
						"main_content"=> "public/productos",
						"showslider" =>false,
						"scripts" => null
					);
		$this->load->view('templates/basic_template',$this->data);
	}

}

/* End of file productos.php */
/* Location: .//C/wamp/www/aaa/app/controllers/web/productos.php */