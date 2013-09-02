<style type="text/css">
/*    #collision-header #collision-slider {
            background: none;
            box-shadow: none;
            padding: 0;
            border-radius: 0;
            margin: 0px auto;
            border: none;
            position: relative;
            top: -5px;
            overflow: visible !important;
        }
            #collision-header #collision-slider .flex-viewport { overflow: hidden; !important;}*/
</style>
<div class="main-content">
	<div class="container">
    	<div class="row show-grid">
        	<div class="span12">
				<div id="breadcrumb">
                    <ul>
                        <li class="home"><a href="#">Inicio</a></li>
                        <li>Productos</li>
                    </ul>
                </div>
                <div>
                    <p>Actualmente contamos con un paquete tecnológico de más de 40 productos, entre herbicidas, insecticidas, fungicidas, fertilizantes y coadyuvantes.

El origen de los mismos es Chino, (herbicidas, insecticidas y fungicidas) y argentino (fertilizante y coadyuvantes).

Estos productos están dirigidos, a la protección de cultivos de oleaginosas como ser Soya, Maíz, Arroz, Trigo, Girasol, Fréjol entre los más importantes.</p>
                </div>
                <div class="main-block clients">
                    <div class="title-wrapper">
                        <h2>Clients</h2>
                    </div>
                    <div class="row show-grid">
                        <div id="collision-header" class="span12">
                            <div id="collision-slider" class="flexslider" >
                            <ul class="slides">
                                <li>
                                    <img alt="" src="<?php echo cdn_base("user-files/web/productos/coadyuvantes.jpg"); ?>" />
                                </li>
                                <li>
                                    <img alt="" src="<?php echo cdn_base("user-files/web/productos/domestico.jpg"); ?>" />
                                </li>
                                <li>
                                    <img alt="" src="<?php echo cdn_base("user-files/web/productos/fertilizantes.jpg"); ?>" />
                                </li>
                                <li>
                                    <img alt="" src="<?php echo cdn_base("user-files/web/productos/fungicidas.jpg"); ?>" />
                                </li>
                                <li>
                                    <img alt="" src="<?php echo cdn_base("user-files/web/productos/herbicidas.jpg"); ?>" />
                                </li>
                                <li>
                                    <img alt="" src="<?php echo cdn_base("user-files/web/productos/insecticidas.jpg"); ?>" />
                                </li>
                                <li>
                                    <img alt="" src="<?php echo cdn_base("user-files/web/productos/maquinarias.jpg"); ?>" />
                                </li>
                            </ul>
                            </div>
                        </div>
                    </div>
                </div>
    	</div>
	</div>
</div>
<script type="text/javascript" src="<?= cdn_base("js/jquery.flexslider-min.js"); ?>"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('.flexslider').flexslider({
        animation: "slide",
        
        itemWidth: 220,
        directionNav:false,
        controlNav:false
    });

    $('.flexslider').flexslider("play")
});
</script>