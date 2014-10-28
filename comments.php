<?php
/**
 * @package Reach
 */

// Do not delete these lines

	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if ( post_password_required() ) { ?>
		<p class="nocomments">This post is password protected. Enter the password to view comments.</p>
	<?php
		return;
	}

  /*do_action('dc_before_comment_list');*/
  do_action('dc_comment_list');
  /*do_action('dc_after_comment_list');*/
  do_action('dc_comment_form');
?>

