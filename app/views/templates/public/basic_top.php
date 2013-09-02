<?php $conf = load_settings(); ?>
<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $conf['nombre']; ?></title>
		<meta name="keywords" content="" />
		<meta name="description" content="" />
		<meta name="author" content="" />
		<meta name="robots" content="follow, index" />
		<!--  SEO STUFF END -->
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<!--  revolution slider plugin : begin -->
		<link rel="stylesheet" type="text/css" href="<?= cdn_base("rs-plugin/css/settings.css"); ?>" media="screen" />
		<link rel="stylesheet" type="text/css" href="<?= cdn_base("css/rs-responsive.css"); ?>" media="screen" />
		<!--  revolution slider plugin : end -->
		<link rel="stylesheet" href="<?= cdn_base("css/bootstrap.css"); ?>" />
		<link rel="stylesheet" href="<?= cdn_base("css/custom.css"); ?>" />
		<link rel="stylesheet" href="<?= cdn_base("css/styler.css"); ?>" />
		<link rel="stylesheet" href="<?= cdn_base("css/isotope.css"); ?>" />
		<link rel="stylesheet" href="<?= cdn_base("css/color_scheme.css"); ?>" />
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,400italic,600,600italic,700,700italic" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" href="<?= cdn_base("css/font-awesome.css"); ?>" />
		<link rel="stylesheet" href="<?= cdn_base("css/font-awesome-ie7.css"); ?>" />
		<link rel="stylesheet" href="<?= cdn_base("css/flexslider.css"); ?>" />
		<link rel="stylesheet" href="<?= cdn_base("css/jquery.fancyboxf066.css?v=2.1.0"); ?>" type="text/css" media="screen" />
		<!--[if lte IE 8]>
		<link rel="stylesheet" type="text/css" href="<?= cdn_base("css/IE-fix.css"); ?>" />
		<![endif]-->
		<script type="text/javascript" src="<?= cdn_base("js/jquery-1.8.2.min.js"); ?>"></script>
		<?php $this->load->view("templates/public/extra_css"); ?>
	</head>
	<body>
		<div id="out_container">
			<!-- THE LINE AT THE VERY TOP OF THE PAGE -->
        	<div class="top_line"></div>
