<?php
add_action('wp_head','integratecodes');
add_action("admin_init", "procedures_metabox");

function integratecodes() {
?>
	<script>
    (function($) {	
		$(document).ready(function() {
			var offer = $('p.datetoday').html();
			var date = new Date().toDateString();
			var fday = date.split(" ")[0];
			var month = date.split(" ")[1];
			var day = date.split(" ")[2];
			var year = date.split(" ")[3];
			var newdate =  fday+', '+month+' '+day+', '+year;
			$('p.datetoday').html(offer+' '+newdate);
	
		});
    })(jQuery);
    </script>
<?php }

	function procedures_metabox(){
		add_meta_box("post-template-meta-container", __('Slider Options','iva_theme_admin'), "procedures_sllider_settings", "procedures", "normal", "high");
		add_action('save_post','procedures_meta_save');
	}

	#Slider Meta Box for PROCEDURES
	function procedures_sllider_settings($args){	
		global $post; 
		$lifecare_wm4d_settings = get_post_meta($post->ID,'_lifecare_wm4d_settings',TRUE);
		$lifecare_wm4d_settings = is_array($lifecare_wm4d_settings) ? $lifecare_wm4d_settings  : array();?>

		<!-- Show Slider -->        
        <div class="custom-box">
        	<div class="column one-sixth">
                  <label><?php _e('Show Slider','iva_theme_admin');?> </label>
            </div>
            <div class="column four-sixth last">
				<?php $switchclass = array_key_exists("show_slider",$lifecare_wm4d_settings) ? 'checkbox-switch-on' :'checkbox-switch-off';
                      $checked = array_key_exists("show_slider",$lifecare_wm4d_settings) ? ' checked="checked"' : '';?>
                <div data-for="mytheme-show-slider" class="checkbox-switch <?php echo $switchclass;?>"></div>
                <input id="mytheme-show-slider" type="checkbox" name="mytheme-show-slider" value="true"  <?php echo $checked;?>/>
                <p class="note"> <?php _e('YES! to show slider on this page.','iva_theme_admin');?> </p>
            </div>
        </div><!-- Show Slider End-->

        <!-- slier-container starts-->
    	<div id="slider-conainer">
        <?php $layerslider = $revolutionslider = 'style="display:none"';
			  if(isset($lifecare_wm4d_settings['slider_type'])&& $lifecare_wm4d_settings['slider_type'] == "layerslider"):
			  	$layerslider = 'style="display:block"';
			  endif;?>
          
              <!-- Layered Slider -->
              <div id="layerslider" class="custom-box" <?php echo $layerslider;?>>
              	<h3><?php _e('Layer Slider','iva_theme_admin');?></h3>
                <?php if(is_plugin_active('LayerSlider/layerslider.php')):?>
                <?php // Get WPDB Object
					  global $wpdb;
					  // Table name
					  $table_name = $wpdb->prefix . "layerslider";
					  // Get sliders
					  $sliders = $wpdb->get_results( "SELECT * FROM $table_name WHERE flag_hidden = '0' AND flag_deleted = '0'  ORDER BY date_c ASC LIMIT 100" );
					  
					  if($sliders != null && !empty($sliders)):
		 	                echo '<div class="one-half-content">';
							echo '	<div class="bpanel-option-set">';
							echo ' <div class="column one-sixth">';
                            echo '	<label>'.__('Select LayerSlider','iva_theme_admin').'</label>';
							echo ' 	</div>';
							echo ' <div class="column two-sixth">';
                            echo '	<select name="layerslider_id">';
                            echo '		<option value="0">'.__("Select Slider",'iva_theme_admin').'</option>';
									  	foreach($sliders as $item) :
											$name = empty($item->name) ? 'Unnamed' : $item->name;
											$id = $item->id;
											$rs = isset($lifecare_wm4d_settings['layerslider_id']) ? $lifecare_wm4d_settings['layerslider_id']:'';
											$rs = selected($id,$rs,false);
											echo "	<option value='{$id}' {$rs}>{$name}</option>";
										endforeach;
                            echo '	</select>';
                            echo '<p class="note">';
							_e("Choose Which LayerSlider you would like to use..",'iva_theme_admin');
							echo "</p>";
							echo ' 	</div>';
							echo '	</div>';
                            echo '</div>';
					  else:
					     echo '<p id="j-no-images-container">'.__('Please add atleat one layer slider','iva_theme_admin').'</p>';
					  endif;?>
                      
					<?php $layersliders = get_option('layerslider-slides');
                        if($layersliders):
                            $layersliders = is_array($layersliders) ? $layersliders : unserialize($layersliders);	
                            foreach($layersliders as $key => $val):
                                $layersliders_array[$key+1] = 'LayerSlider #'.($key+1);
                            endforeach;
                            echo '<div class="one-half-content">';
							echo '	<div class="bpanel-option-set">';
							echo ' <div class="column one-sixth">';
                            echo '	<label>'.__('Select LayerSlider','iva_theme_admin').'</label>';
                            echo '</div>';
							echo ' <div class="column two-sixth">';
                            echo '	<select name="layerslider_id">';
                            echo '		<option value="0">'.__("Select Slider",'iva_theme_admin').'</option>';
                            foreach($layersliders_array as $key => $value):
                                $rs = isset($lifecare_wm4d_settings['layerslider_id']) ? $lifecare_wm4d_settings['layerslider_id']:'';
                                $rs = selected($key,$rs,false);
                                echo "	<option value='{$key}' {$rs}>{$value}</option>";
                            endforeach;
                            echo '	</select>';
                            echo '<p class="note">';
							_e("Choose which LayerSlider would you like to use!",'iva_theme_admin');
							echo "</p>";
                            echo '</div>';
							echo '	</div>';
                            echo '</div>';
                        endif;
					  else:?>
                      <p id="j-no-images-container"><?php _e('Please activate Layered Slider','iva_theme_admin'); ?></p>
               <?php endif;?>         
                
              </div><!-- Layered Slider End-->

        </div><!-- slier-container ends-->
<?php  wp_reset_postdata();
	}
		
	function procedures_meta_save($post_id){
		global $pagenow;
		if ( 'post.php' != $pagenow ) return $post_id;
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 	return $post_id;
		
		$settings = array();
		$settings['layout'] = isset($_POST['layout']) ? $_POST['layout'] : "";
		$settings['disable-comment'] = isset( $_POST['post-comment'] ) ? $_POST['post-comment'] : "";
		$settings['disable-everywhere-sidebar'] = isset($_POST['disable-everywhere-sidebar']) ? $_POST['disable-everywhere-sidebar'] : "";
		$settings['disable-featured-image'] = isset($_POST['post-featured-image']) ? $_POST['post-featured-image'] : "";
		$settings['disable-author-info']	= isset($_POST['disable-author-info']) ? $_POST['disable-author-info'] : "";
		$settings['disable-date-info']	= isset($_POST['disable-date-info']) ? $_POST['disable-date-info'] : "";
		$settings['disable-comment-info']	= isset($_POST['disable-comment-info']) ? $_POST['disable-comment-info'] : "";
		$settings['disable-category-info']	= isset($_POST['disable-category-info'])?$_POST['disable-category-info']: "";
		$settings['disable-tag-info']	= isset($_POST['disable-tag-info']) ? $_POST['disable-tag-info'] : "";

		$settings['show_slider'] =  $_POST['mytheme-show-slider'];
		$settings['slider_type'] = $_POST['mytheme-slider-type'];
		$settings['layerslider_id'] = $_POST['layerslider_id'];
		$settings['revolutionslider_id'] = $_POST['revolutionslider_id'];
		
		update_post_meta($post_id, "_lifecare_wm4d_settings", array_filter($settings));
		
	}

