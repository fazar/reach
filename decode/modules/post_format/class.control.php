<?php
	class DC_post_format_control{
		function __construct(){
			add_theme_support( 'post-formats', array( 'gallery', 'link',  'audio', 'video', 'quote' ) );
			add_action( 'admin_footer', array($this, 'scripts') );
			add_action( 'admin_head', array($this, 'style'));
		}

		function scripts(){
			global $typenow;
			if ( $typenow == 'post' ){
				?>
					<script type="text/javascript">
						(function($){
							$(document).ready(function(){
								$('input:radio[name="post_format"]').change(function(){
									if($(this).val() == 0){
										if($('.postbox.active').length)
											$('.postbox.active').removeClass('active');
									}else{
										if($('.postbox.active').length)
											$('.postbox.active').removeClass('active');

										var type = $(this).val();
										$('#dc_post_' + type).addClass('active');
									}
								});
								$('input:radio[name="post_format"]:checked').change();
							});
						}(jQuery));
					</script>
				<?php
			}
		}

		function style(){
			global $typenow;
			if($typenow == 'post'){
				echo '<style>
					#dc_post_audio,
					#dc_post_quote,
					#dc_post_gallery,
					#dc_post_link,
					#dc_post_video{
						display:none;
					}
					.postbox.active{
						display:block !important;
					}
				</style>';
			}
		}
	}
?>