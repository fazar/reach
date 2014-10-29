<?php
	class RH_content_main extends DC_parts_base{
		function __construct(){
			parent::__construct();
			add_action('rh_media_thumbnail', array( $this, 'media_thumbnail' ), 10, 1);
			add_action('rh_blog_layout', array( $this, 'blog_layout' ), 10, 1);
		}

		function blog_layout() {
			$options = $this->options;
			$blog_layout = !empty($options['blog-layout']) ? $options['blog-layout'] : '1';
			if($blog_layout == '1') {
				echo
				$this->one_content();
			} else {
				$this->two_content();
			}
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

		private function two_content() {
			global $wp_query;
			$post_count = $wp_query->post_count;
			$last_is_twelve = false;
			if($post_count % 2 == 1) {
				$last_is_twelve = true;
			}

			$col = array(
				0 => 4,
				1 => 8,
				2 => 8,
				3 => 4,				
			);
			$i = 0;
			$counter = 1;
			
			while ( have_posts() ) : the_post(); 				
				$size = $col[$i] == 4 ? 'dc-small' : 'dc-medium';
				if($i % 2 == 0) {					
					echo '<div class="row">';
				}

				if( $counter == $post_count && $counter % 2 == 1) { 
					$size = 'large';
					?>
					<article class="large-12 columns">
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
		}

		private function one_content() {
			global $wp_query;
			$i = 0;
			$post_count = $wp_query->post_count;		
			
			
			while ( have_posts() ) : the_post();?>
				<div class="row">
					<?php
					if($i % 2 == 0) {
						$this->show_post_media();
						$this->show_article();
					}else {
						$this->show_article();
						$this->show_post_media();						
					}
					?>
				</div> 
			<?php		
			$i++;		
			endwhile;
		}

		private function show_post_media() {
			?>
			<div class="large-6 medium-6 columns content-left">
				<?php
					$post_format = get_post_format();
					if(!$post_format){
						do_action('dc_display_media', 'image', 'large');
					}else{
						do_action('dc_display_media', get_post_format(), 'large');
					}
				?>
			</div>
			<?php
		}

		private function show_article() { ?>
			<article class="large-6 medium-6 columns content-right">
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
				</div>
			</article>
		<?php
		}
	}
?>