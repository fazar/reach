<?php
/**
* The single blog post file. 
*
*
* @package Reach
* @since Reach 1.0
*/
	get_header();
	/* Start the Loop */
	?>
	<div class="row main-content single-blogpost">		
		<div class="large-offset-2 large-8 medium-8 large-offset-2 columns">
		<?php
			while ( have_posts() ) : the_post();
				?>
				<article>
					<div class="post-header">
						<?php 
							$post_format = get_post_format();
							if(!$post_format){
								do_action('dc_display_media', 'image');
							}else{
								do_action('dc_display_media', get_post_format());
							}
						?>
					</div>
					<div class="post-content">
						<ul class="post-meta">				
							<li><?php the_category(); ?></li>							
							<li>• <?php the_time( get_option( 'date_format' ) ); ?> </li>
							<li>• <?php echo get_post_meta( get_the_id(), '_dc_post_views', true  ); ?> Views</li>
						</ul>
						<h2 class="post-title"><?php the_title() ?></h2>						
						<div class="the-content">
						<?php the_content() ?>
						</div>
						<div class="post-footer">
						<?php do_action( 'dc_social_share' ) ?>
						</div>
					</div>
					<?php 					
					if ( comments_open() || get_comments_number() ) {
						echo '<div class="comment-section">';
						comments_template();
						echo '</div>';
					}
					?>
				</article>
				<?php
			endwhile;
		?>
		<div class="pagination-wrapper">
		<?php 
			global $wp_query;

			$big = 999999999; // need an unlikely integer

			echo paginate_links( array(
				'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format' => '?paged=%#%',
				'current' => max( 1, get_query_var('paged') ),
				'total' => $wp_query->max_num_pages,
				'prev_text'    => '<span class="icon-arrow-left"></span>',
				'next_text'    => '<span class="icon-arrow-right"></span>',
			) );
		?>
		</div>
		</div>
	</div>
	<?php  
		get_footer();
	?>
	