<?php
$dd_lightbox_ads_visiblity = get_option( 'dd_lightbox_ads_visiblity' );
$dd_lightbox_ads_custom_url = get_option( 'dd_lightbox_ads_custom_url' );


if( $dd_lightbox_ads_visiblity ){
	
	switch( $dd_lightbox_ads_visiblity ):
		case 'home_only':
			if( !is_front_page() ){ return; }
		break;
		
		case 'all_posts':
			
		break;
		
		case 'custom_posts':
			global $post;
			if (strpos($dd_lightbox_ads_custom_url, ',') !== false) {
				$explode_post_page_ids = explode(",", trim($dd_lightbox_ads_custom_url) );
				if( !in_array( get_the_ID(), $explode_post_page_ids ) ){ return; }
				
				if( is_single() ){  } elseif( is_page() ){  } else{ return; }
				
			} else{
				if( get_the_ID() != $dd_lightbox_ads_custom_url ){ return; }
				
				if( is_single() ){  } elseif( is_page() ){  } else{  return; }
				//if( !is_single( $post->ID ) || !is_page( $post->ID ) ){ $returnthis = 1; return; }
			}			
		break;
		default:
		break;
	endswitch;
}


$dd_lightbox_imgurl = get_option( 'dd_lightbox_ads_imgurl' );
$dd_lightbox_ads_link = get_option( 'dd_lightbox_ads_link' );
$dd_lightbox_ads_lbbg = get_option('dd_lightbox_ads_lbbg');
$dd_lightbox_ads_delay = get_option( 'dd_lightbox_ads_delay' );
$dd_lightbox_ads_width = get_option( 'dd_lightbox_ads_width' );

$dd_lightbox_ads_allowfooter = get_option( 'dd_lightbox_setting_allowfooter' );
$dd_lightbox_ads_footertext = get_option( 'dd_lightbox_setting_footertext' );
$dd_lightbox_ads_display_type = get_option( 'dd_lightbox_ads_display_type' );

$responsive_dd_lightbox_width = 0;
$background_color = '';

function hex2rgb($hex) {
   $hex = str_replace("#", "", $hex);
   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
   $rgb = array($r, $g, $b);
   return $rgb;
}

if($dd_lightbox_ads_lbbg){
	$rgbacolor = hex2rgb($dd_lightbox_ads_lbbg);
	$background_color = 'background:rgba(' . $rgbacolor[0] .',' . $rgbacolor[1] .',' . $rgbacolor[2] .',0.5);';
}

if( $dd_lightbox_ads_width ){
	if (strpos($dd_lightbox_ads_width, '%') !== false) {
		$get_numiric = substr($dd_lightbox_ads_width, 0, -2 );		
    	$dd_lightbox_ads_width = 'max-width:' . $dd_lightbox_ads_width . ';';
		//margin-left:-' . ($get_numiric / 2) . '%;';

	} elseif (strpos($dd_lightbox_ads_width, 'px') !== false) {
		$get_numiric = substr($dd_lightbox_ads_width, 0, -2 );
		$responsive_dd_lightbox_width = $dd_lightbox_ads_width;
		$dd_lightbox_ads_width = 'max-width:' . $dd_lightbox_ads_width . ';';
		//margin-left:-' . ($get_numiric / 2) . 'px;';
	} else{
		$responsive_dd_lightbox_width = $dd_lightbox_ads_width.'px';
		$dd_lightbox_ads_width = 'max-width:' . $dd_lightbox_ads_width . 'px;';
		// margin-left:-' . ($dd_lightbox_ads_width/2) . 'px;';
	}
}

if( $responsive_dd_lightbox_width == 'autopx' ) {
$dd_lightbox_ads_width = 'width:auto;';
$responsive_dd_lightbox_width = '600px';
}
echo '<!--'. $dd_lightbox_ads_width . '-->';
?>

<div id="dd-lightbox-overflow" style="<?php echo $background_color;?>opacity:0;z-index:-1;display:none;"></div>
<div id="dd-lightbox-popup" style="<?php if($dd_lightbox_ads_width){ echo $dd_lightbox_ads_width; } ?>width:auto;opacity:0;z-index:-1;display:none;">
<div class="dd-lightbox-wrap">
<?php if( $dd_lightbox_imgurl ){ ?>
<?php if( $dd_lightbox_ads_link ) { ?><a href="<?php echo $dd_lightbox_ads_link; ?>" target=""><?php } ?>
<img id="dd-lightbox-img" class="dd-lightbox-img" src="<?php echo $dd_lightbox_imgurl; ?>" />
<?php if( $dd_lightbox_ads_link ) { ?></a><?php } ?>
<?php } ?>
<a href="" id="dd-lightbox-close"></a>
</div>
<?php if( $dd_lightbox_ads_allowfooter != 1){ ?>
<div class="dd-credit">Brought to you by <a href="http://www.daddydesign.com" target="_blank">Daddy Design</a></div>
<?php } ?>
</div>


