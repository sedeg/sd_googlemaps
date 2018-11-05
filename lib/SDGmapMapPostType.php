<?php
class SDGmapMapPostType
{

	const POST_TYPE_NAME = 'sd_gmap';
	const PREFIX = 'sd_gmap_map_';

	/**#@+
	 * @const string Meta Keys
	 */
	const META_KEY_GMAP_WIDTH			= self::PREFIX . 'width';
	const META_KEY_GMAP_HEIGHT			= self::PREFIX . 'height';
	const META_KEY_GMAP_CENTER			= self::PREFIX . 'map_center';
	const META_KEY_GMAP_ZOOM			= self::PREFIX . 'zoom';
	const META_KEY_GMAP_STYLE			= self::PREFIX . 'style';
	const META_KEY_GMAP_MOUSEWHEEL		= self::PREFIX . 'mousewheel';
	const META_KEY_GMAP_DRAGGING		= self::PREFIX . 'dragging';
	const META_KEY_GMAP_STREETVIEW		= self::PREFIX . 'streetview';
	const META_KEY_GMAP_ZOOMBUTTONS		= self::PREFIX . 'zoombuttons';
	const META_KEY_GMAP_SCALE			= self::PREFIX . 'scale';
	const META_KEY_GMAP_MAPTYPE			= self::PREFIX . 'maptype';
	const META_KEY_GMAP_FULLSCREEN		= self::PREFIX . 'fullscreen';
	/**#@-*/

	const METAFIELDS = [
		self::META_KEY_GMAP_WIDTH,
		self::META_KEY_GMAP_HEIGHT,
		self::META_KEY_GMAP_CENTER,
		self::META_KEY_GMAP_ZOOM,
		self::META_KEY_GMAP_STYLE,
		self::META_KEY_GMAP_MOUSEWHEEL,
		self::META_KEY_GMAP_DRAGGING,
		self::META_KEY_GMAP_STREETVIEW,
		self::META_KEY_GMAP_ZOOMBUTTONS,
		self::META_KEY_GMAP_SCALE,
		self::META_KEY_GMAP_MAPTYPE,
		self::META_KEY_GMAP_FULLSCREEN,
	];


	public function __construct()
	{
		add_action('init', [$this, 'registerPostType']);
		add_action('add_meta_boxes', [$this, 'addMapMetaBox'], 10, 2);
		add_action('save_post_'.self::POST_TYPE_NAME, [$this, 'saveMeta'], 10, 2);
	}

	/**
	 * register Map Custom Post Type
	 */
	public function registerPostType()
	{
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
			'show_in_menu' => 'sd_gmaps',
		];

		register_post_type(self::POST_TYPE_NAME, $args);
	}

	/**
	 * Adding Map Metaboxes
	 */
	public function addMapMetaBox()
	{
		add_meta_box('mapsettings-meta-box', 'Allgemeine Einstellungen', [$this, 'mapSettingsMetaBox'], self::POST_TYPE_NAME, 'advanced', 'high');
		add_meta_box('mappreview-meta-box', 'Vorschau', [$this, 'mapPreviewMetaBox'], self::POST_TYPE_NAME, 'advanced', 'low');
		add_meta_box('mapcontrols-meta-box', 'erweiterte Einstellungen', [$this, 'mapControlsMetaBox'], self::POST_TYPE_NAME, 'side', 'low');
	}

	public function mapSettingsMetaBox()
	{
		include __DIR__ . '/templates/map/settings.php';
	}

	public function mapPreviewMetaBox()
	{
		include __DIR__ . '/templates/map/preview.php';
	}

	public function mapControlsMetaBox()
	{
		include __DIR__ . '/templates/map/controls.php';
	}

	/**
	 * @param null $postId
	 */
	public function saveMeta($postId = null)
	{

		if (empty($_POST[self::META_KEY_GMAP_WIDTH]))
			$_POST[self::META_KEY_GMAP_WIDTH] = '100%';

		if (empty($_POST[self::META_KEY_GMAP_HEIGHT]))
			$_POST[self::META_KEY_GMAP_HEIGHT] = '300px';

		if (empty($_POST[self::META_KEY_GMAP_CENTER]))
			$_POST[self::META_KEY_GMAP_CENTER] = '51.3396955,12.3730747';

		if (empty($_POST[self::META_KEY_GMAP_ZOOM]))
			$_POST[self::META_KEY_GMAP_ZOOM] = '13';

		foreach (self::METAFIELDS as $field) {
			if (!isset($_POST[$field]))
				continue;

			update_post_meta($postId, $field, $_POST[$field]);
		}
	}

	/**
	 * @param $field
	 * @param null $postId
	 * @return mixed
	 */
	public static function getMapValue($field, $postId = null)
	{
		if (!$postId) {
			$postId = get_the_ID();
		}
		return get_post_meta($postId, $field, true);
	}

	/**
	 * @param null $mapId
	 * @return bool|mixed|string
	 */
	public static function getMapStyle($mapId = null){
		if (!$mapId)
			$mapId = get_the_ID();

		$mapStyle = self::getMapValue(self::META_KEY_GMAP_STYLE, $mapId);
		$mapStyle = (empty($mapStyle)) ? '[]' : file_get_contents(wp_get_attachment_url($mapStyle), FILE_USE_INCLUDE_PATH);
		return $mapStyle;
	}

	/**
	 * @param null $args
	 * @return array
	 */
	public static function getMaps($args = null)
	{
		$defaults = [
			'posts_per_page' => -1,
			'post_type' => self::POST_TYPE_NAME,
			'post_status' => 'publish',
		];
		$args = wp_parse_args($args, $defaults);
		return get_posts($args);
	}
}