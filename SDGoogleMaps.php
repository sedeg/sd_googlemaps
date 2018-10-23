<?php
defined('ABSPATH') or die('No script kiddies please!');

/**
 * Plugin Name: SD Google Maps
 * Plugin URI: http://sebastiandegner.de/wp-plugins
 * Description: Google Maps API Einbindung. Erstelle mehrere Karten und Marker
 * Version: 1.0.0
 * Author: Sebastian Degner
 * Author URI: http://sebastiandegner.de
 */
class SDGoogleMaps
{

	const POST_TYPE_NAME_MAP = 'sd_gmap';
	const POST_TYPE_NAME_MARKER = 'sd_gmarker';
	const PREFIX = 'sd_gmaps_';

	public function __construct(){
		define('WPFP_PATH_SDGMAP', plugin_dir_path( __FILE__ ));
		add_action('admin_menu', [$this, 'addPluginMenuPage']);
		add_action('admin_menu', [$this, 'addPluginMenuSubPage']);
		add_action('init', [$this, 'registerPostTypeMap']);
		add_action('init', [$this, 'registerPostTypeMarker']);
		add_action('add_meta_boxes', [$this, 'addMapMetaBox'], 10, 2);
		add_action('add_meta_boxes', [$this, 'addMarkerMetaBox'], 10, 2);
		add_action('wp_enqueue_scripts', [$this, 'enqueue_stylesandscripts_fe'], 10, 2);
		add_action('admin_enqueue_scripts', [$this, 'enqueue_stylesandscripts_be'], 10, 2);
		add_action('init', [$this, 'includeSDGmapHelpers']);
		add_action('save_post', [$this, 'saveMeta'], 10, 2);
		add_shortcode('sd_gmap', [$this, 'sdGmapShortcode'], 10, 2);
	}

	public function includeSDGmapHelpers(){
		include __DIR__.'/lib/SDGmap_fields.php';
		include __DIR__.'/lib/SDGmap_params.php';

		new SDGmap_fields;
		new SDGmap_params;
	}

	/**
	 * Add Admin Menu Page
	 */
	public function addPluginMenuPage(){
		add_menu_page('Maps', 'Maps', 'manage_options', 'sd_gmaps.php', [$this, 'sd_gmaps_admin_page'], 'dashicons-admin-site', 101);
	}

	/**
	 * Add Sub Menu Page
	 */
	public function addPluginMenuSubPage() {
		add_submenu_page('sd_gmaps.php', 'Allg. Einstellungen', 'Allg. Einstellungen', 'manage_categories', 'sd_gmaps_generalsettings', [$this, 'sd_gmapsGeneralSettings']);
	}

	/**
	 * Load Sub Menu Page Template
	 */
	public function sd_gmapsGeneralSettings(){
		if(isset($_POST['sd_gmaps_generalsettings_submit'])){
			self::saveGeneralSettings();
		}
		include __DIR__.'/templates/backend/general-settings.php';
	}

	/**
	 * register Map Custom Post Type
	 */
	public function registerPostTypeMap(){
		$labels = [
			'name' => 'Karte',
			'singular_name' => 'Karte',
			'add_new' => 'Neue Karte hinzufügen',
			'all_items' => 'Alle Karten',
			'add_new_item' => 'Neue Karte',
			'edit_item' => 'Karte bearbeiten',
			'new_item' => 'Neue Karte',
			'search_items' => 'Karte suchen',
			'not_found' => 'Keine Karte gefunden',
			'not_found_in_trash' => 'Keine Karte im PP gefunden',
			'menu_name' => 'Karte',
		];

		$args = [
			'labels' => $labels,
			'public' => true,
			'supports' => ['title'],
			'menu_position' => 100,
			'has_archive' => false,
			'publicaly_queryable' => false,
			'query_var' => false,
			'exclude_from_search' => true,
			'show_in_menu' => 'sd_gmaps.php',
		];

		register_post_type(self::POST_TYPE_NAME_MAP, $args);
	}

	/**
	 * Adding Map Metaboxes
	 */
	public function addMapMetaBox() {
		add_meta_box('mapsettings-meta-box', 'Allgemeine Einstellungen', [$this, 'mapSettingsMetaBox'], self::POST_TYPE_NAME_MAP, 'advanced', 'high');
		add_meta_box('mappreview-meta-box', 'Vorschau', [$this, 'mapPreviewMetaBox'], self::POST_TYPE_NAME_MAP, 'advanced', 'low');
		add_meta_box('mapcontrols-meta-box', 'erweiterte Einstellungen', [$this, 'mapControlsMetaBox'], self::POST_TYPE_NAME_MAP, 'side', 'low');
	}
	public function mapSettingsMetaBox() {
		include __DIR__.'/templates/backend/map/settings.php';
	}
	public function mapPreviewMetaBox() {
		include __DIR__.'/templates/backend/map/preview.php';
	}
	public function mapControlsMetaBox() {
		include __DIR__.'/templates/backend/map/controls.php';
	}

