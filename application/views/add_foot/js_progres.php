<!-- Data Table -->
<script>
  $(function () {
    $("#tabel-progres").DataTable();
    // $('#example2').DataTable({
    //   "paging": true,
    //   "lengthChange": false,
    //   "searching": false,
    //   "ordering": true,
    //   "info": true,
    //   "autoWidth": false
    // });
});
</script>

<!-- leaflet -->
<?php if(!empty($location)): ?>
    <script src="<?= base_url() ?>plugins/leaflet/leaflet.js"></script>
    <script>

        var map = L.map('mapid').setView([-6.21462, 106.84513], 13);

        var mapboxAccessToken = 'pk.eyJ1IjoiaGFraW1pcnphIiwiYSI6ImNqNWNsaXZ6NTBiYnkyd3A4bGM1NWg2eWcifQ.K2V45-g_Jw3gi6bgRpimRw';

        // Menambahkan peta osm
        L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=' + mapboxAccessToken, {
            id: 'mapbox.light',
            attribution: ''
        }).addTo(map);

        var file;
        var geojson;

        var lokus = <?php print_r(json_encode($forTable)) ?>;
        var n = lokus[0].id.toString().length;

        function fileUrl(n){

            return n == 2 ? 'prov.js' :
            n == 4 ? 'kab.js' :
            n == 7 ? 'kec.js' :
            n == 10? 'des.js' :
            '';
        }

        $.ajax({
            url: '<?= base_url() ?>dist/map/' + fileUrl(n),
            dataType: 'json',
            success: function(data) {

                file = data;
                geojson = L.geoJson(file, {
                    onEachFeature: onEachFeature,
                    filter: filterID,
                    style: style
                });

                geojson.addTo(map);

                // initial zoom to all features
                map.fitBounds(geojson.getBounds());
            },
            error: function() {

                console.log('There was a problem with the request.');
            }
        });

    function filterID(feature, layer) { //return true akan menampilkan fitur pada map
        if (feature.properties) { //punya properti ? 

            for (var i = 0; i < lokus.length; i++) {

             properti = n == 2 ? feature.properties.id2013 : 
                        n == 4 ? feature.properties.ID2014_2 :
                        n == 7 ? feature.properties.IDKEC :
                                feature.properties.IDSP2010;

             if (properti == lokus[i].id) {

                var obj = lokus[i];
                feature.properties.show_on_map = true;
                feature.properties.nama = obj.nama;
                feature.properties.input = obj.count;
                feature.properties.target = obj.target;
                feature.properties.progres = Math.round(obj.count/obj.target*100);
            }
        }
        return feature.properties.show_on_map;
    }
    return false;
}

function onEachFeature(feature, layer) {
// tidak punya properti.show_on_map ?
if (!feature.properties.show_on_map) {
    feature.properties.show_on_map = false; 
}

layer.on({

    mouseover: highlightFeature,
    mouseout: resetHighlight,
    click: zoomToFeature
});
}

function getColor(p) {

    return p > 80  ? '#1a9641' :
    p > 60   ? '#a6d96a' :
    p > 40   ? '#ffffbf' :
    p > 20   ? '#fdae61' :
    '#d7191c';
}

// colorize polygon by certain value
function style(feature) {

    if (feature.properties.progres != undefined) { //use != cz 0 is looked as false

        return {
            fillColor: getColor(feature.properties.progres),
            weight: 2,
            opacity: 1,
            color: 'white',
            dashArray: '3',
            fillOpacity: 0.7
        };
    }
}

// event listener=====
function highlightFeature(e) {

    var layer = e.target;

    layer.setStyle({
        weight: 3,
        color: '#666',
        dashArray: '',
        fillOpacity: 0.7
    });

    if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) {
        layer.bringToFront();
    }

    info.update(layer.feature.properties);
}

function resetHighlight(e) {

    geojson.resetStyle(e.target);
    info.update();
}

function zoomToFeature(e) {

    map.fitBounds(e.target.getBounds());
}
// ===== e

// custom info control=====
var info = L.control();

info.onAdd = function (map) {
    this._div = L.DomUtil.create('div', 'mapinfo'); // create a div with a class "info"
    this.update();
    return this._div;
};

// method that we will use to update the control based on feature properties passed
info.update = function (props) {
    this._div.innerHTML = '<h4>Progres Input Kuesioner</h4>' +  (props ?
        '' + props.nama + '<br />' + '<h2>' + props.progres + ' %</h2>'
        : 'Arahkan kursor ke wilayah survei');
};

info.addTo(map);
// ===== c

// legend control =====
var legend = L.control({position: 'bottomright'});

legend.onAdd = function (map) {

    var div = L.DomUtil.create('div', 'mapinfo legend'),
    grades = [0, 20, 40, 60, 80],
    labels = [];

    // loop through our density intervals and generate a label with a colored square for each interval
    for (var i = 0; i < grades.length; i++) {

        div.innerHTML +=
        '<i style="background:' + getColor(grades[i] + 1) + '"></i> ' +
        grades[i] + (grades[i + 1] ? '&ndash;' + grades[i + 1] + '<br>' : '&ndash;100 %');
    }

    return div;
};

legend.addTo(map);
// ===== l

</script>
<?php endif; ?> 
<!-- end leaflet -->

<script>
// ganti warna progres
// progres positif
var progpos = $('.progress-positive');
$( progpos ).each(function( i ) {
  if($(this).attr('aria-valuenow') < 30){
    $(this).addClass('progress-bar-danger');
}else if($(this).attr('aria-valuenow') < 60){
    $(this).addClass('progress-bar-warning');
}else{
    $(this).addClass('progress-bar-success')
}
});

// progres negatif
var progneg = $('.progress-negative');
$( progneg ).each(function( i ) {
 if($(this).attr('aria-valuenow') < 30){
    $(this).addClass('progress-bar-success');
}else if($(this).attr('aria-valuenow') < 60){
    $(this).addClass('progress-bar-warning');
}else{
    $(this).addClass('progress-bar-danger')
}
});

//coba


</script>