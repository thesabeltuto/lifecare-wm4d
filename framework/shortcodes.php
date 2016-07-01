<?php
/* USE SHORTCODE IN MENU */
add_filter( 'wp_nav_menu_objects', 'my_dynamic_menu_items' );

function my_dynamic_menu_items( $menu_items ) {
    foreach ( $menu_items as $menu_item ) {
		$title = $menu_item->title;
        if ( preg_match('%client_name%', $title) ) {
			$title = get_general_data('client_name', $title);
        }
        if ( preg_match('%practice_name%', $title) ) {
			$title = get_general_data('practice_name', $title);
        }
        if ( preg_match('%doctor_name%', $title) ) {
			$title = get_multi_data('doctor_name', $title);
        }
        if ( preg_match('%doctor_title%', $title) ) {
			$title = get_multi_data('doctor_title', $title);
        }
        if ( preg_match('%location%', $title) ) {
			$title = get_general_data('location', $title);
        }
        if ( preg_match('%phone_numbers_menu%', $title) ) {
			$title = get_phones_menu($title);
        }
		
		global $shortcode_tags;
		$menu_item->title = $title;
  }
    return $menu_items;
}

/* EDIT DT SHORTCODE OUTPUT */
/*
	dt_sc_titled_box
	dt_sc_icon_box_colored
	dt_sc_icon_box
	dt_sc_phone
	dt_sc_address
	dt_sc_web
*/
remove_shortcode ( "dt_sc_titled_box");
remove_shortcode ( "dt_sc_icon_box_colored" );
remove_shortcode ( "dt_sc_icon_box" );
remove_shortcode ( "dt_sc_phone" );
remove_shortcode ( "dt_sc_address" );
remove_shortcode ( "dt_sc_web" );

add_shortcode ( "dt_sc_titled_box", "dt_sc_titled_box_edited" );
add_shortcode ( "dt_sc_icon_box_colored", "dt_sc_icon_box_colored_edited" );
add_shortcode ( "dt_sc_icon_box", "dt_sc_icon_box_edited" );
add_shortcode ( "dt_sc_phone", "dt_sc_phone_edited");
add_shortcode ( "dt_sc_address", "dt_sc_address_edited");
add_shortcode ( "dt_sc_web", "dt_sc_web_edited");

/* calls for all edited output */
function call_title_shortcode($title,$content=null){
	if(preg_match('%client_name%', $title)){
		$title = get_general_data('client_name', $title);
	}
	if(preg_match('%practice_name%', $title)){
		$title = get_general_data('practice_name', $title);
	}
	if(preg_match('%phone_number%', $title)){
		$title = get_multi_data('phone_number', $title, $content);
	}
	if(preg_match('%location%', $title)){
		$title = get_multi_data('location', $title);
	}
	if(preg_match('%doctor_name%', $title)){
		$title = get_multi_data('doctor_name', $title);
	}
	if(preg_match('%doctor_title%', $title)){
		$title = get_multi_data('doctor_title', $title);
	}
	
	return $title;	
}

function get_general_data($match, $title) {
	if($match == 'client_name') {
		$string = explode('%client_name%', $title );
		$match1 = get_option('wm4d_client');
	}
	if($match == 'practice_name') {
		$string = explode('%practice_name%', $title );
		$match1 = get_option('wm4d_practice');
	}
	if($match == 'doctor_name') {
		$string = explode('%doctor_name%', $title );
		$match1 = get_option('wm4d_doctor');
	}
	if($match == 'doctor_title') {
		$string = explode('%doctor_title%', $title );
		$match1 = get_option('wm4d_doctor').', '.get_option('wm4d_doc_titles');
	}
	if($match == 'location') {
		$string = explode('%location%', $title );
		$match1 = nl2br(get_option('wm4d_location'));
	}
	$title = $string[0];
	$title .= $match1;
	$title .= $string[1];	
	return $title;	
}


