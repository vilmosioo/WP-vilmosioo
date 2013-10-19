			</div>
		</div><!--#main-->

		<footer role="contentinfo">
			<div class='container clearfix'>
				<?php dynamic_sidebar('Footer'); ?>
				<div class='clear'></div>
				<hr/>
				<div class='fright'>
					<?php wp_nav_menu( array('menu' => 'Main', 'container' => false, )); ?>
				</div>
				<p>Copyright Vilmos Ioo <?php echo date('Y');?></p>
			</div>
		</footer>

		<!--[if lt IE 7 ]>
		  <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
		  <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
		<![endif]-->
		
		<?php wp_footer(); ?>
		<?php 
		if ( is_front_page() ){ 
			echo "
			<script type='text/javascript'>
				jQuery(window).load(function() {
				        jQuery('#slideshow-flex').flexslider({ 
						animation: 'fade',
						controlsContainer: '.flexslider-container',
						directionNav: false,
						animationDuration: 1200
					});
    				});
			</script>
			";
		} 
		?>
		<script>!window.jQuery && document.write(unescape('%3Cscript src="<?php echo THEME_PATH; ?>/js/vendor/jquery/jquery.min.js"%3E%3C/script%3E'))</script>
	</body>
</html>
