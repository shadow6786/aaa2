<?php

class Userfeatures extends CI_Controller {
    function __construct() {
        parent::__construct();
		$this->load->library('form_validation');
		$this->load->helper(array('form','url','codegen_helper','menu'));
		$this->load->model('panel/sec/userfeatures_model','',TRUE);
		$this->load->model('panel/sec/roles_model');
		$this->load->model('panel/auth/mysecurity');
		$this->mysecurity->verifysecurity('perm');
		$this->data["title"] = "Asignación de permisos";
		$this->data["page_segment"] = "Asignación de permisos";
		$this->data["father"]="Sec";
	}	
	
	function index(){
		$this->manage();
	}

	function manage(){
        $this->load->library('table');
        $this->load->library('pagination');
        
        //paging
        $config['base_url'] = base_url().'panel/sec/userfeatures/manage/';
        	
        // make sure to put the primarykey first when selecting , 
		//eg. 'userID,name as Name , lastname as Last_Name' , Name and Last_Name will be use as table header.
		// Last_Name will be converted into Last Name using humanize() function, under inflector helper of the CI core.
		$this->data['results'] = $this->userfeatures_model->get("id_ufe,menu_ufe AS Menu_ufe,securitystring_ufe AS Securitystring_ufe,name_ufe AS Name_ufe,link_ufe AS Link_ufe,page_ufe AS Page_ufe,order_ufe AS Order_ufe,active_ufe AS Active_ufe",'',1000,$this->uri->segment(4));
		$this->data["scripts"]=array('plugins/data-tables/jquery.dataTables.js',
                           'plugins/data-tables/DT_bootstrap.js');
		$this->data["main_content"] = 'panel/sec/userfeatures_list';
		$this->load->view('panel/panel_template',$this->data);
    }
	
    function add(){        
        $this->load->library('form_validation');
		$this->data['custom_error'] = '';
		$this->form_validation->set_rules('rol_usr','Rol','required|trim|xss_clean');
		$this->form_validation->set_rules('securitystring_ufe','Securitystring_ufe','required|trim|xss_clean');
		$this->form_validation->set_rules('name_ufe','Name_ufe','required|trim|xss_clean');
		$this->form_validation->set_rules('link_ufe','Link_ufe','required|trim|xss_clean');
		$this->form_validation->set_rules('page_ufe','Page_ufe','required|trim|xss_clean');
		$this->form_validation->set_rules('order_ufe','Order_ufe','required|trim|xss_clean');
		$this->form_validation->set_rules('active_ufe','Active_ufe','required|trim|xss_clean');

        if ($this->form_validation->run() == false)
        {
             $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">'.validation_errors().'</div>' : false);
        }
        else
        {                            
            $data = array(
                    'rol_usr' => set_value('rol_usr'),
            );
			if ($this->userfeatures_model->add($data) == TRUE)
			{
				//$this->data['custom_error'] = '<div class="form_ok"><p>Added</p></div>';
				// or redirect
				redirect(base_url().'panel/sec/userfeatures/manage/');
			}
			else
			{
				$this->data['custom_error'] = '<div class="form_error"><p>An Error Occured.</p></div>';
			}
		}	

		$this->data['roles'] = $this->roles_model->get_roles_combo('id_rol,name_rol');
		$features = $this->userfeatures_model->get_features();	
        $this->data['features'] = json_encode($features); 

		$this->data["scripts"]="plugins/bootstrap-listTree/bootstrap-listTree.js";
		$this->data["main_content"] = 'panel/sec/userfeatures_add';
		$this->load->view('panel/panel_template',$this->data);
    }	
    
    function edit($id){        
        $this->load->library('form_validation');
		$this->data['custom_error'] = '';
		$this->form_validation->set_rules('menu_ufe','Menu_ufe','required|trim|xss_clean');
		$this->form_validation->set_rules('securitystring_ufe','Securitystring_ufe','required|trim|xss_clean');
		$this->form_validation->set_rules('name_ufe','Name_ufe','required|trim|xss_clean');
		$this->form_validation->set_rules('link_ufe','Link_ufe','required|trim|xss_clean');
		$this->form_validation->set_rules('page_ufe','Page_ufe','required|trim|xss_clean');
		$this->form_validation->set_rules('order_ufe','Order_ufe','required|trim|xss_clean');
		$this->form_validation->set_rules('active_ufe','Active_ufe','required|trim|xss_clean');

        if ($this->form_validation->run() == false)
        {
             $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">'.validation_errors().'</div>' : false);
        }
        else
        {                            
            $data = array(
                    'menu_ufe' => $this->input->post('menu_ufe'),
					'securitystring_ufe' => $this->input->post('securitystring_ufe'),
					'name_ufe' => $this->input->post('name_ufe'),
					'link_ufe' => $this->input->post('link_ufe'),
					'page_ufe' => $this->input->post('page_ufe'),
					'order_ufe' => $this->input->post('order_ufe'),
					'active_ufe' => $this->input->post('active_ufe')
            );
			if ($this->userfeatures_model->edit($data,'id_ufe',$this->input->post('id_ufe')) == TRUE)
			{
				redirect(base_url().'panel/sec/userfeatures/manage/');
			}
			else
			{
				$this->data['custom_error'] = '<div class="form_error"><p>An Error Occured</p></div>';

			}
		}
		$this->data['result'] = $this->userfeatures_model->get('id_ufe,menu_ufe,securitystring_ufe,name_ufe,link_ufe,page_ufe,order_ufe,active_ufe','id_ufe = '.$id,1,0,true);

		$this->data["scripts"]=array('plugins/data-tables/jquery.dataTables.js',
                           'plugins/data-tables/DT_bootstrap.js');
		$this->data["main_content"] = 'panel/sec/userfeatures_edit';
		$this->load->view('panel/panel_template',$this->data);
    }
	
    function delete($id){
            //$ID =  $this->uri->segment(4);
            $this->userfeatures_model->delete('id_ufe',$id);
            redirect(base_url().'panel/sec/userfeatures/manage/');
			
    }
						
}

/* End of file userfeatures.php */
/* Location: ./system/application/controllers/userfeatures.php */