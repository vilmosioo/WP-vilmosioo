<!DOCTYPE html>
<!--[if IEMobile 7 ]><html class="no-js iem7" manifest="default.appcache?v=1"><![endif]-->
<!--[if lt IE 7 ]><html class="no-js ie6" <?php language_attributes(); ?> ><![endif]-->
<!--[if IE 7 ]><html class="no-js ie7" <?php language_attributes(); ?> ><![endif]-->
<!--[if IE 8 ]><html class="no-js ie8" <?php language_attributes(); ?> ><![endif]-->
<!--[if (gte IE 9)|(gt IEMobile 7)|!(IEMobile)|!(IE)]><!--><html class="no-js" <?php language_attributes(); ?> ><!--<![endif]-->

	<head>
		<meta charset="UTF-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />

		<link rel="apple-touch-icon" href="<?php bloginfo('stylesheet_directory'); ?>/images/favicon.png"/>
		<link rel="shortcut icon" href="<?php bloginfo('stylesheet_directory'); ?>/images/favicon.ico" />
		<link rel="icon" href="<?php bloginfo('stylesheet_directory'); ?>/images/favicon.png" />
		
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
			if ( $paged >= 2 || $page >= 2 ) { echo ' | ' . sprintf( 'Page %s', max( $paged, $page ) );} 
		?></title>
		
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		
		<!-- !html5 elements for ie<9 -->
		<!--[if lte IE 8 ]> <script type="text/javascript">var htmlForIe = ["abbr" ,"article" ,"aside" ,"audio" ,"canvas" ,"details" ,"figcaption" ,"figure" ,"footer" ,"header" ,"hgroup" ,"mark" ,"meter" ,"nav" ,"output" ,"progress" ,"section" ,"summary" ,"time" ,"video"], htmlForIeLen = htmlForIe.length; for(i=0;i<htmlForIeLen;i++){ document.createElement(htmlForIe[i]); }</script> <![endif]-->

		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
		<link href='http://fonts.googleapis.com/css?family=Droid+Sans:400,700' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Bree+Serif' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>"/>
		
		<?php wp_head(); ?>
		
		<script type='text/javascript'>	
			var _gaq = _gaq || [];
			_gaq.push(['_setAccount', 'UA-27809256-1']);
			_gaq.push(['_setDomainName', 'vilmosioo.co.uk']);
			_gaq.push(['_trackPageview']);
			_gaq.push(['_trackPageLoadTime']);

			(function() {
				var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
				ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
				var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
			})();
		</script>
	</head>
	
	<body <?php body_class(); ?>>

		<?php if(is_single()) :?>
			<div id="fb-root"></div>
			<script>(function(d, s, id) {
					var js, fjs = d.getElementsByTagName(s)[0];
					if (d.getElementById(id)) return;
					js = d.createElement(s); js.id = id;
					js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=276045295746597";
					fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));</script>
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
		<?php endif; ?>

		<script type='text/javascript'>
			jQuery(function(){
				jQuery('#menu-button').click(function(){
					jQuery('nav').toggleClass('active');
					jQuery(this).toggleClass('active');
				});	
			});
		</script>

		<header id='header'>
			<div class='container'>
				<a href='<?php echo home_url(); ?>' id='logo'>
					<h1><?php bloginfo('name'); ?></h1>
					<h2><?php bloginfo('description'); ?></h2>
					<span><img class='msPinSite' src='<?php echo get_template_directory_uri(); ?>/images/w-logo.png' /></span>
				</a><!--#logo-->
				<span id='menu-button'>Menu</span><!--#menu-button-->
				<nav><?php wp_nav_menu(array('menu' => 'Main', 'container' => false)); ?></nav>
				<div class='clear'></div>
			</div>
		</header><!--#header-->

		<div id='main' role="main">
			<div class='container'>
