<?php 

if( !class_exists( "dd_lightbox_ads_admin" ) ) {
	
	class dd_lightbox_ads_admin {
		public $wpdb;

		public function __construct () {			
			global $wpdb;			
			$this->wpdb = $wpdb;
		}

		public function add_menu () {
			add_options_page( 'Responsive Lightbox', 'Responsive Lightbox', 'manage_options', 'dd_lightbox_ads', array( new dd_lightbox_ads(), "dd_lighbox_controller" ) );
		}
	}

}