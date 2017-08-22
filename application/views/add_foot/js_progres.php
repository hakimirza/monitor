<!-- leaflet -->
<script src="<?= base_url() ?>plugins/leaflet/leaflet.js"></script>
<script>

// leaflet map
var map = L.map('mapid').setView([-6.21462, 106.84513], 13);

var mapboxAccessToken = 'pk.eyJ1IjoiaGFraW1pcnphIiwiYSI6ImNqNWNsaXZ6NTBiYnkyd3A4bGM1NWg2eWcifQ.K2V45-g_Jw3gi6bgRpimRw';

        // Menambahkan peta osm
        L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=' + mapboxAccessToken, {
            id: 'mapbox.light',
            attribution: ''
        }).addTo(map);

        var file = new Array();
        var geojson;

        var lokus = new Array();
        var n = 0;

        function map_init(i){

          if (file[i]) {

            // clear initial geojson layer
            geojson.removeFrom(map);

            geojson = L.geoJson(file[i], {
              onEachFeature: onEachFeature,
              filter: filterID,
              style: style
          });

            geojson.addTo(map);
            console.log('geojson layers RE-added');

                // initial zoom to all features
                map.fitBounds(geojson.getBounds());
            }
            else{

                $.ajax({
                  url: '<?= base_url() ?>dist/map/' + fileUrl(n),
                  dataType: 'json',
                  success: function(data) {

                    file[i] = data;
                    geojson = L.geoJson(file[i], {
                      filter: filterID,
                      onEachFeature: onEachFeature,
                      style: style
                  });

                    geojson.addTo(map);
                    console.log('geojson layers added');

                // initial zoom to all features
                map.fitBounds(geojson.getBounds());
            },
            error: function() {

                console.log('There was a problem with Map request.');
            }
        });
            }
        }

        function fileUrl(n){

            return n == 2 ? 'prov.js' :
            n == 4 ? 'kab.js' :
            n == 7 ? 'kec.js' :
            n == 10? 'des.js' :
            '';
        }

        function fileIndex(n){

            return n == 2 ? 0 :
            n == 4 ? 1 :
            n == 7 ? 2 :
            n == 10? 3 :
            99;
        }

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
    '<b>' + props.nama + '</b><br/>' + 
    '<table>' +
    '<tr><td>Progres</td> <td> : </td> <td>' + props.progres + ' % <td/></tr>' +
    '<tr><td>Input</td> <td> : </td> <td>' + props.input + '<td/></tr>' + 
    '<tr><td>Target</td> <td> : </td> <td>' + props.target + '<td/></tr>' + 
    '</table>'
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

//  ====================================
// get parents
function get_parents(id){

    $.ajax({
      type: 'GET',
      url: '<?= base_url() ?>progres/getParents/' + id,
      datatype: 'json',
      success: function(result){

        var data = JSON.parse(result);

        breadcrumbs(data);
    },
    error: function(){
        console.log('There was a problem with mainLoader request.');
    }
});
}

function breadcrumbs(data){


}

//  ====================================
// data table
function table_init(data){

    $('#tabel-progres').DataTable().destroy();
    $('#tabel-progres tbody').empty();

    $.each(data, function(i, item) {

        var progres = item.count/item.target*100;
        progres = Math.round(progres * 100)/100;

        var $tr = $('<tr id="'+ item.id +'" data-href="#" title="Tampilkan wilayah di bawah ' + item.nama + '">').append(
            $('<td>').text(i+1),
            $('<td>').text(item.nama),
            $('<td>').text(item.id),
            $('<td>').text(item.count),
            $('<td>').text(item.target),
            $('<td>').append(`
                <div class="progress progress-striped progress-bg-grey active">
                    <div class="progress-bar progress-positive" aria-valuenow="` + progres + `" style="width: ` + progres + `%">
                        ` + progres + `%
                    </div>
                </div>`)
            ); 
        $tr.appendTo('#tabel-progres tbody');

    });

    clickRow();
    colorPos();
    $('#tabel-progres').DataTable();
}

//  ====================================

// main loader

mainLoader();

function mainLoader(wil = ''){

    var param = wil === '' ? '' : wil;

    $.ajax({
      type: 'GET',
      url: '<?= base_url() ?>progres/data/<?= $id_proj ?>/' + param,
      datatype: 'json',
      success: function(result){

        var data = JSON.parse(result);

        lokus = data.forTable;
        var pins = JSON.parse(data.pins);
        n = lokus[0].id.toString().length;
        i = fileIndex(n);

        table_init(lokus);
        map_init(i);
        colorPos();
    },
    error: function(){
        console.log('There was a problem with mainLoader request.');
    }
});
}

//  ====================================

// change progress color
// progres positif
var colorPos = function(){
  var progpos = $('.progress-positive');
  $( progpos ).each(function( i ) {
    if($(this).attr('aria-valuenow') < 30){
      $(this).addClass('progress-bar-danger');
  }else if($(this).attr('aria-valuenow') < 60){
      $(this).addClass('progress-bar-warning');
  }else{
      $(this).addClass('progress-bar-success');
  }
});
}

// state of now selected locus
var idNow = '';

$('#reload').click(function(){
  mainLoader(idNow);
});

var clickRow = function(){
// click a row
$('#tabel-progres tbody').find('tr').click( function(){

    var id = $(this).attr('id');

    geojson.removeFrom(map);
    console.log('clicker***init');
    mainLoader(id);

    idNow = id;
});
}

</script>