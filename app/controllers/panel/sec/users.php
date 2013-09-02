<?php

class Users extends CI_Controller {
    
    function __construct() {
        parent::__construct();
		$this->load->library('form_validation');
		$this->load->helper(array('form','url','codegen_helper'));
		$this->load->model('panel/sec/users_model','',TRUE);
		$this->load->model('panel/auth/mysecurity');
		$this->mysecurity->verifysecurity('user');
		$this->data["title"] = "Usuario";
		$this->data["page_segment"] = "Usuario";
		$this->data["father"]="SEC";
	}	
	
	function index(){
		$this->manage();
	}

	function manage(){
        $this->load->library('table');
        $this->load->library('pagination');
        
        //paging
        $config['base_url'] = base_url().'panel/sec/users/manage/';
        	
        // make sure to put the primarykey first when selecting , 
		//eg. 'userID,name as Name , lastname as Last_Name' , Name and Last_Name will be use as table header.
		// Last_Name will be converted into Last Name using humanize() function, under inflector helper of the CI core.
		$this->data['results'] = $this->users_model->get("id_usr,fname_usr AS Nombre,lname_usr AS Apellido,email_usr AS Correo_electrónico,phone_usr AS Teléfono,enable_usr AS Activo",'',1000,$this->uri->segment(4));

		$this->data["scripts"]=array('plugins/data-tables/jquery.dataTables.js',
                           'plugins/data-tables/DT_bootstrap.js');
		$this->data["main_content"] = 'panel/sec/users_list';
		$this->load->view('panel/panel_template',$this->data);
    }
	
    function add(){        
        $this->load->library('form_validation');
		$this->data['custom_error'] = '';
		
		$this->form_validation->set_rules('fname_usr','Nombre','required|trim|xss_clean');
		$this->form_validation->set_rules('lname_usr','Apellido','trim|xss_clean');
		$this->form_validation->set_rules('email_usr','Correo electrónico','required|trim|valid_email|xss_clean');
		$this->form_validation->set_rules('password_usr','Contraseña','required|min_length[6]|trim|xss_clean');
		$this->form_validation->set_rules('rpassword_usr','Repita Contraseña','required|min_length[6]|trim|xss_clean|matches[password_usr]');
		$this->form_validation->set_rules('phone_usr','Teléfono','trim|xss_clean');
		$this->form_validation->set_rules('rol_usr','Rol','required|xss_clean');
		$this->form_validation->set_rules('enable_usr','Activo','required|trim|xss_clean');

        if ($this->form_validation->run() == false)
        {
             $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">'.validation_errors().'</div>' : false);
        }
        else
        {                            
            $data = array(
					'fname_usr' => set_value('fname_usr'),
					'lname_usr' => set_value('lname_usr'),
					'email_usr' => set_value('email_usr'),
					'phone_usr' => set_value('phone_usr'),
					'password_usr' => $this->mysecurity->passwordencrypt(set_value('password_usr')),
					'enable_usr' => set_value('enable_usr'),
            );
			$id = $this->users_model->add($data);
			if ($id)
			{
				$this->load->model('panel/sec/roles_model');
				
				foreach($this->input->post('rol_usr') as $rol)
				{
					$data = array('user_uro' => $id,'rol_uro'=>$rol);
					$this->roles_model->add_user_rol($data);
				}
				
				//$this->data['custom_error'] = '<div class="form_ok"><p>Added</p></div>';
				// or redirect
				redirect(base_url().'panel/sec/users/manage/');
			}
			else
			{
				$this->data['custom_error'] = '<div class="form_error"><p>An Error Occured.</p></div>';
			}
		}
		$this->load->model('panel/sec/roles_model');
		
		$this->data["scripts"] = "";
		$this->data["roles"] = $this->roles_model->get_roles_combo('id_rol, name_rol');
		$this->data["main_content"] = 'panel/sec/users_add';
		$this->load->view('panel/panel_template',$this->data);
    }	
    
    function edit($id){        
        $this->load->library('form_validation');
		$this->data['custom_error'] = '';
		$this->form_validation->set_rules('fname_usr','Nombre','required|trim|xss_clean');
		$this->form_validation->set_rules('lname_usr','Apellido','trim|xss_clean');
		$this->form_validation->set_rules('email_usr','Correo electrónico','required|trim|valid_email|xss_clean');
		$this->form_validation->set_rules('phone_usr','Teléfono','trim|xss_clean');
		$this->form_validation->set_rules('rol_usr','Rol','required|xss_clean');
		$this->form_validation->set_rules('enable_usr','Activo','required|trim|xss_clean');

        if ($this->form_validation->run() == false)
        {
             $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">'.validation_errors().'</div>' : false);
        }
        else
        {                            
            $data = array(
					'fname_usr' => $this->input->post('fname_usr'),
					'lname_usr' => $this->input->post('lname_usr'),
					'email_usr' => $this->input->post('email_usr'),
					'phone_usr' => $this->input->post('phone_usr'),
					'enable_usr' => $this->input->post('enable_usr'),

            );
			if ($this->users_model->edit($data,'id_usr',$this->input->post('id_usr')) == TRUE)
			{
				$this->load->model('panel/sec/roles_model');
				$this->users_model->delete_rol_usuario($this->input->post('id_usr'));
				
				foreach($this->input->post('rol_usr') as $rol)
				{
					$data = array('user_uro' => $id,'rol_uro'=>$rol);
					$this->roles_model->add_user_rol($data);
				}

				redirect(base_url().'panel/sec/users/manage/');
			}
			else
			{
				$this->data['custom_error'] = '<div class="form_error"><p>An Error Occured</p></div>';

			}
		}
		$this->load->model('panel/sec/roles_model');
		
		$this->data['rolus'] = $this->users_model->get_list_rol_usuario($id);
		$this->data["roles"] = $this->roles_model->get_roles_combo('id_rol, name_rol');
		$this->data['result'] = $this->users_model->get('id_usr,fname_usr,lname_usr,email_usr,phone_usr,enable_usr','id_usr = '.$id,1,0,true);

		$this->data["scripts"]=array('plugins/data-tables/jquery.dataTables.js',
                           'plugins/data-tables/DT_bootstrap.js');
		$this->data["main_content"] = 'panel/sec/users_edit';
		$this->load->view('panel/panel_template',$this->data);
    }
	
	
    function delete($id){
            //$ID =  $this->uri->segment(4);
            $this->users_model->delete('id_usr',$id);
            redirect(base_url().'panel/sec/users/manage/');
    }
}

/* End of file users.php */
/* Location: ./system/application/controllers/users.php */