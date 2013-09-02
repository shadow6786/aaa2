<?php 

class Mysecurity extends CI_model {
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	function passwordencrypt($unsecpass)
	{
		$this->load->library("encrypt");
		$len = strlen($unsecpass);
		
		if($len < 35)
		{
			$unsecpass = $this->encrypt->sha1($unsecpass);
		}

		if($len < 128)
		{
			$password = $this->encrypt->encode($unsecpass);
		} else {
			$password = $unsecpass;
		}

		return $password;
	}
	
	function password_reset($user, $pass)
	{
		$this->db->update('sec_users',array("passwordhash_usr" => "","password_usr" => $this->passwordencrypt($pass)),"`email_usr` = ".$this->db->escape($user["email_usr"]));
	}
	
	function checkpassword($passwords)
	{
		$this->load->library("encrypt");
		$ret = NULL;
		$pass1 = $unsecpass = $this->encrypt->sha1($passwords["pass1"]);
		$pass2 = $password = $this->encrypt->decode($passwords["pass2"]);
		var_dump($pass1);
		var_dump($pass2);
		if($pass1 == $pass2)
		{
			$ret = TRUE;
		}
		
		return $ret;

	}
	
	function login($data)
	{
		$ret = NULL;
		$email = $data["email"];
		$pass1 = $data["password"];
		
		$sql = "SELECT * FROM seg_usuarios WHERE usuario_usr = ".$this->db->escape($email)." limit 1";
		$query = $this->db->query($sql);
		
		if($query->num_rows() == 1)
		{
			$result = $query->result();
			$user = $result[0];
			$passwords = array(
								"pass1" => $pass1,
								"pass2" => $user->password_usr
							   );
			
			if($this->mysecurity->checkpassword($passwords))
			{
				
				$ret = TRUE;
				$data = array(
								"user_lus" => $user->id_usr,
								"sessionid_lus" => $this->session->userdata("session_id"),
								"loginon_lus" => date("Y-m-d H:i:s"),
								"ip_lus" => $_SERVER["REMOTE_ADDR"]
							 );
				$this->loginlog($data);
				$id = $user->id_usr;
				$this->autologin($id, FALSE);
				if($this->input->post("remember") && $this->input->post("remember") == 1)
				{
					$this->rememberme($id);
				}
				//$this->mysecurity->redirect(); //to-do redirect to prev. link
				redirect('/panel/welcome');
			}
		}
		
		return $ret;
	}
	
	function autologin($id,$force = NULL)
	{
		$ret = NULL;		
		if($force)
		{
			$forcewhere = " AND activo_usr = 1 ";
		} else {
			$forcewhere = "";
		}
		
		//$sql = "SELECT * FROM sec_users u LEFT JOIN pla_customers c ON u.customer_usr = c.id_cus WHERE id_usr = ".$this->db->escape($id).$forcewhere;
		$sql = "SELECT * FROM seg_usuarios WHERE id_usr = ".$this->db->escape($id).$forcewhere;

		$query = $this->db->query($sql);
		
		if($query->num_rows() == 1)
		{
			$result = $query->result();
			$user = $result[0];
			$ret = TRUE;
		}
		
		$this->session->set_userdata('id_usr', $user->id_usr);
		//$this->session->set_userdata('maincustomeruser_usr', $user->maincustomeruser_usr);
		//$this->session->set_userdata('customer_usr', $user->customer_usr);
		$this->session->set_userdata('enable_usr', $user->enable_usr);		
		$this->session->set_userdata('fname_usr', $user->fname_usr);
		$this->session->set_userdata('lname_usr', $user->lname_usr);
		$this->session->set_userdata('email_usr', $user->email_usr);
		$this->session->set_userdata('userfeatures', $this->get_userfeatures($user->id_usr));
		if (!is_null($user->id_file)) {
			$this->load->model('files_model');
			$file = $this->files_model->get_file($user->id_file);
			$this->session->set_userdata('photo', $file['filename']);
		} else {
			$this->session->set_userdata('photo', NULL);
		}
		return $ret;
	}
	
	function redirect()
	{
		// The security may check the previous page that fails security
		// Delete that page from session and redirect to that page
		// If fails will go to default, all other ecenarios go to default
		$id = $this->session->userdata("id_usr");
		if($id)
		{
			$sql = "SELECT link_ufe, defaultfeature_per FROM (SELECT id_usr FROM sec_users WHERE id_usr = ".$this->db->escape($id)." ) u 
					LEFT JOIN sec_usersrols ur ON u.id_usr = ur.user_uro 
					LEFT JOIN sec_roles r ON r.id_rol = ur.rol_uro
					LEFT JOIN sec_permissions p ON p.rol_per = r.id_rol
					LEFT JOIN sec_userfeatures uf ON p.feature_per = uf.id_ufe

					ORDER BY order_ufe";

			$query = $this->db->query($sql);
			$url = NULL;
			$url2 = NULL;
			
			if($query->num_rows() > 0)
			{
				foreach($query->result() as $row)
				{
					if($row->defaultfeature_per == 1)
					{
						$url = $row->link_ufe;
					} else {
						if(!$url2)
						{
							$url2 =  $row->link_ufe;
						}
					}
					
					if(is_null($url) && !is_null($url2))
					{
						$url = $url2;
					}
				}
				
				if(!$url)
				{
					$this->cleansession();
					$this->cleanrememberme();
					redirect("panel/auth/login?e=2");
				} else 
				{
					redirect($url);
				}
			} else {
				$this->cleansession();
				$this->cleanrememberme();
				redirect("panel/auth/login?e=2");
			}
		}
	}
	
	function check($secstring = NULL)
	{
		if($secstring)
		{
			// check security
		} else {
			$this->redirect();
		}
	}
	