function get_multi_data($match, $title, $content=null) {
	if($match == 'phone_number') {
		$match1 = get_option('wm4d_phone');
		$matchN = get_option('wm4d_phones');
		$string = explode('%phone_number', $title );

	}
	
	if($match == 'doctor_name') {
		$match1 = get_option('wm4d_doctor');
		$matchN = get_option('wm4d_doctors');
		$string = explode('%doctor_name', $title );
	}
	
	if($match == 'doctor_title') {
		$doctor1 = get_option('wm4d_doctor');
		$titles1 = get_option('wm4d_doc_titles');
		$match1 = $doctor1.', '.$titles1;
		$matchN = get_option('wm4d_doctors');
		$titlesN = get_option('wm4d_docs_titles');
		$string = explode('%doctor_title', $title );
	}
	
	if($match == 'location') {
		$match1 = get_option('wm4d_location');
		$matchN = get_option('wm4d_locations');
		$string = explode('%location', $title );
	}
	
	$title = $string[0];
	for($i=1; $i < sizeof($string); $i++) {
		$matchstring1 = explode('%', $string[$i]);
		if($matchstring1[0] == '') {
			if($match == 'phone_number') {
				$title .= '<a href="tel:'.$match1.'">'.$match1.'</a>';
			} else {
				
				$title .= $match1;
			}
			$title .= $matchstring1[$i]; //outnext
		} else {
			$next = explode('s', $matchstring1[0] );
			$getid = explode('_', $matchstring1[0]);
			$id = $getid[1]-1;

			if($id == -1) {
				$endtext = substr($string[$i],2); // cut first: s%
				$max = count($matchN);
				foreach( $matchN as $k => $v) {
					if($match == 'phone_number') {
						if ($k == $max-1) {
						   $title .= '<a href="tel:'.$v.'">'.$v.'</a>';
						} else {
						   $title .= '<a href="tel:'.$v.'">'.$v.'</a>, ';
						}
					} elseif($match == 'doctor_title') {
						if ($k == $max-1) {
						   $title .= $v.', '.$titlesN[$k];
						} else {
						   $title .= $v.', '.$titlesN[$k].', ';
						}
					} else {
						if ($k == $max-1) {
						   $title .= $v;
						} else {
						   $title .= $v.', ';
						}
					}
				}
				$title .= $endtext; //outnext
			}
			if($id > -1) {
				if ($id<10) {
					$endtext = substr($string[$i],4);  // cut first: s_#%
				} else {
					$endtext = substr($string[$i],5);  // cut first: s_##%
				}
				
				if($match == 'phone_number') {
					$title .= '<a href="tel:'.$matchN[$id].'">'.$matchN[$id].'</a>';
				} elseif($match == 'doctor_title') {
					$Ndoctor = $matchN[$id];
					$Ntitles = $titlesN[$id];
					$title .= $Ndoctor.', '.$Ntitles;
				} else {
					$title .= $matchN[$id];
				}
				$title .= $endtext; //outnext
			}
		}
	} 
	
	return $title;	
}

function get_phones_menu($title){
	$title = '';
	$phones = get_option('wm4d_phones');
	$location = get_option('wm4d_phones_loc');
	$string = explode('%phone_numbers_menu%', $title );
	$max = count($phones);
	foreach( $phones as $k => $v) {
		if($k == 0) {
			$title .= '<a href="tel:'.$v.'">'. $location[$k] ."<br/>". $v .'</a></li>';
		}
		else {
			$title .= '<li id="menu-item-phones-'.$k.'" clas"menu-item menu-item-type-custom menu-item-object-custom menu-item-phones'.$k.'">';
			$title .= '<a href="tel:'.$v.'">'. $location[$k] ."<br/>". $v .'</a></li>';
		}
	}
	
	return $title;
}

function call_phone_shortcode($phone){
	if(preg_match('%phone_number%', $phone)){
		$phone = get_multi_data('phone_number', $phone);
	} else {
		$phone = '<a href="tel:'.$phone.'">'.$phone.'</a>';
	}
	return $phone;	
}
	
