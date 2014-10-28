<?php
	class DC_post_media{
		private $type;
		private $size;
		function __construct( $type, $size ){
			$this->type = $type;
			$this->size = $size;
		}

		function display(){
			switch ($this->type) {
				case 'audio':
					$this->display_audio();
					break;

				case 'video':
					$this->display_video();
					break;

				case 'image':
					$this->display_image();
					break;

				case 'gallery':
					$this->display_gallery();
					break;

				case 'quote':
					$this->display_quote();
					break;

				case 'link':
					$this->display_link();
					break;
			}
		}

		function display_audio(){
			$audio = get_post_meta(get_the_id(), '_dc_post_audio', true);
			$audio_mp3 = $audio['mp3'];
		    $audio_ogg = $audio['oga'];
			$audio_embed = $audio['embedded'];
			if(!empty($audio_ogg) || !empty($audio_mp3)) {
	        	
				$audio_output = '[dc_audio ';
				
				if(!empty($audio_mp3)) { $audio_output .= 'mp3="'. $audio_mp3 .'" '; }
				if(!empty($audio_ogg)) { $audio_output .= 'ogg="'. $audio_ogg .'"'; }
				
				$audio_output .= ']';
				
        		echo  '<div class="audio-media">'. do_shortcode($audio_output) . '</div>';	
        	}else if ( !empty( $audio_embed ) ){
        		echo '<div class="audio-media">' . do_shortcode( $audio_embed ) . '</div>';
        	}
		}

		function display_video(){
			$video = get_post_meta(get_the_id(), '_dc_post_video', true);
			$video_embed = $video['embedded'];
		  	$video_m4v = $video['m4v'];
		  	$video_ogv = $video['ogv'];
		  	$video_poster = $video['poster'];
		  
		  	if( !empty($video_embed) || !empty($video_m4v) ){
         		$wp_version = floatval(get_bloginfo('version'));
				//video embed
				if( !empty( $video_embed ) ) {
		             echo '<div class="video-media flex-video">' . do_shortcode($video_embed) . '</div>';
		        } 
		        else {
		        	if(!empty($video_m4v) || !empty($video_ogv)) {
		        		
						$video_output = '[dc_video ';
						
						if(!empty($video_m4v)) { $video_output .= 'mp4="'. $video_m4v .'" '; }
						if(!empty($video_ogv)) { $video_output .= 'ogv="'. $video_ogv .'"'; }
						
						$video_output .= ' poster="'.$video_poster.'"]';
						
		        		echo '<div class="video-media">' . do_shortcode($video_output) . '</div>';	
		        	}
		        }	
			}
		}

		function display_image(){
			if ( has_post_thumbnail() ) {
				var_dump($this->size);
				the_post_thumbnail($this->size);
			} 
		}

		function display_gallery(){
			$gallery = get_post_meta( get_the_id(), '_dc_post_gallery', true );
			$enable_gallery_slider = $gallery['as_slider'];
			if( !is_single() || (!empty($enable_gallery_slider) && $enable_gallery_slider == '1') ) { 
				DC::resolves(array('imagesloaded','flexslider'));
				$gallery_ids = $this->grab_ids_from_gallery();
				$attr = array(
				    'class' => "attachment-full wp-post-image",
				);
				?>	
				<div class="dc-gallery flexslider"> 
					<ul class="slides">	
						 	<?php 
							foreach( $gallery_ids as $image_id ) {
							     echo  '<li>'.wp_get_attachment_image($image_id, '', false, $attr).'</li>' ;
							} ?>
					</ul>
			   	 </div>
		   	<?php } 
		}

		function grab_ids_from_gallery() {
			global $post;
			if($post != null) {
				$attachment_ids = array();  
				$pattern = get_shortcode_regex();
				$ids = array();
				if (preg_match_all( '/'. $pattern .'/s', $post->post_content, $matches ) ) { 
					$count = 0;
					foreach ($matches[2] as $tag) {
						if($tag == 'gallery'){
							$atts = shortcode_parse_atts( $matches[3][$count] );
							$attachment_ids = explode( ',', $atts['ids'] );
							$ids = array_merge($ids, $attachment_ids);
							break;
						}
						$count++;
					}
				}
				return $ids;
		  	} else {
			  	$ids = array();
			  	return $ids;
		  	}
		}

		function display_quote(){
			global $post;
			$quote = get_post_meta($post->ID, '_dc_post_quote', true);
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large');
			?>
			 <a class="quote whole-link" href="<?php the_permalink() ?>"  style="background-image:url(<?php echo $image[0] ?>)">
			  	 <div class="semi-dark-cover">
				  	 <div class="quote-wrapper">
				  	 	<p class="quote-content">
				  	 		&ldquo;
				  	 		<?php echo $quote['content'] ?>
			  	 			&rdquo;
				  	 	</p>
				  	 	<p class="quote-author">
				  	 		<?php echo $quote['author'] ?>
				  	 	</p>
				  	 </div>
				  </div>
			  </a>
			<?php
		}

		function display_link(){
			global $post;
			$link = get_post_meta($post->ID, '_dc_post_link', true);
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large');
			?>
			 <a class="link whole-link" href="<?php the_permalink() ?>"  style="background-image:url(<?php echo $image[0] ?>)">
			  	 <div class="semi-dark-cover">
				  	 <div class="link-wrapper">
				  	 	<p class="link-url">
				  	 		<?php echo $link['url'] ?>
				  	 	</p>
				  	 	<p class="link-title">
				  	 		<?php echo $link['title'] ?>
				  	 	</p>
				  	 </div>
				  </div>
			  </a>
			<?php
		}
	}
?>