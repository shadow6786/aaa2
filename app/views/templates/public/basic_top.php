<?php $conf = load_settings(); ?>
<!DOCTYPE html>
<html>
<head>
	<title>Business Template</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	
    <!-- Styles -->
    <link href="<?php echo cdn_base("css/bootstrap/bootstrap.min.css"); ?>" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo cdn_base("css/compiled/bootstrap-overrides.css"); ?>" type="text/css" />
    <link rel="stylesheet" type="text/css" href="<?php echo cdn_base("css/compiled/theme.css"); ?>" />

    <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,900,300italic,400italic,700italic,900italic' rel='stylesheet' type='text/css' />

    <link rel="stylesheet" href="<?php echo cdn_base("css/compiled/index.css"); ?>" type="text/css" media="screen" />    
    <link rel="stylesheet" type="text/css" href="<?php echo cdn_base("css/lib/animate.css"); ?>" media="screen, projection" />    

    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
	<?php $this->load->view("templates/public/extra_css"); ?>
	<!--
	<script type="text/javascript" src="<?= cdn_base("js/jquery-1.8.2.min.js"); ?>"></script>
	<script type="text/javascript" src="<?= cdn_base("js/jquery-ui.min.js"); ?>"></script> -->
</head>
<body class="pull_top">