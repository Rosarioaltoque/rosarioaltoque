function centraMapaLocacionRosario(map) {
	centrarMapaSinLocacionRosario(map);
	if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(
			function(position) {  
				if (position.coords.latitude == -32.950741 && position.coords.longitude == -60.6665) {
					centrarMapaSinLocacionRosario(map);
//					alert("Proveedor desconocido no provee su ubicacion");
				} else if (position.coords.latitude == -32.950741 && position.coords.longitude == -60.66649999999999) {
					centrarMapaSinLocacionRosario(map);
//					alert("Fibertel no provee su ubicacion");
				} else if (position.coords.latitude > -32.861132 || position.coords.latitude < -33.031981 || position.coords.longitude < -60.78495 || position.coords.longitude > -60.594406) {
//					alert("Usted se encuentra fuera de Rosario (" + position.coords.latitude + ")");
//					map.setCenter(new OpenLayers.LonLat(-60.647235, -32.949443), 16); //centro comercial cerca
					centrarMapaSinLocacionRosario(map);
				} else {
					map.setCenter(new OpenLayers.LonLat(position.coords.longitude, position.coords.latitude), 16);
//					alert('Usted se encuentra en Rosario (' + position.coords.latitude + ' ' + position.coords.longitude + ').');
				}
			}
			,function() {
//				alert('no funciono');
				centrarMapaSinLocacionRosario(map);
			}
		);
	} else {
		centrarMapaSinLocacionRosario(map);
//		alert('Su navegador no soporta geolocacion.');
	}
}
function centrarMapaSinLocacionRosario(map) {
	map.setCenter(new OpenLayers.LonLat(-60.675774, -32.947606), 14); //todo rosario lejos
}
function getMapaRosarioAlToque(idDivMapa) {
						var options = {
							numZoomLevels: 25
							,allOverlays: true
						}
						var map = new OpenLayers.Map(idDivMapa, options);
						
/*						var wms_santafe = new OpenLayers.Layer.WMS(
							"IDESF",
							"http://www.idesf.santafe.gov.ar/cgi-bin/idesf",
							{layers: "departamentos,limite_provincial,manzanasipec,localidades_point,ejesipec,rutas_nacionales,rutas_sec"}
						);
						map.addLayer(wms_santafe);*/

						var wms_rosario = new OpenLayers.Layer.WMS(
							"Infomapa Rosario"
							,"http://www.rosario.gov.ar/wms/planobase"
							,{layers: "av_circunvalacion,manzanas,manzanas_no_regularizada,espacios_verdes,hidrografia,avenidas_y_boulevares,segmentos_de_calle,sentidos_de_calle,via_ferroviaria,islas_del_parana,bancos_de_arena,autopistas,nombres_de_calles,numeracion_de_calles,limite_municipio"}
//							,{layers: "sin_manzanas,canteros,av_circunvalacion,manzanas,manzanas_no_regularizada,parcelas,espacios_verdes,hidrografia,avenidas_y_boulevares,segmentos_de_calle,sentidos_de_calle,via_ferroviaria,islas_del_parana,bancos_de_arena,autopistas,nombres_de_calles,numeracion_de_calles,numeros_de_manzana,limite_municipio,puentes"}
							,{transitionEffect: 'resize'}

						);
						map.addLayer(wms_rosario);
						
//						map.setCenter(new OpenLayers.LonLat(-60.665817, -32.949911), 15);
//						map.setCenter(new OpenLayers.LonLat(0, 0), 15);
						map.addControl(new OpenLayers.Control.LayerSwitcher());
						
						centraMapaLocacionRosario(map);
						return map;
}

	
function centraMapaLocacionRosariogeolocation(map) {
	var style = {
		fillColor: '#000',
		fillOpacity: 0.1,
		strokeWidth: 0
	};

/*var map = new OpenLayers.Map('map');
var layer = new OpenLayers.Layer.OSM( "Simple OSM Map");
var vector = new OpenLayers.Layer.Vector('vector');
map.addLayers([layer, vector]);*/

/*map.setCenter(
    new OpenLayers.LonLat(-71.147, 42.472).transform(
        new OpenLayers.Projection("EPSG:4326"),
        map.getProjectionObject()
    ), 12
);*/

	var pulsate = function(feature) {
		var point = feature.geometry.getCentroid(),
			bounds = feature.geometry.getBounds(),
			radius = Math.abs((bounds.right - bounds.left)/2),
			count = 0,
			grow = 'up';

		var resize = function(){
			if (count>16) {
				clearInterval(window.resizeInterval);
			}
			var interval = radius * 0.03;
			var ratio = interval/radius;
			switch(count) {
				case 4:
				case 12:
					grow = 'down'; break;
				case 8:
					grow = 'up'; break;
			}
			if (grow!=='up') {
				ratio = - Math.abs(ratio);
			}
			feature.geometry.resize(1+ratio, point);
			//vector.drawFeature(feature);
			count++;
		};
		window.resizeInterval = window.setInterval(resize, 50, point, radius);
	};

	var geolocate = new OpenLayers.Control.Geolocate({
		bind: false,
		geolocationOptions: {
			enableHighAccuracy: false,
			maximumAge: 0,
			timeout: 7000
		}
	});

	map.addControl(geolocate);
	var firstGeolocation = true;
	geolocate.events.register("locationupdated",geolocate,function(e) {
    //vector.removeAllFeatures();
/*    var circle = new OpenLayers.Feature.Vector(
        OpenLayers.Geometry.Polygon.createRegularPolygon(
            new OpenLayers.Geometry.Point(e.point.x, e.point.y),
            e.position.coords.accuracy/2,
            40,
            0
        ),
        {},
        style
    );*/
/*    vector.addFeatures([
        new OpenLayers.Feature.Vector(
            e.point,
            {},
            {
                graphicName: 'cross',
                strokeColor: '#f00',
                strokeWidth: 2,
                fillOpacity: 0,
                pointRadius: 10
            }
        ),
        circle
    ]);*/
		if (firstGeolocation) {
			//map.zoomToExtent(vector.getDataExtent());
			//pulsate(circle);
			firstGeolocation = false;
			this.bind = true;
		}
	});
	geolocate.events.register("locationfailed",this,function() {
		OpenLayers.Console.log('Location detection failed');
	});

//    vector.removeAllFeatures();
    geolocate.deactivate();
	geolocate.watch = true;
	firstGeolocation = true;
	geolocate.activate();
}