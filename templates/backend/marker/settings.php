<?php
$prefix = SDGoogleMaps::PREFIX;
$maps = SDGoogleMaps::getMaps();
$mapOptions =[
	'none' => '0',
];
foreach($maps as $map){
	$mapOptions[$map->post_title] = $map->ID;
}

$fields = [
	[
		'fieldtype' => SDGmap_fields::FIELD_TYPE_SELECT,
		'name' => $prefix.'marker_related_map',
		'label' => 'Karte',
		'options' => $mapOptions,
		'description' => 'Auf Welcher Karte soll diese Markierung eingfügt werden?',
		'value' => SDGoogleMaps::getMapValue('marker_related_map'),
	],
	[
		'fieldtype' => SDGmap_fields::FIELD_TYPE_INPUT,
		'type' => 'text',
		'name' => $prefix.'marker_position',
		'placeholder' => 'z.B. 51.3396955,12.3730747',
		'label' => 'Position der Markierung',
		'description' => 'Geokoordinaten der Markierung mit kommaseparierten Höhen- und Breitengrad. Höhen- und Breitengrad kann bspw. auf <a href="http://www.mapcoordinates.net/en">mapcoordinates.net</a> ermittelt werden.<br>Standardwert: 51.3396955,12.3730747 (Leipzig)',
		'value' => SDGoogleMaps::getMapValue('marker_position'),
	],
	[
		'fieldtype' => SDGmap_fields::FIELD_TYPE_INPUT,
		'type' => 'text',
		'name' => $prefix.'marker_image_size',
		'placeholder' => 'z.B. 32,32',
		'label' => 'Größe des Bildes der Markierung',
		'description' => 'Kommaseparierte Größe in Pixel.',
		'value' => SDGoogleMaps::getMapValue('marker_image_size'),
	],
];
?>
<div class="cpt-meta">
	<?php foreach ($fields as $field): ?>
		<?php SDGmap_fields::createField($field);?>
	<?php endforeach; ?>
</div>