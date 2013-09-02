<?php

class Roles extends CI_Controller {
    
    function __construct() {
        parent::__construct();
		$this->load->library('form_validation');
		$this->load->helper(array('form','url','codegen_helper'));
		$this->load->model('panel/sec/roles_model','',TRUE);
		$this->data["title"] = "Roles";
		$this->data["page_segment"] = "Roles";
		$this->data["father"]="Seguridad";
	}	
	
	function index(){
		$this->manage();
	}

	function manage(){
        $this->load->library('table');
        $this->load->library('pagination');
        
        //paging
        $config['base_url'] = base_url().'panel/sec/roles/manage/';
        	
        // make sure to put the primarykey first when selecting , 
		//eg. 'userID,name as Name , lastname as Last_Name' , Name and Last_Name will be use as table header.
		// Last_Name will be converted into Last Name using humanize() function, under inflector helper of the CI core.
		$this->data['results'] = $this->roles_model->get("id_rol,name_rol AS Rol,CASE WHEN admin_rol = 1 THEN 'SI' ELSE 'NO' END AS Administrador",'',1000,$this->uri->segment(4));
		$this->data["scripts"]=array('plugins/data-tables/jquery.dataTables.js',
                           'plugins/data-tables/DT_bootstrap.js');
		$this->data["main_content"] = 'panel/sec/roles_list';
		$this->load->view('panel/panel_template',$this->data);
    }
	
    function add(){        
        $this->load->library('form_validation');
		$this->data['custom_error'] = '';
		$this->form_validation->set_rules('name_rol','Rol','required|trim|xss_clean');
		$this->form_validation->set_rules('admin_rol','Administrador','required|trim|xss_clean');


        if ($this->form_validation->run() == false)
        {
             $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">'.validation_errors().'</div>' : false);
        }
        else
        {                            
            $data = array(               
					'name_rol' => set_value('name_rol'),
					'admin_rol' => set_value('admin_rol'),
            );
			if ($this->roles_model->add($data) == TRUE)
			{
				//$this->data['custom_error'] = '<div class="form_ok"><p>Added</p></div>';
				// or redirect
				redirect(base_url().'panel/sec/roles/manage/');
			}
			else
			{
				$this->data['custom_error'] = '<div class="form_error"><p>An Error Occured.</p></div>';
			}
		}
		
		$this->data["scripts"]="";
		$this->data["main_content"] = 'panel/sec/roles_add';
		$this->load->view('panel/panel_template',$this->data);
    }	
    
    function edit($id){        
        $this->load->library('form_validation');
		$this->data['custom_error'] = '';
		$this->form_validation->set_rules('name_rol','Rol','required|trim|xss_clean');
		$this->form_validation->set_rules('admin_rol','Administrador','required|trim|xss_clean');

        if ($this->form_validation->run() == false)
        {
             $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">'.validation_errors().'</div>' : false);
        }
        else
        {                            
            $data = array(
					'name_rol' => $this->input->post('name_rol'),
					'admin_rol' => $this->input->post('admin_rol'),
            );
			if ($this->roles_model->edit($data,'id_rol',$this->input->post('id_rol')) == TRUE)
			{
				redirect(base_url().'panel/sec/roles/manage/');
			}
			else
			{
				$this->data['custom_error'] = '<div class="form_error"><p>An Error Occured</p></div>';

			}
		}
		$this->data['result'] = $this->roles_model->get('id_rol,name_rol,admin_rol','id_rol = '.$id,1,0,true);

		$this->data["scripts"]=array('plugins/data-tables/jquery.dataTables.js',
                           'plugins/data-tables/DT_bootstrap.js');
		$this->data["main_content"] = 'panel/sec/roles_edit';
		$this->load->view('panel/panel_template',$this->data);
    }
	
    function delete($id){
            //$ID =  $this->uri->segment(4);
            $this->roles_model->delete('id_rol',$id);
            redirect(base_url().'panel/sec/roles/manage/');
    }
}

/* End of file roles.php */
/* Location: ./system/application/controllers/roles.php */