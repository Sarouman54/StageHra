	/* ******************************************	Création de la carte	******************************************* */
	
var currPath = [[2.33126104,48.93271121],[1.35, 44]]

var center = ol.proj.fromLonLat([2, 47]);

var map = new ol.Map({
    target: 'map',
    layers: [
    	new ol.layer.Tile({
        	source: new ol.source.OSM()
      	})
    ],
	controls: ol.control.defaults().extend([
		new ol.control.ScaleLine()
	]),
    view: new ol.View({
      center: center,
      zoom: 1
    })
});

	/* **************************************************************************************************************** */

	/* ************************************		Ajout && Animation des points	*************************************** */	
	/* 																													*/
	/* 								Création des variables nécessaire pour les points									*/
	/*										Création des fonctions d'animation											*/
	/* 																													*/
	/* **************************************************************************************************************** */

function AddMap(data) {
	
	if(map.getLayers().getLength() >= 2){
		for(let i = 1; i <= map.getLayers().getLength() ;i++)
			map.removeLayer(map.getLayers().item(i));
	}
	data.forEach((dataObject) => {
		var layer = new ol.layer.Vector({
			id: dataObject["idTruck"],
			heure: dataObject["heure"],
			minute: dataObject["minute"],
			seconde: dataObject["seconde"],			
			source: new ol.source.Vector({
				features: [
					new ol.Feature({
		  				geometry: new ol.geom.Point(ol.proj.fromLonLat([dataObject["longitude"], dataObject["latitude"]])),
					}),
				]
			})
		});
		map.addLayer(layer);
	})
	
	var polyline = new ol.format.Polyline({
	    factor: 1e6
	}).writeGeometry(new ol.geom.LineString(currPath));
	
	var polyline = polyline;
	
	var route = new ol.format.Polyline({
	  factor: 1e6,
	}).readGeometry(polyline, {
	  dataProjection: 'EPSG:4326',
	  featureProjection: 'EPSG:3857',
	});
	
	var routeFeature = new ol.Feature({
	  type: 'route',
	  geometry: route,
	});
	
	var geoMarker = new ol.Feature({
	  type: 'geoMarker',
	  geometry: new ol.geom.Point(route.getCoordinateAt(0)),
	});
	
	var startMarker = new ol.Feature({
	  type: 'icon',
	  geometry: new ol.geom.Point(route.getCoordinateAt(0)),
	});
	
	var endMarker = new ol.Feature({
	  type: 'icon',
	  geometry: new ol.geom.Point(route.getCoordinateAt(1)),
	});
	
	var styles = {
	  'route': new ol.style.Style({
	    stroke: new ol.style.Stroke({
	      width: 6,
	      color: [82, 175, 243, 1],
	    }),
	  }),
	
	  'geoMarker': new ol.style.Style({
	    image: new ol.style.Circle({
	      radius: 7,
	      fill: new ol.style.Fill({color: 'black'}),
	      stroke: new ol.style.Stroke({
	        color: 'white',
	        width: 2,
	      }),
	    }),
	  }),
	};
	
	var animating = false;
	
	var vectorLayer = new ol.layer.Vector({
	  source: new ol.source.Vector({
	    features: [routeFeature, geoMarker, startMarker, endMarker],
	  }),
	  style: function (feature) {
	    // masquer geoMarker si l'animation est active
	    if (animating && feature.get('type') === 'geoMarker') {
	      return null;
	    }
	    return styles[feature.get('type')];
	  },
	});
	
	map.addLayer(vectorLayer);
	
	var speed, startTime;
	var speedInput = document.getElementById('speed');
	var startButton = document.getElementById('start-animation');
	
	function moveFeature(event) {
	  var vectorContext = ol.render.getVectorContext(event);
	  var frameState = event.frameState;
	
	  if (animating) {
	    var elapsedTime = frameState.time - startTime;
	    var distance = (speed * elapsedTime) / 1e6;
	
	    if (distance >= 1) {
	      stopAnimation(true);
	      return;
	    }
	
	    var currentPoint = new ol.geom.Point(route.getCoordinateAt(distance));
	    var feature = new ol.Feature(currentPoint);
	    vectorContext.drawFeature(feature, styles.geoMarker);
	  }
	  // indique à OpenLayers de continuer l'animation de post-rendu
	  map.render();
	}
		
	function startAnimation() {
	  if (animating) {
	    stopAnimation(false);
	  } else {
	    animating = true;
	    startTime = new Date().getTime();
	    speed = speedInput.value;
	    startButton.textContent = 'Cancel Animation';
	    // masquer geoMarker
	    geoMarker.changed();
		// juste au cas où vous vous déplaceriez ailleurs
	    map.getView().setCenter(center);
	    vectorLayer.on('postrender', moveFeature);
	    map.render();
	  }
	}
	
	function stopAnimation(ended) {
	
	  animating = false;
	  startButton.textContent = 'Start Animation';
	
		// si l'animation est annulée place le marqueur au début
	  var coord = route.getCoordinateAt(ended ? 1 : 0);
	  geoMarker.getGeometry().setCoordinates(coord);
		// supprime l'écouteur
	  vectorLayer.un('postrender', moveFeature);
	}
	
	startButton.addEventListener('click', startAnimation, false);
		
};

	/* **************************************************************************************************************** */	
	/* *****************************************	Actualisation de la carte	*************************************** */

AjaxCall();
var idInter = setInterval(AjaxCall, 60000);

function AjaxCall(){
	$.get(
		'/adminMap',
		'false', 
	    AddMap, 
		'json'
	)
}

	/* **************************************************************************************************************** */
	/* *****************************************	Création fenêtre PopUp	******************************************* */

var container = document.getElementById('popup');
var content = document.getElementById('popup-content');
var closer = document.getElementById('popup-closer');

var overlay = new ol.Overlay({
	element: container,
	autoPan: true,
	autoPanAnimation: {
		duration: 250
	}
});
map.addOverlay(overlay);

closer.onclick = function(){
	overlay.setPosition(undefined);
	closer.blur();
	return false;
};

map.on('click', function(event){
	map.forEachFeatureAtPixel(event.pixel,
		function (feature){
			if(feature){
				var coordinate = event.coordinate;
				var idTruck = GetLayerEvent(feature).get("id")
				var heure = GetLayerEvent(feature).get("heure")
				var minute = GetLayerEvent(feature).get("minute")
				var seconde = GetLayerEvent(feature).get("seconde")
				var data = "idTruck="+ idTruck.toString();
				clearInterval(idInter)
				$.get(
					'/mapTruck',
					data, 
				    AddMap, 
					'json'
				)
				content.innerHTML = 'Camion' + idTruck.toString() + '<br> Heure: <br>' + heure.toString() + ' : ' + minute.toString() + ' : ' + seconde.toString();
				overlay.setPosition(coordinate);
			}
			else{
				overlay.setPosition(undefined);
				closer.blur();
			}
		}
	);
});

	/* ****************************************		Récupération des points		*************************************** */

function GetLayerEvent(feature){
	var layerMap = map.getLayers();
	for(let i=1 ; i < layerMap.getLength(); i++){
		var featureLayer = layerMap.item(i).getSource().getFeatures()[0];
		if(feature === featureLayer){return layerMap.item(i)}
	}
	return null;
}

	/* **************************************************************************************************************** */