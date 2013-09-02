<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function getmymenu($usr)
{
	//$ci será como $this
	$ci =& get_instance();
	
	//patron singelton para devolver siempre una instancia del menu desde la sesión, para no recargar la BD.
	if ($ci->session->userdata("GNmenu") == "" || $ci->session->userdata("GNmenu")  == null)
	{ 
		//funcion recursiva que trae todos los elementos del menú en un mismo menú anidado agrupado por el padre.
		$ci->session->set_userdata("GNmenu",get_menu_por_padre("0",$usr));
	}
	
	return $ci->session->userdata("GNmenu");	
	
}
	
function get_menu_por_padre($padre, $usr)
{
	
	$ci =& get_instance();
	$items = array();
	$sql = "select DISTINCT(op.id_opc), op.nombre_opc, op.url_opc, op.espagina_opc
from seg_opciones op, seg_usuariosroles ur, seg_permisos p
where op.menu_opc = ".$padre."
and ur.usuario_uro = ".$usr."
and ur.rol_uro = p.rol_per 
and op.id_opc = p.opcion_per";
	

	$query = $ci->db->query($sql);
	$results = $query->result();
	
	 foreach($results as $result) {
		$child_array = get_menu_por_padre($result->id_ufe,$usr);
		if(sizeof($child_array) == 0) {
			array_push($items, array($result->name_ufe=>$result->link_ufe));
		} else {
			array_push($items, array(array($result->name_ufe=>$result->link_ufe), $child_array));
		}
	}
	
	return $items;
}        
?> 
