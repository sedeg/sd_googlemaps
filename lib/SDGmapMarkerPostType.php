<?php
class SDGmapMarkerPostType
{

	const POST_TYPE_NAME = 'sd_gmarker';
	const PREFIX = 'sd_gmap_marker_';

	/**#@+
	 * @const string Meta Keys
	 */
	const META_KEY_GMARKER_POSITION				= self::PREFIX . 'position';
	const META_KEY_GMARKER_ACTION				= self::PREFIX . 'action';
	const META_KEY_GMARKER_ANIMATION			= self::PREFIX . 'animation';
	const META_KEY_GMARKER_LINK					= self::PREFIX . 'link';
	const META_KEY_GMARKER_INFOWINDOW_CONTENT	= self::PREFIX . 'infowindow_content';
	const META_KEY_GMARKER_RELATED_MAP			= self::PREFIX . 'related_map';
	const META_KEY_GMARKER_IMAGESIZE			= self::PREFIX . 'image_size';
	/**#@-*/

	const METAFIELDS = [
		self::META_KEY_GMARKER_POSITION,
		self::META_KEY_GMARKER_ACTION,
		self::META_KEY_GMARKER_ANIMATION,
		self::META_KEY_GMARKER_LINK,
		self::META_KEY_GMARKER_INFOWINDOW_CONTENT,
		self::META_KEY_GMARKER_RELATED_MAP,
		self::META_KEY_GMARKER_IMAGESIZE,
	];

	public function __construct(){
		add_action('init', [$this, 'registerPostTypeMarker']);
		add_action('add_meta_boxes', [$this, 'addMarkerMetaBox'], 10, 2);
		add_action('save_post_'.self::POST_TYPE_NAME, [$this, 'saveMeta'], 10, 2);
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
			'show_in_menu' => 'sd_gmaps',
		];

		register_post_type(self::POST_TYPE_NAME, $args);
	}

	/**
	 * Adding Marker Metaboxes
	 */
	public function addMarkerMetaBox() {
		remove_meta_box( 'postimagediv', self::POST_TYPE_NAME, 'side' );
		add_meta_box('postimagediv', __('Bild der Markierung'), 'post_thumbnail_meta_box', self::POST_TYPE_NAME, 'side', 'high');
		add_meta_box('markersettings-meta-box', 'Allgemeine Einstellungen', [$this, 'markerSettingsMetaBox'], self::POST_TYPE_NAME, 'advanced', 'high');
		add_meta_box('markeraction-meta-box', 'Onclick Aktion der Markierung', [$this, 'markerActionMetaBox'], self::POST_TYPE_NAME, 'advanced', 'low');
	}
	public function markerSettingsMetaBox() {
		include __DIR__.'/templates/marker/settings.php';
	}
	public function markerActionMetaBox() {
		include __DIR__.'/templates/marker/action.php';
	}

	/**
	 * @param null $postId
	 */
	public function saveMeta($postId=null){

		if (empty($_POST[self::META_KEY_GMARKER_POSITION]))
			$_POST[self::META_KEY_GMARKER_POSITION] = '51.3396955,12.3730747';

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
	public static function getMarkerValue($field, $postId = null)
	{
		if (!$postId) {
			$postId = get_the_ID();
		}
		return get_post_meta($postId,  $field, true);
	}


	/**
	 * @param null $args
	 * @return array
	 */
	public static function getMarkers($args = null){
		$defaults = [
			'posts_per_page' => -1,
			'post_type' => self::POST_TYPE_NAME,
			'post_status' => 'publish',
		];
		$args = wp_parse_args( $args, $defaults );
		return get_posts($args);
	}

	public static function getMarkersString($mapId, $args = null)
	{

		$markers = self::getMarkers($mapId, $args);

		$markerString = '[';

		foreach ($markers as $marker) {
			$marker_title = get_the_title($marker->ID);
			$marker_image_url = get_the_post_thumbnail_url($marker->ID, 'full');

			$marker_position = SDGmapMarkerPostType::getMarkerValue(self::META_KEY_GMARKER_POSITION, $marker->ID);
			$marker_image_size = SDGmapMarkerPostType::getMarkerValue(self::META_KEY_GMARKER_IMAGESIZE, $marker->ID);
			$marker_action = SDGmapMarkerPostType::getMarkerValue(self::META_KEY_GMARKER_ACTION, $marker->ID);
			$marker_link = SDGmapMarkerPostType::getMarkerValue(self::META_KEY_GMARKER_LINK, $marker->ID);
			$marker_infowindow = nl2br(SDGmapMarkerPostType::getMarkerValue(self::META_KEY_GMARKER_INFOWINDOW_CONTENT, $marker->ID));
			$marker_infowindow = preg_replace("/\r|\n/", "", $marker_infowindow);
			$marker_animation = SDGmapMarkerPostType::getMarkerValue(self::META_KEY_GMARKER_ANIMATION, $marker->ID);

			$markerString .= $output = '["' . $marker_title . '","' . $marker_position . '","' . $marker_image_url . '","' . $marker_image_size . '","' . $marker_action . '","' . $marker_infowindow . '","' . $marker_link . '","'.$marker_animation.'"],';
		}
		$markerString .= ']';

		return $markerString;
	}

}
