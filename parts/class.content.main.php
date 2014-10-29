<?php
	class RH_content_main extends DC_parts_base{
		function __construct(){
			parent::__construct();
			add_action('rh_media_thumbnail', array( $this, 'media_thumbnail' ), 10, 1);
		}

		function media_thumbnail( $type ){
			if ( has_post_thumbnail() ) {
				the_post_thumbnail();
				return;
			} 
			switch ($type) {
				case 'audio':
					?>
					<div class="thumbnail-no-image">
						<span class="icon-music"></span>
					</div>
					<?php
					break;

				case 'video':
					?>
					<div class="thumbnail-no-image">
						<span class="icon-video"></span>
					</div>
					<?php
					break;

				case 'gallery':
					?>
					<div class="thumbnail-no-image">
						<span class="icon-photo"></span>
					</div>
					<?php
					break;

				case 'quote':
					?>
					<div class="thumbnail-no-image">
						<span class="icon-bulb"></span>
					</div>
					<?php
					break;

				case 'link':
					?>
					<div class="thumbnail-no-image">
						<span class="icon-clip"></span>
					</div>
					<?php
					break;
				default:
					?>
					<div class="thumbnail-no-image">
						<span class="icon-pen"></span>
					</div>
					<?php
					break;
			}
		}
	}
?>