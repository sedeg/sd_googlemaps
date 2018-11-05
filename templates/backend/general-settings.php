<?php
$prefix = SDGoogleMaps::PREFIX;
$fields = [
	[
		'fieldtype' => 'input',
		'type' => 'text',
		'name' => SDGoogleMaps::META_KEY_GMAP_SETTING_API,
		'placeholder' => 'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
		'value' => SDGoogleMaps::getGeneralSettingValue(SDGoogleMaps::META_KEY_GMAP_SETTING_API),
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
					<td><?php SDGmapFields::createField($fields[0]);?></td>
				</tr>
			</tbody>
		</table>
		<p class="submit">
			<input type="submit" value="Speichern" class="button button-primary" id="submit" name="<?php echo SDGoogleMaps::META_KEY_GMAP_SETTING_SUBMIT;?>">
		</p>
	</form>
</div>