	function loginlog($data)
	{
		return $this->db->insert("sec_loginlog",$data);
	}
	
	private function rememberme($id)
	{
		$hash = md5(rand(10000000,99999999).time());
		
		$this->input->set_cookie("seccookierememberme",$hash,60*60*24*30);

		$data = array (
						"cookiehash_usr" => $hash
					  );
		$where = array (
						"id_usr" => $id
					  );
		$this->db->update("sec_users",$data,$where);

	}
	
	function logged_cookie()
	{
		$ret = FALSE;
		$hash = $this->input->cookie("seccookierememberme",TRUE);
		
		$sql = "SELECT * FROM `sec_users` where cookiehash_usr = ".$this->db->escape($hash);
		$query = $this->db->query($sql);

		if($query->num_rows() > 0)
		{
			$ret = TRUE;
		}

		return $ret;

	}
	
	function get_userfeatures($id)
	{
		$sql = "SELECT uf.securitystring_ufe as secf, link_ufe, page_ufe FROM (SELECT id_usr FROM sec_users WHERE id_usr = ".$this->db->escape($id)." ) u 
				LEFT JOIN sec_usersrols ur ON u.id_usr = ur.user_uro 
				LEFT JOIN sec_roles r ON r.id_rol = ur.rol_uro
				LEFT JOIN sec_permissions p ON p.rol_per = r.id_rol
				LEFT JOIN sec_userfeatures uf ON p.feature_per = uf.id_ufe";
				
				
		$query = $this->db->query($sql);
		$data = FALSE;

		if($query->num_rows() > 0)
		{
			foreach($query->result() as $row)
			{
				if($row->page_ufe == 1)
				{
					$data[$row->secf] = $row->link_ufe;
				} else {
					$data[$row->secf] = "0";
				}
			}
		}
		return $data;
	}
	
	function verifysecurity($lookfor)
	{
		$ret = TRUE;
		if((int)$this->session->userdata("id_usr") > 0)
		{
			
				if($this->session->userdata("enable_usr") == 1)
				{
					$security = $this->session->userdata("userfeatures");
					if(key_exists($lookfor, $security))
					{
						// Pass the security check
						if($security[$lookfor] != "0")
						{
							$this->session->set_userdata("userseclastlink", $security[$lookfor]);
						}
					} else {
						$ret = FALSE;
						redirect("panel/auth/login?e=1");	
					}
				} else {
					$ret = FALSE;
					redirect("panel/auth/login?e=4");
				}
			
		} else {
			if($this->session->userdata("id_usr") == 0 && $this->session->userdata("email_usr") == "na" )
			{
				$ret = FALSE;
				redirect("panel/auth/login?e=3");
			} else {
				$ret = FALSE;
				redirect("panel/auth/login?e=1");	
			}
			
		}
		return $ret;	
	}
	
	function logout()
	{
		$this->cleansession();
		$this->cleanrememberme();
		
		redirect("panel/auth/login");
	}
	
	function cleanrememberme()
	{
		$this->input->set_cookie("seccookierememberme",0,60*60*24*30);
	}
	
	function cleansession()
	{
		if($this->session->userdata("id_usr") && (int)$this->session->userdata("id_usr") > 0)
		{
			$this->session->set_userdata("id_usr","0");
			$this->session->set_userdata('enable_usr', "na");
			$this->session->set_userdata('fname_usr', "na");
			$this->session->set_userdata('lname_usr', "na");
			$this->session->set_userdata('email_usr', "na");
			$this->session->set_userdata('fbid_usr', "na");
			$this->session->set_userdata('company_cus', "na");
			$this->session->set_userdata('GNmenu', "");
			$this->session->set_userdata('userfeatures', "na");
			$this->session->set_userdata('maincustomeruser_usr', "na");
			$this->session->set_userdata('photo', 'na');
			
			$this->session->sess_destroy();
		}
	}
	
	function getmyroles()
	{
		$data = FALSE;
		$sql = "
		SELECT r.name_rol FROM (SELECT id_usr FROM sec_users WHERE id_usr = ".$this->db->escape($this->session->userdata("id_usr"))." ) u 
		LEFT JOIN sec_usersrols ur ON u.id_usr = ur.user_uro 
		LEFT JOIN sec_roles r ON r.id_rol = ur.rol_uro";

		$query = $this->db->query($sql);

		if($query->num_rows() > 0)
		{
			$data= array();
			foreach($query->result() as $row)
			{
				$data[] = $row->name_rol;
			}
		}

		return $data;
	}

	/*function getmymenu()
	{
		//funcion recursiva que trae todos los elementos del menú en un mismo menú anidado agrupado por el padre.
		return $this->get_menu_por_padre();
	}
	
	function get_menu_por_padre($padre = 0)
	{
		$items = array();
		$sql = "select  DISTINCT(f.id_ufe), f.name_ufe, f.link_ufe, f.link_ufe,f.page_ufe
		from sec_userfeatures f, sec_usersrols u, sec_permissions p
		where f.menu_ufe = ". $padre. "
		and u.user_uro = ". $this->db->escape($this->session->userdata("id_usr")) . "
		and u.rol_uro = p.rol_per
		and f.id_ufe = p.feature_per
		order by f.order_ufe";

		$query = $this->db->query($sql);
		$results = $query->result();
		
		 foreach($results as $result) {
            $child_array = $this->get_menu_por_padre($result->id_ufe);
            if(sizeof($child_array) == 0) {
                array_push($items, array($result->name_ufe,$result->link_ufe, $result->page_ufe));
            } else {
                array_push($items, array(array($result->name_ufe,$result->link_ufe, $result->page_ufe), $child_array));
            }
        }
        
        return $items;
		
		
		
	}*/
}