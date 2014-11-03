<?php
/*
Template Name: Page Centered Content
*/
get_header();
?>
	<div class='row centered-content'>
		<div class="large-8 large-offset-2">
			<article>
			<?php
			while ( have_posts() ) : the_post(); 
				the_content();
			endwhile;
			?>
			</article>
		</div>
	</div>
<?php
get_footer();