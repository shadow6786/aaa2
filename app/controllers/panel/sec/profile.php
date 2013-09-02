<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CI_Controller {

	private $data;
	public $rules = array(
		'fname_usr' => array(
			'field' => 'fname_usr',
			'label' => 'First name',
			'rules' => 'trim|required|xss_clean'
		),
		'lname_usr' => array(
			'field' => 'lname_usr',
			'label' => 'Last name',
			'rules' => 'trim|required|xss_clean'
		),
		'email_usr' => array(
			'field' => 'email_usr',
			'label' => 'Email',
			'rules' => 'trim|required|valid_email|xss_clean'
		)
	);

	public $rules_password = array(
		'old_password' => array(
			'field' => 'old_password',
			'label' => 'Contraseña anterior',
			'rules' => 'trim|required|callback__verify_old_password'
		),
		'password_usr' => array(
			'field' => 'password_usr',
			'label' => 'Nueva contraseña',
			'rules' => 'trim|required|matches[rpassword]'
		),
		'rpassword' => array(
			'field' => 'rpassword',
			'label' => 'Confirmar password',
			'rules' => 'trim|matches[password_usr]'
		)
	);

	private $id_user;

	public function __construct()
	{
		parent::__construct();
		$this->id_user = $this->session->userdata('id_usr');
		$this->data["title"] = "Mi Perfil";
		$this->data["page_segment"] = "Mi perfil";
		$this->data["father"]="Seguridad";
		$this->load->model('panel/sec/users_model','user');
		$this->load->model("panel/auth/mysecurity");
		$this->load->model('files_model');
 		$this->load->helper('form');
 		$this->load->library('form_validation');
 		$this->data["scripts"]=array('plugins/ajax-file-uploader/ajaxfileupload.js');
	}

	public function index()
	{   
		$this->form_validation->set_rules($this->rules);
		$this->form_validation->set_error_delimiters('<div class="inline_validation_message">','</div>');
		if ($this->form_validation->run() == TRUE) {
			$data = $this->array_request($_POST);
			$this->user->edit($data, 'id_usr', $this->id_user);
			$this->mysecurity->autologin($this->id_user);
		}
		$this->data['user'] = $this->user->get_user($this->id_user);
		if (!is_null($this->data['user']['id_file'])) {
			$file = $this->files_model->get_file($this->data['user']['id_file']);
			$this->data['user']['photo'] = $file['filename'];
		}
		$this->data["main_content"] = 'panel/sec/profile';
		$this->load->view('panel/panel_template', $this->data);
	}

	public function change_password()
	{
		$this->form_validation->set_rules($this->rules_password);
		$this->form_validation->set_error_delimiters('<div class="inline_validation_message">','</div>');
		if ($this->form_validation->run() == TRUE) {
			$data = $this->array_request($_POST);
			$data['password_usr'] = $this->mysecurity->passwordencrypt($data["password_usr"]);
			unset($data['old_password'], $data['rpassword']);
			$this->user->edit($data, 'id_usr', $this->id_user);
		}
		$this->load->view('panel/sec/profile_password');
	}

	public function update_photo()
	{
		$this->data['user'] = $this->user->get_user($this->id_user);
		if (!is_null($this->data['user']['id_file'])) {
			$file = $this->files_model->get_file($this->data['user']['id_file']);
			$this->data['user']['photo'] = $file['filename'];
		}
		$this->mysecurity->autologin($this->id_user);
		$this->load->view('panel/sec/profile_photo', $this->data);
	}

	public function delete_photo()
	{
		$this->files_model->delete_file($this->session->userdata('id_file'));
		$this->user->edit(array('id_file' => null), 'id_usr', $this->id_user);

		$this->update_photo();
	}

	public function upload_photo()
	{
		$status = "";
		$msg = "";
		$file_element_name = 'photo';
		$config['upload_path'] = './static/user-files/user-profile/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']  = 1024 * 8;
		$config['encrypt_name'] = TRUE;

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload($file_element_name)) {
			$status = 'ERROR';
			$msg = $this->upload->display_errors('', '');
		} else {
			$data = $this->upload->data();
			$id_file = $this->files_model->insert_file($data);
			if($id_file) {
				$this->user->edit(array('id_file' => $id_file), 'id_usr', $this->id_user);
				$status = "OK";
			} else {
				unlink($data['full_path']);
				$status = "ERROR";
				$msg = "Something went wrong when saving the file, please try again.";
			}
		}
		@unlink($_FILES[$file_element_name]);
		echo json_encode(array('status' => $status, 'msg' => $msg));
	}

	public function array_request($request)
	{
		$data = array();
		foreach ($request as $key => $value) {
			$data[$key] = $this->input->post($key);
		}
		return $data;
	}

	public function _verify_old_password()
	{
		$user = $this->user->get_user($this->id_user);

		$passwords = array(
			"pass1" => $this->input->post('old_password'),
			"pass2" => $user['password_usr']
	   	);
		if ($this->mysecurity->checkpassword($passwords)) {
			return TRUE;
		} else {
			$this->form_validation->set_message('_verify_old_password', 'La %s es incorrecta.');
			return FALSE;
		}
	}

}

/* End of file profile.php */
/* Location: .//C/wamp/www/gns/app/controllers/panel/cms/profile.php */