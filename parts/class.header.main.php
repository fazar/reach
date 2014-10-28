<?php
	class RH_header_main extends DC_parts_base{
		function __construct(){
			parent::__construct();
			add_action( 'rh_main_header', array( $this, 'display_main_header' ) );
		}

		function display_main_header(){
			?>
			<header class="main">
				<div class="secondary-nav">
					<ul>
						<li class="hidden-sidebar-toggle">
		                  <a href="#" class="off-sidebar-control left-off-sidebar">
		                    <?php echo get_bloginfo( 'name' )[0] ?>
		                  </a>
		                </li>
		                <li class="search-button">
		                  <p> search form here </p>
		                </li>
					</ul>
				</div>
				<div class="row">
				<div class="brand columns large-12">
					<h1> <?php do_action( 'dc_logo' ) ?> </h1>
					<h4> <?php echo get_bloginfo( 'description' ) ?> </h4>
				</div>
				</div>
			</header>
			<?php
		}
	}
?>