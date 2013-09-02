<?php

class Ciudades extends CI_Controller {
    
    function __construct() {
        parent::__construct();
		$this->load->library('form_validation');
		$this->load->helper(array('form','url','codegen_helper'));
		$this->load->model('panel/crm/ciudades_model','',TRUE);
		$this->load->model('panel/auth/mysecurity');
		$this->mysecurity->verifysecurity('city');
	}	
	
	function index(){
		$this->manage();
	}

	function manage(){
        $this->load->library('table');
        $this->load->library('pagination');
        
        //paging
        $config['base_url'] = base_url().'panel/crm/ciudades/manage/';
        	
        // make sure to put the primarykey first when selecting , 
		//eg. 'userID,name as Name , lastname as Last_Name' , Name and Last_Name will be use as table header.
		// Last_Name will be converted into Last Name using humanize() function, under inflector helper of the CI core.
		//$this->data['results'] = $this->ciudades_model->get("id_cid,nombre_cid AS Ciudad,departamento_cid AS Departamento,CASE WHEN activo_cid = 1 THEN 'SI' ELSE 'NO' END AS Activo",'',1000,$this->uri->segment(4));
		$this->data['results'] = $this->ciudades_model->get_ciudades();
		$this->data["title"] = "Ciudades";
		$this->data["page_segment"] = "Ciudades";
		$this->data["scripts"]=array('plugins/data-tables/jquery.dataTables.js',
                           'plugins/data-tables/DT_bootstrap.js');
		$this->data["father"]="CRM";
		$this->data["main_content"] = 'panel/crm/ciudades_list';
		$this->load->view('panel/panel_template',$this->data);
    }
	
    function add(){        
        $this->load->library('form_validation');
		$this->data['custom_error'] = '';
		$this->form_validation->set_rules('nombre_cid','Ciudad','required|trim|xss_clean');
		$this->form_validation->set_rules('departamento_cid','Departamento','required|trim|xss_clean');
		$this->form_validation->set_rules('activo_cid','Activo','required|trim|xss_clean');

        if ($this->form_validation->run() == false)
        {
             $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">'.validation_errors().'</div>' : false);
        }
        else
        {                            
            $data = array(
                    'nombre_cid' => set_value('nombre_cid'),
					'departamento_cid' => set_value('departamento_cid'),
					'activo_cid' => set_value('activo_cid')
            );
			if ($this->ciudades_model->add($data) == TRUE)
			{
				//$this->data['custom_error'] = '<div class="form_ok"><p>Added</p></div>';
				// or redirect
				redirect(base_url().'panel/crm/ciudades/manage/');
			}
			else
			{
				$this->data['custom_error'] = '<div class="form_error"><p>An Error Occured.</p></div>';
			}
		}
		$this->load->model('panel/crm/departamentos_model');	
		$this->data['departamentos'] = $this->departamentos_model->get_departamentos_combo('id_dpt,nombre_dpt','');	

		$this->data["title"] = "Ciudades";
		$this->data["page_segment"] = "Ciudades";
		$this->data["scripts"]="";
		$this->data["father"]="CRM";
		$this->data["main_content"] = 'panel/crm/ciudades_add';
		$this->load->view('panel/panel_template',$this->data);
    }	
    
    function edit($id){        
        $this->load->library('form_validation');
		$this->data['custom_error'] = '';
		$this->form_validation->set_rules('nombre_cid','Ciudad','required|trim|xss_clean');
		$this->form_validation->set_rules('departamento_cid','Departamento','required|trim|xss_clean');
		$this->form_validation->set_rules('activo_cid','Activo','required|trim|xss_clean');

        if ($this->form_validation->run() == false)
        {
             $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">'.validation_errors().'</div>' : false);
        }
        else
        {                            
            $data = array(
                    'nombre_cid' => $this->input->post('nombre_cid'),
					'departamento_cid' => $this->input->post('departamento_cid'),
					'activo_cid' => $this->input->post('activo_cid')
            );
			if ($this->ciudades_model->edit($data,'id_cid',$this->input->post('id_cid')) == TRUE)
			{
				redirect(base_url().'panel/crm/ciudades/manage/');
			}
			else
			{
				$this->data['custom_error'] = '<div class="form_error"><p>An Error Occured</p></div>';

			}
		}
        $this->load->model('panel/crm/departamentos_model');	
		$this->data['departamentos'] = $this->departamentos_model->get_departamentos_combo('id_dpt,nombre_dpt','');
		$this->data['result'] = $this->ciudades_model->get('id_cid,nombre_cid,departamento_cid,activo_cid','id_cid = '.$id,1,0,true);

		$this->data["title"] = "Ciudades";
		$this->data["page_segment"] = "Ciudades";
		$this->data["scripts"]=array('plugins/data-tables/jquery.dataTables.js',
                           'plugins/data-tables/DT_bootstrap.js');
		$this->data["father"]="CRM";
		$this->data["main_content"] = 'panel/crm/ciudades_edit';
		$this->load->view('panel/panel_template',$this->data);
    }
	
    function delete($id){
            //$ID =  $this->uri->segment(4);
            $this->ciudades_model->delete('id_cid',$id);
            redirect(base_url().'panel/crm/ciudades/manage/');
    }
}

/* End of file ciudades.php */
/* Location: ./system/application/controllers/ciudades.php */