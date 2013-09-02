		<script type="text/javascript" src="<?= cdn_base("js/jquery-1.8.2.min.js"); ?>"></script>
		<script type="text/javascript" src="<?= cdn_base("js/jquery.cookie.js"); ?>" ></script>
		<script type="text/javascript" src="<?= cdn_base("js/jquery.cookie.js"); ?>"></script>
		<script type="text/javascript" src="<?= cdn_base("js/jquery-ui.min.js"); ?>"></script>
		<script type="text/javascript" src="<?= cdn_base("js/iris.min.js"); ?>"></script>
		<script type="text/javascript" src="<?= cdn_base("js/bootstrap.js"); ?>"></script>
		<script type="text/javascript" src="<?= cdn_base("js/jquery.flexslider-min.js"); ?>"></script>
		<script type="text/javascript" src="<?= cdn_base("js/jquery.isotope.js"); ?>"></script>
		<script type="text/javascript" src="<?= cdn_base("js/jquery.fancybox.packf066.js?v=2.1.0"); ?>"></script>
		<script type="text/javascript" src="<?= cdn_base("rs-plugin/js/jquery.themepunch.plugins.min.js"); ?>"></script>
		<script type="text/javascript" src="<?= cdn_base("rs-plugin/js/jquery.themepunch.revolution.min.js"); ?>"></script>
		<script type="text/javascript" src="<?= cdn_base("js/revolution.custom.js"); ?>"></script>
		<script type="text/javascript" src="<?= cdn_base("js/custom.js"); ?>"></script>
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