function call_address_shortcode($address, $line){
	if(preg_match('%location%', $address)){
		$address = get_multi_data('location', $address);
		$string = explode("\n", $address );

		switch ($line) {
		case 'line1':
			$address = $string[0];
			return $address;
			break;
		case 'line2':
			$address = $string[1];
			return $address;
			break;
		case 'line3':
			$address = $string[2];
			return $address;
			break;
		case 'line4':
			$address = $string[3];
			return $address;
			break;
		}
	}
	else {
		return $address;
	}
}

function call_description_shortcode($description,$skip_phone=false){
	if(!$skip_phone && preg_match('%phone_number%', $description)){
		$description = get_multi_data('phone_number', $description);
	}
	if(preg_match('%doctor_name%', $description)){
		$description = get_multi_data('doctor_name', $description);
	}
	if(preg_match('%doctor_title%', $description)){
		$description = get_multi_data('doctor_title', $description);
	}
	if(preg_match('%client_name%', $description)){
		$description = get_general_data('client_name', $description);
	}
	if(preg_match('%practice_name%', $description)){
		$description = get_general_data('practice_name', $description);
	}
	if(preg_match('%location%', $description)){
		$data = get_multi_data('location', $description);
		$string = preg_replace("#\r\n#",'{br}',trim($data));
		$description = $string;
	}
	if(preg_match('%multi_data%', $description)){
		$practice = get_option('wm4d_practice');
		$all_phones = get_option('wm4d_phones');
		$all_locations = get_option('wm4d_locations');
		
		$string = '';
		foreach($all_phones as $k => $v) {
			$locations = preg_replace("#\r\n#",'{br}',trim($all_locations[$k]));

			//$string .= $practice . '{br}';
			$string .= $locations . '{br}';
			//$string .= 'Phone: ' . $v . ' | ';
			 $string .='Phone: <a href="tel:'.$v.'">'.$v.'</a> | ';
		}
		
		$description = $string;
	}
	
	return $description;

}

function call_addresses_shortcode($address){
	if(preg_match('%location%', $address)){
		$data = get_multi_data('location', $address);
		$string = preg_replace("#\r\n#",'',trim($data));
		$address = $string;
	}
	if(preg_match('%multi_data%', $address)){
		$data = get_option('wm4d_locations');
		
		foreach($data as $k => $v) {
			$locations = preg_replace("#\r\n#",'',trim($v));
			$string .= $locations . '|';
		}
		$address = $string;
	}
	return $address;
	//return print_r( $data );
}

function call_icons_shortcode($address, $icons) {
	if(preg_match('%multi_data%', $address)){
		$data = get_option('wm4d_locations');
		$string = '';
		foreach($data as $k => $v) {
			$string .=  $icons . '|';
		}
		$icons = $string;
	}
	return $icons;
}

function call_web_shortcode($url){
	if(preg_match('%self%', $url)){
		$url = site_url();
		$a = preg_replace('#^[^:/.]*[:/]+#i', '',urldecode( $url ));
		$out =	preg_replace('!\bwww3?\..*?\b!', '', $a);
		$url = $out;	
	}
	else {
		$out = "<a target='_blank' href='{$url}'>";
		$a = preg_replace('#^[^:/.]*[:/]+#i', '',urldecode( $url ));
		$out .=	preg_replace('!\bwww3?\..*?\b!', '', $a);
		$out .= "</a>";
		$url = $out;	
	}
	return $url;	
}


