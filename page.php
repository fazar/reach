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
	<div class="main-content single-page">				
		<?php
			while ( have_posts() ) : the_post(); 
				the_content();
			endwhile;
		?>
	</div>
	<?php  
		get_footer();
	?>
	