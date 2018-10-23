<div class="cpt-meta">
	<strong>Diese Karte kann auf einer beliebigen Seite oder Beitrag mit diesem Shortcode eingebunden werden.</strong>
	<div class="sd_shortcode_preview">
		[sd_gmap map_id="<?php the_ID(); ?>"]
	</div>
	<?php $mapId = get_the_ID(); ?>
	<?php echo do_shortcode('[sd_gmap map_id="' . $mapId . '"]'); ?>
</div>