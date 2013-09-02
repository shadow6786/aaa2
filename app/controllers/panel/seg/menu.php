<?php

class Menu extends CI_Controller {
    
    function __construct() {
        parent::__construct();
		$this->load->library('form_validation');
		$this->load->helper(array('form','url','codegen_helper'));
		$this->load->model('panel/seg/menu_model','',TRUE);
		$this->data["title"] = "Menu";
		$this->data["page_segment"] = "Menu";
		$this->data["father"]="seg";
	}	
	
	function index(){
		$this->manage();
	}

	function manage(){
        $this->load->library('table');
        $this->load->library('pagination');
        
        //paging
        $config['base_url'] = base_url('panel/seg/menu/manage/');
        	
        // make sure to put the primarykey first when selecting , 
		//eg. 'userID,name as Name , lastname as Last_Name' , Name and Last_Name will be use as table header.
		// Last_Name will be converted into Last Name using humanize() function, under inflector helper of the CI core.
		$this->data['results'] = $this->menu_model->get("id_men,nombre_men AS Nombre,icono_men AS Icono,CASE WHEN activo_men = 1 THEN 'SI' ELSE 'NO' END AS Activo",'',1000,$this->uri->segment(4));
		$this->data["scripts"]=array('plugins/data-tables/jquery.dataTables.js',
                           'plugins/data-tables/DT_bootstrap.js');
		$this->data["main_content"] = 'panel/seg/menu_list';
		$this->load->view('panel/panel_template',$this->data);
    }
	
    function add(){        
        $this->load->library('form_validation');
		$this->data['custom_error'] = '';
		$this->form_validation->set_rules('nombre_men','Nombre','required|trim|xss_clean');
$this->form_validation->set_rules('icono_men','Icono','required|trim|xss_clean');
$this->form_validation->set_rules('activo_men','Activo','required|trim|xss_clean');

        if ($this->form_validation->run() == false)
        {
             $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">'.validation_errors().'</div>' : false);
        }
        else
        {                            
            $data = array(
                    'nombre_men' => set_value('nombre_men'),
					'icono_men' => set_value('icono_men'),
					'activo_men' => set_value('activo_men')
            );
			if ($this->menu_model->add($data) == TRUE)
			{
				//$this->data['custom_error'] = '<div class="form_ok"><p>Added</p></div>';
				// or redirect
				redirect(base_url('panel/seg/menu/manage/'));
			}
			else
			{
				$this->data['custom_error'] = '<div class="form_error"><p>An Error Occured.</p></div>';
			}
		}
		
		

		$this->data["scripts"]="";
		$this->data["main_content"] = 'panel/seg/menu_add';
		$this->load->view('panel/panel_template',$this->data);
    }	
    
    function edit($id){        
        $this->load->library('form_validation');
		$this->data['custom_error'] = '';
		$this->form_validation->set_rules('nombre_men','Nombre','required|trim|xss_clean');
$this->form_validation->set_rules('icono_men','Icono','required|trim|xss_clean');
$this->form_validation->set_rules('activo_men','Activo','required|trim|xss_clean');

        if ($this->form_validation->run() == false)
        {
             $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">'.validation_errors().'</div>' : false);
        }
        else
        {                            
            $data = array(
                    'nombre_men' => $this->input->post('nombre_men'),
					'icono_men' => $this->input->post('icono_men'),
					'activo_men' => $this->input->post('activo_men')
            );
			if ($this->menu_model->edit($data,'id_men',$this->input->post('id_men')) == TRUE)
			{
				redirect(base_url('panel/seg/menu/manage/'));
			}
			else
			{
				$this->data['custom_error'] = '<div class="form_error"><p>An Error Occured</p></div>';

			}
		}
		$this->data['result'] = $this->menu_model->get('id_men,nombre_men,icono_men,activo_men','id_men = '.$id,1,0,true);

		$this->data["scripts"]=array('plugins/data-tables/jquery.dataTables.js',
                           'plugins/data-tables/DT_bootstrap.js');
		$this->data["main_content"] = 'panel/seg/menu_edit';
		$this->load->view('panel/panel_template',$this->data);
    }
	
    function delete($id){
            //$ID =  $this->uri->segment(4);
            $this->menu_model->delete('id_men',$id);
            redirect(base_url('panel/seg/menu/manage/'));
    }
}

/* End of file menu.php */
/* Location: ./system/application/controllers/menu.php */