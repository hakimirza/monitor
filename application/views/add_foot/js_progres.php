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
            // geojson.removeFrom(map);
            var tempFile = file[i];

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
                    var tempFile = file[i];

                    geojson = L.geoJson(file[i], {
                      onEachFeature: onEachFeature,
                      filter: filterID,
                      style: style
                  });

                    geojson.addTo(map);
                    console.log('geojson layers added');

                // initial zoom to all features
                map.fitBounds(geojson.getBounds());
            },
            error: function() {

                failed();
                console.log('There was a problem with Map request.');
            }
        });
            }
        }

        var jeniscol='';
        function failed(){

            $('#box-map').attr({'style' : 'display:none;'});
            toastUp('<i class="icon fa fa-warning"></i> Peta '+ jeniscol +' tidak tersedia');
            // $('#minmap button').val('TSV Export').trigger('click');
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
                break;
            }
        }
        return feature.properties.show_on_map;
    }
    return false;
}

function onEachFeature(feature, layer) {
// tidak punya properti.show_on_map ?
if (!feature.properties.show_on_map || feature.properties.show_on_map == true) {
    feature.properties.show_on_map = false; 
}

layer.on({

    mouseover: highlightFeature,
    mouseout: resetHighlight,
    click: zoomToFeature
});
}

function getColor(p) {

    return p > 90  ? '#006837' : 
    p > 80  ? '#1a9850' :
    p > 70  ? '#66bd63' :
    p > 60  ? '#a6d96a' :
    p > 50  ? '#d9ef8b' :
    p > 40  ? '#ffffbf' :
    p > 30  ? '#fee08b' :
    p > 20  ? '#fdae61' :
    p > 10  ? '#f46d43' :
    p > 0   ? '#d73027' :
    '#a50026';
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
    grades = [0, 10, 20, 30, 40, 50, 60, 70, 80, 90],
    labels = [];

    div.innerHTML += '<i style="background:' + getColor(0) + '"></i> ' + '0<br>';
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
// map markers
var pins;
var markers = new Array();

$('#loadPins').click(function(){

  var but = $('#loadPins');
  var cek = $('#cekPin');

  if (markers.length != 0) {

    but.attr({'title' : 'Tampilkan posisi responden'});
    cek.attr({'class' : 'fa fa-square-o'});

    for(var i = 0; i < markers.length; i++){
      markers[i].removeFrom(map);
  }
  markers = new Array();
}
else{

    but.attr({'title' : 'Sembunyikan posisi responden'});
    cek.attr({'class' : 'fa fa-check-square-o'});

    addMarker(pins);
}
});

function addMarker(pins){

  for(var i = 0; i < pins.length; i++){

      var marker = L.marker(pins[i]).addTo(map);

      marker.on('click', function(e){
        map.setView(e.latlng, 13);
    });

      markers[i] = marker;
  }
}

//  ====================================
// get parents
function get_parents(id = ''){

    $.ajax({
      type: 'GET',
      url: '<?= base_url() ?>progres/getParents/' + id,
      datatype: 'json',
      success: function(result){

        var data = JSON.parse(result);

        breadcrumbs(data);
        table_label(data);
        jeniscol = data[data.length - 1].col;
    },
    error: function(){
        console.log('There was a problem with your parents ;)');
    }
});
}

function breadcrumbs(data){

    var ol = $('#bread-place');
    ol.empty();

    var $i = $('<i class="fa fa-map-marker">&nbsp;&nbsp;</i>');
    $i.appendTo(ol);

    $.each(data, function(i, item) {

        var $li = $(`
            <li>
                <a href=# title="`+ item.id +`" >
                  `+ item.name +`
              </a>
          </li>
          `);
        $li.appendTo(ol);
    });

    clickBread(); 
}

function table_label(data){

    var i = data.length - 1;
    var data = data[i];

    var title = $('#table-area');
    var col = $('#col-jenis');

    title.empty();
    title.append(data.jenis + ' <b>' + data.name + '</b>');
    col.text(data.col);
}

function clickBread(){
// click a crumb
$('#bread-place').find('a').click( function(){

    var id = $(this).attr('title');

    geojson.removeFrom(map);
    mainLoader(id);

    idNow = id;
});
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

// default
mainLoader(<?= $wil ?>);

function mainLoader(wil = ''){

    $.ajax({
      type: 'GET',
      url: '<?= base_url() ?>progres/data/<?= $id_proj ?>/' + wil,
      datatype: 'json',
      success: function(result){

        var data = JSON.parse(result);

        lokus = data.forTable;
        pins = JSON.parse(data.pins);
        n = lokus[0].id.toString().length;
        i = fileIndex(n);

        table_init(lokus);
        get_parents(wil);
        map_init(i);
        colorPos();

        idNow = wil;

        $('#loadPins span').text(data.input);
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

// state of now-selected locus
var idNow = '';

$('#reload').click(function(){

    geojson.removeFrom(map);
    mainLoader(idNow);
});

var clickRow = function(){
// click a row
$('#tabel-progres tbody').find('tr').click( function(){

    var id = $(this).attr('id');

    geojson.removeFrom(map);
    mainLoader(id);

    idNow = id;
});
}

</script>