<?php

class Permisos extends CI_Controller {
    
    function __construct() {
        parent::__construct();
		$this->load->library('form_validation');
		$this->load->helper(array('form','url','codegen_helper'));
		$this->load->model('panel/seg/permisos_model','',TRUE);
		$this->data["title"] = "Permisos";
		$this->data["page_segment"] = "Permisos";
		$this->data["father"]="seg";
	}	
	
	function index(){
		$this->manage();
	}

	function manage(){
        $this->load->library('table');
        $this->load->library('pagination');
        
        //paging
        $config['base_url'] = base_url('panel/seg/permisos/manage/');
        	
        // make sure to put the primarykey first when selecting , 
		//eg. 'userID,name as Name , lastname as Last_Name' , Name and Last_Name will be use as table header.
		// Last_Name will be converted into Last Name using humanize() function, under inflector helper of the CI core.
		$this->data['results'] = $this->permisos_model->get("id_per,rol_per AS Rol,opcion_per AS Opcion",'',1000,$this->uri->segment(4));
		$this->data["scripts"]=array('plugins/data-tables/jquery.dataTables.js',
                           'plugins/data-tables/DT_bootstrap.js');
		$this->data["main_content"] = 'panel/seg/permisos_list';
		$this->load->view('panel/panel_template',$this->data);
    }
	
    function add(){        
        $this->load->library('form_validation');
		$this->data['custom_error'] = '';
		$this->form_validation->set_rules('rol_per','Rol','required|trim|xss_clean');
$this->form_validation->set_rules('opcion_per','Opcion','required|trim|xss_clean');

        if ($this->form_validation->run() == false)
        {
             $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">'.validation_errors().'</div>' : false);
        }
        else
        {                            
            $data = array(
                    'rol_per' => set_value('rol_per'),
					'opcion_per' => set_value('opcion_per')
            );
			if ($this->permisos_model->add($data) == TRUE)
			{
				//$this->data['custom_error'] = '<div class="form_ok"><p>Added</p></div>';
				// or redirect
				redirect(base_url('panel/seg/permisos/manage/'));
			}
			else
			{
				$this->data['custom_error'] = '<div class="form_error"><p>An Error Occured.</p></div>';
			}
		}
		
		

		$this->data["scripts"]="";
		$this->data["main_content"] = 'panel/seg/permisos_add';
		$this->load->view('panel/panel_template',$this->data);
    }	
    
    function edit($id){        
        $this->load->library('form_validation');
		$this->data['custom_error'] = '';
		$this->form_validation->set_rules('rol_per','Rol','required|trim|xss_clean');
$this->form_validation->set_rules('opcion_per','Opcion','required|trim|xss_clean');

        if ($this->form_validation->run() == false)
        {
             $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">'.validation_errors().'</div>' : false);
        }
        else
        {                            
            $data = array(
                    'rol_per' => $this->input->post('rol_per'),
					'opcion_per' => $this->input->post('opcion_per')
            );
			if ($this->permisos_model->edit($data,'id_per',$this->input->post('id_per')) == TRUE)
			{
				redirect(base_url('panel/seg/permisos/manage/'));
			}
			else
			{
				$this->data['custom_error'] = '<div class="form_error"><p>An Error Occured</p></div>';

			}
		}
		$this->data['result'] = $this->permisos_model->get('id_per,rol_per,opcion_per','id_per = '.$id,1,0,true);

		$this->data["scripts"]=array('plugins/data-tables/jquery.dataTables.js',
                           'plugins/data-tables/DT_bootstrap.js');
		$this->data["main_content"] = 'panel/seg/permisos_edit';
		$this->load->view('panel/panel_template',$this->data);
    }
	
    function delete($id){
            //$ID =  $this->uri->segment(4);
            $this->permisos_model->delete('id_per',$id);
            redirect(base_url('panel/seg/permisos/manage/'));
    }
}

/* End of file permisos.php */
/* Location: ./system/application/controllers/permisos.php */