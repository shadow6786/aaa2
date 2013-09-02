<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function load_settings()
{
	//$ci será como $this
	$ci =& get_instance();
	$ci->load->database();
	$query = $ci->db->get('set_variables');

	if($query->num_rows())
	{
		$data= array();
		foreach($query->result() as $row)
		{
			$data[$row->variable_set] = $row->valor_set;
		}
	}
	
	return $data;
}

function set_setting_item($key, $value)
{
	$CI =& get_instance();
	$CI->db->update('set_variables', array('valor_set' => $value), array('variable_set' => $key));
}

