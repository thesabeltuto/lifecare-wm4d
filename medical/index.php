<?php
/**
 * Requiring lifecare theme options,shortcode meta
 */
require_once( child_require_file( MED_DIR . 'additional_themeoptions.php' ) );
require_once( child_require_file( MED_DIR . 'additional-sh-meta.php' ) );
/**
 * This class extends ATP_Theme.
 */
if ( ! class_exists('IVA_theme_medical') ) { 
	class IVA_theme_medical extends ATP_Theme {

		/**
		 * Tell WordPress to run atp_theme_setup() when the 'after_setup_theme' hook is run. 
		 */
		function _construct() {
			add_action( 'after_setup_theme', array( $this,'atp_theme_setup' ));
		}
		
		/**
		 * Load medical post types.. 
		 */
		public function atp_post_types() {
		
			parent::atp_post_types();
			
			$this->child_index_require_once( MED_DIR . 'doctor/doctor.php');
			$this->child_index_require_once( MED_DIR . 'appointment/appointment.php');
			$this->child_index_require_once( MED_DIR . 'department/department.php');
		}
		

		/**
		 * Load medical Doctor Shortcode.. 
		 */
		public function atp_shortcodes(){

			parent::atp_shortcodes();

			$this->child_index_require_once( MED_DIR . 'shortcodes/doctors.php' );
			$this->child_index_require_once( MED_DIR . 'shortcodes/doctor_featured.php' );
			$this->child_index_require_once( MED_DIR . 'shortcodes/doctor_carousel.php');
			$this->child_index_require_once( MED_DIR . 'shortcodes/appointmentcallout.php');
		}

		/**
		 * Load medical Doctor Shortcode.. 
		 */
		public function atp_widgets(){
		
			parent::atp_widgets();

			$this->child_index_require_once( MED_DIR . 'widgets/appointment.php');
		}

		function child_index_require_once( $file ){
			global $atp_shortcodes;
			$child_file = str_replace(get_template_directory(),get_stylesheet_directory(),$file);
			if( file_exists( $child_file ) ){
				require_once( $child_file );
			}else{
				require_once( $file );
			}
		}
		
		
		/**
		 * retrieves the terms in a taxonomy or list of taxonomies.
		 */	
		public function atp_variable( $type ) {
		
			$iva_of_options = parent::atp_variable( $type );
			
			switch( $type ) {

				/**
				 * get doctors id and name.	
				 */	

				case 'doctors': // Get doctors Name/Id
					$args = array(
						'posts_per_page'   => -1,
						'offset'           => 0,
						'orderby'          => 'post_date',
						'order'            => 'DESC',
						'post_type'        => 'doctor',
						'post_status'      => 'publish',
						'suppress_filters' => true 
					); 
				
					$atp_entries = get_posts( $args );
					foreach ( $atp_entries as $key => $entry ) {
						$iva_of_options[$entry->ID] = $entry->post_title;
					}
					break;
				/**
				 * get posts id and name	
				 */	
				case 'departments': // Get departments Name/Id
					$args = array(
						'posts_per_page'   => -1,
						'offset'           => 0,
						'orderby'          => 'post_date',
						'order'            => 'DESC',
						'post_type'        => 'department',
						'post_status'      => 'publish',
						'suppress_filters' => true 
					); 
				
					$atp_entries = get_posts( $args );
					foreach ( $atp_entries as $key => $entry ) {
						$iva_of_options[$entry->ID] = $entry->post_title;
					}
					break;
				
				/**
				 * get specialists slug and name	
				 */	
				case 'specialties':
					$iva_specialties = get_terms('specialty', 'orderby=name&hide_empty=1');
					if ( count ( $iva_specialties ) >= 1 ) {
						foreach ( $iva_specialties as $iva_specialty ) {
							$iva_of_options[$iva_specialty->slug] = $iva_specialty->name;
							$specialty_ids[]               = $iva_specialty->slug;
						}
					}
					break;

				}
				return $iva_of_options;
			}
	}
	$atp_theme = new IVA_theme_medical();
	$url =  FRAMEWORK_URI . 'admin/images/';
}

/**
 * Additional Meta Class
 */
require_once( child_require_file( MED_DIR . 'additional_meta_class.php') );

/**
 * load medical custom meta.
 */	
