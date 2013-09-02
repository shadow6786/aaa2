<?php

class Opciones extends CI_Controller {
    
    function __construct() {
        parent::__construct();
		$this->load->library('form_validation');
		$this->load->helper(array('form','url','codegen_helper'));
		$this->load->model('panel/seg/opciones_model','',TRUE);
		$this->data["title"] = "Opciones";
		$this->data["page_segment"] = "Opciones";
		$this->data["father"]="seg";
	}	
	
	function index(){
		$this->manage();
	}

	function manage(){
        $this->load->library('table');
        $this->load->library('pagination');
        
        //paging
        $config['base_url'] = base_url('panel/seg/opciones/manage/');
        	
        // make sure to put the primarykey first when selecting , 
		//eg. 'userID,name as Name , lastname as Last_Name' , Name and Last_Name will be use as table header.
		// Last_Name will be converted into Last Name using humanize() function, under inflector helper of the CI core.
		$this->data['results'] = $this->opciones_model->get("id_opc,nombre_opc AS Nombre,seguridad_opc AS Cadena_de_seguridad,CASE WHEN esadmin_opc = 1 THEN 'SI' ELSE 'NO' END AS Es_Admin_Menu,espagina_opc AS Es_Pagina,activo_opc AS Activo,url_opc AS URL",'',1000,$this->uri->segment(4));
		$this->data["scripts"]=array('plugins/data-tables/jquery.dataTables.js',
                           'plugins/data-tables/DT_bootstrap.js');
		$this->data["main_content"] = 'panel/seg/opciones_list';
		$this->load->view('panel/panel_template',$this->data);
    }
	
    function add(){        
        $this->load->library('form_validation');
		$this->data['custom_error'] = '';
		$this->form_validation->set_rules('nombre_opc','Nombre','required|trim|xss_clean');
$this->form_validation->set_rules('seguridad_opc','Cadena de seguridad','required|trim|xss_clean');
$this->form_validation->set_rules('esadmin_opc','Es Admin Menu','required|trim|xss_clean');
$this->form_validation->set_rules('espagina_opc','Es Pagina','required|trim|xss_clean');
$this->form_validation->set_rules('activo_opc','Activo','required|trim|xss_clean');
$this->form_validation->set_rules('url_opc','URL','required|trim|xss_clean');

        if ($this->form_validation->run() == false)
        {
             $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">'.validation_errors().'</div>' : false);
        }
        else
        {                            
            $data = array(
                    'nombre_opc' => set_value('nombre_opc'),
					'seguridad_opc' => set_value('seguridad_opc'),
					'esadmin_opc' => set_value('esadmin_opc'),
					'espagina_opc' => set_value('espagina_opc'),
					'activo_opc' => set_value('activo_opc'),
					'url_opc' => set_value('url_opc')
            );
			if ($this->opciones_model->add($data) == TRUE)
			{
				//$this->data['custom_error'] = '<div class="form_ok"><p>Added</p></div>';
				// or redirect
				redirect(base_url('panel/seg/opciones/manage/'));
			}
			else
			{
				$this->data['custom_error'] = '<div class="form_error"><p>An Error Occured.</p></div>';
			}
		}
		
		

		$this->data["scripts"]="";
		$this->data["main_content"] = 'panel/seg/opciones_add';
		$this->load->view('panel/panel_template',$this->data);
    }	
    
    function edit($id){        
        $this->load->library('form_validation');
		$this->data['custom_error'] = '';
		$this->form_validation->set_rules('nombre_opc','Nombre','required|trim|xss_clean');
$this->form_validation->set_rules('seguridad_opc','Cadena de seguridad','required|trim|xss_clean');
$this->form_validation->set_rules('esadmin_opc','Es Admin Menu','required|trim|xss_clean');
$this->form_validation->set_rules('espagina_opc','Es Pagina','required|trim|xss_clean');
$this->form_validation->set_rules('activo_opc','Activo','required|trim|xss_clean');
$this->form_validation->set_rules('url_opc','URL','required|trim|xss_clean');

        if ($this->form_validation->run() == false)
        {
             $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">'.validation_errors().'</div>' : false);
        }
        else
        {                            
            $data = array(
                    'nombre_opc' => $this->input->post('nombre_opc'),
					'seguridad_opc' => $this->input->post('seguridad_opc'),
					'esadmin_opc' => $this->input->post('esadmin_opc'),
					'espagina_opc' => $this->input->post('espagina_opc'),
					'activo_opc' => $this->input->post('activo_opc'),
					'url_opc' => $this->input->post('url_opc')
            );
			if ($this->opciones_model->edit($data,'id_opc',$this->input->post('id_opc')) == TRUE)
			{
				redirect(base_url('panel/seg/opciones/manage/'));
			}
			else
			{
				$this->data['custom_error'] = '<div class="form_error"><p>An Error Occured</p></div>';

			}
		}
		$this->data['result'] = $this->opciones_model->get('id_opc,nombre_opc,seguridad_opc,esadmin_opc,espagina_opc,activo_opc,url_opc','id_opc = '.$id,1,0,true);

		$this->data["scripts"]=array('plugins/data-tables/jquery.dataTables.js',
                           'plugins/data-tables/DT_bootstrap.js');
		$this->data["main_content"] = 'panel/seg/opciones_edit';
		$this->load->view('panel/panel_template',$this->data);
    }
	
    function delete($id){
            //$ID =  $this->uri->segment(4);
            $this->opciones_model->delete('id_opc',$id);
            redirect(base_url('panel/seg/opciones/manage/'));
    }
}

/* End of file opciones.php */
/* Location: ./system/application/controllers/opciones.php */