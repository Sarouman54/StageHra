var map = new ol.Map({
    target: 'map',
    layers: [
    	new ol.layer.Tile({
        	source: new ol.source.OSM()
      	})
    ],
    view: new ol.View({
      center: ol.proj.fromLonLat([2, 47]),
      zoom: 5
    })
});

AjaxCall();
setInterval(AjaxCall, 10000);

function AjaxCall(){
	$.get(
		'/adminMap',
		'false', 
	    AddMap, 
		'json'
	)
}

function AddMap(data) {
	
	if(map.getLayers().getLength() >= 2){
		for(let i = 0; i+1 < map.getLayers().getLength() ; i++)
			map.removeLayer(map.getLayers().item(i+1));
	}
		
	data.forEach((coordinate) => {
		var layer = new ol.layer.Vector({					
			source: new ol.source.Vector({
				features: [
					new ol.Feature({
		  				geometry: new ol.geom.Point(ol.proj.fromLonLat([coordinate["longitude"], coordinate["latitude"]])),
					}),
				]
			})
		});
		map.addLayer(layer);
	})
};

