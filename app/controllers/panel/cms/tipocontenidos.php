<?php

class Tipocontenidos extends CI_Controller {
    
    function __construct() {
        parent::__construct();
		$this->load->library('form_validation');
		$this->load->helper(array('form','url','codegen_helper'));
		$this->load->model('panel/cms/tipocontenidos_model','',TRUE);
		$this->data["title"] = "Tipocontenidos";
		$this->data["page_segment"] = "Tipocontenidos";
		$this->data["father"]="cms";
	}	
	
	function index(){
		$this->manage();
	}

	function manage(){
        $this->load->library('table');
        $this->load->library('pagination');
        
        //paging
        $config['base_url'] = base_url('panel/cms/tipocontenidos/manage/');
        	
        // make sure to put the primarykey first when selecting , 
		//eg. 'userID,name as Name , lastname as Last_Name' , Name and Last_Name will be use as table header.
		// Last_Name will be converted into Last Name using humanize() function, under inflector helper of the CI core.
		$this->data['results'] = $this->tipocontenidos_model->get("id_tcn,nombre_tcn AS Nombre,CASE WHEN activo_tcn = 1 THEN 'SI' ELSE 'NO' END AS Activo",'',1000,$this->uri->segment(4));
		$this->data["scripts"]=array('plugins/data-tables/jquery.dataTables.js',
                           'plugins/data-tables/DT_bootstrap.js');
		$this->data["main_content"] = 'panel/cms/tipocontenidos_list';
		$this->load->view('panel/panel_template',$this->data);
    }
	
    function add(){        
        $this->load->library('form_validation');
		$this->data['custom_error'] = '';
		$this->form_validation->set_rules('nombre_tcn','Nombre','required|trim|xss_clean');
$this->form_validation->set_rules('activo_tcn','Activo','required|trim|xss_clean');

        if ($this->form_validation->run() == false)
        {
             $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">'.validation_errors().'</div>' : false);
        }
        else
        {                            
            $data = array(
                    'nombre_tcn' => set_value('nombre_tcn'),
					'activo_tcn' => set_value('activo_tcn')
            );
			if ($this->tipocontenidos_model->add($data) == TRUE)
			{
				//$this->data['custom_error'] = '<div class="form_ok"><p>Added</p></div>';
				// or redirect
				redirect(base_url('panel/cms/tipocontenidos/manage/'));
			}
			else
			{
				$this->data['custom_error'] = '<div class="form_error"><p>An Error Occured.</p></div>';
			}
		}
		
		

		$this->data["scripts"]="";
		$this->data["main_content"] = 'panel/cms/tipocontenidos_add';
		$this->load->view('panel/panel_template',$this->data);
    }	
    
    function edit($id){        
        $this->load->library('form_validation');
		$this->data['custom_error'] = '';
		$this->form_validation->set_rules('nombre_tcn','Nombre','required|trim|xss_clean');
$this->form_validation->set_rules('activo_tcn','Activo','required|trim|xss_clean');

        if ($this->form_validation->run() == false)
        {
             $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">'.validation_errors().'</div>' : false);
        }
        else
        {                            
            $data = array(
                    'nombre_tcn' => $this->input->post('nombre_tcn'),
					'activo_tcn' => $this->input->post('activo_tcn')
            );
			if ($this->tipocontenidos_model->edit($data,'id_tcn',$this->input->post('id_tcn')) == TRUE)
			{
				redirect(base_url('panel/cms/tipocontenidos/manage/'));
			}
			else
			{
				$this->data['custom_error'] = '<div class="form_error"><p>An Error Occured</p></div>';

			}
		}
		$this->data['result'] = $this->tipocontenidos_model->get('id_tcn,nombre_tcn,activo_tcn','id_tcn = '.$id,1,0,true);

		$this->data["scripts"]=array('plugins/data-tables/jquery.dataTables.js',
                           'plugins/data-tables/DT_bootstrap.js');
		$this->data["main_content"] = 'panel/cms/tipocontenidos_edit';
		$this->load->view('panel/panel_template',$this->data);
    }
	
    function delete($id){
            //$ID =  $this->uri->segment(4);
            $this->tipocontenidos_model->delete('id_tcn',$id);
            redirect(base_url('panel/cms/tipocontenidos/manage/'));
    }
}

/* End of file tipocontenidos.php */
/* Location: ./system/application/controllers/tipocontenidos.php */