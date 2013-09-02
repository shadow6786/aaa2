<?php

class Usuarios extends CI_Controller {
    
    function __construct() {
        parent::__construct();
		$this->load->library('form_validation');
		$this->load->helper(array('form','url','codegen_helper'));
		$this->load->model('panel/seg/usuarios_model','',TRUE);
		$this->data["title"] = "Usuarios";
		$this->data["page_segment"] = "Usuarios";
		$this->data["father"]="seg";
	}	
	
	function index(){
		$this->manage();
	}

	function manage(){
        $this->load->library('table');
        $this->load->library('pagination');
        
        //paging
        $config['base_url'] = base_url('panel/seg/usuarios/manage/');
        	
        // make sure to put the primarykey first when selecting , 
		//eg. 'userID,name as Name , lastname as Last_Name' , Name and Last_Name will be use as table header.
		// Last_Name will be converted into Last Name using humanize() function, under inflector helper of the CI core.
		$this->data['results'] = $this->usuarios_model->get("id_usr,nombre_usr AS Nombres,apellidos_usr AS Apellidos,usuario_usr AS Nombre_de_Usuario,password_usr AS Contraseña,CASE WHEN activo_usr = 1 THEN 'SI' ELSE 'NO' END AS Activo,creadoen AS Creadoen,actualizadoen AS Actualizadoen",'',1000,$this->uri->segment(4));
		$this->data["scripts"]=array('plugins/data-tables/jquery.dataTables.js',
                           'plugins/data-tables/DT_bootstrap.js');
		$this->data["main_content"] = 'panel/seg/usuarios_list';
		$this->load->view('panel/panel_template',$this->data);
    }
	
    function add(){        
        $this->load->library('form_validation');
		$this->data['custom_error'] = '';
		$this->form_validation->set_rules('nombre_usr','Nombres','required|trim|xss_clean');
$this->form_validation->set_rules('apellidos_usr','Apellidos','required|trim|xss_clean');
$this->form_validation->set_rules('usuario_usr','Nombre de Usuario','required|trim|xss_clean');
$this->form_validation->set_rules('password_usr','Contraseña','required|trim|xss_clean');
$this->form_validation->set_rules('activo_usr','Activo','required|trim|xss_clean');
$this->form_validation->set_rules('creadoen','Creadoen','required|trim|xss_clean');
$this->form_validation->set_rules('actualizadoen','Actualizadoen','required|trim|xss_clean');

        if ($this->form_validation->run() == false)
        {
             $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">'.validation_errors().'</div>' : false);
        }
        else
        {                            
            $data = array(
                    'nombre_usr' => set_value('nombre_usr'),
					'apellidos_usr' => set_value('apellidos_usr'),
					'usuario_usr' => set_value('usuario_usr'),
					'password_usr' => set_value('password_usr'),
					'activo_usr' => set_value('activo_usr'),
					'creadoen' => set_value('creadoen'),
					'actualizadoen' => set_value('actualizadoen')
            );
			if ($this->usuarios_model->add($data) == TRUE)
			{
				//$this->data['custom_error'] = '<div class="form_ok"><p>Added</p></div>';
				// or redirect
				redirect(base_url('panel/seg/usuarios/manage/'));
			}
			else
			{
				$this->data['custom_error'] = '<div class="form_error"><p>An Error Occured.</p></div>';
			}
		}
		
		

		$this->data["scripts"]="";
		$this->data["main_content"] = 'panel/seg/usuarios_add';
		$this->load->view('panel/panel_template',$this->data);
    }	
    
    function edit($id){        
        $this->load->library('form_validation');
		$this->data['custom_error'] = '';
		$this->form_validation->set_rules('nombre_usr','Nombres','required|trim|xss_clean');
$this->form_validation->set_rules('apellidos_usr','Apellidos','required|trim|xss_clean');
$this->form_validation->set_rules('usuario_usr','Nombre de Usuario','required|trim|xss_clean');
$this->form_validation->set_rules('password_usr','Contraseña','required|trim|xss_clean');
$this->form_validation->set_rules('activo_usr','Activo','required|trim|xss_clean');
$this->form_validation->set_rules('creadoen','Creadoen','required|trim|xss_clean');
$this->form_validation->set_rules('actualizadoen','Actualizadoen','required|trim|xss_clean');

        if ($this->form_validation->run() == false)
        {
             $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">'.validation_errors().'</div>' : false);
        }
        else
        {                            
            $data = array(
                    'nombre_usr' => $this->input->post('nombre_usr'),
					'apellidos_usr' => $this->input->post('apellidos_usr'),
					'usuario_usr' => $this->input->post('usuario_usr'),
					'password_usr' => $this->input->post('password_usr'),
					'activo_usr' => $this->input->post('activo_usr'),
					'creadoen' => $this->input->post('creadoen'),
					'actualizadoen' => $this->input->post('actualizadoen')
            );
			if ($this->usuarios_model->edit($data,'id_usr',$this->input->post('id_usr')) == TRUE)
			{
				redirect(base_url('panel/seg/usuarios/manage/'));
			}
			else
			{
				$this->data['custom_error'] = '<div class="form_error"><p>An Error Occured</p></div>';

			}
		}
		$this->data['result'] = $this->usuarios_model->get('id_usr,nombre_usr,apellidos_usr,usuario_usr,password_usr,activo_usr,creadoen,actualizadoen','id_usr = '.$id,1,0,true);

		$this->data["scripts"]=array('plugins/data-tables/jquery.dataTables.js',
                           'plugins/data-tables/DT_bootstrap.js');
		$this->data["main_content"] = 'panel/seg/usuarios_edit';
		$this->load->view('panel/panel_template',$this->data);
    }
	
    function delete($id){
            //$ID =  $this->uri->segment(4);
            $this->usuarios_model->delete('id_usr',$id);
            redirect(base_url('panel/seg/usuarios/manage/'));
    }
}

/* End of file usuarios.php */
/* Location: ./system/application/controllers/usuarios.php */