	/**
	 * register Marker Custom Post Type
	 */
	public function registerPostTypeMarker(){

		$labels = [
			'name' => 'Markierung',
			'singular_name' => 'Markierung',
			'add_new' => 'Neue Markierung hinzufügen',
			'all_items' => 'Alle Markierungen',
			'add_new_item' => 'Neue Markierung',
			'edit_item' => 'Markierung bearbeiten',
			'new_item' => 'Neue Markierung',
			'search_items' => 'Markierung suchen',
			'not_found' => 'Keine Markierung gefunden',
			'not_found_in_trash' => 'Keine Markierung im PP gefunden',
			'menu_name' => 'Markierungen'
		];


		$args = [
			'labels' => $labels,
			'public' => true,
			'supports' => [
				'title',
				'thumbnail'
			],
			'menu_position' => 101,
			'has_archive' => false,
			'publicaly_queryable' => false,
			'query_var' => false,
			'exclude_from_search' => true,
			'show_in_menu' => 'sd_gmaps.php',
		];

		register_post_type(self::POST_TYPE_NAME_MARKER, $args);
	}

	/**
	 * Adding Marker Metaboxes
	 */
	public function addMarkerMetaBox() {
		remove_meta_box( 'postimagediv', self::POST_TYPE_NAME_MARKER, 'side' );
		add_meta_box('postimagediv', __('Bild der Markierung'), 'post_thumbnail_meta_box', self::POST_TYPE_NAME_MARKER, 'side', 'high');
		add_meta_box('markersettings-meta-box', 'Allgemeine Einstellungen', [$this, 'markerSettingsMetaBox'], self::POST_TYPE_NAME_MARKER, 'advanced', 'high');
		add_meta_box('markeraction-meta-box', 'Onclick Aktion der Markierung', [$this, 'markerActionMetaBox'], self::POST_TYPE_NAME_MARKER, 'advanced', 'low');
	}
	public function markerSettingsMetaBox() {
		include __DIR__.'/templates/backend/marker/settings.php';
	}
	public function markerActionMetaBox() {
		include __DIR__.'/templates/backend/marker/action.php';
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

		$apikey = self::getGeneralSettingValue('apikey');
		wp_register_script('google_maps_be','https://maps.googleapis.com/maps/api/js?key='.$apikey);

		wp_enqueue_style('sd_gmap-styles-be');
		wp_enqueue_script('actions_backend');
		wp_enqueue_script('google_maps_be');
	}

	/**
	 * @param null $postId
	 */
	public function saveMeta($postId=null){
		$fields = [
			self::PREFIX.'width',
			self::PREFIX.'height',
			self::PREFIX.'map_center',
			self::PREFIX.'zoom',
			self::PREFIX.'style',
			self::PREFIX.'mousewheel',
			self::PREFIX.'dragging',
			self::PREFIX.'streetview',
			self::PREFIX.'zoombuttons',
			self::PREFIX.'scale',
			self::PREFIX.'maptype',
			self::PREFIX.'fullscreen',

			self::PREFIX.'marker_position',
			self::PREFIX.'marker_action',
			self::PREFIX.'marker_animation',
			self::PREFIX.'marker_link',
			self::PREFIX.'marker_infowindow_content',
			self::PREFIX.'marker_related_map',
			self::PREFIX.'marker_image_size',

			self::PREFIX.'selected_map',
		];


		if (empty($_POST[self::PREFIX.'width']))
			$_POST[self::PREFIX.'width'] = '100%';

		if (empty($_POST[self::PREFIX.'height']))
			$_POST[self::PREFIX.'height'] = '300px';

		if (empty($_POST[self::PREFIX.'map_center']))
			$_POST[self::PREFIX.'map_center'] = '51.3396955,12.3730747';

		if (empty($_POST[self::PREFIX.'zoom']))
			$_POST[self::PREFIX.'zoom'] = '13';

		if (empty($_POST[self::PREFIX.'marker_position']))
			$_POST[self::PREFIX.'marker_position'] = '51.3396955,12.3730747';

		foreach ($fields as $field) {
			if (!isset($_POST[$field])) {
				continue;
			}
			update_post_meta($postId, $field, $_POST[$field]);
		}
	}

	/**
	 * @param $field
	 * @param null $postId
	 * @return mixed
	 */
	public static function getMapValue($field, $postId = null){
		if (!$postId) {
			$postId = get_the_ID();
		}
		return get_post_meta($postId, self::PREFIX . $field, true);
	}

	/**
	 * @param null $args
	 * @return array
	 */
	public static function getMaps($args = null){
		$defaults = [
			'posts_per_page' => -1,
			'post_type' => self::POST_TYPE_NAME_MAP,
			'post_status' => 'publish',
		];
		$args = wp_parse_args( $args, $defaults );
		return get_posts($args);
	}

	/**
	 * @param $mapId
	 * @return array
	 */
	public static function getMarkerByMapId($mapId){
		$args = [
			'posts_per_page' => -1,
			'post_type' => self::POST_TYPE_NAME_MARKER,
			'post_status' => 'publish',
			'meta_key'   => self::PREFIX.'marker_related_map',
			'meta_value' => $mapId,
		];
		return get_posts($args);
	}

	public function saveGeneralSettings(){
		$fields = [
			self::PREFIX.'apikey',
		];

		foreach ($fields as $field) {
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
		return get_option(self::PREFIX . $field);
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