/******* REPLACED SHORTCODES FROM ORGINAL *******/
	/* Titles Box Shortcode */
	function dt_sc_titled_box_edited($attrs, $content = null) {
		extract ( shortcode_atts ( array (
				'title' => '',
				'icon' => '',
				'type'	=> '',
				'variation' => '',
				'bgcolor' => '',
				'textcolor' => '' 
		), $attrs ) );
		
		$type = (empty($type)) ? 'dt-sc-titled-box' :"dt-sc-$type";
		$variation = ( ( $variation ) && ( empty( $bgcolor ) ) ) ? ' ' . $variation : '';
		$content = DTCoreShortcodesDefination::dtShortcodeHelper( $content );
		$title = call_title_shortcode($title,$content);
		
		$styles = array();
		if($bgcolor) $styles[] = 'background-color:' . $bgcolor . ';border-color:' . $bgcolor . ';';
		if($textcolor) $styles[] = 'color:' . $textcolor . ';';
		$style = join('', array_unique( $styles ) );
		$style = !empty( $style ) ? ' style="' . $style . '"': '' ;
		
		if($type == 'dt-sc-titled-box') :
			$icon = ( empty($icon) ) ? "" : "<span class='fa {$icon} '></span>";
			$title = "<h6 class='{$type}-title' {$style}> {$icon} {$title}</h6>";
			$out = "<div class='{$type} {$variation}'>";
			$out .= $title;
			$out .=	"<div class='{$type}-content'>{$content}</div>";
			$out .= "</div>";
		else :
			$out = "<div class='{$type}'>{$content}</div>";
		endif;
		return $out;
	}

	/* Icon Boxes Colored Shortcode */
	function dt_sc_icon_box_colored_edited($attrs, $content = null, $shortcodename = "") {
		extract ( shortcode_atts ( array (
				'type' => '',
				'fontawesome_icon' => '',
				'custom_icon' => '',
				'title' => '',
				'bgcolor' => ''
		), $attrs ) );
		
		$content = DTCoreShortcodesDefination::dtShortcodeHelper ( $content );
		$title = call_title_shortcode($title,$content);
		
		$bgcolor = empty ( $bgcolor ) ? "" : " style='background:{$bgcolor};' ";
		
		$type = ( trim($type) === 'type1' ) ? "no-space" : "space";
		
		$out =  "<div class='dt-sc-colored-box {$type}' {$bgcolor}>";
		
		$icon = "";
		if( !empty($fontawesome_icon) ){
			$icon = "<span class='fa fa-{$fontawesome_icon}'> </span>";
		
		}elseif( !empty($custom_icon) ){
			$icon = "";	
		}
		
		$out .= "<h5>{$icon}{$title}</h5>";
		$out .= $content;
		$out .= "</div>";
		return $out;
	}

	/* Icon Boxes Shortcode */
	function dt_sc_icon_box_edited($attrs, $content = null, $shortcodename = "") {
		extract ( shortcode_atts ( array (
				'type' => '',
				'fontawesome_icon' => '',
				'custom_icon' => '',
				'title' => '',
				'link' => '',
				'target' => ''
		), $attrs ) );
		
		$content = DTCoreShortcodesDefination::dtShortcodeHelper ( $content );
		$title = call_title_shortcode($title,$content);
		
		$out =  "<div class='dt-sc-ico-content {$type}'>";
		if( !empty($fontawesome_icon) ){
			$out .= "<div class='icon'> <span class='fa fa-{$fontawesome_icon}'> </span> </div>";
		
		}elseif( !empty($custom_icon) ){
			
		}
		$out .= empty( $title ) ? $out : "<h5><a href='{$link}' target='{$target}'> {$title} </a></h5>";
		$out .= $content;
		$out .= "</div>";
		return $out;
	}

	/* Phone Shortcode */
	function dt_sc_phone_edited($attrs, $content = null) {
		extract ( shortcode_atts ( array (
				'phone' => ''
		), $attrs ) );
		
		$phone = call_phone_shortcode($phone);

		$out = '<p class="dt-sc-contact-info">';
		$out .= "<i class='fa fa-phone'></i>";
		$out .= __('Phone : ','dt_themes');
		$out .= ( !empty($phone) ) ?"<span>{$phone}</span>": "";
		$out .= '</p>';
		
		return $out;
	}

	/* Address Shortcode */
	function dt_sc_address_edited($attrs, $content = null) {
		extract ( shortcode_atts ( array (
				'line1' => '',
				'line2' => '',
				'line3' => '',
				'line4' => ''
		), $attrs ) );
		if(!empty($line1)) $line1 = call_address_shortcode($line1, 'line1'); else $line1 = '';
		if(!empty($line2)) $line2 = call_address_shortcode($line2, 'line2'); else $line2 = '';
		if(!empty($line3)) $line3 = call_address_shortcode($line3, 'line3'); else $line3 = '';
		if(!empty($line4)) $line4 = call_address_shortcode($line4, 'line4'); else $line4 = '';
		
		$out = '<p class="dt-sc-contact-info address">';
		$out .= "<i class='fa fa-rocket'></i>";
		$out .= "<span>";
		$out .= ( !empty($line1) ) ? $line1 : "";
		$out .= ( !empty($line2) ) ? "<br>{$line2}" : "";
		$out .= ( !empty($line3) ) ? "<br>{$line3}" : "";
		$out .= ( !empty($line4) ) ? "<br>{$line4}" : "";
		$out .= "</span>";
		$out .= '</p>';
		
		return $out;
	}
	
	/* Web Shortcode */
	function dt_sc_web_edited($attrs, $content = null) {
		extract ( shortcode_atts ( array (
				'url' => ''
		), $attrs ) );
		$url = call_web_shortcode($url);
		
		$out = '<p class="dt-sc-contact-info">';
		$out .= "<i class='fa fa-globe' ></i>";
		$out .= __('Web : ','dt_themes');
		if( !empty( $url ) ) {
			$out .= $url;
		}
		$out .= '</p>';
		
		return $out;
	}

