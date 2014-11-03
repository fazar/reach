<?php
/**
* The main template file. Includes the loop.
*
*
* @package Reach
* @since Reach 1.0
*/
	get_header();
	?>
			<div class="not-found-page">
				<div class="message">
					<h4><?php _e("Can't find what you wanted to read?", THEMENAME) ?></h4>
					<h1>
						<?php _e("We are sorry for this embarrasing moment", THEMENAME) ?>
					</h1>
				</div>
				<div class="back-to-home">
					<i class="fa fa-angle-left"></i>
					<a href="<?php echo home_url() ?>">
						<?php _e('Back to home', THEMENAME) ?>
					</a>
				</div>
			</div>
		</div>
		<?php 
			wp_footer(); //do not remove, used by the theme and many plugins
			do_action( 'rh_after_footer' ); 
		?>
	</body>
</html>