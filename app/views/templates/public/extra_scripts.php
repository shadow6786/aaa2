		<script src="<?php echo cdn_base("js/jquery-latest.js");?>"></script>
		<script src="<?php echo cdn_base("js/bootstrap.min.js");?>"></script>
		<script src="<?php echo cdn_base("js/theme.js");?>"></script>
		<script type="text/javascript" src="<?php echo cdn_base("js/index-slider.js");?>"></script>	
		<?php
		if (isset($scripts) && is_array($scripts)) {
			//Auxiliar Scripts - Call JS you will only use in this page in the controller.
			foreach ($scripts as $script) {
				$cad = substr($script, 0, 4);
				if ($cad == "http")
					echo "<script src=\"" . $script . "\" type=\"text/javascript\"></script>";
				else
					echo "<script src=\"" . cdn_base($script) . "\" type=\"text/javascript\"></script>";
			}
		}
		?>
	</body>
	</html>