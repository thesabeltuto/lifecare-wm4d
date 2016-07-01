<?php
/** 
 * The Header for our theme.
 * Includes the header.php template file. 
 */

get_header(); ?>

	<div id="primary" class="pagemid">
	<div class="inner">
		<div class="content-area">
			<?php

			$iva_dr_photo_txt		= get_option('iva_dr_photo_txt') ? get_option('iva_dr_photo_txt') :__('Photo','iva_theme_front');
			$iva_dr_name_txt		= get_option('iva_dr_name_txt') ? get_option('iva_dr_name_txt') :__('Name','iva_theme_front');
			$iva_dr_spl_txt 		= get_option('iva_dr_spl_txt') ? get_option('iva_dr_spl_txt') : __('Specialty','iva_theme_front');
			$iva_dr_location_txt 	= get_option('iva_dr_location_txt') ? get_option('iva_dr_location_txt') :__('Location','iva_theme_front');
			$iva_sociables_txt 		= get_option('iva_dr_sociables_txt') ? get_option('iva_dr_sociables_txt') :__('Sociales','iva_theme_front');


			if ( have_posts()) :

			echo '<div class="drlist-Table">';
			echo '<div class="drlist-Header">';
			echo'<div class="drlist-Row">';
			echo '<div class="drlist-photo drlist-item">'.$iva_dr_photo_txt.'</div>';
			echo '<div class="drlist-details">';
			echo '<div class="drlist-name drlist-item">'.$iva_dr_name_txt.'</div>';
			echo '<div class="drlist-specialty drlist-item">'.$iva_dr_spl_txt.'</div>';
			echo '<div class="drlist-location drlist-item">'.$iva_dr_location_txt.'</div>';
			echo '<div class="drlist-socials drlist-item">'.$iva_sociables_txt.'</div>';
			echo '</div>';
			echo '</div>';
			echo '</div>';
			echo '<div class="drlist-Body">';
			
			while (  have_posts()) : the_post(); 

				$img_alt_title 		= get_the_title();
				$iva_sociables 		= get_post_meta( $post->ID, 'iva_sociable', true );
				$dr_location 		= get_post_meta( $post->ID, 'iva_dr_location', true );
				$specialties 		= $term_links = '';
				$no_image 			= THEME_URI.'/images/no_image.jpg';
				
				$terms = get_the_terms( $post->ID,'specialty');
				if ( $terms && ! is_wp_error( $terms ) ){
					foreach ( $terms as $term ) {
						$term_links[] = $term->name;
					}
					$specialties = join( ', ', $term_links );
				}

					echo '<div class="drlist-Row">';
					
					// Doctor Image
					echo'<div class="drlist-photo drlist-item">';
					if( has_post_thumbnail()){
						echo '<a href="' .get_permalink(). '" title="' . get_the_title() . '"><figure>'. atp_resize( $post->ID, '', 100, 100, '', $img_alt_title ) .'</figure></a>'; 
					}
					else{
						echo '<a href="' .get_permalink(). '" title="' . get_the_title() . '"><img src="'.$no_image.'" width="100" height="100"></a>'; 
					}
					echo '</div>';
					
					echo '<div class="drlist-details">';
					//Doctor Title
					echo '<div class="drlist-name drlist-item"><a href="' .get_permalink(). '" title="' . get_the_title() . '">'.get_the_title().'</a></div>';
					
					//Doctor specialty
					echo '<div class="drlist-specialty drlist-item">';
					if ( $specialties !='' ) { 
						echo $specialties;
					}
					echo '</div>';
										
					//Doctor Location
					echo '<div class="drlist-location drlist-item"><i class="fa fa-map-marker fa-fw fa-lg"></i>';
					if ( $dr_location !='' ) { 
						echo $dr_location;
					}
					echo'</div>';
					
					//Doctor Sociables
					echo '<div class="drlist-socials drlist-item">';
					if ( $iva_sociables !='' ) { 
						echo doctor_social_icon( $iva_sociables );
					}
					echo '</div>';

					echo '</div>';
					echo '</div>';
				
			endwhile;
			
			echo '</div>';
			echo '</div>';

			echo '<div class="clear"></div>';
			
			if(function_exists('atp_pagination')) { 
				echo atp_pagination(); 
			} 
			?>

			<?php wp_reset_query(); ?>

			<?php else : ?>

			<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'iva_theme_front' ); ?></p>

			<?php get_search_form(); ?>
				
			<?php endif;?>
			
			</div><!-- .content-area -->

	</div><!-- inner -->
	</div><!-- #primary.pagemid -->

<?php get_footer(); ?>