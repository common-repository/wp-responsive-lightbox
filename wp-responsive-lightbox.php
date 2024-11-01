<?php
/*
Plugin Name: WP Responsive Lightbox
Plugin URI: http://www.daddydesign.com/wordpress/responsive-lightbox-wordpress-plugin
Description: Display a Responsive Lightbox withs ads on specific pages
Version: 1.1
Author: Daddy Design
Author URI: http://www.daddydesign.com/
*/

register_activation_hook( __FILE__, 'dd_responsive_lightbox_install' );

function dd_responsive_lightbox_install(){
	$dd_lightbox_ads_delay = get_option( 'dd_lightbox_ads_delay' );
	$dd_lightbox_ads_width = get_option( 'dd_lightbox_ads_width' );
	$dd_lightbox_ads_display_type = get_option( 'dd_lightbox_ads_display_type' );
	$dd_lightbox_ads_visiblity = get_option( 'dd_lightbox_ads_visiblity' );

	if( !$dd_lightbox_ads_delay ){
		add_option( 'dd_lightbox_ads_delay', '2' );
	}
	if( !$dd_lightbox_ads_width ){
		add_option( 'dd_lightbox_ads_width', '800px' );
	}
	if( !$dd_lightbox_ads_display_type ){
		add_option( 'dd_lightbox_ads_display_type', 'show_everytime' );
	}
	if( !$dd_lightbox_ads_visiblity ){
		add_option( 'dd_lightbox_ads_visiblity', 'home_only' );
	}
}


