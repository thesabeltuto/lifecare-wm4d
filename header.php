<!DOCTYPE html>
<!--[if IE 6]>
<html id="ie6" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta name="google-site-verification" content="ccgiMEPC9y9jV7N9Xcq1LucvEMDysztC-t_eubbsXnw" />
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />	
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
<!--[if lt IE 9]>
<script src="<?php echo THEME_URI; ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->

<?php

if( get_option('atp_custom_favicon') ) { 
	echo '<link rel="shortcut icon" href="'. get_option('atp_custom_favicon') .'" type="image/x-icon" /> ';
} ?>

<?php wp_head(); ?>

</head>
<?php if( is_page( 2868 ) ) {
if ( get_option( 'atp_layoutoption' )== 'stretched') { ?>
	<body <?php body_class( 'stretched vertical_leftmenu'); ?>>
	<?php }else{ ?>
		<body <?php body_class( 'boxed vertical_leftmenu'); ?>>
	<?php } ?>
<?php } else { ?>
<body <?php body_class(); ?>>	
<?php } ?>
<?php 
	// Gets front page id
	if( is_tag() || is_search() || is_404() || is_home()) { 
		$frontpageid = '';
	}else{
		if ( class_exists('woocommerce') ) {
			if( is_shop() ){	
				$frontpageid = get_option ('woocommerce_shop_page_id');
			}elseif( is_cart( get_option('woocommerce_cart_page_id') ) ){
				$frontpageid = get_option ('woocommerce_cart_page_id');
			}else{
				$frontpageid = $post->ID;
			}
		}else{
			$frontpageid = $post->ID;
		} 
	}


	// Gets page background image from post meta
	if ( get_post_meta( $frontpageid, 'page_bg_image', true ) ) {
		echo '<img id="pagebg" style="background-image:url('. get_post_meta( $frontpageid, 'page_bg_image', true ) .')" />';
	}
$headerstyle = get_option('atp_headerstyle','default');
if( $headerstyle != 'verticalleftmenu'){
	?>

	<div id="<?php echo (get_option( 'atp_layoutoption' )) ? get_option( 'atp_layoutoption' ) : 'stretched'; ?>" class="<?php echo atp_generator( 
'sidebaroption', $frontpageid ); ?>">
<?php } ?>

	<div class="bodyoverlay"></div>

	<?php 

	// Displays sticky content on sticky bar
	if( get_option( 'atp_stickybar' ) != "on" &&  get_option( 'atp_stickycontent' ) != '' ) { ?>
		<div id="trigger" class="tarrow"></div>
		<div id="sticky"><?php echo  stripslashes( get_option( 'atp_stickycontent' ) ); ?></div>
	<?php } ?>


	<div id="wrapper">
		<?php

		// Get header style from option panel
		$headerstyle = get_option('atp_headerstyle','default');
		
		switch( $headerstyle ) {
			case 'headerstyle1':
				get_template_part('headers/header','style1');
				break;
			case 'headerstyle2':
				get_template_part('headers/header','style2');
				break;
			case 'headerstyle3':
				get_template_part('headers/header','style3');
				break;
			case 'headerstyle4':	
				get_template_part('headers/header','style4');
				break;
			case 'fixedheader':	
				get_template_part('headers/header','fixed');
				break;		
			case 'verticalleftmenu':	
				get_template_part('headers/vertical','leftmenu');
				break;		
			
			default:
				get_template_part('headers/header','default');
		}

		// Get page slider from custom post meta
		$pageslider = get_post_meta( $frontpageid, 'page_slider', true );
		
		if( is_front_page() || $pageslider != "" ) {
		
			// Get Slider based on the option selected in theme options panel
			if( get_option( 'atp_slidervisble') != "on" ) {
				if( $pageslider == "" ) {
					$chooseslider = get_option( 'atp_slider' );
				} else {
					$chooseslider = $pageslider;
				}
				switch ( $chooseslider ):
					case 'toggleslider':
										get_template_part( 'slider/toggle', 'slider' );
										break;
					case 'static_image':
										get_template_part( 'slider/static', 'slider' );   	
										break;
					case 'flexslider':
										get_template_part( 'slider/flex', 'slider' );
										break;
					case 'videoslider':
										get_template_part( 'slider/video', 'slider' );   	
										break;
					case 'customslider':
										get_template_part( 'slider/custom', 'slider' );   	
										break;
					case 'default':
										get_template_part( 'slider/default', 'slider' );   	
										break;
					
					default:
										get_template_part( 'slider/default', 'slider' );
				endswitch;
			}
			wp_reset_query();
		} 
		
		elseif( is_singular('procedures') ) {
			global $post;
			procedure_slider_out( $post->ID );
		}
		
		elseif( is_post_type_archive('doctors') ) {
			generate_subhead( 'Meet the Doctors' );
		}
		elseif( is_post_type_archive('team') ) {
			generate_subhead( 'Meet the Team' );
		}
		elseif( is_post_type_archive('procedures') ) {
			generate_subhead( 'Procedures' );
		}
		elseif( is_post_type_archive('testimonials') ) {
			generate_subhead( 'Testimonials' );
		}
		elseif( is_post_type_archive('office-images') ) {
			generate_subhead( 'Office Images' );
		}
		elseif( is_post_type_archive('before-and-afters') ) {
			generate_subhead( 'Before and Afters' );
		}
		
		else
		{
			if( ! is_404()  ) {

				// Displays subheader content in all pages except 404 page
				echo atp_generator( 'subheader', $frontpageid );
			}			
		}
		?>
		<section id="main" class="<?php echo atp_generator( 'sidebaroption', $frontpageid ); ?>">