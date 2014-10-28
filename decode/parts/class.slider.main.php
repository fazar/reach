<?php
	class DC_slider_main extends DC_parts_base{

		function __construct(){
			parent::__construct();
			add_action('dc_slider', array($this, 'display_slider' ));
		}

		function display_slider(){
			$options = $this->options;
			$skin = !empty($options['slider_skin']) ? $options['slider_skin'] : 'circle' ;
			DC::resolves(array('dcslider', 'videofit'));
			$slides = $this->get_data();
			if(!$slides) return;
			?>
			<div id="full-slider" class="dc-slider fullscreen <?php echo $skin ?>">
			  <div class="items">
			  	<?php
		  		foreach ($slides as $key => $slide):
		  			$behaviour_extended = array_key_exists('extend_behaviour', $slide);

		  			$active = $key  == 0 ? 'active' : '';
		  			$title_style = $behaviour_extended ? $slide['extend_behaviour']['title_style'] : $slide['caption_style'];
		  			$subtitle_style = $behaviour_extended ? $slide['extend_behaviour']['subtitle_style'] : $slide['caption_style'];
		  			$data_animation = $behaviour_extended ? '' : 'data-animation="' .$slide['caption_animation']. '"';
		  			$title_data_animation = $behaviour_extended ? 'data-animation="' .$slide['extend_behaviour']['title_animation']. '"' : '';
		  			$subtitle_data_animation = $behaviour_extended ? 'data-animation="' .$slide['extend_behaviour']['subtitle_animation'].'"' : '';
		  			?>
		  			<div class="item <?php echo $active ?> <?php echo $slide['color_scheme'] ?>">
		  				<?php if ( !empty($slide['mp4']) || !empty($slide['ogv']) ) : ?>
	  					 <div class="item-bg">
		  					<video class="videofit" preload="auto" autoplay="autoplay" loop="loop">
		  					  <?php if ( !empty($slide['mp4']) ) : ?>
		  					  <source src="<?php echo $slide['mp4'] ?>" type="video/mp4">
	  						  <?php endif; ?>
	  						  <?php if( !empty($slide['ogv'])  ) : ?>
		  					  <source src="<?php echo $slide['ogv'] ?>" type="video/ogg">
  							  <?php endif;?>
		  					</video>
		  				 </div>
		  				<?php else : ?>
		  				  <div class="item-bg"style="background-image:url(<?php echo $slide['image'] ?>)"></div>
		  				<?php endif; ?>
		  				<div class="item-content content-<?php echo $slide['alignment'] ?>">
		  				  <div class="animate <?php echo $slide['behaviour'] ?>" <?php echo $data_animation ?>>
			  				  <h1 <?php echo $title_data_animation ?>><span class="<?php echo $title_style ?>"><?php echo $slide['title'] ?></span></h1>
			  				  <p <?php echo $subtitle_data_animation ?>><span class="<?php echo $subtitle_style ?>"><?php echo $slide['subtitle'] ?></span></p>
		  				  </div>
		  				</div>
		  			</div>
		  		<?php
		  			endforeach;
			  	?>
			  </div>
			  <a class="left-control slider-nav" href="#full-slider">
			    <span class="icon-arrow-left"></span>
			    <?php
			    	if($skin == 'square'){
			    		echo '<div class="slide-counter">';
			    		echo '<span class="slide-index">1</span>';
			    		echo '<div class="diagonal-line"></div>';
			    		echo '<span class="slide-total">'.count($slides).'</span>';
			    		echo '</div>';
			    	}
			     ?>
			  </a>
			  <a class="right-control slider-nav" href="#full-slider">
			  	<?php
			    	if($skin == 'square'){
			    		echo '<div class="slide-counter">';
			    		echo '<span class="slide-index">1</span>';
			    		echo '<div class="diagonal-line"></div>';
			    		echo '<span class="slide-total">'.count($slides).'</span>';
			    		echo '</div>';
			    	}
			     ?>
			    <span class="icon-arrow-right"></span>
			  </a>
			  <?php $this->generate_indicators(count($slides)); ?>
			</div>
			<?php
		}

		function generate_indicators($length){
			echo "<ol class='dc-slider-indicators' >";
				echo '<li class="active"></li>';
			for($x=$length; $x > 1; $x--){
				echo "<li></li>";
			}
			echo "</ol>";
		}

		function get_data(){
			$query = new WP_Query( array( 'post_type' => 'dc_slider') );
			$results = array();
			while ($query->have_posts()) : $query->next_post();
				$content = get_post_meta( $query->post->ID, '_dc_slider_content', true );
				$options = get_post_meta( $query->post->ID, '_dc_slider_options', true );
				$buttons = array();
				if ( !empty($content['button_1']) ){
					$buttons[] = array(
						'text' => $content['button_1'],
						'link' => $content['button_link_1']
					);
				}
				if ( !empty($content['button_2']) ){
					$buttons[] = array(
						'text' => $content['button_2'],
						'link' => $content['button_link_2']
					);
				}

				$slide = array(
					'image' => $content['image'],
					'mp4' => $content['mp4'],
					'ogv' => $content['ogv'],
					'title' => $content['title'],
					'subtitle' => $content['subtitle'],
					'buttons' => $buttons,
					'alignment' => $options['alignment'],
					'color_scheme' => $options['color_scheme'],
					'behaviour' => $options['style_and_animation'],
					'caption_style' => 'with-' .$options['caption_style'],
					'caption_animation' => $options['caption_animation']
				);
				if($options['style_and_animation'] == 'per-element'){
					$title_options = get_post_meta($query->post->ID, '_dc_slider_title', true);
					$subtitle_options = get_post_meta($query->post->ID, '_dc_slider_subtitle', true);
					$buttons_options = get_post_meta($query->post->ID, '_dc_slider_buttons', true);
					$extend_behaviour = array(
						'title_style' =>  'with-' .$title_options['style'],
						'title_animation' => $title_options['animation'],
						'subtitle_style' =>  'with-' .$subtitle_options['style'],
						'subtitle_animation' => $subtitle_options['animation'],
						'buttons_style' =>  'with-' .$buttons_options['style'],
						'buttons_animation' => $buttons_options['animation']
					);
					$slide['extend_behaviour'] = $extend_behaviour;
				}
				$results[] = $slide;

			endwhile;
			wp_reset_postdata();
			return $results;
		}

	}
?>