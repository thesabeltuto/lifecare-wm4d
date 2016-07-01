<?php
// Global define variables
$THEME_CHILD = '-wm4d';
define('THEME_CHILD_FILE', __FILE__ );
define('THEME_CHILD_DIR', get_template_directory().$THEME_CHILD);
define('THEME_CHILD_URL', get_template_directory_uri().$THEME_CHILD);

// Global variables
$THEME_VERSION = '1.1.2';
$THEME_CSS_VERSION = '1.0.9';

require_once(THEME_CHILD_DIR.'/framework/admin.php');
require_once(THEME_CHILD_DIR.'/framework/integrations.php');
require_once(THEME_CHILD_DIR.'/framework/shortcodes.php');

error_reporting(E_ALL); ini_set('display_errors', 1);

/*************************************/
/*** ORIGINAL CHILD THEME SETTINGS ***/
/*************************************/

function child_scripts( $file ){
	$child_file = str_replace( get_template_directory_uri(),get_stylesheet_directory_uri(),$file);
	return( $child_file );
}
/**
 * Enqueue the files in child theme
 * If you wish to change any js file or css file then use 'child_scripts' function for that specific file and place it in relevant folder.
 * for eg:wp_register_script('iva-countTo', child_scripts(THEME_JS . '/jquery.countTo.js'), 'jquery','1.0','in_footer'); 
 */
function child_require_file($file){
	global $atp_shortcodes;
	$child_file = str_replace(get_template_directory(),get_stylesheet_directory(),$file);
	if( file_exists( $child_file )){
		return( $child_file );
	}else{
		return( $file );
	}
}

/**
 * Theme Frontend Scripts and Styles
 */
