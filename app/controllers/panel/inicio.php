<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inicio extends Admin_controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('panel/auth/mysecurity');
		$this->mysecurity->verifysecurity('inicio');
	}

	public function index()
	{
		$data = array(
						"main_content"=> "panel/inicio",
						"scripts" => null,
						"title" => "Inicio"
					);
		$this->load->view('templates/basic_panel',$data);
	}

}

