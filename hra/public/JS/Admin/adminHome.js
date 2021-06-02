var map = new ol.Map({
    target: 'map',
    layers: [
    	new ol.layer.Tile({
        	source: new ol.source.OSM()
      	})
    ],
    view: new ol.View({
      center: ol.proj.fromLonLat([2, 47]),
      zoom: 1
    })
});

$.get(
	'/adminMap',
	'false',
	AddMap,
	'json'
);

function AddMap(data){
	data.forEach((coordinate) => {
		var layer = new ol.layer.Vector({
			source: new ol.source.Vector({
				features: [
					new ol.Feature({
						geometry: new ol.geom.Point(ol.proj.fromLonLat([coordinate["longitude"], coordinate["latitude"]]))
            		}),
        		]
			})		
		});
		map.addLayer(layer);
	})
};