if( !class_exists( "dd_lightbox_ads" ) ) {

	class dd_lightbox_ads {	

		public $wpdb;		

		public function __construct () {
			$this->include_classes();
			$this->admin = new dd_lightbox_ads_admin();
		}


		private function include_classes () {
			require_once( $this->directory() . "admin.php" );
		}		


		public function init () {
			$this->dependencies();
			add_action('admin_init', array(&$this, 'register_lightbox_ads_settings'));
		}


		public function register_lightbox_ads_settings(){

			register_setting('dd_lightbox_ads', 'dd_lightbox_ads_imgurl');
			register_setting('dd_lightbox_ads', 'dd_lightbox_ads_link');
			register_setting('dd_lightbox_ads', 'dd_lightbox_ads_delay');
			register_setting('dd_lightbox_ads', 'dd_lightbox_ads_width');
			register_setting('dd_lightbox_ads', 'dd_lightbox_ads_lbbg');
			
			register_setting('dd_lightbox_ads', 'dd_lightbox_setting_allowfooter');
			register_setting('dd_lightbox_ads', 'dd_lightbox_setting_footertext');
			register_setting('dd_lightbox_ads', 'dd_lightbox_ads_visiblity');
			register_setting('dd_lightbox_ads', 'dd_lightbox_ads_custom_url');
			register_setting('dd_lightbox_ads', 'dd_lightbox_ads_display_type');
			
			
			//choose which page to display
			// Time Delay before ads show
			// Footer Display


			add_settings_section('section', 'Main Settings', array(&$this, 'lightbox_ads_section_desc'), 'dd_lightbox_ads' );
			add_settings_field( 'dd_lightbox_ads_imgurl', 'Image URL', array(&$this, 'settings_field_input_upload'), 'dd_lightbox_ads', 'section', array('field' => 'dd_lightbox_ads_imgurl') );
			add_settings_field( 'dd_lightbox_ads_link', 'AD Link URL', array(&$this, 'settings_field_input_text'), 'dd_lightbox_ads', 'section', array('field' => 'dd_lightbox_ads_link') );
			add_settings_field( 'dd_lightbox_ads_lbbg', 'Lightbox Filter Background Color', array(&$this, 'settings_field_input_text'), 'dd_lightbox_ads', 'section', array('field' => 'dd_lightbox_ads_lbbg','desc' => 'Please enter Hex color code ( ex. #000000 )') );
            add_settings_field( 'dd_lightbox_ads_delay', 'Delay', array(&$this, 'settings_field_input_text'), 'dd_lightbox_ads', 'section', array('field' => 'dd_lightbox_ads_delay', 'desc' => 'Enter the amount of seconds to delay the lightbox from opening.') );
            add_settings_field( 'dd_lightbox_ads_width', 'Lightbox Width', array(&$this, 'settings_field_input_text'), 'dd_lightbox_ads', 'section', array('field' => 'dd_lightbox_ads_width', 'desc' => 'Enter the width in either pixels or percent ( ex. 100px or 100% )'  ) );			
			add_settings_field( 'dd_lightbox_setting_allowfooter', 'Hide Credits', array(&$this, 'settings_field_input_checkbox'), 'dd_lightbox_ads', 'section', array('field' => 'dd_lightbox_setting_allowfooter') );
			
		}


		public function lightbox_ads_section_desc(){
			echo 'These settings are for the lightbox after the page has completely loaded.';
		}


		public function settings_field_input_text($args){			
            // Get the field name from the $args array
            $field = $args['field'];
			$desc = $args['desc'];
            // Get the value of this setting
            $value = get_option($field);
            // echo a proper input type="text"
            echo sprintf('<input type="text" name="%s" id="%s" value="%s" class="regular-text" />', $field, $field, $value);
			if( $desc ){
				echo '<p class="description">'.$desc.'</p>';
			}
			
        }

		public function settings_field_input_textarea($args){			
            // Get the field name from the $args array
            $field = $args['field'];
            // Get the value of this setting
            $value = get_option($field);
            // echo a proper input type="text"
            echo sprintf('<textarea name="%s" id="%s">%s</textarea>', $field, $field, $value);
        }
		
		public function settings_field_input_checkbox($args){			
            // Get the field name from the $args array
            $field = $args['field'];
            // Get the value of this setting
            $value = get_option($field);			
			$checkbox_check = '';
			if( $value == 1 ){ $checkbox_check = 'checked="checked"'; }
            // echo a proper input type="text"
            echo '<input type="checkbox" name="'.$field.'" id="'.$field.'" value="1" '.$checkbox_check.' />';
        }

        public function settings_field_input_upload($args){        	
            $field = $args['field'];
            $value = get_option($field);
            echo '<input type="text" name="'.$field.'" id="meta-image" value="'.$value.'" class="regular-text" />';
            if($value){
            	echo '<br/><img id="dd-meta-img-con" src="'.$value.'" height="150" style="max-width:100%;" />';
            }
            echo '<br/><input type="button" id="meta-image-button" class="button" value="Choose or Upload an Image" />';
        }


		public function dependencies () {
			wp_enqueue_style ( "dd-light-box", plugins_url( "css/dd-light-box.css", __FILE__ ) );			

			if (isset($_GET['page']) && $_GET['page'] == 'dd_lightbox_ads') {
				wp_enqueue_media();
				// Registers and enqueues the required javascript.
				wp_register_script( 'dd-meta-box-image', plugins_url( "js/custom-js.js", __FILE__ ), array( 'jquery' ) );
				wp_localize_script( 'dd-meta-box-image', 'meta_image',
					array(
	                'title' => __( 'Choose or Upload an Image', 'prfx-textdomain' ),
	                'button' => __( 'Use this image', 'prfx-textdomain' ),
	            	)
				);
	        	wp_enqueue_script( 'dd-meta-box-image' );
        	}
		}		


		public function directory () {
			return plugin_dir_path( __FILE__ );
		}


		public function generate_lightbox(){
			include( $this->directory() . "lightbox.php" );
		}

		public function admin_menu(){
			$this->admin->add_menu();
		}


		public function dd_lighbox_controller(){
			include( $this->directory() . "views/admin/index.php" );
		}
	}


	add_action( "init", array( new dd_lightbox_ads(), "init"  ) );
	add_action( 'admin_menu', array( new dd_lightbox_ads(), "admin_menu" ) );
	add_action( "wp_footer", array( new dd_lightbox_ads(), "generate_lightbox" ) );
}