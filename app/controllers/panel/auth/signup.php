<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Signup extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('panel/auth/users');
		$this->load->helper("communication");
	}	
	
	function index()
	{
	   $this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div  class="alert-error">', '</div>');
		$this->form_validation->set_rules('password', 'Contraseña', 'trim|required|xss_clean|min_length[6]|alpha_numeric|callback_password_check|max_length[30]');
		$this->form_validation->set_rules('rpassword', 'Re-ingresa contraseña', 'trim|required|xss_clean|matches[password]');
		$this->form_validation->set_rules('email', 'Correo electrónico', 'trim|required|xss_clean|valid_email');
		$this->form_validation->set_rules('tnc', 'Términos y políticas', 'required');
		$err = '';	
		if($this->form_validation->run() == FALSE)
		{			
			 $data['main_content'] = 'panel/auth/auth_signup';
			 $data['scripts'] = '';
			 $data['err'] = $err;
			 $this->load->view('panel/panel_login',$data);		
		}
		else
		{
			if (!$this->existemail($this->input->post('email',TRUE)))
			{
				$data = array(
								"email" => $this->input->post('email'),
								"password" => $this->input->post('password')
							 );
				$this->session->set_userdata($data);
				
			 if (!$this->users->exist_verifyemail($this->input->post('email',TRUE))){
			   	redirect('panel/auth/signup2');
			 }else{
		       sendverificationemail($this->input->post('email'));
			   redirect('panel/auth/signup3');
		     }	
			}else{
			 $data['main_content'] = 'panel/auth/auth_login';
			 $data['scripts'] = '';
			 $data['err'] = "Este email <b>'".$this->input->post('email')."'</b> se encuentra ya regsitrado en nuestra base de datos; utiliza la opción de resetear contraseña.";
			 $this->load->view('panel/panel_login',$data);
			}
		}
	}
	private function existemail($email)
	{
		if($this->users->exist_email($email))
		{
			return "Este email ya está tomado.";
		}
		else
			return false;
	}
 }
?>