require_once( child_require_file( MED_DIR . 'appointment/appointment-meta.php') );
require_once( child_require_file( MED_DIR . 'doctor/doctor-meta.php') );
require_once( child_require_file( MED_DIR . 'department/department-meta.php') );


/**
 * Defining medical uri
 */	
define( 'MEDICAL_URI',get_template_directory_uri() . '/medical/');


/**
 * function admin_enqueue_custompostscripts()
 * @uses admin_enqueue_scripts()
 * @uses wp_enqueue_script()
 * @uses wp_enqueue_style()
 * @link : http://codex.wordpress.org/Plugin_API/Action_Reference/admin_enqueue_scripts
 * admin_enqueue_scripts is the first action hooked into the admin scripts actions
 */
if( !function_exists('admin_enqueue_custompostscripts')){ 
	function admin_enqueue_custompostscripts(){
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('medical-script', MEDICAL_URI . 'js/medical-script.js','jquery','','in_footer');
		wp_enqueue_style('medical-custom-style', MEDICAL_URI . 'css/medical-customstyle.css', false,false,'all' ); 
	}
	add_action( 'admin_enqueue_scripts', 'admin_enqueue_custompostscripts' );
}

/**
 * function iva_localize()
 * @param string $text.
 * @param string $before.
 * @param string $after
 * @return string.
 * wp_enqueue_scripts is the proper hook to use when enqueuing items that are meant to appear on the front end
 */
if( !function_exists('iva_localize')){ 
	function iva_localize( $text = '',$before = '',$after = '' ){
		$output = $before.$text.$after;
		return $output;
	}
}

global $iva_of_options, $atp_options, $url, $shortname,$atp_theme ;

/**
 * Custom Post type language theme options 
 */
require_once( child_require_file( MED_DIR . 'posttype_label_options.php' ) );


/**
 * require appointment functions
 */
require_once( child_require_file( MED_DIR . 'appointment/appointment_functions.php') );
require_once( child_require_file( MED_DIR . 'appointment/update_appt_functions.php') );

/**
 * looks for path of post type single templates.
 * @uses  single-{post_type}.php 
 */
if(!function_exists('iva_posttypes_single')){
	function iva_posttypes_single() {
		global $wp_query, $post;  

		$customtype = $post->post_type;

		if( file_exists( child_require_file(get_template_directory() .'/medical/'.$customtype.'/'. 'single-'.$customtype.'.php')) ){
			return child_require_file(get_template_directory().'/medical/' . $customtype.'/'. 'single-'.$customtype.'.php');
		   
		}elseif( file_exists( child_require_file(get_template_directory() . '/single-'.$customtype.'.php')) ){
			return child_require_file(get_template_directory() . '/single-'.$customtype.'.php');
		}else{
			return child_require_file(get_template_directory() .'/single.php');
		}
	}
	add_filter('single_template', 'iva_posttypes_single');
}
if(!function_exists('atp_taxonomy_posttypes')){
	function atp_taxonomy_posttypes(){
	
		 global $wp_query, $post;  
		 
		 $customtype = $post->post_type;
		 $name = get_queried_object()->taxonomy;
		 
		 if( file_exists( child_require_file( MED_DIR .$customtype.'/'. 'taxonomy-'.$name.'.php'))){
				return child_require_file( MED_DIR . $customtype.'/'. 'taxonomy-'.$name.'.php');
		 }elseif( file_exists( child_require_file( THEME_DIR . '/taxonomy-'.$name.'.php'))){
				return child_require_file( THEME_DIR . '/taxonomy-'.$name.'.php');
		 }else{
				return child_require_file( THEME_DIR .'/archive.php');
		 } 
	}
	add_filter('taxonomy_template', 'atp_taxonomy_posttypes');
}

// Retrieve path of archive template in current or parent template. 
if(!function_exists('atp_archive_posttypes')){
	function atp_archive_posttypes(){
	
		global $wp_query, $post;  
		$customtype = $post->post_type;
		
		if( file_exists( child_require_file( MED_DIR .$customtype.'/'. 'archive-'.$customtype.'.php'))){
			return child_require_file( MED_DIR . $customtype.'/'. 'archive-'.$customtype.'.php');
		}elseif(file_exists( child_require_file( THEME_DIR . '/archive-'.$customtype.'.php'))){
			return child_require_file( THEME_DIR . '/archive-'.$customtype.'.php');
		}else{
			return child_require_file( THEME_DIR .'/archive.php');
		}
	}
	add_filter('archive_template', 'atp_archive_posttypes');
}

