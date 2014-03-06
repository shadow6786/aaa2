<div class="navbar navbar-inverse <?php if($showslider) {echo "navbar-fixed-top";}else{ echo "navbar-static-top";} ?>" role="navigation">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle pull-right" data-toggle="collapse" data-target=".navbar-ex1-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a href="<?php echo base_url("home"); ?>" class="navbar-brand"><strong>AAA Internacional LTDA.</strong></a>
		</div>

		<div class="collapse navbar-collapse navbar-ex1-collapse" role="navigation">
			<ul class="nav navbar-nav navbar-right">
				<li class="active"><a href="<?php echo base_url("home"); ?>">INICIO</a></li>
				<li><a href="<?php echo base_url("web/nosotros"); ?>">NOSOTROS</a></li>
				<li>
					<a href="<?php echo base_url('web/productos'); ?>">PRODUCTOS Y SERVICIOS</a>
				</li>
				<li><a href="<?php echo base_url('web/programas'); ?>">PROGRAMAS</a></li>
				<li><a href="<?php echo base_url('web/contacto'); ?>">CONTACTANOS</a></li>
				<li><a href="<?php echo base_url('panel/auth/login'); ?>">LOGIN</a></li>
				<!-- <li><a href="sign-up.html">Sign up</a></li>
				<li><a href="sign-in.html">Sign in</a></li> -->
			</ul>
		</div>
	</div>
</div>