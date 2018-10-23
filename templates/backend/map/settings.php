<?php
$prefix = SDGoogleMaps::PREFIX;
$fields = [
	[
		'fieldtype' => SDGmap_fields::FIELD_TYPE_INPUT,
		'type' => 'text',
		'name' => $prefix.'width',
		'placeholder' => 'z.B. 100% oder 500px',
		'label' => 'Breite der Karte',
		'description' => 'Breitenangabe in Prozent oder Pixel.<br>Standardwert: 100%',
		'class' => '',
		'value' => SDGoogleMaps::getMapValue('width'),
	],
	[
		'fieldtype' => SDGmap_fields::FIELD_TYPE_INPUT,
		'type' => 'text',
		'name' => $prefix.'height',
		'placeholder' => 'z.B. 500px',
		'label' => 'Höhe der Karte',
		'description' => 'Höhenangabe in Pixel.<br>Standardwert: 300px',
		'description_class' => 'distance-bottom',
		'value' => SDGoogleMaps::getMapValue('height'),
	],
	[
		'fieldtype' => SDGmap_fields::FIELD_TYPE_INPUT,
		'type' => 'text',
		'name' => $prefix.'map_center',
		'placeholder' => 'z.B. 51.3396955,12.3730747',
		'label' => 'Kartenzentrum',
		'description' => 'Mittelpunkt der Karte mit kommaseparierten Höhen- und Breitengrad. Höhen- und Breitengrad kann bspw. auf <a href="http://www.mapcoordinates.net/en">mapcoordinates.net</a> ermittelt werden.<br>Standardwert: 51.3396955,12.3730747 (Leipzig)',
		'value' => SDGoogleMaps::getMapValue('map_center'),
	],
	[
		'fieldtype' => SDGmap_fields::FIELD_TYPE_INPUT,
		'type' => 'text',
		'name' => $prefix.'zoom',
		'placeholder' => 'z.B. 10',
		'label' => 'Zoomfaktor',
		'description' => 'Vergrößerung der Karte. Von 0 bis 21.<br>Standardwert: 13',
		'value' => SDGoogleMaps::getMapValue('zoom'),
	],
	[
		'fieldtype' => SDGmap_fields::FIELD_TYPE_ATTACHMENT,
		'upload_value'      => 'Style hochladen',
		'upload_name'		=> 'upload',
		'name' => $prefix.'style',
		'value' => SDGoogleMaps::getMapValue('style'),
	],
];
?>
<div class="cpt-meta">
	<?php foreach ($fields as $field): ?>
		<?php SDGmap_fields::createField($field);?>
	<?php endforeach; ?>
</div>