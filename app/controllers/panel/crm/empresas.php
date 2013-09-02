<?php

class Empresas extends CI_Controller {
    
    function __construct() {
        parent::__construct();
		$this->load->library('form_validation');
		$this->load->helper(array('form','url','codegen_helper'));
		$this->load->model('panel/crm/empresas_model','',TRUE);
		$this->load->model('panel/auth/mysecurity');
		$this->mysecurity->verifysecurity('empr');
		
	}	
	
	function index(){
		$this->manage();
	}

	function manage(){
        $this->load->library('table');
        $this->load->library('pagination');
        
        //paging
        $config['base_url'] = base_url().'panel/crm/empresas/manage/';
        	
        // make sure to put the primarykey first when selecting , 
		//eg. 'userID,name as Name , lastname as Last_Name' , Name and Last_Name will be use as table header.
		// Last_Name will be converted into Last Name using humanize() function, under inflector helper of the CI core.
		//$this->data['results'] = $this->empresas_model->get("id_emp,nombre_emp AS Empresa,direccion_emp AS Direccion,telefono_emp AS Teléfono,nombre_contacto_emp AS Nombre_contacto,cargo_contacto_emp AS Cargo_contacto,telefono_contacto_emp AS Teléfono_contacto,email_contacto_emp AS Correo_electrónico_contacto,celular_contacto_emp AS Celular_contacto,pagina_web_emp AS Pagina_web,departamento_emp AS Departamento,ciudad_emp AS Ciudad,CASE WHEN activo_emp = 1 THEN 'SI' ELSE 'NO' END AS Activo",'',1000,$this->uri->segment(4));
        $this->data['results'] = $this->empresas_model->get_empresas();
		$this->data["title"] = "Empresas";
		$this->data["page_segment"] = "Empresas";
		$this->data["scripts"]=array('plugins/data-tables/jquery.dataTables.js',
                           'plugins/data-tables/DT_bootstrap.js');
		$this->data["father"]="CRM";
		$this->data["main_content"] = 'panel/crm/empresas_list';
		$this->load->view('panel/panel_template',$this->data);
    }
	
    function add(){        
        $this->load->library('form_validation');
		$this->data['custom_error'] = '';
		$this->form_validation->set_rules('nombre_emp','Empresa','required|trim|xss_clean');
		$this->form_validation->set_rules('direccion_emp','Direccion','trim|xss_clean');
		$this->form_validation->set_rules('telefono_emp','Teléfono','trim|xss_clean');
		$this->form_validation->set_rules('nombre_contacto_emp','Nombre contacto','trim|xss_clean');
		$this->form_validation->set_rules('cargo_contacto_emp','Cargo contacto','trim|xss_clean');
		$this->form_validation->set_rules('telefono_contacto_emp','Teléfono contacto','trim|xss_clean');
		$this->form_validation->set_rules('email_contacto_emp','Correo electrónico contacto','trim|valid_email|xss_clean');
		$this->form_validation->set_rules('celular_contacto_emp','Celular contacto','trim|xss_clean');
		$this->form_validation->set_rules('pagina_web_emp','Pagina web','trim|xss_clean');
		$this->form_validation->set_rules('departamento_emp','Departamento','trim|xss_clean');
		$this->form_validation->set_rules('ciudad_emp','Ciudad','trim|xss_clean');
		$this->form_validation->set_rules('activo_emp','Activo','required|trim|xss_clean');

        if ($this->form_validation->run() == false)
        {
             $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">'.validation_errors().'</div>' : false);
        }
        else
        {                            
            $data = array(
                    'nombre_emp' => set_value('nombre_emp'),
					'direccion_emp' => set_value('direccion_emp'),
					'telefono_emp' => set_value('telefono_emp'),
					'nombre_contacto_emp' => set_value('nombre_contacto_emp'),
					'cargo_contacto_emp' => set_value('cargo_contacto_emp'),
					'telefono_contacto_emp' => set_value('telefono_contacto_emp'),
					'email_contacto_emp' => set_value('email_contacto_emp'),
					'celular_contacto_emp' => set_value('celular_contacto_emp'),
					'pagina_web_emp' => set_value('pagina_web_emp'),
					'departamento_emp' => set_value('departamento_emp'),
					'ciudad_emp' => set_value('ciudad_emp'),
					'activo_emp' => set_value('activo_emp')
            );
			if ($this->empresas_model->add($data) == TRUE)
			{
				//$this->data['custom_error'] = '<div class="form_ok"><p>Added</p></div>';
				// or redirect
				redirect(base_url().'panel/crm/empresas/manage/');
			}
			else
			{
				$this->data['custom_error'] = '<div class="form_error"><p>An Error Occured.</p></div>';
			}
		}
		$this->load->model('panel/crm/departamentos_model');	
		$this->load->model('panel/crm/ciudades_model');	

		$this->data['departamentos'] = $this->departamentos_model->get_departamentos_combo('id_dpt,nombre_dpt','');	
		//$this->data['ciudades'] = $this->ciudades_model->get_ciudades_combo('id_cid,nombre_cid','');	

		$this->data["title"] = "Empresas";
		$this->data["page_segment"] = "Empresas";
		$this->data["scripts"]="";
		$this->data["father"]="CRM";
		$this->data["main_content"] = 'panel/crm/empresas_add';
		$this->load->view('panel/panel_template',$this->data);
    }	
    
