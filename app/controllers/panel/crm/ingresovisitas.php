<?php

class IngresoVisitas extends CI_Controller {
    
    function __construct() {
        parent::__construct();
		$this->load->library('form_validation');
		$this->load->helper(array('form','url','codegen_helper','invertir_fecha'));
		$this->load->model('panel/crm/visitas_model','',TRUE);
		$this->load->model('panel/auth/mysecurity');
		$this->mysecurity->verifysecurity('ingresovis');
		
	}	
	
	function index(){
		$this->manage_usuario();
	}


	
	function manage_usuario(){
        $this->load->library('table');
        $this->load->library('pagination');
        
        //paging
        $config['base_url'] = base_url().'panel/crm/ingresovisitas/manage_usuario/';
        	
        // make sure to put the primarykey first when selecting , 
		//eg. 'userID,name as Name , lastname as Last_Name' , Name and Last_Name will be use as table header.
		// Last_Name will be converted into Last Name using humanize() function, under inflector helper of the CI core.
			
	    $this->data['results'] = $this->visitas_model->get_vistas_usuario($this->session->userdata('id_usr'));   
		$this->data["title"] = "Ingreso Visitas";
		$this->data["page_segment"] = "Ingreso Visitas";
		$this->data["scripts"]=array('plugins/data-tables/jquery.dataTables.js',
                           'plugins/data-tables/DT_bootstrap.js');
		$this->data["father"]="CRM";
		$this->data["main_content"] = 'panel/crm/visitas_usuario_list';
		$this->load->view('panel/panel_template',$this->data);
    }
	function addv(){        
        $this->load->library('form_validation');
		$this->data['custom_error'] = '';
		$this->form_validation->set_rules('fecha_vst','Fecha','required|trim|xss_clean');
		$this->form_validation->set_rules('horai_vst','Hora inicio','trim|xss_clean');
		$this->form_validation->set_rules('horaf_vst','Hora fin','trim|xss_clean');
		$this->form_validation->set_rules('persona_vst','Persona','trim|xss_clean');
		$this->form_validation->set_rules('resultado_vst','Comentario visita','trim|xss_clean');
		$this->form_validation->set_rules('proximafecha_vst','Próxima visita','trim|xss_clean');
		$this->form_validation->set_rules('empresa_vst','Empresa','trim|xss_clean');
		$this->form_validation->set_rules('sucursal_vst','Sucursal','trim|xss_clean');
		$this->form_validation->set_rules('clasificacion_vst','Clasificación visita','trim|xss_clean');
		$this->form_validation->set_rules('activo_vst','Activo','required|trim|xss_clean');

        if ($this->form_validation->run() == false)
        {
             $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">'.validation_errors().'</div>' : false);
        }
        else
        {                            
            $data = array(
                    'fecha_vst' => invierte_fecha_mysql(set_value('fecha_vst')),
					'horai_vst' => set_value('horai_vst'),
					'horaf_vst' => set_value('horaf_vst'),
					'persona_vst' => set_value('persona_vst'),
					'resultado_vst' => set_value('resultado_vst'),
					'proximafecha_vst' => invierte_fecha_mysql(set_value('proximafecha_vst')),
					'empresa_vst' => set_value('empresa_vst'),
					'sucursal_vst' => set_value('sucursal_vst'),
					'clasificacion_vst' => set_value('clasificacion_vst'),
					'activo_vst' => set_value('activo_vst')
            );
			$data['usuario_vst'] = $this->session->userdata('id_usr');
			
			if ($this->visitas_model->add($data) == TRUE)
			{
				//$this->data['custom_error'] = '<div class="form_ok"><p>Added</p></div>';
				// or redirect
				redirect(base_url().'panel/crm/ingresovisitas/manage_usuario/');
			}
			else
			{
				$this->data['custom_error'] = '<div class="form_error"><p>An Error Occured.</p></div>';
			}
		}
		
		$this->load->model('panel/crm/empresas_model');	
		//$this->load->model('panel/crm/sucursales_model');	
		$this->load->model('panel/crm/clasificaciones_model');	

		$this->data['empresas'] = $this->empresas_model->get_empresas_combo('id_emp,nombre_emp','');	
		//$this->data['sucursales'] = $this->sucursales_model->get_sucursales_combo('id_suc,nombre_suc','');	
		$this->data['clasificaciones'] = $this->clasificaciones_model->get_clasificaciones_combo('id_cla,nombre_cla','');	

		$this->data["title"] = "Ingreso Visitas";
		$this->data["page_segment"] = "Ingreso Visitas";
		$this->data["scripts"]=array('plugins/bootstrap/js/bootstrap.js',
		                             'plugins/bootstrap-datepicker/js/bootstrap-datepicker.js',
									 'plugins/bootstrap-timepicker/js/bootstrap-datetimepicker.min.js');
		$this->data["father"]="CRM";
		$this->data["main_content"] = 'panel/crm/visitas_usuario_add';
		$this->load->view('panel/panel_template',$this->data);
    }
    function editv($id){        
        $this->load->library('form_validation');
		$this->data['custom_error'] = '';
		$this->form_validation->set_rules('fecha_vst','Fecha','required|trim|xss_clean');
		$this->form_validation->set_rules('horai_vst','Hora inicio','trim|xss_clean');
		$this->form_validation->set_rules('horaf_vst','Hora fin','trim|xss_clean');
		$this->form_validation->set_rules('persona_vst','Persona','trim|xss_clean');
		$this->form_validation->set_rules('resultado_vst','Comentario visita','trim|xss_clean');
		$this->form_validation->set_rules('proximafecha_vst','Próxima visita','rtrim|xss_clean');
		$this->form_validation->set_rules('empresa_vst','Empresa','trim|xss_clean');
		$this->form_validation->set_rules('sucursal_vst','Sucursal','trim|xss_clean');
		$this->form_validation->set_rules('clasificacion_vst','Clasificación visita','trim|xss_clean');
		//$this->form_validation->set_rules('activo_vst','Activo','trim|xss_clean');

        if ($this->form_validation->run() == false)
        {
             $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">'.validation_errors().'</div>' : false);
        }
        else
        {                            
            $data = array(
                    'fecha_vst' => invierte_fecha_mysql($this->input->post('fecha_vst')),
					'horai_vst' => $this->input->post('horai_vst'),
					'horaf_vst' => $this->input->post('horaf_vst'),
					'persona_vst' => $this->input->post('persona_vst'),
					'resultado_vst' => $this->input->post('resultado_vst'),
					'proximafecha_vst' => invierte_fecha_mysql($this->input->post('proximafecha_vst')),
					'empresa_vst' => $this->input->post('empresa_vst'),
					'sucursal_vst' => $this->input->post('sucursal_vst'),
					'clasificacion_vst' => $this->input->post('clasificacion_vst'),
					//'activo_vst' => $this->input->post('activo_vst')
            );
			if ($this->visitas_model->edit($data,'id_vst',$this->input->post('id_vst')) == TRUE)
			{
				redirect(base_url().'panel/crm/ingresovisitas/manage_usuario/');
			}
			else
			{
				$this->data['custom_error'] = '<div class="form_error"><p>An Error Occured</p></div>';

			}
		}
        
        $result = $this->visitas_model->get('id_vst,usuario_vst,fecha_vst,horai_vst,horaf_vst,persona_vst,resultado_vst,proximafecha_vst,empresa_vst,sucursal_vst,clasificacion_vst,activo_vst','id_vst = '.$id,1,0,true);
		
		$this->load->model('panel/cms/users_model');
		$this->load->model('panel/crm/empresas_model');	
		$this->load->model('panel/crm/sucursales_model');	
		$this->load->model('panel/crm/clasificaciones_model');	
		
        $this->data['empresas'] = $this->empresas_model->get_empresas_combo('id_emp,nombre_emp','');
		$this->data['users'] = $this->users_model->get("id_usr,CONCAT(fname_usr,' ',lname_usr) AS usuario",'',1000,$this->uri->segment(4));	
		$this->data['sucursales'] = $this->sucursales_model->get_sucursales_empresas($result->empresa_vst);	
		$this->data['clasificaciones'] = $this->clasificaciones_model->get_clasificaciones_combo('id_cla,nombre_cla','');
		$this->data['result'] = $result;
        
		$this->data["title"] = "Ingreso Visitas";
		$this->data["page_segment"] = "Ingreso Visitas";
		$this->data["scripts"]=array('plugins/bootstrap/js/bootstrap.js',
		                             'plugins/bootstrap-datepicker/js/bootstrap-datepicker.js',
									 'plugins/bootstrap-timepicker/js/bootstrap-datetimepicker.min.js');
		//$this->data["scripts"]=array('plugins/data-tables/jquery.dataTables.js','plugins/data-tables/DT_bootstrap.js');
		$this->data["father"]="CRM";
		$this->data["main_content"] = 'panel/crm/visitas_usuario_edit';
		$this->load->view('panel/panel_template',$this->data);
    }
   function deletev($id){
            //$ID =  $this->uri->segment(4);
            $this->visitas_model->update_activo('id_vst',$id);
			redirect(base_url().'panel/crm/ingresovisitas/manage_usuario');
    }	
}

/* End of file visitas.php */
/* Location: ./system/application/controllers/visitas.php */