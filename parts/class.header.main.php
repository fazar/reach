<?php
	class RH_header_main extends DC_parts_base{
		function __construct(){
			parent::__construct();
			add_action( 'rh_main_header', array( $this, 'display_search_form' ) );
			add_action( 'rh_main_header', array( $this, 'display_main_header' ) );
		}

		function display_main_header(){			
			if(is_single()) {
				$this->single_header();
			} 
			else if(is_author()){
				$this->author_header();
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

		private function main_header() { ?>
			<header class="main">
				<?php $this->secondary_nav();  ?>
				<div class="row">
					<div class="brand columns large-12">
						<h1> <?php do_action( 'dc_logo' ) ?> </h1>
						<h4> <?php echo get_bloginfo( 'description' ) ?> </h4>
					</div>
				</div>
			</header>
		<?php
		}

		private function single_header() { 		
			global $post;			
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large');				
			$main_class = (!$image) ? '': 'main-with-image';
			?>
			<header class="main single-post-header <?php echo $main_class; ?>" style="background-image:url(<?php echo $image[0] ?>)">
				<?php $this->secondary_nav() ?>
				<div class="row">
					<div class="large-12 columns">
						<h2 class="post-title"><?php the_title() ?></h2>
						<p>Music is for All</p>						
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
	}
?>