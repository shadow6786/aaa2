<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	function __construct()
 	{
		parent::__construct();
		$this->load->model('panel/auth/users');
		$this->load->model('panel/auth/mysecurity');

		$this->data["title"] = "Dashboard";
		$this->data["page_segment"] = "Dashboard";
		$this->data["father"]="";
		
		$this->load->model('panel/auth/mysecurity');
		$this->mysecurity->verifysecurity('welcome');
	}
	
	function index()
	{
		//$this->data["menu"] = $this->mysecurity->getmymenu();
		$user_id = $this->session->userdata('id_usr');
		$this->data['roles'] =$this->mysecurity->getmyroles();
		$user = $this->users->getuser(array("id_usr" => $user_id));
		$this->data['sec'] = $this->session->userdata('userfeatures');
		
		$this->data['user'] =  $user[0];
		$this->data["main_content"] = 'panel/welcome';
		$this->load->view('panel/panel_template', $this->data);
	}
}