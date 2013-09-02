<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Equipos extends CI_Controller {
	
    function __construct() {
        parent::__construct();
		$this->load->library('form_validation');
		$this->load->helper(array('form','url','codegen_helper','settings'));
		$this->load->model('panel/crm/equipos_model');
		$this->load->model('panel/sec/users_model');
		$this->load->model('panel/auth/mysecurity');
		$this->mysecurity->verifysecurity('equ');
		$this->conf = load_settings();
		
	}	
	
	function index(){
		$this->manage();
	}
	
	function manage()
	{
		
		$this->load->library('table');
        $this->load->library('pagination'); 
		
        //paging
        $config['base_url'] = base_url().'panel/crm/sucursales/manage/';
        	
        // make sure to put the primarykey first when selecting , 
		//eg. 'userID,name as Name , lastname as Last_Name' , Name and Last_Name will be use as table header.
		// Last_Name will be converted into Last Name using humanize() function, under inflector helper of the CI core.
		
		$this->data['supervisor'] = $this->users_model->get_supervisor_vendedor($this->conf['supervisor_id']);
		$this->data['vendedor'] = $this->users_model->get_supervisor_vendedor($this->conf['vendedor_id']);
		$this->data['results'] = null; 
		$this->data['equipo'] = null;	
		
		$this->data["title"] = "Creacion de Equipos";
		$this->data["page_segment"] = "Equipos";
		$this->data["scripts"]=array('plugins/data-tables/jquery.dataTables.js',
                           'plugins/data-tables/DT_bootstrap.js');
		$this->data["father"]="CRM";
		$this->data["custom_error"] = "";
		$this->data["main_content"] = 'panel/crm/equipos_add';
		$this->load->view('panel/panel_template',$this->data);
		
	}
} 
?>