<script type="text/javascript">
jQuery(document).ready(function($) {
	
	<?php if( $dd_lightbox_ads_display_type && $dd_lightbox_ads_display_type == 'show_everytime' ) { ?>
	if (typeof window.localStorage != "undefined") {
		localStorage.removeItem('ddpopState');
	}<?php } ?>
	
	<?php if( $dd_lightbox_ads_display_type && $dd_lightbox_ads_display_type == 'show_single' ) { ?>
	if(localStorage.getItem('ddpopState') != 'showed'){
		localStorage.setItem('ddpopState','showed');
	<?php } ?>
	
	
	<?php if( $dd_lightbox_ads_delay ){ ?>
	$('#dd-lightbox-overflow').delay(1000).css('z-index','9999998');
	$('#dd-lightbox-popup').delay(1000).css('z-index','9999999');
	<?php } else { ?>
	$('#dd-lightbox-overflow').delay(1000).css('z-index','9999998');
	$('#dd-lightbox-popup').delay(1000).css('z-index','9999999');
	<?php } ?>

	if( $('#dd-lightbox-img').height() > $(window).height() ){
		$('#dd-lightbox-img').height( $(window).height() - 150 ).css('width','auto');
		//$('#dd-lightbox-popup').css({'margin-left': '-' + ( $('#dd-lightbox-img').width()/2 ) + 'px' });
		//console.log('bigger image');
	 }

	//$('#dd-lightbox-popup').css({'margin-top': '-' + ( $('#dd-lightbox-img').height()/2 ) + 'px' });
	<?php if( $dd_lightbox_ads_delay ){ ?>
	setTimeout( function(){
	$('#dd-lightbox-overflow').fadeTo('500', 1, function() {
		$('#dd-lightbox-popup').fadeTo('500', 1, function() {});
	});
	}, <?php echo $dd_lightbox_ads_delay* 1000; ?>);
	<?php } else { ?>
	setTimeout( function(){
	$('#dd-lightbox-overflow').fadeTo('500', 1, function() {
		$('#dd-lightbox-popup').fadeTo('500', 1, function() {});
	});
	}, 2000);
	<?php } ?>

	$(document).on('click', function (e) {
	    if ($(e.target).closest("#dd-lightbox-popup").length === 0) {
	        $("#dd-lightbox-popup, #dd-lightbox-overflow").fadeOut('400');
	    }
	});

	$('#dd-lightbox-close').on('click', function (e) {
		e.preventDefault();
		$("#dd-lightbox-popup, #dd-lightbox-overflow").fadeOut('400');
	});

	var dd_lb_width = '<?php echo $dd_lightbox_ads_width; ?>';
	if( dd_lb_width.toLowerCase().indexOf("px") >= 0 ){
		
		//console.log('has px');
		console.log( dd_lb_width.substring(0, dd_lb_width.length-3).substr(6) );
		console.log( $('#dd-lightbox-img').width() );
		
		dd_user_width = dd_lb_width.substring(0, dd_lb_width.length-3).substr(6);
		
		if( dd_user_width > $('#dd-lightbox-img').width() ){			
			//console.log('test');
			$('#dd-lightbox-popup').css('width','auto');
		}
	}
	
	
	$(window).resize(function(event) {
		if( $('#dd-lightbox-img').height() > $(window).height() ){
			$('#dd-lightbox-img').height( $(window).height() - 150 ).css('width','auto');
			//console.log('image bigger height');
			//$('#dd-lightbox-popup').css({'margin-left': '-' + ( $('#dd-lightbox-img').width()/2 ) + 'px' });
		}
			
		
		//$('#dd-lightbox-popup').css({'margin-top': '-' + ( $('#dd-lightbox-img').height()/2 ) + 'px' });
	});
	
	<?php if( $dd_lightbox_ads_display_type && $dd_lightbox_ads_display_type == 'show_single' ) { ?>
	}
	<?php } ?>

});
</script>

<style type="text/css">
@media screen and (max-width: <?php echo $responsive_dd_lightbox_width; ?>) {
	#dd-lightbox-popup{ width: 90% !important; /*left: 5% !important; margin-left:0 !important;*/ }
}
</style>