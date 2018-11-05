<?php
$prefix = SDGmapMarkerPostType::PREFIX;
$fields = [
	[
		'fieldtype' => SDGmapFields::FIELD_TYPE_SELECT,
		'name' => SDGmapMarkerPostType::META_KEY_GMARKER_ANIMATION,
		'label' => 'Soll die Markierung animiert werden?',
		'options' => [
			'Keine Animation' => '',
			'Bounce' => 'bounce',
			'Drop' => 'drop',
		],
		'value' => SDGmapMarkerPostType::getMarkerValue(SDGmapMarkerPostType::META_KEY_GMARKER_ANIMATION),
	],
	[
		'fieldtype' => SDGmapFields::FIELD_TYPE_SELECT,
		'name' => SDGmapMarkerPostType::META_KEY_GMARKER_ACTION,
		'label' => 'Was soll beim anklicken der Markierung passieren?',
		'options' => [
			'Keine Aktion' => 'none',
			'Verlinkung' => 'hyperlink',
			'Info Fenster' => 'infowindow',
		],
		'value' => SDGmapMarkerPostType::getMarkerValue(SDGmapMarkerPostType::META_KEY_GMARKER_ACTION),
	],
	[
		'fieldtype' => SDGmapFields::FIELD_TYPE_LINK,
		'name' => SDGmapMarkerPostType::META_KEY_GMARKER_LINK,
		'placeholder' => 'z.B. http://www.google.de/maps',
		'label' => 'Verlinkung',
		'button_value' => 'Verlinkung festlegen',
		'description' => 'Wird nur verwendet, wenn zuvor "Verlinkung" ausgewählt wurde.',
		'input_class' => 'button-secondary',
		'value' => SDGmapMarkerPostType::getMarkerValue(SDGmapMarkerPostType::META_KEY_GMARKER_LINK),
	],
	[
		'fieldtype' => SDGmapFields::FIELD_TYPE_TEXTAREA,
		'name' => SDGmapMarkerPostType::META_KEY_GMARKER_INFOWINDOW_CONTENT,
		'label' => 'Information',
		'rows' => 10,
		'description' => 'Inhalt der in dem Info Fenster angezeigt wird.<br>Wird nur verwendet, wenn zuvor "Info Fenster" ausgewählt wurde.',
		'value' => SDGmapMarkerPostType::getMarkerValue(SDGmapMarkerPostType::META_KEY_GMARKER_INFOWINDOW_CONTENT),
	],
];
?>
<div class="cpt-meta">
	<?php foreach ($fields as $field): ?>
		<?php SDGmapFields::createField($field);?>
	<?php endforeach; ?>
</div>