/* CALL FUNCTION FOR SLIDER */
function procedure_slider_out($post_id) {
	$lifecare_wm4d_settings = get_post_meta($post_id, '_lifecare_wm4d_settings', TRUE);
	$lifecare_wm4d_settings = is_array($lifecare_wm4d_settings) ? $lifecare_wm4d_settings : array();

	if (array_key_exists('show_slider', $lifecare_wm4d_settings) && array_key_exists('slider_type', $lifecare_wm4d_settings)) :

		echo '<!-- **Slider Section** -->';
		echo '<section id="slider" class="procedure-slider">';
		if ($lifecare_wm4d_settings['slider_type'] === "layerslider") :
			$id = isset( $lifecare_wm4d_settings['layerslider_id'])? $lifecare_wm4d_settings['layerslider_id'] : "";
			$slider = !empty($id) ? do_shortcode("[layerslider id='{$id}']") : "";
			echo $slider;
		endif;

		echo '</section><!-- **Slider Section - End** -->';
	endif;
}

/* CALL FUNCTION FOR SUBHEADER */
function generate_subhead( $title ) {
?>	<div id="subheader" class="sleft">
		<div class="subheader-inner">
			<div class="subdesc">
				<h1 class="page-title"><?=$title;?></h1>
			</div>
		</div>
	 </div>	
<?php
}
?>