/**
 * Manage Reservation page id
 */
$iva_templateid = '';
$page_query = new WP_Query(
	array(
		 'post_type'  => 'page',
		 'meta_key'   => '_wp_page_template',
		 'meta_value' => 'medical/template_manage_appts.php'
	)
);

if ( $page_query->have_posts()) : while (  $page_query->have_posts()) :  $page_query->the_post();
$iva_templateid = get_the_id();
endwhile;
endif;

// Sending admin notification email
$status_changed_notification_msg = get_option('iva_status');
$iva_status = isset( $_POST['iva_appt_status'] ) ? $_POST['iva_appt_status'] : '';

if( $iva_status ) {
	switch( $_POST['iva_appt_status'] ){
	
		case 'cancelled':
			$status_txt = get_option('iva_apt_cancel') ? get_option('iva_apt_cancel') : __('Cancelled','iva_theme_admin');
			break;
			
		case 'unconfirmed':
			$status_txt = get_option('iva_apt_unconfirm') ? get_option('iva_apt_unconfirm') : __('UnConfirmed','iva_theme_admin');
			break;
			
		case 'confirmed':
			$status_txt = get_option('iva_apt_confirm') ? get_option('iva_apt_confirm') : __('Confirmed','iva_theme_admin');
			break;
	}

	$iva_appttime_info	= get_post_meta( $_POST['post_ID'],'iva_appt_appointmenttime',true );
	if( $iva_appttime_info ){
		$iva_appt_time 	= $iva_appttime_info['appt_time_hrs'].':'. $iva_appttime_info['appt_time_mnts'].$iva_appttime_info['appt_time_period'];
	}else{
		$iva_appt_time = '';
	}

	$iva_dept_id 		= $_POST['iva_appt_department'] ? $_POST['iva_appt_department'] :'';
	$iva_dept_title 	= get_the_title( $iva_dept_id );
	$iva_dr_id			= $_POST['iva_appt_doctor'] ? $_POST['iva_appt_doctor'] :'';
	$iva_dr_title 		= get_the_title( $iva_dr_id ) ;

	// Assigns message details for appointment

	$placeholders 				=	 array(
										'[first_name]',
										'[last_name]',
										'[date_of_birth]',
										'[gender]',
										'[contact_email]',
										'[contact_phone]',
										'[department_name]',
										'[doctor_name]',
										'[appointment_date]',
										'[appointment_time]',
										'[appointment_note]',
										'[appointment_status]'
									);
	$values 				 	=	 array(
										get_the_title( $_POST['post_ID'] ),
										$_POST['iva_appt_lastname'],
										$_POST['iva_appt_dob'],
										$_POST['iva_appt_gender'],
										$_POST['iva_appt_email'],
										$_POST['iva_appt_phone'],
										$iva_dept_title,
										get_the_title($iva_dr_id),
										$_POST['iva_appt_appointmentdate'],
										$iva_appt_time,
										$_POST['iva_appt_description'],
										$status_txt
									);	

	$status_changed_email_msg 	= str_replace( $placeholders,$values,$status_changed_notification_msg ); //replace the placeholders

	$status_subject 			= get_option('iva_statussubject');
	
	// Assigns subject for appointment
	$doctors_placeholders 	= array('[doctor_name]','[appointment_id]','[department_name]' );			
	$doctors_values 		= array( $iva_dr_title,$_POST['post_ID'],$iva_dept_title );
	
	$status_email_subject = str_replace( $doctors_placeholders,$doctors_values,$status_subject); //replace the placeholders
	
	$aivah_booking_email = isset( $_POST['iva_appt_email'] ) ? $_POST['iva_appt_email'] :'';
	
	$iva_apt_headers_msg = get_option('iva_apt_headers_msg') ? get_option('iva_apt_headers_msg') :get_option('blogname');
	
	$headers = 'From: ' . $iva_apt_headers_msg  . ' appointment <' . get_option('iva_appointmentemail') . '>' . "\r\n\\";
	
	// Sends email
	wp_mail( $aivah_booking_email, $status_email_subject, $status_changed_email_msg, $headers );

}
/**
 * Additional meta save function 
 */