    function edit($id){        
        $this->load->library('form_validation');
		$this->data['custom_error'] = '';
		$this->form_validation->set_rules('nombre_emp','Empresa','required|trim|xss_clean');
		$this->form_validation->set_rules('direccion_emp','Direccion','trim|xss_clean');
		$this->form_validation->set_rules('telefono_emp','Teléfono','trim|xss_clean');
		$this->form_validation->set_rules('nombre_contacto_emp','Nombre contacto','trim|xss_clean');
		$this->form_validation->set_rules('cargo_contacto_emp','Cargo contacto','trim|xss_clean');
		$this->form_validation->set_rules('telefono_contacto_emp','Teléfono contacto','trim|xss_clean');
		$this->form_validation->set_rules('email_contacto_emp','Correo electrónico contacto','trim|valid_email|xss_clean');
		$this->form_validation->set_rules('celular_contacto_emp','Celular contacto','trim|xss_clean');
		$this->form_validation->set_rules('pagina_web_emp','Pagina web','trim|xss_clean');
		$this->form_validation->set_rules('departamento_emp','Departamento','trim|xss_clean');
		$this->form_validation->set_rules('ciudad_emp','Ciudad','trim|xss_clean');
		$this->form_validation->set_rules('activo_emp','Activo','required|trim|xss_clean');

        if ($this->form_validation->run() == false)
        {
             $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">'.validation_errors().'</div>' : false);
        }
        else
        {                            
            $data = array(
                    'nombre_emp' => $this->input->post('nombre_emp'),
					'direccion_emp' => $this->input->post('direccion_emp'),
					'telefono_emp' => $this->input->post('telefono_emp'),
					'nombre_contacto_emp' => $this->input->post('nombre_contacto_emp'),
					'cargo_contacto_emp' => $this->input->post('cargo_contacto_emp'),
					'telefono_contacto_emp' => $this->input->post('telefono_contacto_emp'),
					'email_contacto_emp' => $this->input->post('email_contacto_emp'),
					'celular_contacto_emp' => $this->input->post('celular_contacto_emp'),
					'pagina_web_emp' => $this->input->post('pagina_web_emp'),
					'departamento_emp' => $this->input->post('departamento_emp'),
					'ciudad_emp' => $this->input->post('ciudad_emp'),
					'activo_emp' => $this->input->post('activo_emp')
            );
			if ($this->empresas_model->edit($data,'id_emp',$this->input->post('id_emp')) == TRUE)
			{
				redirect(base_url().'panel/crm/empresas/manage/');
			}
			else
			{
				$this->data['custom_error'] = '<div class="form_error"><p>An Error Occured</p></div>';

			}
		}
		$this->load->model('panel/crm/departamentos_model');	
		$this->load->model('panel/crm/ciudades_model');	

        $result = $this->empresas_model->get('id_emp,nombre_emp,direccion_emp,telefono_emp,nombre_contacto_emp,cargo_contacto_emp,telefono_contacto_emp,email_contacto_emp,celular_contacto_emp,pagina_web_emp,departamento_emp,ciudad_emp,activo_emp','id_emp = '.$id,1,0,true);
		
		$this->data['departamentos'] = $this->departamentos_model->get_departamentos_combo('id_dpt,nombre_dpt','');	
		$this->data['ciudades'] = $this->ciudades_model->get_ciudades_departamentos($result->departamento_emp);
		$this->data['result'] = $result;

		$this->data["title"] = "Empresas";
		$this->data["page_segment"] = "Empresas";
		$this->data["scripts"]=array('plugins/data-tables/jquery.dataTables.js',
                           'plugins/data-tables/DT_bootstrap.js');
		$this->data["father"]="CRM";
		$this->data["main_content"] = 'panel/crm/empresas_edit';
		$this->load->view('panel/panel_template',$this->data);
    }
	
    function delete($id){
            //$ID =  $this->uri->segment(4);
            $this->empresas_model->delete('id_emp',$id);
            redirect(base_url().'panel/crm/empresas/manage/');
    }
}

/* End of file empresas.php */
/* Location: ./system/application/controllers/empresas.php */