<div class="wrap">
<h1>Responsive Lightbox</h1>
<form method="post" action="options.php">
<?php @settings_fields('dd_lightbox_ads'); ?>
<?php @do_settings_fields('section'); ?>
<h2>Settings</h2>
<table class="form-table">
<tbody>
<tr>
<th scope="row">Visibility</th>
<td>
<label for="dd_lightbox_ads_visiblity-1"><input id="dd_lightbox_ads_visiblity-1" type="radio" name="dd_lightbox_ads_visiblity" value="home_only" <?php echo get_option('dd_lightbox_ads_visiblity') == 'home_only' ? 'checked' : ''; ?>/> Home Page Only</label><br/>
<label for="dd_lightbox_ads_visiblity-2"><input id="dd_lightbox_ads_visiblity-2" id="dd_lightbox_ads_visiblity-1" type="radio" name="dd_lightbox_ads_visiblity" value="all_posts" <?php echo get_option('dd_lightbox_ads_visiblity') == 'all_posts' ? 'checked' : ''; ?>/> All Post and Pages</label><br/>
<label for="dd_lightbox_ads_visiblity-3"><input id="dd_lightbox_ads_visiblity-3" type="radio" name="dd_lightbox_ads_visiblity" value="custom_posts" <?php echo get_option('dd_lightbox_ads_visiblity') == 'custom_posts' ? 'checked' : ''; ?>/> Specific Page or Post</label>
</td>
</tr>
<tr class="dd_case_custom_url" <?php echo get_option('dd_lightbox_ads_visiblity') == 'custom_posts' ? 'style="display:table-row;"' : 'style="display:none;"'; ?>>
<th scope="row">Enter Page or Post ID to use Custom URL</th>
<td><input type="text" value="<?php echo get_option('dd_lightbox_ads_custom_url');?>" name="dd_lightbox_ads_custom_url" id="dd_lightbox_ads_custom_url" class="regular-text" /><p class="description">If there are multiple ID's, use commas to separate</p></td>
</tr>
<tr>
<th scope="row">Display Type</th>
<td>
<label for="dd_lightbox_ads_display_type-1"><input id="dd_lightbox_ads_display_type-1" type="radio" name="dd_lightbox_ads_display_type" value="show_everytime" <?php echo get_option('dd_lightbox_ads_display_type') == 'show_everytime' ? 'checked' : ''; ?>/> Show Everytime on Page Load</label><br/>
<label for="dd_lightbox_ads_display_type-2"><input id="dd_lightbox_ads_display_type-2" type="radio" name="dd_lightbox_ads_display_type" value="show_single" <?php echo get_option('dd_lightbox_ads_display_type') == 'show_single' ? 'checked' : ''; ?>/> Show One Time Only</label>
</td>
</tr>
</tbody>
</table>
<?php do_settings_sections('dd_lightbox_ads'); ?>
<?php @submit_button(); ?>
</form>
</div>