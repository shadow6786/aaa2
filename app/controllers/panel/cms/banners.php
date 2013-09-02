<?php

class Banners extends CI_Controller {
    
    function __construct() {
        parent::__construct();
		$this->load->library('form_validation');
		$this->load->helper(array('form','url','codegen_helper'));
		$this->load->model('panel/cms/banners_model','',TRUE);
		$this->data["title"] = "Banners";
		$this->data["page_segment"] = "Banners";
		$this->data["father"]="cms";
	}	
	
	function index(){
		$this->manage();
	}

	function manage(){
        $this->load->library('table');
        $this->load->library('pagination');
        
        //paging
        $config['base_url'] = base_url('panel/cms/banners/manage/');

		$this->data['results'] = $this->banners_model->get("id_ban,nombre_ban AS Nombre,descripcion_ban AS Descripcion,imagen_ban AS Imagen,video_ban AS Video,CASE WHEN activo_ban = 1 THEN 'SI' ELSE 'NO' END AS Activo",'',1000,$this->uri->segment(4));
		$this->data["scripts"]=array('plugins/data-tables/jquery.dataTables.js',
                           'plugins/data-tables/DT_bootstrap.js');
		$this->data["main_content"] = 'panel/cms/banners_list';
		$this->load->view('panel/panel_template',$this->data);
    }
	
    function add(){        
        $this->load->library('form_validation');
		$this->data['custom_error'] = '';
		$this->form_validation->set_rules('nombre_ban','Nombre','required|trim|xss_clean');
		$this->form_validation->set_rules('descripcion_ban','Descripcion','required|trim|xss_clean');
		$this->form_validation->set_rules('imagen_ban','Imagen','required|trim|xss_clean');
		$this->form_validation->set_rules('video_ban','Video','required|trim|xss_clean');
		$this->form_validation->set_rules('activo_ban','Activo','required|trim|xss_clean');

        if ($this->form_validation->run() == false)
        {
             $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">'.validation_errors().'</div>' : false);
        }
        else
        {                            
            $data = array(
                    'nombre_ban' => set_value('nombre_ban'),
					'descripcion_ban' => set_value('descripcion_ban'),
					'imagen_ban' => set_value('imagen_ban'),
					'video_ban' => set_value('video_ban'),
					'activo_ban' => set_value('activo_ban')
            );
			if ($this->banners_model->add($data) == TRUE)
			{
				redirect(base_url('panel/cms/banners/manage/'));
			}
			else
			{
				$this->data['custom_error'] = '<div class="form_error"><p>An Error Occured.</p></div>';
			}
		}
		
		$this->data["scripts"]="";
		$this->data["main_content"] = 'panel/cms/banners_add';
		$this->load->view('panel/panel_template',$this->data);
    }	
    
    function edit($id){        
        $this->load->library('form_validation');
		$this->data['custom_error'] = '';
		$this->form_validation->set_rules('nombre_ban','Nombre','required|trim|xss_clean');
		$this->form_validation->set_rules('descripcion_ban','Descripcion','required|trim|xss_clean');
		$this->form_validation->set_rules('imagen_ban','Imagen','required|trim|xss_clean');
		$this->form_validation->set_rules('video_ban','Video','required|trim|xss_clean');
		$this->form_validation->set_rules('activo_ban','Activo','required|trim|xss_clean');

        if ($this->form_validation->run() == false)
        {
             $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">'.validation_errors().'</div>' : false);
        }
        else
        {                            
            $data = array(
                    'nombre_ban' => $this->input->post('nombre_ban'),
					'descripcion_ban' => $this->input->post('descripcion_ban'),
					'imagen_ban' => $this->input->post('imagen_ban'),
					'video_ban' => $this->input->post('video_ban'),
					'activo_ban' => $this->input->post('activo_ban')
            );
			if ($this->banners_model->edit($data,'id_ban',$this->input->post('id_ban')) == TRUE)
			{
				redirect(base_url('panel/cms/banners/manage/'));
			}
			else
			{
				$this->data['custom_error'] = '<div class="form_error"><p>An Error Occured</p></div>';

			}
		}
		$this->data['result'] = $this->banners_model->get('id_ban,nombre_ban,descripcion_ban,imagen_ban,video_ban,activo_ban','id_ban = '.$id,1,0,true);

		$this->data["scripts"]=array('plugins/data-tables/jquery.dataTables.js',
                           'plugins/data-tables/DT_bootstrap.js');
		$this->data["main_content"] = 'panel/cms/banners_edit';
		$this->load->view('panel/panel_template',$this->data);
    }
	
    function delete($id){
            //$ID =  $this->uri->segment(4);
            $this->banners_model->delete('id_ban',$id);
            redirect(base_url('panel/cms/banners/manage/'));
    }
}

/* End of file banners.php */
/* Location: ./system/application/controllers/banners.php */