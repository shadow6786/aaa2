<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends CI_Controller {
		
	public function index()
	{
		$this->data = array(
						"main_content"=> "public/home",
						"showslider" => true,
						"scripts" => null
					);
		$this->load->view('templates/basic_template',$this->data);
	}
}