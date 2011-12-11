<?php
/**
 * Esta pagina es el servicio de Rosario al toque: Que hay al toque
 */
	wp_enqueue_script('OpenLayers', get_template_directory_uri().'/OpenLayers.js');
	wp_enqueue_script('RosarioAlToque', get_template_directory_uri().'/rosario-al-toque.js');
	get_header();
?>
<div id="container">
	<div id="content-que-hay-al-toque" class="content-que-hay-al-toque-achicado">
		<div class="page-title">
			<div id="page-title-caption">Qu&eacute; hay al toque?</div>
			<div id="boton-full-screen"><a href=javascript:ampliarMapa()><img src="<?php get_template_directory_uri()?>/images/key-fullscreen.png"></a></div>
		</div><!-- #page-title -->
		<?php echo getDivCapasMapa("capas-que-hay-al-toque") ?>
		<div id="mapaPageQueHayAlToque"></div>
		<script>
			function ampliarMapa() {
				if (jQuery("#content-que-hay-al-toque").hasClass('content-que-hay-al-toque-agrandado')) {
					jQuery("#content-que-hay-al-toque").removeClass("content-que-hay-al-toque-agrandado").addClass("content-que-hay-al-toque-achicado");
				} else {
					jQuery("#content-que-hay-al-toque").removeClass("content-que-hay-al-toque-achicado").addClass("content-que-hay-al-toque-agrandado");
				}
			}
			function getCapaBySlug(slugCapa) {
				var capa;
				jQuery.each(arregloCapaMapa, function() {
					if (this['slug'] == slugCapa) {
						capa = this;
					}
				});
				return capa;
			}
			function mostrarCapa(slugCapa) {
				capa = getCapaBySlug(slugCapa);
				cb = jQuery('#cb_' + slugCapa);
				if (cb.is(':checked')) {
					if (capa['URLFeed']) {
						var yelp = new OpenLayers.Icon("<?php get_template_directory_uri()?>/images/marker-mapa-rosario-al-toque.png", new OpenLayers.Size(22,22));
						var newl = new OpenLayers.Layer.GeoRSS( capa['slug'], capa['URLFeed'], {'icon':yelp, useFeedTitle: false, 'slug' : capa['slug']});
						map.addLayer(newl);
					}
				} else {
					var layerABorrar = map.getLayersBy('slug', slugCapa);
					if(layerABorrar.length > 0){
						map.removeLayer(layerABorrar[0]);
					}
				}
				jQuery.each(capa.slugHijos, function() {
					capaHija = getCapaBySlug(this);
					cbHijo = jQuery('#cb_' + this);
					cbHijo.attr('checked', cb.is(':checked'));
					mostrarCapa(this)
				});
			}
			function mostrarNodo(slugCapa) {
				capa = getCapaBySlug(slugCapa);
				img = jQuery('#img' + slugCapa);
				individuoCapaMapa = img.parent().parent().parent();
				familiaresCapaMapa = individuoCapaMapa.next();
				if (img.attr('src') == '<?php get_template_directory_uri()?>/images/nodo-capa-mapa-expandido.png') {
					img.attr('src', '<?php get_template_directory_uri()?>/images/nodo-capa-mapa-contraido.png');
					familiaresCapaMapa.css('position', 'absolute');
					familiaresCapaMapa.css('visibility', 'hidden');
				} else {
					img.attr('src', '<?php get_template_directory_uri()?>/images/nodo-capa-mapa-expandido.png');
					familiaresCapaMapa.css('position', 'relative');
					familiaresCapaMapa.css('visibility', 'visible');
				}
			}
		</script>
		<script>var map = getMapaRosarioAlToque("mapaPageQueHayAlToque")</script>
		<script>
			jQuery.each(arregloCapaMapa, function() {
				if (this['URLFeed']) {
					var yelp = new OpenLayers.Icon("<?php get_template_directory_uri()?>/images/marker-mapa-rosario-al-toque.png", new OpenLayers.Size(22,22));
					var newl = new OpenLayers.Layer.GeoRSS( this['slug'], this['URLFeed'], {'icon':yelp, 'slug' : this['slug']});
					map.addLayer(newl);
				}
			});
		</script>
	</div><!--#content-que-hay-al-toque-->
	<div id="rat-cont-servicios"><?php echo servdig_directory_shortcode("") ?></div><!-- #rat-cont-servicios -->
</div><!-- #container -->
<?php get_footer(); ?>
