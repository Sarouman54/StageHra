/* ********************************************* Creation of Map ************************************************ */

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
      center: ol.proj.fromLonLat([2, 47]),
      zoom: 1
    })
});
/* ******************************************************************************************************************* */


/* ************************************************** Add Layers ***************************************************** */

function AddMap(data) {
	if(map.getLayers().getLength() >= 1){
		for(let i = 1; i < map.getLayers().getLength(); i++){
			map.removeLayer(map.getLayers().item(i));
		}
	}
	
	data.forEach((dataObject) => {
		var layer = new ol.layer.Vector({
			id: dataObject["idTruck"],
			hours: dataObject["hours"],		
			minutes: dataObject["minutes"],
			seconds: dataObject["seconds"],
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
};
/* ******************************************************************************************************************* */


/* ************************************************** Update Map ***************************************************** */

function AjaxCall(){
	$.get(
		'/admin/map',
		'false', 
	    AddMap, 
		'json'
	)
}

AjaxCall();
var idInter = setInterval(AjaxCall, 7000);
/* ******************************************************************************************************************* */


/* ********************************************* Creation of Popup(s) ************************************************ */

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
				var idTruck = GetLayerEvent(feature).get("id");
				var hoursTruck = GetLayerEvent(feature).get("hours");
				var minutesTruck = GetLayerEvent(feature).get("minutes");
				var secondsTruck = GetLayerEvent(feature).get("seconds");
				var data = "idTruck="+ idTruck.toString();
				$.get(
					'/admin/map/truck',
					data, 
				    AddMap, 
					'json'
				)
				content.innerHTML = 'Camion : n°' + idTruck.toString() + '<br>Heure : ' + hoursTruck.toString() + 'h' + minutesTruck.toString() + 'min' + secondsTruck.toString() + 's';
				overlay.setPosition(coordinate);
			}
			else{
				overlay.setPosition(undefined);
				closer.blur();
			}
		}
	);
});
/* ******************************************************************************************************************* */


/* ************************************************ Get item Layer *************************************************** */

function GetLayerEvent(feature){
	var layerMap = map.getLayers();
	for(let i=1 ; i < layerMap.getLength(); i++){
		var featureLayer = layerMap.item(i).getSource().getFeatures()[0];
		if(feature === featureLayer){return layerMap.item(i)}
	}
	return null;
}
/* ******************************************************************************************************************* */