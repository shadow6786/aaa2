<?php

class Archivos extends CI_Controller {
    
    function __construct() {
        parent::__construct();
		$this->load->library('form_validation');
		$this->load->helper(array('form','url','codegen_helper'));
		$this->load->model('panel/msc/archivos_model','',TRUE);
		$this->data["title"] = "Archivos";
		$this->data["page_segment"] = "Archivos";
		$this->data["father"]="msc";
	}	
	
	function index(){
		$this->manage();
	}

	function manage(){
        $this->load->library('table');
        $this->load->library('pagination');
        
        //paging
        $config['base_url'] = base_url('panel/msc/archivos/manage/');
        	
        // make sure to put the primarykey first when selecting , 
		//eg. 'userID,name as Name , lastname as Last_Name' , Name and Last_Name will be use as table header.
		// Last_Name will be converted into Last Name using humanize() function, under inflector helper of the CI core.
		$this->data['results'] = $this->archivos_model->get("id_arc,nombre_arc AS Nombre,descripcion_acr AS Descripcion,imagen_arc AS Imagen,rutacompleta_arc AS Ruta_Completa,tipoarchivo_arc AS Tipo_de_archivo,esimagen_arc AS Es_Imagen,ancho_arc AS Ancho,alto_arc AS Alto,peso_arc AS Peso_en_KB",'',1000,$this->uri->segment(4));
		$this->data["scripts"]=array('plugins/data-tables/jquery.dataTables.js',
                           'plugins/data-tables/DT_bootstrap.js');
		$this->data["main_content"] = 'panel/msc/archivos_list';
		$this->load->view('panel/panel_template',$this->data);
    }
	
    function add(){        
        $this->load->library('form_validation');
		$this->data['custom_error'] = '';
		$this->form_validation->set_rules('nombre_arc','Nombre','required|trim|xss_clean');
$this->form_validation->set_rules('descripcion_acr','Descripcion','required|trim|xss_clean');
$this->form_validation->set_rules('imagen_arc','Imagen','required|trim|xss_clean');
$this->form_validation->set_rules('rutacompleta_arc','Ruta Completa','required|trim|xss_clean');
$this->form_validation->set_rules('tipoarchivo_arc','Tipo de archivo','required|trim|xss_clean');
$this->form_validation->set_rules('esimagen_arc','Es Imagen','required|trim|xss_clean');
$this->form_validation->set_rules('ancho_arc','Ancho','required|trim|xss_clean');
$this->form_validation->set_rules('alto_arc','Alto','required|trim|xss_clean');
$this->form_validation->set_rules('peso_arc','Peso en KB','required|trim|xss_clean');

        if ($this->form_validation->run() == false)
        {
             $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">'.validation_errors().'</div>' : false);
        }
        else
        {                            
            $data = array(
                    'nombre_arc' => set_value('nombre_arc'),
					'descripcion_acr' => set_value('descripcion_acr'),
					'imagen_arc' => set_value('imagen_arc'),
					'rutacompleta_arc' => set_value('rutacompleta_arc'),
					'tipoarchivo_arc' => set_value('tipoarchivo_arc'),
					'esimagen_arc' => set_value('esimagen_arc'),
					'ancho_arc' => set_value('ancho_arc'),
					'alto_arc' => set_value('alto_arc'),
					'peso_arc' => set_value('peso_arc')
            );
			if ($this->archivos_model->add($data) == TRUE)
			{
				//$this->data['custom_error'] = '<div class="form_ok"><p>Added</p></div>';
				// or redirect
				redirect(base_url('panel/msc/archivos/manage/'));
			}
			else
			{
				$this->data['custom_error'] = '<div class="form_error"><p>An Error Occured.</p></div>';
			}
		}
		
		

		$this->data["scripts"]="";
		$this->data["main_content"] = 'panel/msc/archivos_add';
		$this->load->view('panel/panel_template',$this->data);
    }	
    
    function edit($id){        
        $this->load->library('form_validation');
		$this->data['custom_error'] = '';
		$this->form_validation->set_rules('nombre_arc','Nombre','required|trim|xss_clean');
$this->form_validation->set_rules('descripcion_acr','Descripcion','required|trim|xss_clean');
$this->form_validation->set_rules('imagen_arc','Imagen','required|trim|xss_clean');
$this->form_validation->set_rules('rutacompleta_arc','Ruta Completa','required|trim|xss_clean');
$this->form_validation->set_rules('tipoarchivo_arc','Tipo de archivo','required|trim|xss_clean');
$this->form_validation->set_rules('esimagen_arc','Es Imagen','required|trim|xss_clean');
$this->form_validation->set_rules('ancho_arc','Ancho','required|trim|xss_clean');
$this->form_validation->set_rules('alto_arc','Alto','required|trim|xss_clean');
$this->form_validation->set_rules('peso_arc','Peso en KB','required|trim|xss_clean');

        if ($this->form_validation->run() == false)
        {
             $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">'.validation_errors().'</div>' : false);
        }
        else
        {                            
            $data = array(
                    'nombre_arc' => $this->input->post('nombre_arc'),
					'descripcion_acr' => $this->input->post('descripcion_acr'),
					'imagen_arc' => $this->input->post('imagen_arc'),
					'rutacompleta_arc' => $this->input->post('rutacompleta_arc'),
					'tipoarchivo_arc' => $this->input->post('tipoarchivo_arc'),
					'esimagen_arc' => $this->input->post('esimagen_arc'),
					'ancho_arc' => $this->input->post('ancho_arc'),
					'alto_arc' => $this->input->post('alto_arc'),
					'peso_arc' => $this->input->post('peso_arc')
            );
			if ($this->archivos_model->edit($data,'id_arc',$this->input->post('id_arc')) == TRUE)
			{
				redirect(base_url('panel/msc/archivos/manage/'));
			}
			else
			{
				$this->data['custom_error'] = '<div class="form_error"><p>An Error Occured</p></div>';

			}
		}
		$this->data['result'] = $this->archivos_model->get('id_arc,nombre_arc,descripcion_acr,imagen_arc,rutacompleta_arc,tipoarchivo_arc,esimagen_arc,ancho_arc,alto_arc,peso_arc','id_arc = '.$id,1,0,true);

		$this->data["scripts"]=array('plugins/data-tables/jquery.dataTables.js',
                           'plugins/data-tables/DT_bootstrap.js');
		$this->data["main_content"] = 'panel/msc/archivos_edit';
		$this->load->view('panel/panel_template',$this->data);
    }
	
    function delete($id){
            //$ID =  $this->uri->segment(4);
            $this->archivos_model->delete('id_arc',$id);
            redirect(base_url('panel/msc/archivos/manage/'));
    }
}

/* End of file archivos.php */
/* Location: ./system/application/controllers/archivos.php */