if( !function_exists('meta_saves')){ 
	function meta_saves( $additional_options ){

		$dr_weekday = array('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday');
		
		foreach( $dr_weekday as $day ){
			if ( get_post_meta( $additional_options['post_id'], $additional_options['field_id'].'_'.$day.'_closes' ) == "" ){
				add_post_meta( $additional_options['post_id'], $additional_options['field_id'].'_'.$day.'_closes',  $_POST[$additional_options['field_id'].'_'.$day.'_closes'] , true );
			}else {
				$closes = isset( $_POST[$additional_options['field_id'].'_'.$day.'_closes'] ) ? $_POST[$additional_options['field_id'].'_'.$day.'_closes']:'';
				update_post_meta( $additional_options['post_id'], $additional_options['field_id'].'_'.$day.'_closes',$closes  );
			}
			if ( get_post_meta( $additional_options['post_id'], $additional_options['field_id'].'_'.$day.'_opens' ) == "" ){
				add_post_meta( $additional_options['post_id'], $additional_options['field_id'].'_'.$day.'_opens',  $_POST[$additional_options['field_id'].'_'.$day.'_opens'] , true );
			}else {
				$opens= isset( $_POST[$additional_options['field_id'].'_'.$day.'_opens'] ) ? $_POST[$additional_options['field_id'].'_'.$day.'_opens']:'';
				update_post_meta( $additional_options['post_id'], $additional_options['field_id'].'_'.$day.'_opens',  $opens);
			}
			if ( get_post_meta( $additional_options['post_id'], $additional_options['field_id'].'_'.$day.'_close' ) == "" ){
				add_post_meta( $additional_options['post_id'], $additional_options['field_id'].'_'.$day.'_close',  $_POST[$additional_options['field_id'].'_'.$day.'_close'] , true );
			}else {
				 $close = isset( $_POST[$additional_options['field_id'].'_'.$day.'_close'] ) ? $_POST[$additional_options['field_id'].'_'.$day.'_close']:'';
				update_post_meta( $additional_options['post_id'], $additional_options['field_id'].'_'.$day.'_close', $close );
			}
		}
		if ( get_post_meta( $additional_options['post_id'], $additional_options['field_id'].'_timeformat' ) == "" ){
			add_post_meta( $additional_options['post_id'],$additional_options['field_id'].'_timeformat',   $_POST[$additional_options['field_id'].'_timeformat'] , true );
		}else {
			$timeformat = isset( $_POST[$additional_options['field_id'].'_timeformat'] )? $_POST[$additional_options['field_id'].'_timeformat']:'';
			update_post_meta( $additional_options['post_id'], $additional_options['field_id'].'_timeformat',$timeformat );
		}
	}
	add_filter('meta_save', 'meta_saves');
}	
/**
 * Doctor clinic hours output
 */
if( !function_exists('timeformats')){  
	function timeformats( $weekdays,$postid,$hrs,$timeformat ){
	
		$i =0; 
		foreach( $weekdays as $key => $week ){
		
			$dr_meta_weekdays 	 = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
		
			$opens				= get_post_meta( $postid,$hrs.'_'.$dr_meta_weekdays[$key].'_opens',true );
			$closes				= get_post_meta( $postid,$hrs.'_'.$dr_meta_weekdays[$key].'_closes',true );
			$close				= get_post_meta( $postid,$hrs.'_'.$dr_meta_weekdays[$key].'_close',true );
			$time_format		= get_post_meta( $postid,$timeformat,true )?get_post_meta( $postid,$timeformat,true ):'12';
			$iva_closedtxt 		= get_option('iva_closedtxt') ?  get_option('iva_closedtxt') :__('Closed','iva_theme_front');
					
			//24 hours format
			if($time_format =='24'){
				if($close=='on') {
					$arr_keys[$weekdays[$key]]= $iva_closedtxt; 
				}else{
					list($open_hours,$open_min) = explode(':',$opens);
					list($close_hours,$close_min) = explode(':',$closes);
					$arr_keys[$weekdays[$key]]= sprintf('%02d:%02d',$open_hours,$open_min).' -'.sprintf('%02d:%02d',$close_hours,$close_min);
				}
			}
			//12 hours format
			if( $time_format =='12' ){
					if( $close == 'on' ) {
					$arr_keys[$weekdays[$key]]= $iva_closedtxt; 
				}else{
					$opening_hrs	= $opens.':'.'00';
					$closing_hrs	= $closes.':'.'00';
					$arr_keys[$weekdays[$key]] = date("g:i A", strtotime( $opening_hrs )).' - '.date("g:i A", strtotime( $closing_hrs ));
				}
			}
			$i++;
			
		}
		return $arr_keys;
	}
}	
/**
 * Grouping clinic hours
 */