if( !function_exists('iva_frontend_scripts')){  
	function iva_frontend_scripts() {
		
		$iva_protocol = is_ssl() ? 'https' : 'http';

		wp_register_script('iva-easing', THEME_JS .'/jquery.easing.1.3.js', 'jquery', '', 'in_footer');
		wp_register_script('iva-sf-hover', THEME_JS .'/hoverIntent.js', '', '', 'in_footer');
		wp_register_script('iva-sf-menu', THEME_JS .'/superfish.js', '', '', 'in_footer');
		wp_register_script('iva-gmap-api', $iva_protocol.'://maps.google.com/maps/api/js?sensor=false', '', '', 'in_footer');
		wp_register_script('iva-gmap-min', THEME_JS . '/jquery.gmap.js', '', '', 'in_footer');
		wp_register_script('iva-prettyPhoto', THEME_JS .'/jquery.prettyPhoto.js', 'jquery', '', 'in_footer');
		wp_register_script('iva-preloader', THEME_JS .'/jquery.preloadify.min.js', 'jquery', '', 'in_footer');
		wp_register_script('iva-progresscircle', THEME_JS .'/jquery.easy-pie-chart.js', 'jquery', '', 'in_footer');
		wp_register_script('iva-excanvas', THEME_JS .'/excanvas.js', 'jquery', '', 'in_footer');
		wp_register_script('iva-Modernizr', THEME_JS .'/Modernizr.js', '', '', 'in_footer');
		wp_register_script('iva-isotope', THEME_JS .'/isotope.js', '', '', 'in_footer');
		wp_register_script('iva-fitvids', THEME_JS .'/jquery.fitvids.js','jquery', '', 'in_footer');
		wp_register_script('iva-custom', THEME_JS . '/sys_custom.js', 'jquery', '', 'in_footer');
		wp_register_script('iva-wow', THEME_JS .'/wow.js', 'jquery','', 'in_footer');
		wp_register_script('iva-countTo', THEME_JS . '/jquery.countTo.js', 'jquery','1.0','in_footer');
		wp_register_script('iva-weather', THEME_JS . '/jquery.simpleWeather.min.js', 'jquery','1.0','in_footer');
		
		/**
		 * Enqueue Frontend Scripts
		 */
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-datepicker');
		wp_enqueue_script('iva-easing');
		wp_enqueue_script('iva-sf-hover');
		wp_enqueue_script('iva-sf-menu');
		wp_enqueue_script('iva-preloader');
		wp_enqueue_script('iva-prettyPhoto');
		wp_enqueue_script('iva-Modernizr');
		wp_enqueue_script('iva-isotope');
		wp_enqueue_script('iva-fitvids');
		wp_enqueue_script('iva-custom');
		wp_enqueue_script('iva-wow');
		wp_enqueue_script('iva-countTo');
		wp_enqueue_script('iva-weather');
		
		
		//AJAX URL
		$data["ajaxurl"] = admin_url("admin-ajax.php");	

		//HOME URL
		$data["home_url"] = get_home_url();
		
		//pass data to javascript
		$params = array(
			'l10n_print_after' => 'iva_panel = ' . json_encode($data) . ';'
		);
		wp_localize_script('jquery', 'iva_panel', $params);		
		wp_localize_script( 'jquery', 'atp_panel', array( 'SiteUrl' => get_template_directory_uri() ) );
		wp_register_style( 'iva-responsive', THEME_CSS . '/responsive.css', array(), '1', 'screen' );
		// Enqueue Frontend Styles
		wp_enqueue_style('iva-theme-style', get_stylesheet_uri(), array(), '3.0.2' );
		wp_enqueue_style('iva-shortcodes', THEME_CSS . '/shortcodes.css', array(), '1', 'all' ); 
		wp_enqueue_style('iva-fontawesome', THEME_CSS.'/fontawesome/css/font-awesome.css', false, false, 'all');
		wp_enqueue_style('iva-animate', THEME_CSS.'/animate.css', array(), '1', 'screen' );
		wp_enqueue_style('iva-prettyPhoto', THEME_CSS.'/prettyPhoto.css', array(), '1', 'screen' );
		wp_enqueue_style('iva-responsive' );
		wp_enqueue_style('datepicker', FRAMEWORK_URI.'admin/css/datepicker.css', false, false, 'all');

		if ( is_singular() && get_option( 'thread_comments' ) ) { wp_enqueue_script( 'comment-reply' ); }

		if ( get_option( 'atp_style' ) != '0' ) {
			$iva_style = get_option( 'atp_style' );
			wp_enqueue_style( 'iva-style', THEME_URI.'/colors/'.$iva_style, array(), '1', 'screen' );
		}
		
		wp_enqueue_style( 'clinichours_font', $iva_protocol.'://fonts.googleapis.com/css?family=Patua+One' );
	}
	add_action( 'wp_enqueue_scripts', 'iva_frontend_scripts' );
}	

/**
 * Register Theme Frontend Carousel Scripts and Styles
 */
if( !function_exists('iva_owlcarousel_enqueue_scripts')){ 
	
	function iva_owlcarousel_enqueue_scripts() {
		wp_register_script( 'iva-owl-carousel',  THEME_JS . '/owl.carousel.js', 'jquery', '', 'in_footer');
		wp_enqueue_style( 'iva-owl-style', THEME_CSS . '/owl.carousel.css', array(), '1', 'all' ); 
		wp_enqueue_style( 'iva-owl-theme',  THEME_CSS . '/owl.theme.css', array(), '1', 'all' );    
	}
	add_action( 'wp_enqueue_scripts','iva_owlcarousel_enqueue_scripts' );
}
/**
 * Flex Slider Enqueue Scripts 
 */
if( !function_exists('iva_flexslider_enqueue_scripts')){ 
	add_action( 'wp_enqueue_scripts','iva_flexslider_enqueue_scripts' );
	function iva_flexslider_enqueue_scripts() {
		wp_enqueue_script('iva-flexslider', THEME_JS .'/jquery.flexslider-min.js', 'jquery', '', 'in_footer' );
		wp_enqueue_style('iva-css-flexslider',THEME_CSS. '/flexslider.css', array(), '1', 'all' );
	}
}

/**
 * Theme Class
 */
