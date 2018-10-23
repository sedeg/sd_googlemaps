<?php
$prefix = SDGoogleMaps::PREFIX;
$fields = [
	[
		'fieldtype' => SDGmap_fields::FIELD_TYPE_SELECT,
		'name' => $prefix.'mousewheel',
		'label' => 'Zoomen',
		'options' => [
			'Deaktivieren' => 'false',
			'Aktivieren' => 'true',
		],
		'description' => 'Aktiviert das Rein- und Rauszoomen mit dem Mausrad',
		'value' => SDGoogleMaps::getMapValue('mousewheel'),
	],
	[
		'fieldtype' => SDGmap_fields::FIELD_TYPE_SELECT,
		'name' => $prefix.'dragging',
		'label' => 'Verschieben',
		'options' => [
			'Deaktivieren' => 'false',
			'Aktivieren' => 'true',
		],
		'description' => 'Erlaubt das Verschieben der Karte',
		'value' => SDGoogleMaps::getMapValue('dragging'),
	],
	[
		'fieldtype' => SDGmap_fields::FIELD_TYPE_SELECT,
		'name' => $prefix.'streetview',
		'label' => 'Streetview',
		'options' => [
			'Deaktivieren' => 'false',
			'Aktivieren' => 'true',
		],
		'description' => 'Aktiviert Streetview auf der Karte',
		'value' => SDGoogleMaps::getMapValue('streetview'),
	],
	[
		'fieldtype' => SDGmap_fields::FIELD_TYPE_SELECT,
		'name' => $prefix.'zoombuttons',
		'label' => 'Zoomen via Buttons',
		'options' => [
			'Deaktivieren' => 'false',
			'Aktivieren' => 'true',
		],
		'description' => 'Aktiviert das Rein- und Rauszoom-Panel',
		'value' => SDGoogleMaps::getMapValue('zoombuttons'),
	],
	[
		'fieldtype' => SDGmap_fields::FIELD_TYPE_SELECT,
		'name' => $prefix.'scale',
		'label' => 'Skalier-Panel',
		'options' => [
			'Deaktivieren' => 'false',
			'Aktivieren' => 'true',
		],
		'description' => 'Aktiviert das Skalier-Panel',
		'value' => SDGoogleMaps::getMapValue('scale'),
	],
	[
		'fieldtype' => SDGmap_fields::FIELD_TYPE_SELECT,
		'name' => $prefix.'maptype',
		'label' => 'Karten-Typ Auswahl',
		'options' => [
			'Deaktivieren' => 'false',
			'Aktivieren' => 'true',
		],
		'description' => 'Aktiviert das Karten-Typ-Panel',
		'value' => SDGoogleMaps::getMapValue('maptype'),
	],
	[
		'fieldtype' => SDGmap_fields::FIELD_TYPE_SELECT,
		'name' => $prefix.'fullscreen',
		'label' => 'Fullscreen',
		'options' => [
			'Deaktivieren' => 'false',
			'Aktivieren' => 'true',
		],
		'description' => 'Aktiviert die Möglichkeit die Karte Fullscreen anzuschauen',
		'value' => SDGoogleMaps::getMapValue('fullscreen'),
	],
];
?>
<div class="cpt-meta">
	<?php foreach ($fields as $field): ?>
		<?php SDGmap_fields::createField($field);?>
	<?php endforeach; ?>
</div>
