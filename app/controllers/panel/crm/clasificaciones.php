<?php

class Clasificaciones extends CI_Controller {
    
    function __construct() {
        parent::__construct();
		$this->load->library('form_validation');
		$this->load->helper(array('form','url','codegen_helper'));
		$this->load->model('panel/crm/clasificaciones_model','',TRUE);
		$this->load->model('panel/auth/mysecurity');
		$this->mysecurity->verifysecurity('clas');
	}	
	
	function index(){
		$this->manage();
	}

	function manage(){
        $this->load->library('table');
        $this->load->library('pagination');
        
        //paging
        $config['base_url'] = base_url().'panel/crm/clasificaciones/manage/';
        	
        // make sure to put the primarykey first when selecting , 
		//eg. 'userID,name as Name , lastname as Last_Name' , Name and Last_Name will be use as table header.
		// Last_Name will be converted into Last Name using humanize() function, under inflector helper of the CI core.
		$this->data['results'] = $this->clasificaciones_model->get("id_cla,nombre_cla AS Clasificación,CASE WHEN activo_cla = 1 THEN 'SI' ELSE 'NO' END AS Activo",'',1000,$this->uri->segment(4));

		$this->data["title"] = "Clasificaciones";
		$this->data["page_segment"] = "Clasificaciones";
		$this->data["scripts"]=array('plugins/data-tables/jquery.dataTables.js',
                           'plugins/data-tables/DT_bootstrap.js');
		$this->data["father"]="CRM";
		$this->data["main_content"] = 'panel/crm/clasificaciones_list';
		$this->load->view('panel/panel_template',$this->data);
    }
	
    function add(){        
        $this->load->library('form_validation');
		$this->data['custom_error'] = '';
		$this->form_validation->set_rules('nombre_cla','Clasificación','required|trim|xss_clean');
$this->form_validation->set_rules('activo_cla','Activo','required|trim|xss_clean');

        if ($this->form_validation->run() == false)
        {
             $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">'.validation_errors().'</div>' : false);
        }
        else
        {                            
            $data = array(
                    'nombre_cla' => set_value('nombre_cla'),
					'activo_cla' => set_value('activo_cla')
            );
			if ($this->clasificaciones_model->add($data) == TRUE)
			{
				//$this->data['custom_error'] = '<div class="form_ok"><p>Added</p></div>';
				// or redirect
				redirect(base_url().'panel/crm/clasificaciones/manage/');
			}
			else
			{
				$this->data['custom_error'] = '<div class="form_error"><p>An Error Occured.</p></div>';
			}
		}
		
		
		$this->data["title"] = "Clasificaciones";
		$this->data["page_segment"] = "Clasificaciones";
		$this->data["scripts"]="";
		$this->data["father"]="CRM";
		$this->data["main_content"] = 'panel/crm/clasificaciones_add';
		$this->load->view('panel/panel_template',$this->data);
    }	
    
    function edit($id){        
        $this->load->library('form_validation');
		$this->data['custom_error'] = '';
		$this->form_validation->set_rules('nombre_cla','Clasificación','required|trim|xss_clean');
$this->form_validation->set_rules('activo_cla','Activo','required|trim|xss_clean');

        if ($this->form_validation->run() == false)
        {
             $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">'.validation_errors().'</div>' : false);
        }
        else
        {                            
            $data = array(
                    'nombre_cla' => $this->input->post('nombre_cla'),
					'activo_cla' => $this->input->post('activo_cla')
            );
			if ($this->clasificaciones_model->edit($data,'id_cla',$this->input->post('id_cla')) == TRUE)
			{
				redirect(base_url().'panel/crm/clasificaciones/manage/');
			}
			else
			{
				$this->data['custom_error'] = '<div class="form_error"><p>An Error Occured</p></div>';

			}
		}
		$this->data['result'] = $this->clasificaciones_model->get('id_cla,nombre_cla,activo_cla','id_cla = '.$id,1,0,true);

		$this->data["title"] = "Clasificaciones";
		$this->data["page_segment"] = "Clasificaciones";
		$this->data["scripts"]=array('plugins/data-tables/jquery.dataTables.js',
                           'plugins/data-tables/DT_bootstrap.js');
		$this->data["father"]="CRM";
		$this->data["main_content"] = 'panel/crm/clasificaciones_edit';
		$this->load->view('panel/panel_template',$this->data);
    }
	
    function delete($id){
            //$ID =  $this->uri->segment(4);
            $this->clasificaciones_model->delete('id_cla',$id);
            redirect(base_url().'panel/crm/clasificaciones/manage/');
    }
}

/* End of file clasificaciones.php */
/* Location: ./system/application/controllers/clasificaciones.php */