<?php
$prefix = SDGmapMarkerPostType::PREFIX;
$maps = SDGmapMapPostType::getMaps();
$mapOptions =[
	'none' => '0',
];
foreach($maps as $map){
	$mapOptions[$map->post_title] = $map->ID;
}

$fields = [
	[
		'fieldtype' => SDGmapFields::FIELD_TYPE_SELECT,
		'name' => SDGmapMarkerPostType::META_KEY_GMARKER_RELATED_MAP,
		'label' => 'Karte',
		'options' => $mapOptions,
		'description' => 'Auf Welcher Karte soll diese Markierung eingfügt werden?',
		'value' => SDGmapMarkerPostType::getMarkerValue(SDGmapMarkerPostType::META_KEY_GMARKER_RELATED_MAP),
	],
	[
		'fieldtype' => SDGmapFields::FIELD_TYPE_INPUT,
		'type' => 'text',
		'name' => SDGmapMarkerPostType::META_KEY_GMARKER_POSITION,
		'placeholder' => 'z.B. 51.3396955,12.3730747',
		'label' => 'Position der Markierung',
		'description' => 'Geokoordinaten der Markierung mit kommaseparierten Höhen- und Breitengrad. Höhen- und Breitengrad kann bspw. auf <a href="http://www.mapcoordinates.net/en">mapcoordinates.net</a> ermittelt werden.<br>Standardwert: 51.3396955,12.3730747 (Leipzig)',
		'value' => SDGmapMarkerPostType::getMarkerValue(SDGmapMarkerPostType::META_KEY_GMARKER_POSITION),
	],
	[
		'fieldtype' => SDGmapFields::FIELD_TYPE_INPUT,
		'type' => 'text',
		'name' => SDGmapMarkerPostType::META_KEY_GMARKER_IMAGESIZE,
		'placeholder' => 'z.B. 32,32',
		'label' => 'Größe des Bildes der Markierung',
		'description' => 'Kommaseparierte Größe in Pixel.',
		'value' => SDGmapMarkerPostType::getMarkerValue(SDGmapMarkerPostType::META_KEY_GMARKER_IMAGESIZE),
	],
];
?>
<div class="cpt-meta">
	<?php foreach ($fields as $field): ?>
		<?php SDGmapFields::createField($field);?>
	<?php endforeach; ?>
</div>