<?php

// Communication Helper
/*
 * I hereby grant DemoChimp LLC a worldwide perpetual license, 
 * free of any ongoing fees, to use, modify, and or distribute 
 * as part of its software these code pieces and files.
 */
	function sendrecoverpass($email)
	{
		$CI =& get_instance();
		$CI->load->database();
		$CI->load->model('panel/auth/users');
		if($CI->users->exist_email($email))
		{
			$configuraciones = load_settings();
			
			$CI->load->library("email");
			$hash = md5(rand(10000000,99999999).time());
			$CI->db->update('sec_users',array("passwordhash_usr" => $hash),"`email_usr` = ".$CI->db->escape($email));
			$CI->email->subject($configuraciones["nombre"] . " - Recuperación de la contraseña");
			
			 
			$CI->email->from($configuraciones["correo"]);
			$CI->email->to($email);
			$data["hash"] = $hash;
			$CI->email->set_mailtype("html");
			$data["email"] = $email;
			$message = $CI->load->view('email/login_recoverpassword_mail', $data, true);
			$CI->email->message($message);
			$CI->email->send();
		}
	}

	function sendwelcomemail($email)
	{
		$CI =& get_instance();
		$CI->load->model('panel/auth/users');	
		if($CI->users->exist_email($email))
		{
			$configuraciones = load_settings();
			
			$CI->load->library("email");
			$CI->email->subject("Bienvenido a " . $configuraciones["nombre"] . " - Detalles de la cuenta");
		
			$CI->email->from($configuraciones["correo"]);
			$CI->email->to($email);
			$CI->email->set_mailtype("html");
			$data["email"] = $email;
			$message = $CI->load->view('email/signup_welcome_mail', $data, true);
			$CI->email->message($message);
			$CI->email->send();	
		}
	}
	
	function sendverificationemail($email)
	{
		$configuraciones = load_settings();
		
		$CI =& get_instance();
		$hash = md5(rand(10000000,99999999).time());
		$CI->load->database();
		$CI->db->update('sec_usersunverify',array("mailverificationhash_usu" => $hash),"`email_usu` = ".$CI->db->escape($email));
		$CI->load->library("email");
		$CI->email->subject("Confirma tu cuenta " .  $configuraciones["nombre"]);			
	
		$CI->email->from($configuraciones["correo"]);
		$CI->email->to($email);
		$CI->email->set_mailtype("html");
		$data["email"] = $email;
		$data["hash"] = $hash;
		$message = $CI->load->view('email/signup_verification_mail', $data, true);
		$CI->email->message($message);
		$CI->email->send();
	}