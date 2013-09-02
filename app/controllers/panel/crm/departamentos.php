<?php

class Departamentos extends CI_Controller {
    
    function __construct() {
        parent::__construct();
		$this->load->library('form_validation');
		$this->load->helper(array('form','url','codegen_helper'));
		$this->load->model('panel/crm/departamentos_model','',TRUE);
		$this->load->model('panel/auth/mysecurity');
		$this->mysecurity->verifysecurity('dept');
	}	
	
	function index(){
		$this->manage();
	}

	function manage(){
        $this->load->library('table');
        $this->load->library('pagination');
        
        //paging
        $config['base_url'] = base_url().'panel/crm/departamentos/manage/';
        	
        // make sure to put the primarykey first when selecting , 
		//eg. 'userID,name as Name , lastname as Last_Name' , Name and Last_Name will be use as table header.
		// Last_Name will be converted into Last Name using humanize() function, under inflector helper of the CI core.
		$this->data['results'] = $this->departamentos_model->get("id_dpt,nombre_dpt AS Departamento,CASE WHEN activo_dpt = 1 THEN 'SI' ELSE 'NO' END AS Activo",'',1000,$this->uri->segment(4));

		$this->data["title"] = "Departamentos";
		$this->data["page_segment"] = "Departamentos";
		$this->data["scripts"]=array('plugins/data-tables/jquery.dataTables.js',
                           'plugins/data-tables/DT_bootstrap.js');
		$this->data["father"]="CRM";
		$this->data["main_content"] = 'panel/crm/departamentos_list';
		$this->load->view('panel/panel_template',$this->data);
    }
	
    function add(){        
        $this->load->library('form_validation');
		$this->data['custom_error'] = '';
		$this->form_validation->set_rules('nombre_dpt','Departamento','required|trim|xss_clean');
$this->form_validation->set_rules('activo_dpt','Activo','required|trim|xss_clean');

        if ($this->form_validation->run() == false)
        {
             $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">'.validation_errors().'</div>' : false);
        }
        else
        {                            
            $data = array(
                    'nombre_dpt' => set_value('nombre_dpt'),
					'activo_dpt' => set_value('activo_dpt')
            );
			if ($this->departamentos_model->add($data) == TRUE)
			{
				//$this->data['custom_error'] = '<div class="form_ok"><p>Added</p></div>';
				// or redirect
				redirect(base_url().'panel/crm/departamentos/manage/');
			}
			else
			{
				$this->data['custom_error'] = '<div class="form_error"><p>An Error Occured.</p></div>';
			}
		}
		
		
		$this->data["title"] = "Departamentos";
		$this->data["page_segment"] = "Departamentos";
		$this->data["scripts"]="";
		$this->data["father"]="CRM";
		$this->data["main_content"] = 'panel/crm/departamentos_add';
		$this->load->view('panel/panel_template',$this->data);
    }	
    
    function edit($id){        
        $this->load->library('form_validation');
		$this->data['custom_error'] = '';
		$this->form_validation->set_rules('nombre_dpt','Departamento','required|trim|xss_clean');
$this->form_validation->set_rules('activo_dpt','Activo','required|trim|xss_clean');

        if ($this->form_validation->run() == false)
        {
             $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">'.validation_errors().'</div>' : false);
        }
        else
        {                            
            $data = array(
                    'nombre_dpt' => $this->input->post('nombre_dpt'),
					'activo_dpt' => $this->input->post('activo_dpt')
            );
			if ($this->departamentos_model->edit($data,'id_dpt',$this->input->post('id_dpt')) == TRUE)
			{
				redirect(base_url().'panel/crm/departamentos/manage/');
			}
			else
			{
				$this->data['custom_error'] = '<div class="form_error"><p>An Error Occured</p></div>';

			}
		}
		$this->data['result'] = $this->departamentos_model->get('id_dpt,nombre_dpt,activo_dpt','id_dpt = '.$id,1,0,true);

		$this->data["title"] = "Departamentos";
		$this->data["page_segment"] = "Departamentos";
		$this->data["scripts"]=array('plugins/data-tables/jquery.dataTables.js',
                           'plugins/data-tables/DT_bootstrap.js');
		$this->data["father"]="CRM";
		$this->data["main_content"] = 'panel/crm/departamentos_edit';
		$this->load->view('panel/panel_template',$this->data);
    }
	
    function delete($id){
            //$ID =  $this->uri->segment(4);
            $this->departamentos_model->delete('id_dpt',$id);
            redirect(base_url().'panel/crm/departamentos/manage/');
    }
}

/* End of file departamentos.php */
/* Location: ./system/application/controllers/departamentos.php */