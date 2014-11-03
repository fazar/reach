<?php
	class RH_header_main extends DC_parts_base{
		function __construct(){
			parent::__construct();
			add_action( 'rh_main_header', array( $this, 'display_search_form' ) );
			add_action( 'rh_main_header', array( $this, 'display_main_header' ) );
		}

		function display_main_header(){
			if (is_404()){
				$this->not_found_header();
			}else if(is_single()) {
				$this->single_header();
			} 
			else if(is_author()){
				$this->author_header();
			}
			else if(is_search()){
				$this->search_header();
			}
			else if(is_archive()){
				$this->archive_header();
			}
			else {
				$this->main_header();
			}			
		}

		function secondary_nav(){
			?>
			<div class="secondary-nav">
				<ul>
					<li class="hidden-sidebar-toggle">
	                  <a href="#" class="off-sidebar-control left-off-sidebar">
	                    <?php echo get_bloginfo( 'name' )[0] ?>
	                  </a>
	                </li>
	                <li class="search-button">
	                 	<i class="fa fa-search"></i>
	                </li>
	                <li>
	                	<?php do_action('dc_social_share'); ?>
	                </li>
				</ul>
			</div>
			<?php
		}

		private function main_header() { 
			if (is_page()){
				global $post;
				$page_header = get_post_meta($post->ID, '_dc_page_header', true);
				if( !empty($page_header['title']) ){
					$title  = $page_header['title'];
				}
				if(!empty($page_header['subtitle'])){
					$subtitle = $page_header['subtitle'];
				}else{
					$subtitle = '';
				}
			}
			?>
			<header class="main">
				<?php $this->secondary_nav();  ?>
				<div class="row">
					<div class="brand columns large-12">
						<h1> 
							<?php 
							if(isset($title))
								echo $title;
							else
							  do_action( 'dc_logo' ) 
							?> 
						</h1>
						<h4> <?php echo isset($subtitle) ? $subtitle : get_bloginfo( 'description' ) ?> </h4>
					</div>
				</div>
			</header>
		<?php
		}

		private function not_found_header(){
			?>
			<header class="main">
				<?php $this->secondary_nav();  ?>
			</header>
			<?php
		}

		private function single_header() { 		
			global $post;			
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large');				
			$main_class = (!$image) ? '': 'main-with-image';
			$post_header = get_post_meta($post->ID, '_dc_post_header', true);
			//$post_header = .!empty($post_header['header_position']) ? $post_header['header_position'] : '';
			$background_position = !empty($post_header['header_position']) ? "background-position:".$post_header['header_position'] : '';
			$header_type = '';
			if(!empty($post_header['header_type'])) {
				$header_type = (!$image) ? '': $post_header['header_type'];	
			}
			
			?>
			<header class="main single-post-header <?php echo $main_class; ?> <?php echo $header_type; ?>" 
				style="background-image:url(<?php echo $image[0] ?>);<?php echo $background_position; ?>">
				<?php $this->secondary_nav() ?>
				<div class="row">
					<div class="large-12 columns">
						<h2 class="post-title"><?php the_title() ?></h2>
						<?php							
							if ( !empty($post_header['subtitle']) ){
								$subtitle = $post_header['subtitle'];
								echo "<p class='subtitle'>$subtitle</p>";
							}
						?>						
					</div>
				</div>
			</header>
		<?php
		}

		public function display_search_form(){
			?>
			<div class="main-search-form">
				<form role="search" method="get" id="searchform" action="<?php echo home_url( "/" ) ?>">
					<input type="text" value="<?php echo get_search_query() ?>" placeholder="Type Your Word Here" class="serach" name="s" id="s"  autocomplete="off" />
				</form>
			</div>
			<?php
		}

		private function author_header(){
			$curauth = (get_query_var('author_name')) ? get_user_by('slug', get_query_var('author_name')) : get_userdata(get_query_var('author'));
			$profile_image = get_user_meta($curauth->ID, "profile_image", true);
			?>
			<header class="main">
				<?php $this->secondary_nav();  ?>
				<div class="row">
					<div class="author columns large-8 large-offset-2">
						<?php
						if ( !empty($profile_image) ){
							echo "<img src='$profile_image' alt='$curauth->display_name' />";
						}
						?>
						<h1> <?php echo $curauth->display_name ?> </h1>
						<p> <?php echo $curauth->description ?> </p>
					</div>
				</div>
			</header>
			<?php
		}

		private function search_header(){
			?>
			<header class="main">
				<?php $this->secondary_nav();  ?>
				<div class="row">
					<div class="brand columns large-12">
						<h1>&#8226; <?php _e('Result For', THEMENAME) ?> &#8226;</h1>
						<h4> <?php  the_search_query() ?> </h4>
					</div>
				</div>
			</header>
			<?php
		}

		private function archive_header(){
			?>
				<header class="main">
				<?php $this->secondary_nav();  ?>
				<div class="row">
					<div class="brand columns large-12">
						<h1>&#8226; <?php echo wp_title("",false); ?> &#8226;</h1>
					</div>
				</div>
			</header>
			<?php
		}
	}
?>