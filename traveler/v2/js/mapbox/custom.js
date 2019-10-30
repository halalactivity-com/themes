function initHalfMapBox(mapEl, mapData, mapLat, mapLng, mapZoom, mapIcon) {
    var popupPos = mapEl.data('popup-position');
    if (mapData.length <= 0)
        mapData = mapEl.data('data_show');
    if (mapLat.length <= 0)
        mapLat = mapEl.data('lat');
    if (mapLng.length <= 0)
        mapLng = mapEl.data('lng');
    if (mapZoom.length <= 0)
        mapZoom = mapEl.data('zoom');
    if (mapIcon.length <= 0)
        mapIcon = mapEl.data('icon');
    mapboxgl.accessToken = st_params.token_mapbox;

    var map = new mapboxgl.Map({
      container: 'map-search-form',
      style: 'mapbox://styles/mapbox/light-v10',
      center: [mapLng, mapLat],
      zoom: 6,
    });
    var listOfObjects = [];
    jQuery.map(mapData, function (location, i) {
        var item_map = InitItemmap(location,i);
        listOfObjects.push(item_map);
    });
    map.on("load", function() {
        map.loadImage("https://i.imgur.com/MK4NUzI.png", function(error, image) {
            if (error) throw error;
            map.addImage("custom-marker", image);
            /* Style layer: A style layer ties together the source and image and specifies how they are displayed on the map. */
            map.addLayer({
                id: "markers",
                type: "symbol",
                source: {
                    type: "geojson",
                    data: {
                        type: 'FeatureCollection',
                        features:listOfObjects
                    }
                },
                layout: {
                    "icon-image": "custom-marker",
                }
            });
        });
         map.on('click', 'markers', function (e) {
            map.flyTo({center: e.features[0].geometry.coordinates});
            var coordinates = e.features[0].geometry.coordinates.slice();
            var description = e.features[0].properties.description;
             
            // Ensure that if the map is zoomed out such that multiple
            // copies of the feature are visible, the popup appears
            // over the copy being pointed to.
            while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
            coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
            }
             
            new mapboxgl.Popup({ offset: [150,150] })
            .setLngLat(coordinates)
            .setHTML(description)
            .addTo(map);
        });
    });




    // var geojson = {
    //     type: 'FeatureCollection',
    //     features: listOfObjects
    // };


    // geojson.features.forEach(function(marker) {
    //     // create a HTML element for each feature
    //     var el = document.createElement('div');
    //     el.className = 'marker';
    //     // if (window.matchMedia("(min-width: 768px)").matches) {
    //     //     if (popupPos == 'right') {
    //     //         el.classList.add("right-box");
    //     //     }
    //     // }
    //     // jQuery(window).resize(function () {
    //     //     if (window.matchMedia("(min-width: 768px)").matches) {
    //     //         if (popupPos == 'right') {
    //     //             el.classList.add("right-box");
    //     //         }
    //     //     } else {
    //     //         el.classList.remove("right-box");
    //     //     }
    //     // });
    //     //el.innerHTML = source;

    //     // make a marker for each feature and add to the map
    //     // new mapboxgl.Marker(el)
    //     //   .setLngLat(marker.geometry.coordinates)
    //     //   .addTo(map);

    //      console.log(marker.geometry.coordinates[0]);
    //     new mapboxgl.Marker(el)
    //     .setLngLat(marker.geometry.coordinates)
    //     .setPopup(new mapboxgl.Popup({ offset: [150,150] }) // add popups
    //     .on('click', clickPoup)
    //     .setHTML(marker.properties.description))
    //     .addTo(map);

        

    // });
    
}
function InitItemmap(item_map,key){
    var singleObj = {};
    singleObj['type'] = 'Feature';
    singleObj['geometry'] = {
        type: 'Point',
        coordinates: [item_map.lng, item_map.lat]
    };
    singleObj['properties'] = {
        title: item_map.name,
        description: item_map.content_html
    };
    return singleObj;
    
}
function clickPoup(mapLng,mapLat) {
    var map = new mapboxgl.Map({
      container: 'map-search-form',
      style: 'mapbox://styles/mapbox/light-v10',
      center: [mapLng, mapLat],
      zoom: 6,
    });
}
