<?php
$prefix = SDGoogleMaps::PREFIX;
$fields = [
	[
		'fieldtype' => SDGmap_fields::FIELD_TYPE_SELECT,
		'name' => $prefix.'marker_animation',
		'label' => 'Soll die Markierung animiert werden?',
		'options' => [
			'Keine Animation' => '',
			'Bounce' => 'bounce',
			'Drop' => 'drop',
		],
		'value' => SDGoogleMaps::getMapValue('marker_animation'),
	],
	[
		'fieldtype' => SDGmap_fields::FIELD_TYPE_SELECT,
		'name' => $prefix.'marker_action',
		'label' => 'Was soll beim anklicken der Markierung passieren?',
		'options' => [
			'Keine Aktion' => 'none',
			'Verlinkung' => 'hyperlink',
			'Info Fenster' => 'infowindow',
		],
		'value' => SDGoogleMaps::getMapValue('marker_action'),
	],
	[
		'fieldtype' => SDGmap_fields::FIELD_TYPE_LINK,
		'name' => $prefix.'marker_link',
		'placeholder' => 'z.B. http://www.google.de/maps',
		'label' => 'Verlinkung',
		'button_value' => 'Verlinkung festlegen',
		'description' => 'Wird nur verwendet, wenn zuvor "Verlinkung" ausgewählt wurde.',
		'input_class' => 'button-secondary',
		'value' => SDGoogleMaps::getMapValue('marker_link'),
	],
	[
		'fieldtype' => SDGmap_fields::FIELD_TYPE_TEXTAREA,
		'name' => $prefix.'marker_infowindow_content',
		'label' => 'Information',
		'description' => 'Inhalt der in dem Info Fenster angezeigt wird.<br>Wird nur verwendet, wenn zuvor "Info Fenster" ausgewählt wurde.',
		'value' => SDGoogleMaps::getMapValue('marker_infowindow_content'),
	],
];
?>
<div class="cpt-meta">
	<?php foreach ($fields as $field): ?>
		<?php SDGmap_fields::createField($field);?>
	<?php endforeach; ?>
</div>