<?php
defined('ABSPATH') or die('No script kiddies please!');

/**
 * Plugin Name: SD Google Maps
 * Plugin URI: http://sebastiandegner.de/wp-plugins
 * Description: Google Maps API Einbindung. Erstelle mehrere Karten und Marker
 * Version: 1.2.0
 * Author: Sebastian Degner
 * Author URI: http://sebastiandegner.de
 */
class SDGoogleMaps
{
	const PREFIX = 'sd_gmap_';

	const META_KEY_GMAP_SETTING_API = self::PREFIX.'apikey';
	const META_KEY_GMAP_SETTING_SUBMIT = self::PREFIX.'generalsettings_submit';

	const METAFIELDS = [
		self::META_KEY_GMAP_SETTING_API,
	];

	public function __construct(){
		define('WPFP_PATH_SDGMAP', plugin_dir_path( __FILE__ ));

		include __DIR__ . '/lib/SDGmapMapPostType.php';
		include __DIR__ . '/lib/SDGmapMarkerPostType.php';
		include __DIR__ . '/lib/SDGmapFields.php';

		new SDGmapMapPostType;
		new SDGmapMarkerPostType;
		new SDGmapFields;

		add_action('admin_menu', [$this, 'addPluginMenuPage']);
		add_action('admin_menu', [$this, 'addPluginMenuSubPage']);
		add_action('wp_enqueue_scripts', [$this, 'enqueue_stylesandscripts_fe'], 10, 2);
		add_action('admin_enqueue_scripts', [$this, 'enqueue_stylesandscripts_be'], 10, 2);
		add_shortcode('sd_gmap', [$this, 'sdGmapShortcode'], 10, 2);
	}

	/**
	 * Add Admin Menu Page
	 */
	public function addPluginMenuPage(){
		add_menu_page('Maps', 'Maps', 'manage_options', 'sd_gmaps', [$this, 'sd_gmapsGeneralSettings'], 'dashicons-admin-site', 101);
	}

	/**
	 * Add Sub Menu Page
	 */
	public function addPluginMenuSubPage() {
		add_submenu_page('sd_gmaps', 'Allg. Einstellungen', 'Allg. Einstellungen', 'manage_categories', 'sd_gmaps_generalsettings', [$this, 'sd_gmapsGeneralSettings']);
	}

	/**
	 * Load Sub Menu Page Template
	 */
	public function sd_gmapsGeneralSettings(){
		if(isset($_POST[self::META_KEY_GMAP_SETTING_SUBMIT])){
			self::saveGeneralSettings();
		}
		include __DIR__.'/templates/backend/general-settings.php';
	}

	/**
	 * Enqueue Scripts and Styles Frontend
	 */
	function enqueue_stylesandscripts_fe(){
		$apikey = self::getGeneralSettingValue('apikey');
		wp_register_script('google_maps','https://maps.googleapis.com/maps/api/js?key='.$apikey);
		wp_enqueue_script('google_maps');
	}

	/**
	 * Enqueue Scripts and Styles Backend
	 */
	public function enqueue_stylesandscripts_be(){
		wp_register_style('sd_gmap-styles-be', plugins_url('/css/backend/sd_gmap_styles_backend.css', __FILE__));
		wp_register_script('actions_backend',plugins_url('/js/backend/sd_gmap_actions_backend.js', __FILE__),'jQuery','1.0',true);

		$apikey = self::getGeneralSettingValue(self::META_KEY_GMAP_SETTING_API);
		wp_register_script('google_maps_be','https://maps.googleapis.com/maps/api/js?key='.$apikey);

		wp_enqueue_style('sd_gmap-styles-be');
		wp_enqueue_script('actions_backend');
		wp_enqueue_script('google_maps_be');
	}

	public function saveGeneralSettings(){

		foreach (self::METAFIELDS as $field) {
			if (!isset($_POST[$field])) {
				continue;
			}
			update_option($field, $_POST[$field]);
		}
		echo '<div id="message" class="updated fade"><p>Änderungen gespeichert</p></div>';
	}

	/**
	 * @param $field
	 * @return mixed|void
	 */
	public static function getGeneralSettingValue($field) {
		return get_option($field);
	}

	/**
	 * @param $atts
	 * @return string
	 */
	public function sdGmapShortcode($atts){
		$shortcodeAttributes = shortcode_atts(['map_id' => 0], $atts );

		ob_start();
		include __DIR__.'/templates/map-template.php';
		$output = ob_get_clean();
		return $output;

	}
}

/**
 * Init Plugin
 */
new SDGoogleMaps;