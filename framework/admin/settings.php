<?php
add_action('admin_menu', 'create_admin_menu_geo');
add_action('init', 'lifecare_wm4d_css');

function create_admin_menu_geo() {
	add_menu_page ('Theme Support', 'Theme Support','manage_theme','lifecare_wm4d_support','lifecare_wm4d_support', ''); //after soulmedic-geo menu
}

function lifecare_wm4d_css() {
	wp_register_style('lifecare_wm4d_css.css', THEME_CHILD_URL.'/framework/admin/admin.css', '', $GLOBALS['THEME_CSS_VERSION'], '');
	wp_enqueue_style('lifecare_wm4d_css.css');
}
?>