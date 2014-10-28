<?php
/**
 * The Footer for Reach
 *
 * Displays all of the <footer> section and everything up till end of html tag
 *
 * @package Reach
 * @since Reach 1.0
 */
?>
			<?php
				do_action( 'rh_before_footer' );
			?>
			<footer id="footer" class="footer">
				<?php do_action( 'rh_main_footer' ); ?>
			</footer>
		</div>
		<?php 
			wp_footer(); //do not remove, used by the theme and many plugins
			do_action( 'rh_after_footer' ); 
		?>
	</body>
</html>