<?php

class Sucursales extends CI_Controller {
    
    function __construct() {
        parent::__construct();
		$this->load->library('form_validation');
		$this->load->helper(array('form','url','codegen_helper','settings'));
		$this->load->model('panel/crm/sucursales_model','',TRUE);
		$this->load->model('panel/auth/mysecurity');
		$this->mysecurity->verifysecurity('suc');
	}	
	
	function index(){
		$this->manage();
	}

	function manage(){
        $this->load->library('table');
        $this->load->library('pagination');
        
        //paging
        $config['base_url'] = base_url().'panel/crm/sucursales/manage/';
        	
        // make sure to put the primarykey first when selecting , 
		//eg. 'userID,name as Name , lastname as Last_Name' , Name and Last_Name will be use as table header.
		// Last_Name will be converted into Last Name using humanize() function, under inflector helper of the CI core.
		
		//$this->data['results'] = $this->sucursales_model->get("id_suc,nombre_suc AS Sucursal,direccion_suc AS Direccion,telefono_suc AS Teléfono,email_suc AS Correo_electrónico,nombre_contacto_suc AS Nombre_contacto,cargo_contacto_suc AS Cargo_contacto,email_contacto_suc AS Correo_electrónico_contacto,telefono_contacto_suc AS Teléfono_contacto,celular_contacto_suc AS Celular_contacto,empresa_suc AS Empresa,departamento_suc AS Departamento,ciudad_suc AS Ciudad,CASE WHEN activo_suc = 1 THEN 'SI' ELSE 'NO' END AS Activo",'',1000,$this->uri->segment(4));
		$this->data['results'] = $this->sucursales_model->get_sucursales();
		$this->data["title"] = "sucursales";
		$this->data["page_segment"] = "sucursales";

		$this->data["scripts"]=array('plugins/data-tables/jquery.dataTables.js',
                           'plugins/data-tables/DT_bootstrap.js');
		$this->data["father"]="CRM";
		$this->data["main_content"] = 'panel/crm/sucursales_list';
		$this->load->view('panel/panel_template',$this->data);
    }
	
    function add(){        
        $this->load->library('form_validation');
		$this->data['custom_error'] = '';
		$this->form_validation->set_rules('nombre_suc','Sucursal','required|trim|xss_clean');
		$this->form_validation->set_rules('direccion_suc','Direccion','trim|xss_clean');
		$this->form_validation->set_rules('telefono_suc','Teléfono','trim|xss_clean');
		$this->form_validation->set_rules('email_suc','Correo electrónico','trim|valid_email|xss_clean');
		$this->form_validation->set_rules('nombre_contacto_suc','Nombre contacto','trim|xss_clean');
		$this->form_validation->set_rules('cargo_contacto_suc','Cargo contacto','trim|xss_clean');
		$this->form_validation->set_rules('email_contacto_suc','Correo electrónico contacto','trim|valid_email|xss_clean');
		$this->form_validation->set_rules('telefono_contacto_suc','Teléfono contacto','trim|xss_clean');
		$this->form_validation->set_rules('celular_contacto_suc','Celular contacto','trim|xss_clean');
		$this->form_validation->set_rules('empresa_suc','Empresa','trim|xss_clean');
		$this->form_validation->set_rules('departamento_suc','Departamento','trim|xss_clean');
		$this->form_validation->set_rules('ciudad_suc','Ciudad','trim|xss_clean');
		$this->form_validation->set_rules('activo_suc','Activo','required|trim|xss_clean');

        if ($this->form_validation->run() == false)
        {
             $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">'.validation_errors().'</div>' : false);
        }
        else
        {                            
            $data = array(
                    'nombre_suc' => set_value('nombre_suc'),
					'direccion_suc' => set_value('direccion_suc'),
					'telefono_suc' => set_value('telefono_suc'),
					'email_suc' => set_value('email_suc'),
					'nombre_contacto_suc' => set_value('nombre_contacto_suc'),
					'cargo_contacto_suc' => set_value('cargo_contacto_suc'),
					'email_contacto_suc' => set_value('email_contacto_suc'),
					'telefono_contacto_suc' => set_value('telefono_contacto_suc'),
					'celular_contacto_suc' => set_value('celular_contacto_suc'),
					'empresa_suc' => set_value('empresa_suc'),
					'departamento_suc' => set_value('departamento_suc'),
					'ciudad_suc' => set_value('ciudad_suc'),
					'activo_suc' => set_value('activo_suc')
            );
			if ($this->sucursales_model->add($data) == TRUE)
			{
				//$this->data['custom_error'] = '<div class="form_ok"><p>Added</p></div>';
				// or redirect
				redirect(base_url().'panel/crm/sucursales/manage/');
			}
			else
			{
				$this->data['custom_error'] = '<div class="form_error"><p>An Error Occured.</p></div>';
			}
		}
		$this->load->model('panel/crm/empresas_model');	
		$this->load->model('panel/crm/departamentos_model');	
		$this->load->model('panel/crm/ciudades_model');	

		$this->data['empresas'] = $this->empresas_model->get_empresas_combo('id_emp,nombre_emp','');	
		$this->data['departamentos'] = $this->departamentos_model->get_departamentos_combo('id_dpt,nombre_dpt','');	
		$this->data['ciudades'] = $this->ciudades_model->get_ciudades_combo('id_cid,nombre_cid','');	

		$this->data["title"] = "Sucursales";
		$this->data["page_segment"] = "Sucursales";
		$this->data["scripts"]="";
		$this->data["father"]="CRM";
		$this->data["main_content"] = 'panel/crm/sucursales_add';
		$this->load->view('panel/panel_template',$this->data);
    }	
    