if( !function_exists('grouping_hours')){  
	function grouping_hours( $openHours ){
		$summaries = array();
		foreach ( $openHours as $day => $hours ) {
			if (count( $summaries ) === 0) {
				$current = false;
			} else {
				$current = &$summaries[count($summaries) - 1];
			}
			if ( $current === false || $current['hours'] !== $hours ) {
				$summaries[] = array('hours' => $hours, 'days' => array( $day ));
			} else {
				$current['days'][] = $day;
			}
		}
		$out=''; 


		foreach ( $summaries as $summary ) { 

			//$days_start_shortnames = substr(reset($summary['days']),0,3);
			//$days_end_shortnames   = substr(end($summary['days']),0,3);

			$days_start_shortnames = reset($summary['days']);
			$days_end_shortnames   = end($summary['days']);

			if ( count( $summary['days'] ) === 1 ) {
				if ( $summary['hours'] == 'closed' ){
					$out[] = $days_start_shortnames;
				}else{
					echo '<p><span class="days">'.$days_start_shortnames . ' ' . '</span><span class="hours">'.$summary['hours'] .'</span></p>'; PHP_EOL;
					
				}
			} elseif ( count( $summary['days'] ) === 2 ) {
				if ( $summary['hours'] == 'closed' ){
					$out[] = $days_start_shortnames . ',' . $days_end_shortnames;
				}else{
					echo '<p><span class="days">'.$days_start_shortnames. ' - ' . $days_end_shortnames .'</span>'. ' ' .'<span class="hours">'. $summary['hours'] .'</span></p>'. PHP_EOL;
					
				}
			} else {
				if ( $summary['hours'] == 'closed' ){
					if ( count( $summary['days'] )>= 3 ) {
						$out[] = $days_start_shortnames . ' - ' . $days_end_shortnames;
					}
				}else{
					echo '<p><span class="days">'.$days_start_shortnames . ' - ' . $days_end_shortnames .'</span>'. ' ' .'<span class="hours">'. $summary['hours'] .'</span></p>'. PHP_EOL;
					
				}
				
			}
		}
		if( !empty( $out ) ){
			echo  '<p><span class="days">'.implode(',',$out).'</span><span class="hours closed">'.__('closed','iva_theme_front').'</span></p>';
		}
	}
}

//Doctor Sociables
if( !function_exists('doctor_social_icon')){ 
	function doctor_social_icon( $sociables ){
		global $sociable_icon;
		$output ='';
		$sociable_path = explode("\n",$sociables);	
		$output .= '<ul class="iva_socials">';

		foreach ( $sociable_path as $sociable_url ){
			$sociableurl 	= preg_replace("/http:\/\/www.||https:\/\/www.||https:\/\/||http:\/\/||www./", "" ,$sociable_url);
			$sociable_host 	= preg_split("/[\s.]+/",$sociableurl);
			$sociable_host_names =  $sociable_host[0];
			
			foreach ($sociable_icon as $key => $sociableicon){
				if( trim($sociableicon) === trim(strtolower($sociable_host_names))) {
					$sociable_url = trim($sociableurl);
					$output .= '<li><a href="'.esc_url($sociable_url).'" target="_blank"><i class="'.$key.'"></i></a><span class="ttip">'.ucfirst($sociableicon).'</span></li>';
				}
			}
		}

		$output .= '</ul>';

		return $output;
	}
}
//
if( !function_exists('aivah_add_query_vars_filter')){ 
	function aivah_add_query_vars_filter( $vars ){
	  $vars[] = "email";
	  return $vars;
	}
	add_filter( 'query_vars', 'aivah_add_query_vars_filter' );
}
?>