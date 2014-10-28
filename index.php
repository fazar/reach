<?php
/**
* The main template file. Includes the loop.
*
*
* @package Reach
* @since Reach 1.0
*/
	get_header();
	/* Start the Loop */
	?>
	<div class="row main-content posts-list">		
		<div class="large-12 medium-12 columns">
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
						<h2 class="post-title"><?php the_title() ?></h2>
						<ul class="post-meta">
							<li><?php the_time( get_option( 'date_format' ) ); ?> </li>
							<li><?php echo __('Post at', THEMENAME);
								echo '&nbsp;';
								the_time();
								echo '&nbsp;';
								echo __('in', THEMENAME);
								echo '&nbsp;';
								the_category();
								echo '&nbsp;';
								echo __('By', THEMENAME);
								echo '&nbsp;';
								the_author_posts_link();
							?>
							</li>
							<li><?php comments_number( 'no comments', 'one comment', '% comments' ); ?></li>
							<li><?php echo get_post_meta( get_the_id(), '_dc_post_views', true  ); ?> Views</li>
						</ul>
						<div class="the-content">
						<?php the_content() ?>
						</div>
						<a class="read-more" href="<?php the_permalink() ?>">
							Read More
						</a>
					</div>
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
	