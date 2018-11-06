<?php
$prefix = SDGmapMapPostType::PREFIX;
$fields = [
	[
		'fieldtype' => SDGmapFields::FIELD_TYPE_INPUT,
		'type' => 'text',
		'name' => SDGmapMapPostType::META_KEY_GMAP_WIDTH,
		'placeholder' => 'z.B. 100% oder 500px',
		'label' => 'Breite der Karte',
		'description' => 'Breitenangabe in Prozent oder Pixel.<br>Standardwert: 100%',
		'class' => '',
		'value' => SDGmapMapPostType::getMapValue(SDGmapMapPostType::META_KEY_GMAP_WIDTH),
	],
	[
		'fieldtype' => SDGmapFields::FIELD_TYPE_INPUT,
		'type' => 'text',
		'name' => SDGmapMapPostType::META_KEY_GMAP_HEIGHT,
		'placeholder' => 'z.B. 500px',
		'label' => 'Höhe der Karte',
		'description' => 'Höhenangabe in Pixel.<br>Standardwert: 300px',
		'description_class' => 'distance-bottom',
		'value' => SDGmapMapPostType::getMapValue(SDGmapMapPostType::META_KEY_GMAP_HEIGHT),
	],
	[
		'fieldtype' => SDGmapFields::FIELD_TYPE_INPUT,
		'type' => 'text',
		'name' => SDGmapMapPostType::META_KEY_GMAP_CENTER,
		'placeholder' => 'z.B. 51.3396955,12.3730747',
		'label' => 'Kartenzentrum',
		'description' => 'Mittelpunkt der Karte mit kommaseparierten Höhen- und Breitengrad. Höhen- und Breitengrad kann bspw. auf <a target="_blank" href="http://www.mapcoordinates.net/en">mapcoordinates.net</a> ermittelt werden.<br>Standardwert: 51.3396955,12.3730747 (Leipzig)',
		'value' => SDGmapMapPostType::getMapValue(SDGmapMapPostType::META_KEY_GMAP_CENTER),
	],
	[
		'fieldtype' => SDGmapFields::FIELD_TYPE_INPUT,
		'type' => 'text',
		'name' => SDGmapMapPostType::META_KEY_GMAP_ZOOM,
		'placeholder' => 'z.B. 10',
		'label' => 'Zoomfaktor',
		'description' => 'Vergrößerung der Karte. Von 0 bis 21.<br>Standardwert: 13',
		'value' => SDGmapMapPostType::getMapValue(SDGmapMapPostType::META_KEY_GMAP_ZOOM),
	],
	[
		'fieldtype' => SDGmapFields::FIELD_TYPE_ATTACHMENT,
		'upload_value'      => 'Theme hinzufügen',
		'upload_name'		=> 'upload',
		'label' => 'Google Maps Theme',
		'name' => SDGmapMapPostType::META_KEY_GMAP_STYLE,
		'value' => SDGmapMapPostType::getMapValue(SDGmapMapPostType::META_KEY_GMAP_STYLE),
	],
];
?>
<div class="cpt-meta">
	<?php foreach ($fields as $field): ?>
		<?php SDGmapFields::createField($field);?>
	<?php endforeach; ?>
</div>