    function edit($id){        
        $this->load->library('form_validation');
		$this->data['custom_error'] = '';
		$this->form_validation->set_rules('nombre_suc','Sucursal','required|trim|xss_clean');
		$this->form_validation->set_rules('direccion_suc','Direccion','trim|xss_clean');
		$this->form_validation->set_rules('telefono_suc','Teléfono','trim|xss_clean');
		$this->form_validation->set_rules('email_suc','Correo electrónico','trim|valid_email|xss_clean');
		$this->form_validation->set_rules('nombre_contacto_suc','Nombre contacto','trim|xss_clean');
		$this->form_validation->set_rules('cargo_contacto_suc','Cargo contacto','trim|xss_clean');
		$this->form_validation->set_rules('email_contacto_suc','Correo electrónico contacto','trim|valid_email|xss_clean');
		$this->form_validation->set_rules('telefono_contacto_suc','Teléfono contacto','trim|xss_clean');
		$this->form_validation->set_rules('celular_contacto_suc','Celular contacto','trim|xss_clean');
		$this->form_validation->set_rules('empresa_suc','Empresa','trim|xss_clean');
		$this->form_validation->set_rules('departamento_suc','Departamento','trim|xss_clean');
		$this->form_validation->set_rules('ciudad_suc','Ciudad','trim|xss_clean');
		$this->form_validation->set_rules('activo_suc','Activo','required|trim|xss_clean');

        if ($this->form_validation->run() == false)
        {
             $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">'.validation_errors().'</div>' : false);
        }
        else
        {                            
            $data = array(
                    'nombre_suc' => $this->input->post('nombre_suc'),
					'direccion_suc' => $this->input->post('direccion_suc'),
					'telefono_suc' => $this->input->post('telefono_suc'),
					'email_suc' => $this->input->post('email_suc'),
					'nombre_contacto_suc' => $this->input->post('nombre_contacto_suc'),
					'cargo_contacto_suc' => $this->input->post('cargo_contacto_suc'),
					'email_contacto_suc' => $this->input->post('email_contacto_suc'),
					'telefono_contacto_suc' => $this->input->post('telefono_contacto_suc'),
					'celular_contacto_suc' => $this->input->post('celular_contacto_suc'),
					'empresa_suc' => $this->input->post('empresa_suc'),
					'departamento_suc' => $this->input->post('departamento_suc'),
					'ciudad_suc' => $this->input->post('ciudad_suc'),
					'activo_suc' => $this->input->post('activo_suc')
            );
			if ($this->sucursales_model->edit($data,'id_suc',$this->input->post('id_suc')) == TRUE)
			{
				redirect(base_url().'panel/crm/sucursales/manage/');
			}
			else
			{
				$this->data['custom_error'] = '<div class="form_error"><p>An Error Occured</p></div>';

			}
		}
		$this->load->model('panel/crm/empresas_model');	
		$this->load->model('panel/crm/departamentos_model');	
		$this->load->model('panel/crm/ciudades_model');	

		$result = $this->sucursales_model->get('id_suc,nombre_suc,direccion_suc,telefono_suc,email_suc,nombre_contacto_suc,cargo_contacto_suc,email_contacto_suc,telefono_contacto_suc,celular_contacto_suc,empresa_suc,departamento_suc,ciudad_suc,activo_suc','id_suc = '.$id,1,0,true);
		$this->data['empresas'] = $this->empresas_model->get_empresas_combo('id_emp,nombre_emp','');	
		$this->data['departamentos'] = $this->departamentos_model->get_departamentos_combo('id_dpt,nombre_dpt','');	
		$this->data['ciudades'] = $this->ciudades_model->get_ciudades_departamentos($result->departamento_suc);	

		$this->data['result'] = $result;

		$this->data["title"] = "Sucursales";
		$this->data["page_segment"] = "Sucursales";
		$this->data["scripts"]=array('plugins/data-tables/jquery.dataTables.js',
                           'plugins/data-tables/DT_bootstrap.js');
		$this->data["father"]="CRM";
		$this->data["main_content"] = 'panel/crm/sucursales_edit';
		$this->load->view('panel/panel_template',$this->data);
    }
	
    function delete($id){
            //$ID =  $this->uri->segment(4);
            
            $this->sucursales_model->delete('id_suc',$id);
            redirect(base_url().'panel/crm/sucursales/manage/');
    }
}

/* End of file sucursales.php */
/* Location: ./system/application/controllers/sucursales.php */