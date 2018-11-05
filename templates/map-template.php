<?php
$mapId = $shortcodeAttributes['map_id'];
$markerArgs = [
	'posts_per_page' => -1,
	'post_type' => SDGmapMarkerPostType::POST_TYPE_NAME,
	'post_status' => 'publish',
	'meta_key'   => SDGmapMarkerPostType::META_KEY_GMARKER_RELATED_MAP,
	'meta_value' => $mapId,
];
?>
<script type="text/javascript">
	var map;
	var marker = Array();
	var infowindows = Array();
	var myLatLngCenter;
	var places = <?php echo SDGmapMarkerPostType::getMarkersString($markerArgs);?>

		function initGmap() {
			var opts = {
				scrollwheel: <?php echo SDGmapMapPostType::getMapValue(SDGmapMapPostType::META_KEY_GMAP_MOUSEWHEEL, $mapId);?>,
				draggable: <?php echo SDGmapMapPostType::getMapValue(SDGmapMapPostType::META_KEY_GMAP_DRAGGING,$mapId);?>,
				streetViewControl: <?php echo SDGmapMapPostType::getMapValue(SDGmapMapPostType::META_KEY_GMAP_STREETVIEW,$mapId);?>,
				zoomControl: <?php echo SDGmapMapPostType::getMapValue(SDGmapMapPostType::META_KEY_GMAP_ZOOMBUTTONS,$mapId);?>,
				scaleControl: <?php echo SDGmapMapPostType::getMapValue(SDGmapMapPostType::META_KEY_GMAP_SCALE,$mapId);?>,
				mapTypeControl: <?php echo SDGmapMapPostType::getMapValue(SDGmapMapPostType::META_KEY_GMAP_MAPTYPE,$mapId);?>,
				center: new google.maps.LatLng(<?php echo SDGmapMapPostType::getMapValue(SDGmapMapPostType::META_KEY_GMAP_CENTER,$mapId);?>),
				zoom: <?php echo SDGmapMapPostType::getMapValue(SDGmapMapPostType::META_KEY_GMAP_ZOOM,$mapId);?>,
				fullscreenControl: <?php echo SDGmapMapPostType::getMapValue(SDGmapMapPostType::META_KEY_GMAP_FULLSCREEN,$mapId);?>,
			}
			map = new google.maps.Map(document.getElementById("sd_gmap-<?php echo $mapId;?>"), opts);
			map.setOptions({styles: <?php echo SDGmapMapPostType::getMapStyle($mapId);?>});

			for (var i = 0; i < places.length; i++) {
				var place = places[i];
				var llCenterString = place[1].split(",");
				var myIcon = '';
				var myAnimation = '';
				myLatLngCenter = new google.maps.LatLng(parseFloat(llCenterString[0]), parseFloat(llCenterString[1]));

				if (place[2].length > 0) {
					if (place[3].length > 0) {
						var iconSize = place[3].split(",");
						iconWidth = parseFloat(iconSize[0]);
						iconHeight = parseFloat(iconSize[1]);
					} else {
						iconWidth = 32;
						iconHeight = 32;
					}
					myIcon = new google.maps.MarkerImage(place[2], null, null, null, new google.maps.Size(iconWidth, iconHeight));
				}
				if(place[7] == 'bounce'){
					myAnimation = google.maps.Animation.BOUNCE;
				}else if(place[7] == 'drop'){
					myAnimation = google.maps.Animation.DROP;
				}
				marker[i] = new google.maps.Marker({
					map: map,
					icon: myIcon,
					title: place[0],
					id: i,
					position: myLatLngCenter,
					animation: myAnimation,
				});

				if (place[4] == "infowindow") {
					infowindows[i] = new google.maps.InfoWindow({
						content: place[5]
					});
					google.maps.event.addListener(marker[i], "click", function () {
						infowindows[this.id].open(map, marker[this.id]);
					});
				} else if (place[4] == "hyperlink") {
					google.maps.event.addListener(marker[i], "click", function () {
						window.open(places[this.id][6], "_blank");
					});
				}
			}
		}

		(function ($, root, undefined) {
			$(function () {
				"use strict";
				google.maps.event.addDomListener(window, 'load', initGmap());
			});
			$(window).resize(function () {
				map.setCenter(myLatLngCenter);
			});
		})(jQuery, this);
</script>
<div style="width:<?php echo SDGmapMapPostType::getMapValue(SDGmapMapPostType::META_KEY_GMAP_WIDTH,$mapId); ?>;height:<?php echo SDGmapMapPostType::getMapValue(SDGmapMapPostType::META_KEY_GMAP_HEIGHT,$mapId); ?>;" class="sd_gmap gmap" id="sd_gmap-<?php echo $mapId; ?>"></div>