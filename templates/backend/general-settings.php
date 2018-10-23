<?php
$prefix = SDGoogleMaps::PREFIX;
$fields = [
	[
		'fieldtype' => 'input',
		'type' => 'text',
		'name' => $prefix.'apikey',
		'placeholder' => 'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
		'value' => SDGoogleMaps::getGeneralSettingValue('apikey'),
	],
	[
		'fieldtype' => 'select',
		'name' => $prefix.'map_output',
		'options' => [
			'nur mit Shortcode' => 'shortcode',
			'Auswahl auf Seiten und Beiträgen' => 'page',
		],
		'value' => SDGoogleMaps::getGeneralSettingValue('map_output'),
	],
];
?>
<div class="wrap cpt-meta">
	<form action="admin.php?page=sd_gmaps_generalsettings" method="POST">
		<h1>Allgemeine Einstellungen</h1>
		<h3 class="sd_heading">Google Maps API</h3>
		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row"><label for="blogname">Google Maps API Key</label></th>
					<td><?php SDGmap_fields::createField($fields[0]);?></td>
				</tr>
			</tbody>
		</table>
		<p class="submit">
			<input type="submit" value="Speichern" class="button button-primary" id="submit" name="<?php echo SDGoogleMaps::PREFIX;?>generalsettings_submit">
		</p>
	</form>
</div>