<?php

class Gns_ajax extends CI_Controller {
  
	function __construct() {
		parent::__construct();
        $this->load->database();
		if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
		{
			$this->isAjax = true;
		}
		else
		{
			$this->isAjax = false;
		}
		if(!$this->isAjax)
		{
			show_404();
			exit;
		}
  	}
	
	function get_ciudades($depar)
	{
		$this->load->model('panel/crm/ciudades_model');
		$ret = $this->ciudades_model->get_ciudades_departamentos($depar);
		if ($ret){
			echo json_encode($ret);
		}else{
			echo 0;
		}
	}
	function get_sucursales($empre)
	{
		$this->load->model('panel/crm/sucursales_model');
		$ret = $this->sucursales_model->get_sucursales_empresas($empre);
		if ($ret){
			echo json_encode($ret);
		}else{
			echo 0;
		}
	}
	function add_vendedor_equipo()
	{
		$this->load->library('table');
        $this->load->library('pagination');
		
		$this->load->model('panel/crm/equipos_model');
		$dato = array(
					"supervisor_equ" => $this->input->post('sup'),
					"vendedor_equ" => $this->input->post('ven')
		);
		$this->equipos_model->add_vendedor_equipo($dato);
		
		$data['results'] = $this->equipos_model->get_equipo_supervisor($this->input->post('sup'));
		$this->load->view('panel/crm/equipo_lista',$data);
	}
	function list_vendedor_equipo()
	{
		$this->load->model('panel/crm/equipos_model');
		//$this->equipos_model->add_vendedor_equipo($dato);
		
		$data['results'] = $this->equipos_model->get_equipo_supervisor($this->input->post('sup'));
		$this->load->view('panel/crm/equipo_lista',$data);
	}
	function delete_vendedor_equipo()
	{
		$this->load->model('panel/crm/equipos_model');
	    if ($this->equipos_model->delete_vendedor_equipo($this->input->post('ide')))
		{
			echo "El registro fue eliminado correctamente";
		}else{
			echo "Error de base de datos";
		}
	}
}