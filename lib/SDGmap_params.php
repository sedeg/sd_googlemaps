<?php
defined('ABSPATH') or die('No script kiddies please!');

class SDGmap_params
{
	/**
	 * @param null $mapId
	 * @return string
	 */
	public static function getSDGmapMarkers($mapId = null)
	{
		if (!$mapId)
			$mapId = get_the_ID();

		$markers = SDGoogleMaps::getMarkerByMapId($mapId);
		$markerString = '[';
		foreach ($markers as $marker) {
			$marker_title = get_the_title($marker->ID);
			$marker_image_url = get_the_post_thumbnail_url($marker->ID, 'full');

			$marker_position = SDGoogleMaps::getMapValue('marker_position', $marker->ID);
			$marker_image_size = SDGoogleMaps::getMapValue('marker_image_size', $marker->ID);
			$marker_action = SDGoogleMaps::getMapValue('marker_action', $marker->ID);
			$marker_link = SDGoogleMaps::getMapValue('marker_link', $marker->ID);
			$marker_infowindow = nl2br(SDGoogleMaps::getMapValue('marker_infowindow_content', $marker->ID));
			$marker_infowindow = preg_replace("/\r|\n/", "", $marker_infowindow);
			$marker_animation = SDGoogleMaps::getMapValue('marker_animation', $marker->ID);

			$markerString .= $output = '["' . $marker_title . '","' . $marker_position . '","' . $marker_image_url . '","' . $marker_image_size . '","' . $marker_action . '","' . $marker_infowindow . '","' . $marker_link . '","'.$marker_animation.'"],';
		}
		$markerString .= ']';

		return $markerString;
	}

	/**
	 * @param $key
	 * @param null $mapId
	 * @return mixed
	 */
	public static function getSDGmapMeta($key, $mapId = null){
		if (!$mapId)
			$mapId = get_the_ID();

		return SDGoogleMaps::getMapValue($key, $mapId);
	}

	/**
	 * @param null $mapId
	 * @return bool|mixed|string
	 */
	public static function getSDGmapStyle($mapId = null){
		if (!$mapId)
			$mapId = get_the_ID();

		$mapStyle = SDGoogleMaps::getMapValue('style', $mapId);
		$mapStyle = (empty($mapStyle)) ? '[]' : file_get_contents(wp_get_attachment_url($mapStyle), FILE_USE_INCLUDE_PATH);
		return $mapStyle;
	}
}

