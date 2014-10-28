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
	<div class="main-content posts-list">				
		<?php			
			$post_count = $wp_query->post_count;
			$last_is_twelve = false;
			if($post_count % 2 == 1) {
				$last_is_twelve = true;
			}

			$col = array(
				0 => 5,
				1 => 7,
				2 => 7,
				3 => 5,				
			);
			$i = 0;
			$counter = 1;
			
			while ( have_posts() ) : the_post(); 				
				$size = 'dc-medium';
				if($i % 2 == 0) {
					$size = 'dc-small';
					echo '<div class="row">';
				}

				if( $counter == $post_count && $counter % 2 == 1) { ?>
					<article class="large-12; ?> columns">
				<?php }else { ?>
					<article class="large-<?php echo $col[$i]; ?> columns">
				<?php } ?>
			
					<div class="post-header">
						<?php 
							$post_format = get_post_format();
							if(!$post_format){
								do_action('dc_display_media', 'image', $size);
							}else{
								do_action('dc_display_media', get_post_format(), $size);
							}
						?>
					</div>
					<div class="post-content">
						<h2 class="post-title"><?php the_title() ?></h2>
						<ul class="post-meta">
							
							<li><?php the_category(); ?></li>
							<!-- <li><?php comments_number( 'no comments', 'one comment', '% comments' ); ?></li> -->
							<li><?php the_time( get_option( 'date_format' ) ); ?> </li>
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
				if($i % 2 == 1) {
					echo '</div>';
				}
				$i++;
				$counter++;
				if($i > 3) $i = 0;				
				
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
	<?php  
		get_footer();
	?>
	