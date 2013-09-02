<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('panel/auth/mysecurity');
	}
	
	function index()
	{
		$this->mysecurity->logout();
	}

}

?>