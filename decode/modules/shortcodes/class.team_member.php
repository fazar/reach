<?php
	class DC_shortcodes_team_member{
		function __construct(){
			add_shortcode( 'dc_team_member', array($this, 'display') );
		}

		function display($atts, $content){
			extract(shortcode_atts(array("position" => "", "name" => "", "img_url" => ""),$atts));
			ob_start();
			?>
			<div class="team-member">
				<div class="member-photo">
				 	<img src="<?php echo $img_url ?>" alt="<?php echo $name ?>" />
				 </div>
				 <div class="desc">
					<h2><?php echo $name ?></h2>
					<h4><?php echo $position ?></h4>
				</div>
			</div>
			<?php
			$result = ob_get_contents();
			ob_end_clean();
			return $result;
		}
	}
?>