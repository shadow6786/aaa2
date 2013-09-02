<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('panel/auth/mysecurity');
	}
	
	function index()
	{
		$this->load->library('form_validation');
		
		$this->form_validation->set_error_delimiters('<div  class="alert-error">', '</div>');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
		$err = '';	
		
		if ($this -> input -> get("e") == 1) {
		
			$err = "No tienes permisos para acceder a esta página, contáctate con el Administrador";
		}
		if ($this -> input -> get("e") == 2) {
		
			$err = "No tienes permisos para acceder a esta página, contáctate con el Administrador";
		}

		if ($this -> input -> get("e") == 3) {
			
			$err = "No tienes una sesión iniciada. Por favo logueate para poder acceder.";
		}

		if ($this -> input -> get("e") == 4) {
			
			$err = "Tu cuenta está deshabilitada, por favor contáctate con el Administrador para obtener mayor información.";
		}

		if($this->form_validation->run() == FALSE)
		{
			$data['main_content'] = 'panel/auth/login';
			$data['scripts'] = '';
			$data['err'] = $err;
			$this->load->view('templates/basic_login',$data);	
		} else {
			$data = array(
			'email'=> $this->input->post('email',TRUE),
				'password' => $this->input->post('password',TRUE)
			);
			if (!$this->mysecurity->login($data)){
				$data['err'] = 'Nombre de Usuarios y/o constraseña es incorrecto';
				$data['main_content'] = 'panel/auth/login';
				$data['scripts'] = '';
				$this->load->view('templates/basic_login',$data);
		  	}  
		}
	}
}

?>