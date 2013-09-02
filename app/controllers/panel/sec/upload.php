<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Upload extends CI_Controller {

   public function __construct()
   {
      parent::__construct();
      $this->load->model('files_model');
      $this->load->database();
      $this->load->helper('url');
   }
 
   public function index()
   {
      $this->load->view('upload');
   }

   public function files()
   {
      $files = $this->files_model->get_files();
      $this->load->view('files', array('files' => $files));
   }

   public function delete_file($id_file)
   {
      if ($this->files_model->delete_file($id_file))
      {
         $status = 'success';
         $msg = 'File successfully deleted';
      }
      else
      {
         $status = 'error';
         $msg = 'Something went wrong when deleteing the file, please try again';
      }
      echo json_encode(array('status' => $status, 'msg' => $msg));
   }

   public function upload_file()
   {
      $status = "";
      $msg = "";
      $file_element_name = 'userfile';
       
      $config['upload_path'] = './static/files/';
      $config['allowed_types'] = 'gif|jpg|png|doc|txt';
      $config['max_size']  = 1024 * 8;
      $config['encrypt_name'] = TRUE;
 
      $this->load->library('upload', $config);
 
      if (!$this->upload->do_upload($file_element_name)) {
         $status = 'error';
         $msg = $this->upload->display_errors('', '');
      } else {
         $data = $this->upload->data();
         $id_file = $this->files_model->insert_file($data);
         if($id_file) {
            $status = "success";
            $msg = "File successfully uploaded";
         } else {
            unlink($data['full_path']);
            $status = "error";
            $msg = "Something went wrong when saving the file, please try again.";
         }
      }
      @unlink($_FILES[$file_element_name]);
      echo json_encode(array('status' => $status, 'msg' => $msg));
   }

}

/* End of file upload.php */
/* Location: .//C/wamp/www/gns/app/controllers/panel/upload.php */