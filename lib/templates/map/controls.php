<?php
$fields = [
	[
		'fieldtype' => SDGmapFields::FIELD_TYPE_SELECT,
		'name' => SDGmapMapPostType::META_KEY_GMAP_MOUSEWHEEL,
		'label' => 'Zoomen',
		'options' => [
			'Deaktivieren' => 'false',
			'Aktivieren' => 'true',
		],
		'description' => 'Aktiviert das Rein- und Rauszoomen mit dem Mausrad',
		'value' => SDGmapMapPostType::getMapValue(SDGmapMapPostType::META_KEY_GMAP_MOUSEWHEEL),
	],
	[
		'fieldtype' => SDGmapFields::FIELD_TYPE_SELECT,
		'name' => SDGmapMapPostType::META_KEY_GMAP_DRAGGING,
		'label' => 'Verschieben',
		'options' => [
			'Deaktivieren' => 'false',
			'Aktivieren' => 'true',
		],
		'description' => 'Erlaubt das Verschieben der Karte',
		'value' => SDGmapMapPostType::getMapValue(SDGmapMapPostType::META_KEY_GMAP_DRAGGING),
	],
	[
		'fieldtype' => SDGmapFields::FIELD_TYPE_SELECT,
		'name' => SDGmapMapPostType::META_KEY_GMAP_STREETVIEW,
		'label' => 'Streetview',
		'options' => [
			'Deaktivieren' => 'false',
			'Aktivieren' => 'true',
		],
		'description' => 'Aktiviert Streetview auf der Karte',
		'value' => SDGmapMapPostType::getMapValue(SDGmapMapPostType::META_KEY_GMAP_STREETVIEW),
	],
	[
		'fieldtype' => SDGmapFields::FIELD_TYPE_SELECT,
		'name' => SDGmapMapPostType::META_KEY_GMAP_ZOOMBUTTONS,
		'label' => 'Zoomen via Buttons',
		'options' => [
			'Deaktivieren' => 'false',
			'Aktivieren' => 'true',
		],
		'description' => 'Aktiviert das Rein- und Rauszoom-Panel',
		'value' => SDGmapMapPostType::getMapValue(SDGmapMapPostType::META_KEY_GMAP_ZOOMBUTTONS),
	],
	[
		'fieldtype' => SDGmapFields::FIELD_TYPE_SELECT,
		'name' => SDGmapMapPostType::META_KEY_GMAP_SCALE,
		'label' => 'Skalier-Panel',
		'options' => [
			'Deaktivieren' => 'false',
			'Aktivieren' => 'true',
		],
		'description' => 'Aktiviert das Skalier-Panel',
		'value' => SDGmapMapPostType::getMapValue(SDGmapMapPostType::META_KEY_GMAP_SCALE),
	],
	[
		'fieldtype' => SDGmapFields::FIELD_TYPE_SELECT,
		'name' => SDGmapMapPostType::META_KEY_GMAP_MAPTYPE,
		'label' => 'Karten-Typ Auswahl',
		'options' => [
			'Deaktivieren' => 'false',
			'Aktivieren' => 'true',
		],
		'description' => 'Aktiviert das Karten-Typ-Panel',
		'value' => SDGmapMapPostType::getMapValue(SDGmapMapPostType::META_KEY_GMAP_MAPTYPE),
	],
	[
		'fieldtype' => SDGmapFields::FIELD_TYPE_SELECT,
		'name' => SDGmapMapPostType::META_KEY_GMAP_FULLSCREEN,
		'label' => 'Fullscreen',
		'options' => [
			'Deaktivieren' => 'false',
			'Aktivieren' => 'true',
		],
		'description' => 'Aktiviert die Möglichkeit die Karte Fullscreen anzuschauen',
		'value' => SDGmapMapPostType::getMapValue(SDGmapMapPostType::META_KEY_GMAP_FULLSCREEN),
	],
];
?>
<div class="cpt-meta">
	<?php foreach ($fields as $field): ?>
		<?php SDGmapFields::createField($field);?>
	<?php endforeach; ?>
</div>
