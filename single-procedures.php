<?php get_header(); ?>
<div id="primary" class="pagemid">
	<div class="inner">	
		<div class="content-area">

				<?php $format = get_post_format( $post->ID ); ?>

				<?php if( false === $format ) { $format = 'standard'; } ?>

				<?php if( atp_generator( 'sidebaroption', get_the_id() ) != "fullwidth" ){ $width = '870'; } else { $width = '1170'; } ?>

				<?php if ( have_posts()) : while ( have_posts() ) : the_post(); ?>
			
				<div <?php post_class('iva_post');?> id="post-<?php the_ID(); ?>">

					<div class="post_wrap">
					
					<!-- post formats-->
					<?php if( $format != 'audio' && $format != 'video') { get_template_part( 'post','formats'); } ?>

					<!-- post content-->
					<?php if( $format != 'aside' && $format != 'quote' && $format != 'link'){?>

					<!-- post content-->
					<div class="post_content">	

						<?php the_title( '<h1 class="entry-title">', '</h1>' );?>
					
						<div class="entry-meta">
						<?php
							edit_post_link( __( 'Edit', 'iva_theme_front' ), '<span class="edit-link">', '</span>' ); 
						?>
						</div>
						<div class="entry-content">
							<?php the_content();?>
							<?php the_tags('<div class="tags">'.__('Tags','iva_theme_front').': ',',&nbsp; ','</div>');?>
						</div><!-- .post-entry -->

					</div><!-- .post-content -->

					<?php } ?>		
				</div><!-- .post_wrap -->
				</div><!-- #post-<?php the_ID(); ?> -->

				<?php endwhile; ?>
				
				<?php else: ?>
				<?php '<p>'.__('Sorry, no posts matched your criteria.', 'iva_theme_front').'</p>';?>
				
				<?php endif; ?>

		</div><!-- .content-area -->

		<?php if ( atp_generator( 'sidebaroption', $post->ID ) != "fullwidth" ){ get_sidebar(); } ?>			
		
		<div class="clear"></div>
		
	</div><!-- .inner -->
</div><!-- .pagemid -->
<?php get_footer(); ?>