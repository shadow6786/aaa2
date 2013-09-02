<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Recover_password extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->helper("communication");
		$this->load->model('panel/auth/mysecurity');
	}	
	
	function index()
	{
	    $this->load->library('form_validation');
		
		$this->form_validation->set_error_delimiters('<div  class="alert-error">', '</div>');
		$this->form_validation->set_rules('email', 'Email', 'required|trim|xss_clean');
		$err = '';
		if($this->form_validation->run() == FALSE)
		{
			$data['main_content'] = 'panel/auth/auth_reset_password';
			$data['scripts'] = '';
			$data['err'] = $err;
			$this->load->view('panel/panel_login',$data);
		}
		else
		{
			$email = $this->input->post("email");
			sendrecoverpass($email);
			$data['main_content'] = 'panel/auth/auth_password_recovered';
			$data['scripts'] = '';
			$data['err'] = '';
			$this->load->view('panel/panel_login',$data);
		}
	}
 }
?>