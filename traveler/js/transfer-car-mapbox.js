$('.transfer-mapbox').each(function () {
	var t                 = $(this);
    var content_map       = $(".transfer-map-content", t).get(0);
    var content_map       = $(".transfer-map-content", t).get(0);
    var latlng            = {lng: 0, lng: 0};
    var zoom = 10;
    var center = latlng;
    mapboxgl.accessToken = st_params.token_mapbox;
    var map = new mapboxgl.Map({
		container: 'transfer-map-content', // container id
		style: 'mapbox://styles/mapbox/streets-v11', //stylesheet location
		center: latlng, // starting position
		zoom: 12, // starting zoom
	});
});