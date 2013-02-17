<!DOCTYPE html>
<!--[if IEMobile 7 ]><html class="no-js iem7" manifest="default.appcache?v=1"><![endif]-->
<!--[if lt IE 7 ]><html class="no-js ie6" <?php language_attributes(); ?> ><![endif]-->
<!--[if IE 7 ]><html class="no-js ie7" <?php language_attributes(); ?> ><![endif]-->
<!--[if IE 8 ]><html class="no-js ie8" <?php language_attributes(); ?> ><![endif]-->
<!--[if (gte IE 9)|(gt IEMobile 7)|!(IEMobile)|!(IE)]><!--><html class="no-js" <?php language_attributes(); ?> ><!--<![endif]-->

	<head>
		<meta charset="UTF-8"/>
		<meta id="meta" name="viewport" content="width=device-width; initial-scale=1.0" />

		<link rel="apple-touch-icon" href="<?php bloginfo('stylesheet_directory'); ?>/images/favicon.png"/>
		<link rel="shortcut icon" href="<?php bloginfo('stylesheet_directory'); ?>/images/favicon.ico" />
		<link rel="icon" href="<?php bloginfo('stylesheet_directory'); ?>/images/favicon.png" />

		<meta name="application-name" content="<?php echo bloginfo('name');?>" />
		
		<meta name="msapplication-task" 
			content="name=Go to Archives;
			action-uri=<?php if( get_option( 'show_on_front' ) == 'page' ) echo get_permalink( get_option('page_for_posts' ) ); else echo bloginfo('url'); ?>;
			icon-uri=<?php echo THEME_PATH; ?>/images/favicon.ico" />
		<meta name="msapplication-task" 
			content="name=Custom Posts;
			action-uri=<?php echo get_post_type_archive_link('custom-post'); ?>;
			icon-uri=<?php bloginfo('stylesheet_directory'); ?>/images/favicon.ico" />

		<script type="text/javascript">//<![CDATA[
			var g_ext = null;        // Global variable.
			window.onload = function(){
    				try {
    					if (window.external.msIsSiteMode()) {
        					g_ext = window.external;
        					// Continue initialization.
							g_ext.msSiteModeClearJumpList();
							g_ext.msSiteModeCreateJumplist('Latests posts');
							<?php
								$my_query = new WP_Query( array( 'posts_per_page' => 5, 'order' => 'DESC' ) );
							 	if( $my_query->have_posts() ) while( $my_query->have_posts() ) {
							 		$my_query->the_post(); ?>
												g_ext.msSiteModeAddJumpListItem(
														'<?php the_title(); ?>', 
														'<?php the_permalink(); ?>',
														'<?php bloginfo('stylesheet_directory'); ?>/images/favicon.ico'
												);
								 	<?php		
								}
								wp_reset_postdata();
							?>
							g_ext.msSiteModeShowJumplist();
    					}
    				}
    				catch (ex) {
        					// Fail silently.
    				}
			}
		//]]></script>

		<title><?php
			global $page, $paged;
			wp_title( '|', true, 'right' );
			bloginfo( 'name' );
			$site_description = get_bloginfo( 'description', 'display' );
			if ( $site_description && ( is_home() || is_front_page() ) ) { echo " | $site_description"; }
			if ( $paged >= 2 || $page >= 2 ) { echo ' | ' . sprintf( __('Page %s', 'ntz'), max( $paged, $page ) );} 
		?></title>
		
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<script type="text/javascript">
			document.documentElement.className = document.documentElement.className.replace('no-js', '');
		</script>
		
		<!-- !html5 elements for ie<9 -->
		<!--[if lte IE 8 ]> <script type="text/javascript">var htmlForIe = ["abbr" ,"article" ,"aside" ,"audio" ,"canvas" ,"details" ,"figcaption" ,"figure" ,"footer" ,"header" ,"hgroup" ,"mark" ,"meter" ,"nav" ,"output" ,"progress" ,"section" ,"summary" ,"time" ,"video"], htmlForIeLen = htmlForIe.length; for(i=0;i<htmlForIeLen;i++){ document.createElement(htmlForIe[i]); }</script> <![endif]-->

		<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>"/>
		<!--<link rel="stylesheet" href="<?php ECHO THEME_PATH ?>/orange.css"/>-->

		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
		
		<?php 
		if ( is_singular() ) {
			wp_enqueue_script( 'comment-reply' ); 
			if ( get_the_title() == "Game Of Life"){ 
				wp_enqueue_script('game-of-life'); 
			}
			if ( get_the_title() == "Arcball rotation"){ 
				wp_enqueue_script('arcball'); 
				?>
				<script id="fragment" type="x-shader/x-fragment">
					#ifdef GL_ES
					precision highp float;
					#endif
					                        
					uniform vec4 uColor;                  
					void main() {
					        gl_FragColor = uColor;
					}
				</script>
				<script id="vertex" type="x-shader/x-vertex">
					attribute vec2 aVertexPosition;
					void main() {
					        gl_Position = vec4(aVertexPosition, 0.0, 1.0);
					}
				</script>
			<?php
			}
		}
		?>

		<?php wp_head(); ?>
	</head>
	
	<body <?php body_class(); ?>>
		<header id='header'>
			<div class='container'>
				<a href='<?php echo HOME_URL; ?>' id='logo'>
					<img src='<?php echo THEME_PATH; ?>/images/favicon.png' title='<?php bloginfo('name'); ?>'>
					<h1><?php bloginfo('name'); ?></h1>
				</a>
				<nav>
					<?php wp_nav_menu( array(
						'menu' => 'Main', 
						'container' => false, 
						'items_wrap'      => '<ul id="%1$s" class="%2$s"><li class="menu-button"><a>Menu</a></li>%3$s</ul>',)); ?>
				</nav>
			</div>
		</header>