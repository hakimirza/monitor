<!-- Google Map -->
<script src="<?= base_url() ?>plugins/leaflet/leaflet.js"></script>
<script>

  var map = L.map('map_dasbor').setView([-6.21462, 106.84513], 13);

  var mapboxAccessToken = 'pk.eyJ1IjoiaGFraW1pcnphIiwiYSI6ImNqNWNsaXZ6NTBiYnkyd3A4bGM1NWg2eWcifQ.K2V45-g_Jw3gi6bgRpimRw';

        // Menambahkan peta osm
        L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=' + mapboxAccessToken, {
          id: 'mapbox.light',
          attribution: ''
        }).addTo(map);

        var file;
        var geojson;

        var lokus = new Array();
        var n = 0;

        function map_init(){

          if (file) {

            // clear initial geojson layer
            geojson.removeFrom(map);

            geojson = L.geoJson(file, {
              onEachFeature: onEachFeature,
              filter: filterID,
              style: style
            });

            geojson.addTo(map);

                // initial zoom to all features
                map.fitBounds(geojson.getBounds());
                console.log('map loaded again');
              }
              else{

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
                console.log('map loaded');
              },
              error: function() {

                console.log('There was a problem with Map request.');
              }
            });}

              }

              function fileUrl(n){

                return n == 2 ? 'prov.js' :
                n == 4 ? 'kab.js' :
                n == 7 ? 'kec.js' :
                n == 10? 'des.js' :
                '';
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
            feature.properties.progres = Math.round((obj.count/obj.target*100)*100)/100;
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
// ===== l

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

// Use the Ray Casting algorithm for checking if a point (marker) lies inside of a polygon:

function isMarkerInsidePolygon(marker, poly) {
  var polyPoints = poly.getLatLngs();       
  var x = marker.getLatLng().lat, y = marker.getLatLng().lng;

  var inside = false;
  for (var i = 0, j = polyPoints.length - 1; i < polyPoints.length; j = i++) {
    var xi = polyPoints[i].lat, yi = polyPoints[i].lng;
    var xj = polyPoints[j].lat, yj = polyPoints[j].lng;

    var intersect = ((yi > y) != (yj > y))
    && (x < (xj - xi) * (y - yi) / (yj - yi) + xi);
    if (intersect) inside = !inside;
  }

  return inside;
};

</script>

<!-- ========================================= -->

<!-- All data and ChartJS 1.0.1 -->
<script>

  // main loader
  mainLoader();

      // used in chart_init.js
      var dataIzin = new Array();
      var lineInput = {};
      var lineDur = {};

      function mainLoader(){

        $.ajax({
          type: 'GET',
          url: '<?= base_url() ?>dasbor/data/<?= $id_proj ?>',
          datatype: 'json',
          success: function(result){
            result = JSON.parse(result);
            dataIzin = result.donatIzin;
            lineInput = result.lineInput;
            lineDur = result.lineDur;

            progresElement(result);
            map_init();
            colorPos();
          },
          error: function(){
            console.log('There was a problem with mainLoader request.');
          },
          complete: function() {

            // $('#line_inputHarian, #line_durasiCacah').empty();
            if(typeof donat !== 'undefined'){

              replaceData(donat, '', dataIzin);
              replaceData(line1, lineInput.date , lineInput.count);
              replaceData(line2, lineDur.date, lineDur.dur);

            }else{
              $.getScript("<?= base_url() ?>dist/js/dasbor/chart_init.js", function() {
                console.log('loaded script and content');
              });}
            }
          });
      }

      function replaceData(chart, label, data) {

        if (label !== '') chart.data.labels = label;
        chart.data.datasets.forEach((dataset) => {
          dataset.data = data;
        });
        chart.update();
        console.log('chart updated');
      }

      function progresElement(data){

        $('#inputLabel').text(data.input);
        $('#progresLabel').text(data.percent_input + '%');
        $('#progresBar').attr({
          'aria-valuenow': data.percent_input, 
          'style': 'width: ' + data.percent_input + '%'
        });
        $('#loadPins span').text(data.input);
        lokus = data.forTable;
        pins = JSON.parse(data.pins);
        n = lokus[0].id.toString().length;
      }

    </script>
    <script src="<?= base_url() ?>plugins/chartjs/Chart.min.js"></script>
    <script src="<?= base_url() ?>plugins/chartjs/Chart.PieceLabel.js"></script>

    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js"></script> -->

    <!-- ======================================== -->

    <script>
// Set the date we're counting down to
var countDownDate = new Date('<?= $deadline ?>').getTime();

// Update the count down every 1 second
var x = setInterval(function() {

  // Get todays date and time
  var now = new Date().getTime();

  // Find the distance between now an the count down date
  var distance = countDownDate - now;

  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);

  // Display the result in the element with id="demo"
  document.getElementById("timer").innerHTML = `
  <span class="big">` + days + `</span><span> hari</span>
  <span class="big"> :` + hours + `</span><span> jam</span>
  <span class="big"> :` + minutes + `</span><span> mnt</span>
  <span class="big"> :` + seconds + `</span><span> dtk</span>
  `;
  // days + "d " + hours + "h " + minutes + "m " + seconds + "s ";

  // If the count down is finished, write some text 
  if (distance < 0) {
  	clearInterval(x);
  	document.getElementById('timer').innerHTML = '<span class="big">Waktu Habis</span>';
  }
}, 1000);

// ==================================

// Progress time interval 1 sec
var cuobo = setInterval(function() {

  var today = new Date();
  var start = new Date('<?= $start ?>');
  var end = new Date('<?= $deadline ?>');

  var p = Math.round(((today - start) / (end - start)) * 100);
  p = p > 100 ? 100 : p;

  $('#timeLabel').text(p + ' %');

  $('#timeBar').attr({
    'aria-valuenow': p, 
    'style': 'width: ' + p + '%'
  });

  colorNeg();
}, 1000);

// ===================================

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

// progres negatif
var colorNeg = function(){
  var progneg = $('.progress-negative');
  $( progneg ).each(function( i ) {
   if($(this).attr('aria-valuenow') < 30){
    $(this).addClass('progress-bar-success');
  }else if($(this).attr('aria-valuenow') < 60){
    $(this).addClass('progress-bar-warning');
  }else{
    $(this).addClass('progress-bar-danger');
  }
});
}

$('#reload').click(function(){
  mainLoader();
});

</script>