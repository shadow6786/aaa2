<?php

class Contenidos extends CI_Controller {
    
    function __construct() {
        parent::__construct();
		$this->load->library('form_validation');
		$this->load->helper(array('form','url','codegen_helper'));
		$this->load->model('panel/cms/contenidos_model','',TRUE);
		$this->data["title"] = "Contenidos";
		$this->data["page_segment"] = "Contenidos";
		$this->data["father"]="cms";
	}	
	
	function index(){
		$this->manage();
	}

	function manage(){
        $this->load->library('table');
        $this->load->library('pagination');
        
        //paging
        $config['base_url'] = base_url('panel/cms/contenidos/manage/');
        	
        // make sure to put the primarykey first when selecting , 
		//eg. 'userID,name as Name , lastname as Last_Name' , Name and Last_Name will be use as table header.
		// Last_Name will be converted into Last Name using humanize() function, under inflector helper of the CI core.
		$this->data['results'] = $this->contenidos_model->get("id_con,titulo_con AS Titulo,descripcion_con AS Descripcion,imagen_con AS Imagen,tipocontenido_con AS Tipo_Contenido,CASE WHEN activo_con = 1 THEN 'SI' ELSE 'NO' END AS Activo",'',1000,$this->uri->segment(4));
		$this->data["scripts"]=array('plugins/data-tables/jquery.dataTables.js',
                           'plugins/data-tables/DT_bootstrap.js');
		$this->data["main_content"] = 'panel/cms/contenidos_list';
		$this->load->view('panel/panel_template',$this->data);
    }
	
    function add(){        
        $this->load->library('form_validation');
		$this->data['custom_error'] = '';
		$this->form_validation->set_rules('titulo_con','Titulo','required|trim|xss_clean');
$this->form_validation->set_rules('descripcion_con','Descripcion','required|trim|xss_clean');
$this->form_validation->set_rules('imagen_con','Imagen','required|trim|xss_clean');
$this->form_validation->set_rules('tipocontenido_con','Tipo Contenido','required|trim|xss_clean');
$this->form_validation->set_rules('activo_con','Activo','required|trim|xss_clean');

        if ($this->form_validation->run() == false)
        {
             $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">'.validation_errors().'</div>' : false);
        }
        else
        {                            
            $data = array(
                    'titulo_con' => set_value('titulo_con'),
					'descripcion_con' => set_value('descripcion_con'),
					'imagen_con' => set_value('imagen_con'),
					'tipocontenido_con' => set_value('tipocontenido_con'),
					'activo_con' => set_value('activo_con')
            );
			if ($this->contenidos_model->add($data) == TRUE)
			{
				//$this->data['custom_error'] = '<div class="form_ok"><p>Added</p></div>';
				// or redirect
				redirect(base_url('panel/cms/contenidos/manage/'));
			}
			else
			{
				$this->data['custom_error'] = '<div class="form_error"><p>An Error Occured.</p></div>';
			}
		}
		
		

		$this->data["scripts"]="";
		$this->data["main_content"] = 'panel/cms/contenidos_add';
		$this->load->view('panel/panel_template',$this->data);
    }	
    
    function edit($id){        
        $this->load->library('form_validation');
		$this->data['custom_error'] = '';
		$this->form_validation->set_rules('titulo_con','Titulo','required|trim|xss_clean');
$this->form_validation->set_rules('descripcion_con','Descripcion','required|trim|xss_clean');
$this->form_validation->set_rules('imagen_con','Imagen','required|trim|xss_clean');
$this->form_validation->set_rules('tipocontenido_con','Tipo Contenido','required|trim|xss_clean');
$this->form_validation->set_rules('activo_con','Activo','required|trim|xss_clean');

        if ($this->form_validation->run() == false)
        {
             $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">'.validation_errors().'</div>' : false);
        }
        else
        {                            
            $data = array(
                    'titulo_con' => $this->input->post('titulo_con'),
					'descripcion_con' => $this->input->post('descripcion_con'),
					'imagen_con' => $this->input->post('imagen_con'),
					'tipocontenido_con' => $this->input->post('tipocontenido_con'),
					'activo_con' => $this->input->post('activo_con')
            );
			if ($this->contenidos_model->edit($data,'id_con',$this->input->post('id_con')) == TRUE)
			{
				redirect(base_url('panel/cms/contenidos/manage/'));
			}
			else
			{
				$this->data['custom_error'] = '<div class="form_error"><p>An Error Occured</p></div>';

			}
		}
		$this->data['result'] = $this->contenidos_model->get('id_con,titulo_con,descripcion_con,imagen_con,tipocontenido_con,activo_con','id_con = '.$id,1,0,true);

		$this->data["scripts"]=array('plugins/data-tables/jquery.dataTables.js',
                           'plugins/data-tables/DT_bootstrap.js');
		$this->data["main_content"] = 'panel/cms/contenidos_edit';
		$this->load->view('panel/panel_template',$this->data);
    }
	
    function delete($id){
            //$ID =  $this->uri->segment(4);
            $this->contenidos_model->delete('id_con',$id);
            redirect(base_url('panel/cms/contenidos/manage/'));
    }
}

/* End of file contenidos.php */
/* Location: ./system/application/controllers/contenidos.php */