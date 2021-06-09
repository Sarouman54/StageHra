	/* ******************************************	Création de la carte	********************************************* */

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

	/* ******************************************************************************************************************** */

	/* *******************************************	Actualisation de la carte	******************************************* */

AjaxCall();
var idInter = setInterval(AjaxCall, 10000);

function AjaxCall(){
	$.get(
		'/adminMap',
		'false', 
	    AddMap, 
		'json'
	)
}

	/* ******************************************************************************************************************** */

	/* *********************************************	Ajout des points	*********************************************** */

function AddMap(data) {

	if(map.getLayers().getLength() >= 2){
		for(let i = 1; i <= map.getLayers().getLength() ;i++)
			map.removeLayer(map.getLayers().item(i));
	}
	console.log(data)
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
};

	/* ********************************************************************************************************************** */

	/* *****************************************	Création fenêtre PopUp		********************************************* */

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
				console.log(data)
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

	/* *******************************************		Récupération des points		***************************************** */

function GetLayerEvent(feature){
	var layerMap = map.getLayers();
	for(let i=1 ; i < layerMap.getLength(); i++){
		var featureLayer = layerMap.item(i).getSource().getFeatures()[0];
		if(feature === featureLayer){return layerMap.item(i)}
	}
	return null;
}

	/* ********************************************************************************************************************** */