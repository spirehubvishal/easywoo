<?php // Enqueue Resources

if (!defined('ABSPATH')) exit;

function g7g_cfg_enqueue_resources_admin() {
	
	$screen_id = g7g_cfg_get_current_screen_id();
	
	if (!$screen_id) return;
	
	if ($screen_id === 'settings_page_g7g-cfg') {
		
		$js_deps = array('jquery', 'jquery-ui-core', 'jquery-ui-dialog');
		
		wp_enqueue_style('wp-jquery-ui-dialog');
		
		wp_enqueue_style('g7g-cfg-font-icons', G7G_CFG_URL .'css/font-icons.css', array(), G7G_CFG_VERSION);
		
		wp_enqueue_style('g7g-cfg-settings', G7G_CFG_URL .'css/settings.css', array(), G7G_CFG_VERSION);
		
		wp_enqueue_script('g7g-cfg-settings', G7G_CFG_URL .'js/settings.js', $js_deps, G7G_CFG_VERSION);
		
	}
	
}

function g7g_cfg_load_assets_editor() {
	
	$random = g7g_cfg_random_string();
	
	wp_enqueue_style('g7g-cfg-load-assets', G7G_CFG_URL .'blocks/blocks.css', array(), $random);
	
	// wp_enqueue_script('g7g-cfg-load-assets-editor', G7G_CFG_URL .'blocks/blocks.js', array('wp-blocks', 'wp-element', 'wp-components', 'wp-i18n'), $random);
	
}

function g7g_cfg_load_assets() {
	
	// add_action('enqueue_block_assets', 'g7g_cfg_load_assets'); // just fyi
		
}

function g7g_cfg_admin_print_scripts() { 
	
	$screen_id = g7g_cfg_get_current_screen_id();
	
	if (!$screen_id) return;
	
	if ($screen_id === 'settings_page_g7g-cfg') : ?>
	
	<script type="text/javascript">
		var 
		alert_reset_options_title   = '<?php _e('Confirm Reset',            'custom-fields-gutenberg'); ?>',
		alert_reset_options_message = '<?php _e('Restore default options?', 'custom-fields-gutenberg'); ?>',
		alert_reset_options_true    = '<?php _e('Yes, make it so.',         'custom-fields-gutenberg'); ?>',
		alert_reset_options_false   = '<?php _e('No, abort mission.',       'custom-fields-gutenberg'); ?>';
	</script>
	
	<?php endif;
	
}

function g7g_cfg_get_current_screen_id() {
	
	if (!function_exists('get_current_screen')) require_once ABSPATH .'/wp-admin/includes/screen.php';
	
	$screen = get_current_screen();
	
	if ($screen && property_exists($screen, 'id')) return $screen->id;
	
	return false;
	
}