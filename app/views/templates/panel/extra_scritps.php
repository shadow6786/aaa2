<script src="../../ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="<?php echo cdn_base("panel/assets/js/vendor/jquery-1.9.1.min.js"); ?> "><\/script>')</script>

        <script src="<?php echo cdn_base("panel/assets/js/vendor/jquery-migrate-1.1.1.min.js"); ?> "></script>

        <script src="../../ajax.googleapis.com/ajax/libs/jqueryui/1.10.0/jquery-ui.min.js"></script>
        <script>window.jQuery.ui || document.write('<script src="<?php echo cdn_base("panel/assets/js/vendor/jquery-ui-1.10.0.custom.min.js"); ?> "><\/script>')</script>


        <script src="<?php echo cdn_base("panel/assets/js/vendor/bootstrap.min.js"); ?> "></script>

        <script src="<?php echo cdn_base("panel/assets/js/lib/jquery.mousewheel.js"); ?> "></script>
        <script src="<?php echo cdn_base("panel/assets/js/lib/jquery.sparkline.min.js"); ?> "></script>
        <script src="<?php echo cdn_base("panel/assets/js/lib/flot/jquery.flot.js"); ?> "></script>
        <script src="<?php echo cdn_base("panel/assets/js/lib/flot/jquery.flot.pie.js"); ?> "></script>
        <script src="<?php echo cdn_base("panel/assets/js/lib/flot/jquery.flot.selection.js"); ?> "></script>
        <script src="<?php echo cdn_base("panel/assets/js/lib/flot/jquery.flot.resize.js"); ?> "></script>
		<script src="<?php echo cdn_base("panel/assets/js/waypoints.min.js"); ?> "></script>
		<script src="<?php echo cdn_base("panel/assets/js/jquery.knob.js"); ?> "></script>
		<script src="<?php echo cdn_base("panel/assets/js/jquery.easy-pie-chart.min.js"); ?> "></script>
        <script src="<?php echo cdn_base("panel/assets/js/lib/fullcalendar.min.js"); ?> "></script>


		<script type="text/javascript" src="<?php echo cdn_base("panel/assets/js/lib/jquery.tablesorter.min.js"); ?> "></script>
        <script type="text/javascript" src="<?php echo cdn_base("panel/assets/js/lib/jquery.dataTables.min.js"); ?> "></script>
        <script type="text/javascript" src="<?php echo cdn_base("panel/assets/js/lib/DT_bootstrap.js"); ?> "></script>
        <script src="<?php echo cdn_base("panel/assets/js/lib/responsive-tables.js"); ?> "></script>
        <script type="text/javascript">
            jQuery(function() {
                bizstrapTable();
				dashboard();
				
				
				var oldie = jQuery.browser.msie && jQuery.browser.version < 9;
	
				jQuery('.easy-pie-chart.percentage').each(function(){
					jQuery(this).easyPieChart({
						barColor: jQuery(this).data('color'),
						trackColor: '#ffffff',
						scaleColor: false,
						lineCap: jQuery(this).data('cap'),
						lineWidth: jQuery(this).data('line'),
						animate: oldie ? false : 3000,
						size:120
					}).css('color', jQuery(this).data('color'));
				});
				
			
				// Triggering only when it is inside viewport
				jQuery('.semicircle-progressbar-span input').waypoint(function(){ 
					var cur = jQuery(this);        		        		        
					// Triggering now
					cur.knob();     
					// Animating the value
					if(cur.val() == 0) {	
						var val = cur.attr("rel");
						if(val < 0) val = val - 1;
						jQuery({value: 0}).animate({value: val}, {
							duration: 3000,
							easing:'swing',
							step: function() 
								{
									cur.val(Math.ceil(this.value)).trigger('change');
								}
							})
						}	        	   	        
					}
					,{
					  triggerOnce: true,
					  offset: function(){
						return jQuery(window).height() - jQuery(this).outerHeight(); 
					  }
					}
				); 
            });
        </script>

        <script src="<?php echo cdn_base("panel/assets/js/main.js"); ?> "></script>
        
        <script type="text/javascript" src="<?php echo cdn_base("panel/assets/js/style-switcher/style-switcher.js"); ?> "></script>
        
		</div>
		</div>
    </body>
</html>