/* EDIT RESPONSIVE MAP SHORTCODE OUTPUT */
remove_shortcode('res_map');
//add_shortcode('res_map', 'responsive_map_shortcode_edited');
add_shortcode('res_map', 'responsive_map_shortcode_edited');
function responsive_map_shortcode_edited($atts) {

    // Extract the attributes from the shortcode
    $atts = shortcode_atts(array(
      'width'           => '100%',    // Use a width in 'px' or '%'. Default: 100%
      'height'          => '500px',   // Use a height in 'px' or '%'. Default: 500px
      'maptype'         => 'roadmap', // Possible values: roadmap, satellite, terrain or hybrid
      'zoom'            => 14,        // Zoom, use values between 1-19, default zoom=14
      'address'         => '',        // Markers list in this format: street, city, country | street, city, country | street, city, country
      'description'     => '',        // Markers descriptions in this format: description1 | description2 | description3 (one for each marker address above)
      'popup'           => 'no',      // 'yes' or 'no'
      'pancontrol'      => 'no',      // 'yes' or 'no'
      'zoomcontrol'     => 'no',      // 'yes' or 'no'
      'draggable'       => 'yes',     // 'yes' or 'no'
      'scrollwheel'     => 'no',      // 'yes' or 'no'
      'typecontrol'     => 'no',      // 'yes' or 'no'
      'scalecontrol'    => 'no',      // 'yes' or 'no'
      'streetcontrol'   => 'no',      // 'yes' or 'no'
      'searchbox'       => 'no',      // 'yes' or 'no'
      'clustering'      => 'no',      // 'yes' or 'no'
      'logging'         => 'no',      // 'yes' or 'no'
      'poi'             => 'yes',     // 'yes' or 'no'
      'directionstext'  => '',        // The text to be displayed for directions link
      'center'          => '',        // The point where the map should be centered (latitude, longitude) for instance: center="38.980288, 22.145996"
      'icon'            => 'green',   // Possible color values: black, blue, gray, green, magenta, orange, purple, red, white, yellow or a http link to a custom image
      'style'           => '1',       // Use style values between 1-50
      'refresh'         => 'no',      // 'yes' or 'no'
      'locateme'        => 'no',      // 'yes' or 'no'
      'key'             => ''         // Google Maps API key
    ), $atts);
    
    // Enque jQuery
    wp_enqueue_script("jquery");

    // Google Maps API link, http or https
    $api_url = is_ssl() ? 'https://maps-api-ssl.google.com' : 'http://maps.googleapis.com';

    // Add to Google Maps API the Google Maps API key parameter if is set in the shortcode
    $api_key = '';
    if (isset($atts['key'])) {
        if (trim($atts['key']) != '') {
            $api_key = '&key=' . trim($atts['key']);
        }
    }

    // And enqueue the Google Maps Api
    wp_enqueue_script('googlemapsapi', $api_url . '/maps/api/js?v=3.exp&libraries=places' . $api_key, array('jquery'), null, true);
	
	/* ----------------------------------------------
	// - WM4D SHORTCODE EDIT - catch script url
	// ---------------------------------------------- */
    // Enqueue the responsive maps javascripts
    wp_enqueue_script('resmap', '/wp-content/plugins/responsive-maps-plugin/includes/js/resmap.min.js', array('jquery'), '3.4', true);
    
    // Generate a unique identifier for the map
    $mapid = rand();

    // Extract the map type
    $atts['maptype'] = strtoupper($atts['maptype']);

    // If width or height were specified in the shortcode, extract them too
    $dimensions = '';
    if(isset($atts['height']))
        $dimensions .= 'height:' . $atts['height'] . ';';
    if(isset($atts['width']))
        $dimensions .= 'width:' . $atts['width'] . ';';

    // Set the pre-defined style which corresponds to the number given in the shortcode
    $atts['style'] = getStyleString($atts['style']);

    // If points of interest (poi) is set to "no" in the shortcode, add this option to the style string
    // And this is the JSON for no points of interest: ', { "featureType": "poi", "stylers": [ { "visibility": "off" } ] }'
    $noPOI = ', {"featureType":"poi","stylers":[{"visibility": "off"}]}';
    if (isset($atts['poi']) && $atts['poi'] == 'no') {
        $atts['style'] = substr($atts['style'], 0, -1) . $noPOI . ']';
    }

    // Extract the langitude and longitude for the map center
    if (trim($atts['center'])  != "") {
        sscanf($atts['center'], '%f, %f', $lat, $long);
    } else {
        $lat = 'null'; $long = 'null';
    }

    // Prepare markers list
    $markers = '[]';

    // Split the addresses, descriptions and icons (by the pipeline "|" delimiter)
    if ($atts['address'] != '') {
	
	/* -----------------------------------------------
	// - WM4D SHORTCODE EDIT - catch %% shortcodes
	// ----------------------------------------------- */
 		$att_address = $atts['address'];
		$att_address = call_addresses_shortcode($att_address);
		$att_description = $atts['description'];
		$att_description = call_description_shortcode($att_description);
		$att_icon = $atts['icon'];
		$att_icon = call_icons_shortcode($att_address, $att_icon);


      $addresses = explode("|", $att_address ); 
	  $descriptions = explode("|", $att_description);
	  $icons = explode("|", $att_icon); 
	  
	  
	  $total_addresses = count($addresses);

      // Start building the markers JSON array
      $markers = '[';

      // For each address from the list, build a marker (with popup with description and an icon)
      for($i = 0; $i < $total_addresses; $i ++) {

        // Remove unneccessary line breaks from the addresses list
        $address = resmap_cleanHtml($addresses[$i]);
        
        // If it's empty, set the default description equal to the the address
        if(isset($descriptions[$i]) && strlen(trim($descriptions[$i])) != 0) {
            $html = $descriptions[$i];  
        }
        else {
            $html = $address;
        }
            
        // Add the directions link to the description
        if (isset($atts['directionstext']) && strlen(trim($atts['directionstext'])) != 0) {
            $directions = 'http://maps.google.com/?daddr=' . urlencode($address);
            $html .= "<br><strong><a target='_blank' href='". $directions ."'>". $atts['directionstext'] ."</a></strong>" ;
        }
            
        // Remove unneccessary line breaks from the $html and transforms {br} to <br>
        $html = resmap_cleanHtml($html);
        
        // Get the correct icon image based on icon color/url which were given in the shortcode
        if(isset($icons[$i])) {
            $icon = resmap_getIcon($icons[$i]);
        } 

        // Extract the lagitude and longitude
        $marker_latitude = null;
        $marker_longitude = null;
        if (trim($address)  != "") {
            sscanf($address, '%f, %f', $marker_latitude, $marker_longitude);
        }

        // See if we show popups. 
        // If only one address, popup is true or false (what's given in the shortcode)
        // If more addresses and in shortcode popup is true, show the open popup only for first address.
        $popup = 'false';
        if (isset($atts['popup']) && $atts['popup'] == 'yes') {
            if ($total_addresses == 1) {
                $popup = 'true';
            } else if ($total_addresses >= 1) {
                $i == 0 ? ($popup = 'true') : ($popup = 'false');
            }
        }

        // If more markers, add the neccessary "," delimiter between markers
        if ($i > 0) $markers .= ",";
        
        // Build markers list based on given address or latitude/longitude
        if ($marker_latitude == '' || $marker_longitude == '') {
            $markers .= "{
                    address: '" . $address . "', 
                    key: '". ($i + 1)  . "',";
        } else {
            $markers .= "{
                    latitude:" . $marker_latitude .", 
                    longitude:" . $marker_longitude .",
                    key: '" . ($i +1) . "',";
        }
        $markers .= "html:'" . $html . "',
                    popup: ". $popup . ",
                    flat: true,
                    icon: {
                        image: '". $icon . "'
                    }}";
        }
        $markers .= ']';
    }
    // Tell PHP to start output buffering
    ob_start();
    ?><script type="text/javascript">
    jQuery(document).ready(function($) {
        // the div that will contain the map
        var mapdiv = jQuery("#responsive_map_<?php echo $mapid; ?>"); 
        // markers should be clustered?
        var clustering = "<?php echo $atts['clustering']; ?>"; 
        // Create the map in the div 
        mapdiv.gMapResp({
            maptype: google.maps.MapTypeId.<?php echo $atts['maptype']; ?>,
            log: <?php echo toBool($atts['logging']); ?>,
            zoom: <?php echo $atts['zoom']; ?>,
            markers: <?php echo $markers; ?>,
            panControl: <?php echo toBool($atts['pancontrol']); ?>,
            zoomControl: <?php echo toBool($atts['zoomcontrol']); ?>,
            draggable: <?php echo toBool($atts['draggable']); ?>,
            scrollwheel: <?php echo toBool($atts['scrollwheel']); ?>,
            mapTypeControl: <?php echo toBool($atts['typecontrol']); ?>,
            scaleControl: <?php echo toBool($atts['scalecontrol']); ?>,
            streetViewControl: <?php echo toBool($atts['streetcontrol']); ?>,
            overviewMapControl: true,
            styles: <?php echo $atts['style']; ?>,
            latitude: <?php echo $lat; ?>,
            longitude: <?php echo $long; ?>,
            onComplete: function() {
                var gmap = mapdiv.data('gmap').gmap;
                if (clustering.length  != 0 && clustering == "yes") {
                    var markerCluster = new MarkerClusterer(gmap, mapdiv.data('gmap').markers, {imagePath: '<?php echo esc_url(plugins_url()); ?>/responsive-maps-plugin/includes/img/m'});
                }
            }
        });
    gmap = mapdiv.data('gmap').gmap;
    <?php if (isset($atts['searchbox']) && $atts['searchbox'] == 'yes') { ?>
    resmap_createSearchBox(gmap);
    <?php } 
    if (isset($atts['locateme']) && $atts['locateme'] == 'yes') { ?>
    resmap_addLocatemeButton(gmap);
    <?php } ?>
    resmap_fixDisplayInTabs(mapdiv, <?php echo toBool($atts['popup']); ?>);
  });
  <?php if (isset($atts['refresh']) && $atts['refresh'] == 'yes') { ?>
  // If the refresh parameter is set to true, resize the map when window is resized 
  window.onresize = function() {
        jQuery('.responsive-map').each(function(i, obj) {
            data = jQuery(this).data('gmap');
            if (data) {
                var gmap = data.gmap;
                google.maps.event.trigger(gmap, 'resize');
                jQuery(this).gMapResp('fixAfterResize');
            }
        });
  };
  <?php } ?>
  </script>
  <div id="responsive_map_<?php echo $mapid; ?>" class="responsive-map" style="<?php echo $dimensions; ?>"></div>
<?php return ob_get_clean();
}
?>