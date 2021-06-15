/* **************************************** Initialization of variables ***************************************** */

//-------------------- Marker's Interaction Style ------------------//
var interaction = ol.interaction.defaults().extend([
	new ol.interaction.Select({
		
		//-------------------------- Marker Style --------------------------//
		style: new ol.style.Style({
			image: new ol.style.Circle({
				radius: 5, // Marker's Size
               	fill: new ol.style.Fill({color: '#FF0000'}), // Marker's Fill Color(blue)
               	stroke: new ol.style.Stroke({color: '#FFFFFF'}) // Marker's Stroke Color(white)
			})
		})
		//------------------------------------------------------------------//
	})
]);
//------------------------------------------------------------------//

//------------------------ Add First Layer -------------------------//
var layer = new ol.layer.Tile({
	source: new ol.source.OSM(), // Type of Map
});
//------------------------------------------------------------------//

//----------------------- Add Controls Item ------------------------//
var screen = new ol.control.FullScreen(); //FullScreen Item
var scale = new ol.control.ScaleLine(); //Scale Item
//------------------------------------------------------------------//

//--------------------- Location After Refresh ---------------------//
var center = ol.proj.fromLonLat([2, 47]);

var view = new ol.View({   
	center: center,
	zoom: 3,
});
//------------------------------------------------------------------//

/* ************************************************************************************************************** */
/* ********************************************* Creation of Map ************************************************ */

var map = new ol.Map({
	interactions: interaction,
	target: 'map',
	controls: [screen, scale],
	view: view,
	layers: [layer]
});

/* ************************************************************************************************************** */
/* ************************************************ Add Layers ************************************************** */

function AddMap(data) {

	//---------------------- Remove Marker's Layer ---------------------//
	if(map.getLayers().getLength() >= 1){
		for(let i = 1; i < map.getLayers().getLength(); i++){
			map.removeLayer(map.getLayers().item(i));
		}
	}
	//------------------------------------------------------------------//
	
	data.forEach((dataObject) => {
		var layer = new ol.layer.Vector({

			//------------------------ Get Data from BDD -----------------------//
			id: dataObject["idTruck"],
			hours: dataObject["hours"],
			minutes: dataObject["minutes"],
			seconds: dataObject["seconds"],
			//------------------------------------------------------------------//
			
			//------------------------- Marker Location ------------------------//
			source: new ol.source.Vector({
				features: [
					new ol.Feature({
		  				geometry: new ol.geom.Point(ol.proj.fromLonLat([dataObject["longitude"], dataObject["latitude"]]))
					}),
				]
			}),
			//------------------------------------------------------------------//
			
			//-------------------------- Marker Style --------------------------//
			style: new ol.style.Style({
				image: new ol.style.Circle({
       				radius: 5,
       				fill: new ol.style.Fill({color: '#46729c'}), // Marker's Fill Color(nightblue)
       				stroke: new ol.style.Stroke({color: '#FFFFFF'}) // Marker's Stroke Color(white)
     			})
   			})
			//------------------------------------------------------------------//
			
		});
		map.addLayer(layer);
		
		var currPath = [[2,47], [2,50], [2,53], [2,56]]; // Road's Coordinates
		
		var polyline = new ol.format.Polyline({
			factor: 1e6
		}).writeGeometry(new ol.geom.LineString(currPath));
		
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
			
			//-------------------------- Road's Style --------------------------//
			'route': new ol.style.Style({
				stroke: new ol.style.Stroke({
					width: 3, //Road's Size
					color: [82, 175, 243, 1], // Road's Color(bluesky)
				}),
			}),
			//------------------------------------------------------------------//

			//---------------------- Marker on Road Style ----------------------//
			'geoMarker': new ol.style.Style({
				image: new ol.style.Circle({
					radius: 5, //Marker Size
					fill: new ol.style.Fill({color: '#000000'}), // Marker Fill Color(dark)
					stroke: new ol.style.Stroke({
						color: '#FFFFFF', // Marker Stroke Color(white)
					}),
				}),
			}),
			//------------------------------------------------------------------//	
		};
		
		var animating = false;
		
		var vectorLayer = new ol.layer.Vector({
			source: new ol.source.Vector({
				features: [routeFeature, geoMarker, startMarker, endMarker],
			}),
			style: function (feature) {
				if (animating && feature.get('type') === 'geoMarker') {
					return null;
				}
				return styles[feature.get('type')];
			},
		});
		map.addLayer(vectorLayer);
		
		var speed, startTime;
		var speedInput = document.getElementById('speed');
		var startButton = document.getElementById('start-animation'); //Get Id of AdminHome.html.twig
		//------------------------------------------------------------------//

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
		map.render();
		}

		//------------------------- Start Animation ------------------------//
		function startAnimation() {
			if (animating) {
				stopAnimation(false);
			} 
			else {
				animating = true;
				startTime = new Date().getTime();
				speed = speedInput.value;
				startButton.textContent = 'Cancel Animation';
				geoMarker.changed();
				map.getView().setCenter(center);
				vectorLayer.on('postrender', moveFeature);
				map.render();
			}
		}
		//------------------------------------------------------------------//
		
		//-------------------------- Stop Animation ------------------------//
		function stopAnimation(ended) {
			animating = false;
			startButton.textContent = 'Start Animation';
		
			// if animation cancelled set the marker at the beginning
			var coord = route.getCoordinateAt(ended ? 1 : 0);
			geoMarker.getGeometry().setCoordinates(coord);
			vectorLayer.un('postrender', moveFeature);
		}
		
		startButton.addEventListener('click', startAnimation, false);
		//------------------------------------------------------------------//
	})
};

/* ************************************************************************************************************** */
/* ************************************************ Update Map ************************************************** */

AjaxCall();
var idInter = setInterval(AjaxCall, 30000); //Set Interval 3s Between Each Call

function AjaxCall(){
	$.get(
		'/admin/map',	//Get URL
		'false', 		//
	    AddMap, 		//Call Function
		'json'			//Type of File
	)
}

/* ************************************************************************************************************** */
/* ****************************************** Creation of Popup(s) ********************************************** */

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
				clearInterval(idInter)
				var coordinate = event.coordinate;
				
				//----------------------- Get Data From AddMap ---------------------//
				var idTruck = GetLayerEvent(feature).get("id");
				var hoursTruck = GetLayerEvent(feature).get("hours");
				var minutesTruck = GetLayerEvent(feature).get("minutes");
				var secondsTruck = GetLayerEvent(feature).get("seconds");				
				var data = "idTruck="+ idTruck.toString();
				//------------------------------------------------------------------//
				
				$.get(
					'/admin/map/truck',		//Get URL
					data, 					//
				    AddMap, 				//Call Function
					'json'					//Type of File
				)
				
				//-------------------------- Popup's Content -----------------------//
				content.innerHTML = 'Camion : n°' + idTruck.toString() + '<br>Heure : ' + hoursTruck.toString() + 'h' + minutesTruck.toString() + 'min' + secondsTruck.toString() + 's';
				//------------------------------------------------------------------//
				
				overlay.setPosition(coordinate);
			}
			else{
				overlay.setPosition(undefined);
				closer.blur();
			}
		}
	);
});

/* ************************************************************************************************************** */
/* ********************************************* Get item Layer ************************************************* */

function GetLayerEvent(feature){
	var layerMap = map.getLayers();
	for(let i=1 ; i < layerMap.getLength(); i++){
		var featureLayer = layerMap.item(i).getSource().getFeatures()[0];
		if(feature === featureLayer){return layerMap.item(i)}
	}
	return null;
}

/* ************************************************************************************************************** */