<?php

class Usuariosroles extends CI_Controller {
    
    function __construct() {
        parent::__construct();
		$this->load->library('form_validation');
		$this->load->helper(array('form','url','codegen_helper'));
		$this->load->model('panel/seg/usuariosroles_model','',TRUE);
		$this->data["title"] = "Usuariosroles";
		$this->data["page_segment"] = "Usuariosroles";
		$this->data["father"]="seg";
	}	
	
	function index(){
		$this->manage();
	}

	function manage(){
        $this->load->library('table');
        $this->load->library('pagination');
        
        //paging
        $config['base_url'] = base_url('panel/seg/usuariosroles/manage/');
        	
        // make sure to put the primarykey first when selecting , 
		//eg. 'userID,name as Name , lastname as Last_Name' , Name and Last_Name will be use as table header.
		// Last_Name will be converted into Last Name using humanize() function, under inflector helper of the CI core.
		$this->data['results'] = $this->usuariosroles_model->get("id_uro,rol_uro AS Rol,usuario_uro AS Usuario",'',1000,$this->uri->segment(4));
		$this->data["scripts"]=array('plugins/data-tables/jquery.dataTables.js',
                           'plugins/data-tables/DT_bootstrap.js');
		$this->data["main_content"] = 'panel/seg/usuariosroles_list';
		$this->load->view('panel/panel_template',$this->data);
    }
	
    function add(){        
        $this->load->library('form_validation');
		$this->data['custom_error'] = '';
		$this->form_validation->set_rules('rol_uro','Rol','required|trim|xss_clean');
$this->form_validation->set_rules('usuario_uro','Usuario','required|trim|xss_clean');

        if ($this->form_validation->run() == false)
        {
             $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">'.validation_errors().'</div>' : false);
        }
        else
        {                            
            $data = array(
                    'rol_uro' => set_value('rol_uro'),
					'usuario_uro' => set_value('usuario_uro')
            );
			if ($this->usuariosroles_model->add($data) == TRUE)
			{
				//$this->data['custom_error'] = '<div class="form_ok"><p>Added</p></div>';
				// or redirect
				redirect(base_url('panel/seg/usuariosroles/manage/'));
			}
			else
			{
				$this->data['custom_error'] = '<div class="form_error"><p>An Error Occured.</p></div>';
			}
		}
		
		

		$this->data["scripts"]="";
		$this->data["main_content"] = 'panel/seg/usuariosroles_add';
		$this->load->view('panel/panel_template',$this->data);
    }	
    
    function edit($id){        
        $this->load->library('form_validation');
		$this->data['custom_error'] = '';
		$this->form_validation->set_rules('rol_uro','Rol','required|trim|xss_clean');
$this->form_validation->set_rules('usuario_uro','Usuario','required|trim|xss_clean');

        if ($this->form_validation->run() == false)
        {
             $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">'.validation_errors().'</div>' : false);
        }
        else
        {                            
            $data = array(
                    'rol_uro' => $this->input->post('rol_uro'),
					'usuario_uro' => $this->input->post('usuario_uro')
            );
			if ($this->usuariosroles_model->edit($data,'id_uro',$this->input->post('id_uro')) == TRUE)
			{
				redirect(base_url('panel/seg/usuariosroles/manage/'));
			}
			else
			{
				$this->data['custom_error'] = '<div class="form_error"><p>An Error Occured</p></div>';

			}
		}
		$this->data['result'] = $this->usuariosroles_model->get('id_uro,rol_uro,usuario_uro','id_uro = '.$id,1,0,true);

		$this->data["scripts"]=array('plugins/data-tables/jquery.dataTables.js',
                           'plugins/data-tables/DT_bootstrap.js');
		$this->data["main_content"] = 'panel/seg/usuariosroles_edit';
		$this->load->view('panel/panel_template',$this->data);
    }
	
    function delete($id){
            //$ID =  $this->uri->segment(4);
            $this->usuariosroles_model->delete('id_uro',$id);
            redirect(base_url('panel/seg/usuariosroles/manage/'));
    }
}

/* End of file usuariosroles.php */
/* Location: ./system/application/controllers/usuariosroles.php */