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
	<div class="main-content search-page archive">
		<div class="row">
			<div class="large-12 columns">		
				<?php
					while ( have_posts() ) : the_post();
						?>
						<article>
							<div class="post-header">
								<?php 
									$post_format = get_post_format();
									if(!$post_format){
										do_action('rh_media_thumbnail', 'image');
									}else{
										do_action('rh_media_thumbnail', get_post_format());
									}
								?>
							</div>
							<div class="post-content">						
								<ul class="post-meta">				
									<li><?php the_category(); ?></li>							
									<li>• <?php the_time( get_option( 'date_format' ) ); ?> </li>
									<li>• <?php echo get_post_meta( get_the_id(), '_dc_post_views', true  ); ?> Views</li>
								</ul>
								<h2 class="post-title">
									<a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>">
										<?php the_title(); ?></a>
								</h2>
								<div class="the-content">
								<?php the_excerpt() ?>
								</div>
								<div class="post-author">
								<?php
									_e('By ', THEMENAME);
									the_author_posts_link();
								?>
								</div>
							</div>
						</article>
						<?php
					endwhile;
				?>	
			</div>
		</div>
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
	<?php  
		get_footer();
	?>
	