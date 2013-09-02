<?php 

class Users extends CI_model {
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library("encrypt");
		$this->load->model("panel/auth/mysecurity");
		//$this->load->helper("communication");
	}
	
	function getuser($data = NULL)
	{
		// example of data :     $data = array("id_usr" => "1");
		 
		$ret = NULL;
		$where = " WHERE ";
		if($data)
		{
			$and = " ";
			foreach($data as $field => $value)
			{
				$where .= $and."`".$field."` = ".$this->db->escape($value)." ";
				$and = " AND ";
			}
			
			$sql = "SELECT * FROM `sec_users` ".$where;
			$query = $this->db->query($sql);

			if($query->num_rows() > 0)
			{
				$ret = array();
				foreach($query->result() as $row)
				{
					$ret[] = get_object_vars($row);
				}
			}
		}
		return $ret;
	}

	function createuserunverified($data)
	{
		if(key_exists("email_usu", $data) && !is_null($data["email_usu"]) && strlen($data["email_usu"]) > 6)
		{
			$this->db->insert('sec_usersunverify',$data);
		}
	}

	function verifyemail($hash = null)
	{
		if(!is_null($hash) && strlen($hash) > 10)
		{
			// false trigger the error and true means the user has been created

			$ret = FALSE;

			$sql = "SELECT * FROM `sec_usersunverify` where activated_usu = 0 AND mailverificationhash_usu = ".$this->db->escape($hash);
			$query = $this->db->query($sql);

			if($query->num_rows() > 0)
			{
				foreach($query->result() as $row)
				{
					$data = $row;
				}
				if($this->signupcustomer($data))
				{
					$ret = TRUE;
					$this->db->update('sec_usersunverify',array("activated_usu" => 1),"`id_usu` = '".$data->id_usu."'");
				} else {
					$ret = FALSE;
				}
			}
			return $ret;
		}
	}

	function signupcustomer($data)
	{
		$ret = TRUE;

		if(!$this->exist_email($data->email_usu))
		{
			/*$cdata = array(
							"plan_cus" => 0,
							"company_cus" => $data->company_usu,
							"createdon_cus" => date("Y-m-d H:i:s")
						);
			$this->db->insert("pla_customers",$cdata);
			$customerid = $this->db->insert_id();
			*/
			$udata = array(
							//"customer_usr" => $customerid,
							//"maincustomeruser_usr" => 1,
							"fname_usr" => $data->fname_usu,
							"lname_usr" => $data->lname_usu,
							"email_usr" => $data->email_usu,
							"phone_usr" => $data->phone_usu,
							"password_usr" => $data->password_usu,
							//"reasonsignup_usr" => $data->reasonsignup_usu,
							//"companysize_usr" => $data->companysize_usu,
							"enable_usr" => 1,
							"createdon_usr" => date("Y-m-d H:i:s")
						  );
			$this->createuser($udata);
			$id = $this->db->insert_id();
			$this->setdefaultcustomerrol($id);
			sendwelcomemail($data->email_usu);
		} else {
			$ret = NULL;
		}

		return $ret;

	}

	function createuser($data)
	{
		$data["password_usr"] = $this->mysecurity->passwordencrypt($data["password_usr"]);

		if(key_exists("email_usr", $data) && !is_null($data["email_usr"]) && strlen($data["email_usr"]) > 6)
		{
			$this->db->insert('sec_users',$data);
		}

		return $this->db->insert_id();
	}

	function updateuser($data)
	{
		if(isset($data["password_usr"]))
		{
			$data["password_usr"] = $this->mysecurity->passwordencrypt($data["password_usr"]);
		}
		$id = $data["id_usr"];
		unset($data["id_usr"]);

		if($this->controller == "user")
		{
			$where = array("id_usr" => $id,"customer_usr" => $this->session->userdata("customer_usr"));
		} else {
			$where = array("id_usr" => $id);
		}

		$this->db->update('sec_users', $data, $where);

	}

	function exist_email($email)
	{
		$ret = NULL;
		$sql = "SELECT * FROM sec_users WHERE email_usr LIKE ".$this->db->escape($email);
		$query = $this->db->query($sql);
		
		if($query->num_rows() > 0)
		{
			$ret = TRUE;
		}
		
		return $ret;	
	}
	
	function exist_verifyemail($email)
	{
		$ret = NULL;
		$sql = "SELECT * FROM sec_usersunverify WHERE activated_usu = 0 AND email_usu LIKE ".$this->db->escape($email);
		$query = $this->db->query($sql);

		if($query->num_rows() > 0)
		{
			$ret = TRUE;
		}
		
		return $ret;
	}
	
	function setdefaultcustomerrol($id)
	{
		// This is the DEFAULT ROL for the Customer
		$defaultrol = 2;
		$data = array(
						"user_uro" => $id,
						"rol_uro" => $defaultrol,
					 );
		$this->db->insert('sec_usersrols',$data);
	}

	function setdefaultuserrol($id)
	{
		$defaultrol = 2;
		$data = array(
						"user_uro" => $id,
						"rol_uro" => $defaultrol,
					 );
		$this->db->insert('sec_usersrols',$data);
	}

	function getcustomer()
	{
			$sql = "SELECT * FROM sec_users WHERE maincustomeruser_usr = 1 AND customer_usr = ".$this->session->userdata("customer_usr");
			$query = $this->db->query($sql);

			if($query->num_rows() > 0)
			{
				foreach($query->result() as $row)
				{
					$data = get_object_vars($row);
				}
			}

			return $data;
	}

	function saveuser($data)
	{
		$this->db->update("sec_users",$udata,$where);
	}

	function updateprofile($data)
	{
		if(key_exists("password_usr", $data))
		{
			$udata = array(
							"fname_usr" => $this->input->post("fname_usr"),
							"lname_usr" => $this->input->post("lname_usr"),
							"phone_usr" => $this->input->post("phone_usr"),
							"password_usr" => $this->mysecurity->passwordencrypt($data["password_usr"])
						 );
		} else {
			$udata = array(
							"fname_usr" => $this->input->post("fname_usr"),
							"phone_usr" => $this->input->post("phone_usr"),
							"lname_usr" => $this->input->post("lname_usr")
						 );
		}
		$where = array(
							"id_usr" => $this->session->userdata("id_usr")
					  );

		$this->db->update("sec_users",$udata,$where);

		if(key_exists("company_cus", $data))
		{
			$data = array(
							"company_cus" => $data["company_cus"]
						 );

			$where = array(
							"id_cus" => $this->session->userdata("customer_usr") 
						  );
			//$this->db->update("pla_customers",$data,$where);
			$this->session->set_userdata('company_cus', $data["company_cus"]);
		}
	}

	function getroles()
	{
		$data = FALSE;
		$sql = "
		SELECT id_rol, r.name_rol FROM sec_roles r WHERE customer_rol = ".$this->session->userdata("customer_usr")." OR (admin_rol = 0 AND user_rol = 1)";

		$query = $this->db->query($sql);

		if($query->num_rows() > 0)
		{
			$data= array();
			foreach($query->result() as $row)
			{
				$data[$row->id_rol] = $row->name_rol;
			}
		}
		return $data;
	}
	
	function admingetroles()
	{
		$data = FALSE;
		$sql = "
		SELECT id_rol, r.name_rol FROM sec_roles r WHERE customer_rol = 0";

		$query = $this->db->query($sql);

		if($query->num_rows() > 0)
		{
			$data= array();
			foreach($query->result() as $row)
			{
				$data[$row->id_rol] = $row->name_rol;
			}
		}
		return $data;
	}
	
	function deleteuser($id)
	{
		if($this->controller == "user")
		{
			$where = array("id_usr" => $id,"customer_usr" => $this->session->userdata("customer_usr"),"maincustomeruser_usr" => "0");
		} else {
			$where = array("id_usr" => $id);
		}
		
		$query = $this->db->delete("sec_users",$where);
		if($query)
		{
			$query = $this->db->query("SELECT id_uro as tot FROM `sec_usersrols` ur LEFT JOIN `sec_users` u ON u.id_usr = ur.user_uro WHERE ISNULL(id_usr)");
			if($query->num_rows() > 0)
			{
				$data= array();
				$c = "";
				$ids = "";
				foreach($query->result() as $row)
				{
					$ids .= $c."'".$row->tot."'";
					$c = ",";
				}
				$query = $this->db->query("DELETE FROM `sec_usersrols` WHERE `id_uro` IN (".$ids.")");
			}
		}
	}
	
	function setroles($roles, $id)
	{
		$query = $this->db->delete("sec_usersrols",array("user_uro" => $id));
		if(is_array($roles))
		{
			foreach($roles as $rol)
			{
				$query = $this->db->insert("sec_usersrols",array("user_uro" => $id, "rol_uro" => $rol));
			}
		}
	}
	
	function getuserrol($id)
	{
		$data = FALSE;
		$sql = "
		SELECT id_rol, r.name_rol FROM (SELECT id_usr FROM sec_users WHERE id_usr = ".$this->db->escape($id)." ) u 
		LEFT JOIN sec_usersrols ur ON u.id_usr = ur.user_uro
		LEFT JOIN sec_roles r ON r.id_rol = ur.rol_uro";

		$query = $this->db->query($sql);

		if($query->num_rows() > 0)
		{
			$data= array();
			foreach($query->result() as $row)
			{
				$data[$row->id_rol] = $row->name_rol;
			}
		}

		return $data;
	}
	
	function cleanpresignup()
	{
		$this->db->query("INSERT INTO sec_archiveusersunverify SELECT * FROM `sec_usersunverify` WHERE createdon_usu < ADDDATE(NOW(),INTERVAL -3 DAY);");
		$this->db->query("DELETE FROM `sec_usersunverify` WHERE createdon_usu < ADDDATE(NOW(),INTERVAL -3 DAY);");
	}
	
	function getmanagers()
	{
		$data = FALSE;
		/*
		$query = $this->db->select("id_usr, fname_usr, lname_usr, company_cus, id_cus")
		->from("pla_customers")
		->join("sec_users", "id_cus = customer_usr","left")
		->where(array("maincustomeruser_usr" => "1"))
		->get();

		if($query->num_rows() > 0)
		{
			$data= array();
			foreach($query->result() as $row)
			{
				$data[] = array("id" => $row->id_cus, "name" => $row->fname_usr." ".$row->lname_usr.", ".$row->company_cus);
			}
		}
		return $data;*/
	}
}

