<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Change_password extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('panel/auth/users');
		$this->load->model('panel/auth/mysecurity');
	}	
	
	function index()
	{
	    $user = $this->users->getuser(array("passwordhash_usr" => $this->input->get("x")));
		$user = $user[0];
		
	    $this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div  class="alert-error">', '</div>');
		$this->form_validation->set_rules('password', 'Contraseña', 'trim|required|xss_clean|min_length[6]|alpha_numeric|callback_password_check|max_length[30]');
		$this->form_validation->set_rules('rpassword', 'Re-Ingreso Contraseña', 'trim|required|xss_clean|matches[password]');

		$err = '';	
		if($this->form_validation->run() == FALSE)
		{
			if ($user){
			 $data['main_content'] = 'panel/auth/auth_recoverpass_form';
			 $data['scripts'] = '';
			 $data['err'] = $err;
			 $this->load->view('panel/panel_login',$data);	
			}else{
			 $data['main_content'] = 'panel/auth/auth_reset_password';
			 $data['scripts'] = '';
			 $data['err'] = $err;
			 $this->load->view('panel/panel_login',$data);
			}	
		}
		else
		{
			if($user)
			{
				$data['main_content'] = 'panel/auth/auth_password_recovered_successful';
			 	$data['scripts'] = '';
			 	$data['err'] = $err;
			 	$this->load->view('panel/panel_login',$data);
				$this->mysecurity->password_reset($user, $this->input->post("password"));
			} else {
				redirect("panel/auth/login");
			}
		}
	}
 }
?>