if ( !class_exists( 'ATP_Theme' ) ) {
	
	class ATP_Theme
	{
		public $theme_name;
		public $meta_box;
		
		public function __construct()
		{
			$this->atp_constant();
			$this->atp_themesupport();
			$this->atp_head();
			$this->atp_themepanel();
			$this->atp_widgets();
			$this->atp_post_types();
			$this->atp_custom_meta();
			$this->atp_meta_generators();
			$this->atp_shortcodes();
			$this->atp_common();
		}
		
		function atp_constant()
		{
			/**
			 * Framework General Variables and directory paths
			 */
			$theme_data;
			
				$theme_data   = wp_get_theme();
				$themeversion = $theme_data->Version;
				$theme_name   = $theme_data->Name;
			
			/**
			 * Set the file path based on whether the Options 
			 * Framework is in a parent theme or child theme
			 * Directory Structure
			 */
			define('FRAMEWORK', '2.0'); //  Theme Framework
			define('THEMENAME', $theme_name);
			define('THEMEVERSION', $themeversion);
			
			define('THEME_URI', get_template_directory_uri());
			define('THEME_DIR', get_template_directory());
			define('THEME_JS', THEME_URI . '/js');
			define('THEME_CSS', THEME_URI . '/css');
			define('FRAMEWORK_DIR', THEME_DIR . '/framework/');
			define('FRAMEWORK_URI', THEME_URI . '/framework/');
			
			define('CUSTOM_META', FRAMEWORK_DIR . '/custom-meta/');
			define('CUSTOM_PLUGINS', FRAMEWORK_DIR . '/custom-plugins/');
			define('CUSTOM_POST', FRAMEWORK_DIR . '/custom-post/');
			
			define('THEME_SHORTCODES', FRAMEWORK_DIR . 'shortcode/');
			define('THEME_WIDGETS', FRAMEWORK_DIR . 'widgets/');
			define('THEME_PLUGINS', FRAMEWORK_DIR . 'plugins/');
			define('THEME_POSTTYPE', FRAMEWORK_DIR . 'custom-post/');
			define('THEME_CUSTOMMETA', FRAMEWORK_DIR . 'custom-meta/');
			
			define('THEME_PATTDIR', THEME_URI . '/images/patterns/');
		}
		
		/** 
		 * Allows a theme to register its support of a certain features
		 */
		function atp_themesupport()
		{
			add_theme_support( 'post-formats', array( 'aside', 'audio', 'link', 'image', 'gallery', 'quote', 'status', 'video' ) );
			add_theme_support( 'automatic-feed-links' );
			add_theme_support( 'editor-style' );
			add_theme_support( 'post-thumbnails' );
			add_theme_support( 'title-tag' );
			
			// Register Wordpress Native Menu
			register_nav_menus( array( 'primary-menu' => 'Primary Menu' ) );
			
			// Define Content Width
			if ( !isset( $content_width ) ) { $content_width = 1170; }
		}
		
		/**
		 * Scripts and Styles Enqueue for Options Framework
		 */
		function atp_head()
		{
			$this->child_require_once( FRAMEWORK_DIR . 'common/head.php');
		}
		
		/**
		 * Admin Interface 
		 */
		function atp_themepanel()
		{
			$this->child_require_once( FRAMEWORK_DIR . 'common/atp_googlefont.php');
			$this->child_require_once( FRAMEWORK_DIR . 'admin/admin-interface.php');
			$this->child_require_once( FRAMEWORK_DIR . 'admin/theme-options.php');
		}
		
		/** 
		 * Custom Widgets
		 */
		function atp_widgets()
		{
			$this->child_require_once( THEME_WIDGETS .'/register_widget.php');
			$this->child_require_once( THEME_WIDGETS .'/contactinfo.php');
			$this->child_require_once( THEME_WIDGETS .'/flickr.php');
			$this->child_require_once( THEME_WIDGETS .'/twitter.php');
			$this->child_require_once( THEME_WIDGETS .'/sociable.php');
			$this->child_require_once( THEME_WIDGETS .'/popularpost.php');
			$this->child_require_once( THEME_WIDGETS .'/recentpost.php');
			$this->child_require_once( THEME_WIDGETS .'/testimonials_submit.php');
		}
		
		/**
		 * Load Custom Post Types Templates
		 * @files slider, testimonials
		 */
		function atp_post_types()
		{
			$this->child_require_once( THEME_POSTTYPE . '/gallery.php');
			$this->child_require_once( THEME_POSTTYPE . '/slider.php');
			$this->child_require_once( THEME_POSTTYPE . '/testimonial.php');
			$this->child_require_once( THEME_POSTTYPE . '/logosc_type.php');
		}
		
		/** Load Meta Generator Templates
		 * @files Slider, Menus, Testimonial, Page, Posts, Shortcodes Generator
		 */
		function atp_custom_meta()
		{

			$this->child_require_once( THEME_CUSTOMMETA . '/page-meta.php');
			$this->child_require_once( THEME_CUSTOMMETA . '/post-meta.php');
			$this->child_require_once( THEME_CUSTOMMETA . '/slider-meta.php');
			$this->child_require_once( THEME_CUSTOMMETA . '/testimonial-meta.php');
			$this->child_require_once( THEME_CUSTOMMETA . '/gallery-meta.php');
			$this->child_require_once( THEME_CUSTOMMETA . '/logosc_type-meta.php');
		}
		
		function atp_meta_generators() {
			$this->child_require_once( THEME_CUSTOMMETA . '/meta-generator.php' );
			$this->child_require_once( THEME_CUSTOMMETA . '/shortcode-meta.php' );
			$this->child_require_once( THEME_CUSTOMMETA . '/shortcode-generator.php' );
		}
		
		/**
		 * Shortcodes 
		 */
		function atp_shortcodes()
		{
			$this->child_require_once( THEME_SHORTCODES . '/accordion.php');
			$this->child_require_once( THEME_SHORTCODES . '/boxes.php');
			$this->child_require_once( THEME_SHORTCODES . '/blog.php');
			$this->child_require_once( THEME_SHORTCODES . '/buttons.php');
			$this->child_require_once( THEME_SHORTCODES . '/contactinfo.php');
			$this->child_require_once( THEME_SHORTCODES . '/flickr.php');
			$this->child_require_once( THEME_SHORTCODES . '/general.php');
			$this->child_require_once( THEME_SHORTCODES . '/feature_box.php');
			$this->child_require_once( THEME_SHORTCODES . '/image.php');
			$this->child_require_once( THEME_SHORTCODES . '/layout.php');
			$this->child_require_once( THEME_SHORTCODES . '/lightbox.php');
			$this->child_require_once( THEME_SHORTCODES . '/planbox.php');
			$this->child_require_once( THEME_SHORTCODES . '/messageboxes.php');
			$this->child_require_once( THEME_SHORTCODES . '/flexslider.php');
			$this->child_require_once( THEME_SHORTCODES . '/tabs_toggles.php');
			$this->child_require_once( THEME_SHORTCODES . '/twitter.php');
			$this->child_require_once( THEME_SHORTCODES . '/gmap.php');
			$this->child_require_once( THEME_SHORTCODES . '/sociable.php');
			$this->child_require_once( THEME_SHORTCODES . '/videos.php');
			$this->child_require_once( THEME_SHORTCODES . '/staff.php');
			$this->child_require_once( THEME_SHORTCODES . '/progressbar.php');
			$this->child_require_once( THEME_SHORTCODES . '/services.php');
			$this->child_require_once( THEME_SHORTCODES . '/blogcarousel.php');
			$this->child_require_once( THEME_SHORTCODES . '/testimonials.php');
			$this->child_require_once( THEME_SHORTCODES . '/progresscircle.php');
			$this->child_require_once( THEME_SHORTCODES . '/sharelink.php');
			$this->child_require_once( THEME_SHORTCODES . '/logos.php');
			
		}
		
		/** 
		 * Theme Functions
		 * @uses skin generator
		 * @uses twitter class
		 * @uses pagination
		 * @uses sociables
		 * @uses Aqua imageresize // Credits : http://aquagraphite.com/
		 * @uses plugin activation class
		 */
		function atp_common()
		{
			$this->child_require_once( THEME_DIR . '/css/skin.php');
			$this->child_require_once( FRAMEWORK_DIR . 'common/class_twitter.php');
			$this->child_require_once( FRAMEWORK_DIR . 'common/atp_generator.php');
			$this->child_require_once( FRAMEWORK_DIR . 'common/pagination.php');
			$this->child_require_once( FRAMEWORK_DIR . 'common/sociables.php');
			$this->child_require_once( FRAMEWORK_DIR . 'includes/image_resize.php');
			$this->child_require_once( FRAMEWORK_DIR . 'includes/class-activation.php');
		}
		
		function child_require_once($file){
			global $atp_shortcodes;
			$child_file = str_replace(get_template_directory(),get_stylesheet_directory(),$file);
			if( file_exists( $child_file ) ){
				require_once( $child_file );
			}else{
				require_once( $file );
			}
		}
		
		/** 
		 * Custom Switch case for fetching
		 * posts, post-types, custom-taxonomies, tags
		 */
		
		function atp_variable($type)
		{
			$iva_terms = array();
			switch ($type) {
				case 'pages': // Get Page Titles
					$atp_entries = get_pages('sort_column=post_parent,menu_order');
					foreach ($atp_entries as $atpPage) {
						$iva_terms[$atpPage->ID] = $atpPage->post_title;
					}
					break;
				case 'slider': // Get Slider Slug and Name
					$atp_entries = get_terms('slider_cat', 'orderby=name&hide_empty=0');
					foreach ($atp_entries as $atpSlider) {
						$iva_terms[$atpSlider->slug] = $atpSlider->name;
						$slider_ids[]              = $atpSlider->slug;
					}
					break;
				case 'posts': // Get Posts Slug and Name
					$atp_entries = get_categories('hide_empty=0');
					foreach ($atp_entries as $atpPosts) {
						$iva_terms[$atpPosts->slug] = $atpPosts->name;
						$atp_posts_ids[]          = $atpPosts->slug;
					}
					break;
				case 'categories':
					$atp_entries = get_categories('hide_empty=true');
					foreach ($atp_entries as $atp_posts) {
						$iva_terms[$atp_posts->term_id] = $atp_posts->name;
						$atp_posts_ids[]              = $atp_posts->term_id;
					}
					break;

				case 'postlink': // Get Posts Slug and Name
						$atp_entries = get_posts( 'hide_empty=0');
						foreach ( $atp_entries as $atpPosts ) {
							$iva_terms[$atpPosts->ID] = $atpPosts->post_title;
							$atp_posts_ids[] = $atpPosts->slug;
						}
						break;

				case 'testimonial': // Get Testimonial Slug and Name
					$atp_entries = get_terms('testimonial_cat', 'orderby=name&hide_empty=0');
					foreach ($atp_entries as $atpTestimonial) {
						$iva_terms[$atpTestimonial->slug] = $atpTestimonial->name;
						$testimonialvalue_id[]          = $atpTestimonial->slug;
					}
					break;				
					
				case 'tags': // Get Taxonomy Tags
					$atp_entries = get_tags(array(
						'taxonomy' => 'post_tag'
					));
					foreach ($atp_entries as $atpTags) {
						$iva_terms[$atpTags->slug] = $atpTags->name;
					}
					break;
				case 'slider_type': // Slider Arrays for Theme Options
					$iva_terms = array(
						'' 					=> 'Select Slider',
						'flexslider' 		=> 'Flex Slider',
						'videoslider'		=> 'Single Video',
						'static_image' 		=> 'Static Image',
						'customslider'		=> 'Custom Slider'
					);
					break;
				case 'logosc_categories': // Get Events Slug and Name
                    $atp_entries = get_terms('logosc_cat', 'orderby=name&hide_empty=0');
					if(!empty($atp_entries) ){
						foreach ($atp_entries as $atpEvents) {
							$iva_terms[$atpEvents->slug] = $atpEvents->name;
							$eventsvalue_id[]          = $atpEvents->slug;
						}
					}
                    break;	
			}
			
			return $iva_terms;
		}
	}
}
/**
 * section to decide whether use child theme or parent theme 
 */
if(!defined('MEDICAL_DIR')){
	define( 'MEDICAL_DIR', child_require_file( get_template_directory() . '/medical/') );
}
?>