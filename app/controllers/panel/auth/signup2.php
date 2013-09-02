<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Signup2 extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('panel/auth/users');
		$this->load->helper("communication");
	}	
	
	function index()
	{
	    $this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div  class="alert-error">', '</div>');
		//$this->form_validation->set_rules('organization', 'Organization Name', 'required|xss_clean|min_length[3]');
		$this->form_validation->set_rules('captcha', "Captcha", 'trim|required|callback_verify_captcha');
		$this->form_validation->set_rules('firstname', "First Name", 'trim|required|xss_clean');
		$this->form_validation->set_rules('lastname', "Last Name", 'trim|required|xss_clean');
		$this->form_validation->set_rules('phone', "Phone", 'trim|xss_clean');
		//$this->form_validation->set_rules('reason', "Reason", 'trim|xss_clean');
		//$this->form_validation->set_rules('other', "Other", 'trim|xss_clean');
		//$this->form_validation->set_rules('companysize', "Companysize", 'trim|xss_clean');
		
			
		if($this->form_validation->run() == FALSE)
		{
			 $data["captcha"] = $this->set_captcha();			
			 $data['main_content'] = 'panel/auth/auth_signup2';
			 $data['scripts'] = '';
			 $data['err'] = '';
			 $this->load->view('panel/panel_login',$data);		
		}
		else
		{
		 if($this->input->post("reason") == "Other")
			{
				$reason = "Other - ".$this->input->post("other");
			} else {
				$reason = $this->input->post("reason");
			}
			$email = $this->session->userdata("email");
			$data = array(
		 	 				"email_usu" => $email,
		 	 				"password_usu" => $this->mysecurity->passwordencrypt($this->session->userdata("password")),
		 	 				//"company_usu" => $this->input->post("organization"),
		 	 				"fname_usu" => $this->input->post("firstname"),
		 	 				"lname_usu" => $this->input->post("lastname"),
		 	 				"phone_usu" => $this->input->post("phone"),
		 	 				//"reasonsignup_usu" => $reason,
		 	 				//"companysize_usu" => $this->input->post("companysize"),
		 	 				"ip_usu" => $_SERVER["REMOTE_ADDR"],
		 	 				"createdon_usu" => date("Y-m-d H:i:s")
			 );
			 
			$this->load->model("users");
			$this->users->createuserunverified($data);

			sendverificationemail($email);			
			redirect('panel/auth/signup3');	
		}
	}
    private function set_captcha()
	{
		$this->load->helper('captcha');
		$this->load->helper('string');
		$str = random_string('alnum', 6);
		$str = strtoupper($str);
		$var = array(
			'word'	 =>  $str,
			'img_path'	 => './static/img/captcha/',
			'img_url'	 => base_url().'static/img/captcha/',
			'font_path'	 => base_url().'static/fonts/segoesc.ttf',
			'img_width'	 => '150',
			'img_height' => 35,
			'expiration' => 7200
			);
		$cap = create_captcha($var);
		$this->session->set_userdata('captcha', $str);
		return $cap['image'];
	}
	
 }
?>