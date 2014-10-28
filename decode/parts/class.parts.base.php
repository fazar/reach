<?php
	class DC_parts_base{
		protected $options;
		function __construct(){
			global $dc;
			$this->options = $dc;
		}
	}
?>