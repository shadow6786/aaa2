<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Signup3 extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('panel/auth/users');
	}	
	
	function index()
	{
	    $data['main_content'] = 'panel/auth/auth_signup3';
		$data['scripts'] = '';
		$data['err'] = '';
		$this->load->view('panel/panel_login',$data);		
		
	}
 }
?>