<?php if(isset($css) && is_array($css)){
	foreach ($css as $cs) {
		$cad = substr($cs, 0, 4);
		if ($cad == "http")
			echo '<link rel="stylesheet" type="text/css" href="'.$cs.'" />';
		else
			echo '<link rel="stylesheet" type="text/css" href="'.cdn_base($cs).'" />';
	}
}