<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inicio extends CI_Controller {

	public function index()
	{
		$data = array(
						"main_content"=> "panel/inicio",
						"scripts" => null
					);
		$this->load->view('templates/basic_panel',$data);
	}

}

