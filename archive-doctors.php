<?php get_header(); ?>
<div id="primary" class="pagemid">
	<div class="inner">			
		<div class="content-area">
				<?php global $readmoretxt; ?>
				<?php if ( atp_generator('sidebaroption', get_the_id() ) != "fullwidth" ) { $width = '870'; } else { $width = '1170';  } ?>
				
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

				<?php $format = get_post_format($post->ID);?>
				
				<?php if( false === $format ) { $format = 'standard'; } ?>
				
				<div <?php post_class('iva_post');?> id="post-<?php the_ID(); ?>">

					<div class="post_wrap">
						
						<!-- post formats-->
						<?php get_template_part( 'post','formats'); ?>	

						<!-- post content-->
						<?php if( $format != 'aside' && $format != 'quote' && $format != 'link'){?>

						<div class="post_content">					
						
							<?php the_title( '<h1 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h1>' );?>

							<?php
							echo '<span class="meta-author"> By ';
								the_author_posts_link(); 
							echo ' &#45; </span>';
							echo '<span class="meta-category">';
								the_category(',') ; 
							echo '</span>';
							?>

							<div class="entry-content">
								<?php the_content( ); ?>	
							
								
								<?php wp_link_pages( array(
										'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'iva_theme_front' ) . '</span>',
										'after'       => '</div>',
										'link_before' => '<span>',
										'link_after'  => '</span>',
									) ); ?>
							</div><!-- .post-entry -->

						</div><!-- .post_content -->

						<?php } ?>	

					</div><!-- .post_wrap -->
				</div><!-- .post-<?php the_ID();?> -->

				<?php endwhile; ?>
						
				<?php if ( function_exists ('atp_pagination') ) { echo atp_pagination(); } ?>

				<?php else : ?>

				<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'iva_theme_front' ); ?></p>

				<?php get_search_form(); ?>

				<?php endif;?>
				
		</div><!-- .content-area -->

		<?php if ( atp_generator( 'sidebaroption', $post->ID ) != "fullwidth" ){ get_sidebar(); } ?>

		<div class="clear"></div>

	</div><!-- .inner -->
</div><!-- .pagemid -->
<?php 
get_footer();