<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Verify extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('panel/auth/users');
	}
	function index()
	{
	  $data['res'] = $this->users->verifyemail($this->input->get("x"));
	  $data['main_content'] = 'panel/auth/auth_signup4';
	  $data['scripts'] = '';
	  $data['err'] = '';
      $this->load->view('panel/panel_login',$data);	
	}	
}