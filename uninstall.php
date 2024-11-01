<?php
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit();
}
 
delete_option( 'dd_lightbox_ads_link' );
delete_option( 'dd_lightbox_ads_delay' );
delete_option( 'dd_lightbox_ads_delay' );
delete_option( 'dd_lightbox_ads_width' );
delete_option( 'dd_lightbox_ads_lbbg' );
delete_option( 'dd_lightbox_setting_allowfooter' );
delete_option( 'dd_lightbox_setting_footertext' );
delete_option( 'dd_lightbox_ads_visiblity' );
delete_option( 'dd_lightbox_ads_custom_url' );
delete_option( 'dd_lightbox_ads_display_type' );

delete_site_option( 'dd_lightbox_ads_link' );
delete_site_option( 'dd_lightbox_ads_delay' );
delete_site_option( 'dd_lightbox_ads_delay' );
delete_site_option( 'dd_lightbox_ads_width' );
delete_site_option( 'dd_lightbox_ads_lbbg' );
delete_site_option( 'dd_lightbox_setting_allowfooter' );
delete_site_option( 'dd_lightbox_setting_footertext' );
delete_site_option( 'dd_lightbox_ads_visiblity' );
delete_site_option( 'dd_lightbox_ads_custom_url' );
delete_site_option( 'dd_lightbox_ads_display_type' );