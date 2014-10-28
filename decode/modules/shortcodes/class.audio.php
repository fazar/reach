<?php
	class DC_shortcodes_audio{
		function __construct(){
			add_shortcode('dc_audio', array($this, 'player'));
		}
		
		function player($atts, $content){
			DC::resolves( array( 'mediaplayer' ) );
			extract(shortcode_atts(array("mp3" => "", "ogg" => ""),$atts));
			ob_start();
			?>
				<audio class="dc-audio" controls="controls" style="width: 100%;">
					<source src="<?php echo  $mp3 ?>" type="audio/mp3">
					<source src="<?php echo  $ogg ?>" type="audio/ogg">
				</audio>
			<?php
			$result = ob_get_contents();
			ob_end_clean();
			return $result;
		}
	}
?>