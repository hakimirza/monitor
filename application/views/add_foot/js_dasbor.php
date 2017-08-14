<!-- Google Map -->
<?php if(!empty($location)): ?>
  <script>
    var map;
    function initMap() {
      var jkt = {lat: -6.21462, lng: 106.84513};
      var map = new google.maps.Map(document.getElementById('map_dasbor'), {
        center: jkt,
        zoom: 5
      });

         // Create an array of alphabetical characters used to label the markers.
         var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        // Add some markers to the map.
        // Note: The code uses the JavaScript Array.prototype.map() method to
        // create an array of markers based on a given "locations" array.
        // The map() method here has nothing to do with the Google Maps API.
        var markers = locations.map(function(location, i) {
          return new google.maps.Marker({
            position: location,
            label: labels[i % labels.length]
          });
        });

        // Add a marker clusterer to manage the markers.
        var markerCluster = new MarkerClusterer(map, markers,
          {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});
      }

      var locations = <?php print_r($location) ?>

      </script>
      <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js">
      </script>
      <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDQFjRggMlnBZO62jcu0-awkKaSiA50kho&callback=initMap"
      async defer></script>
    <?php endif; ?>

<!-- ========================================= -->

    <!-- ChartJS 1.0.1 -->
    <script>

      // used in chart_init.js
      var dataIzin = new Array();
      var lineInput = {};
      var lineDur = {};

      $.ajax({
        type: 'GET',
        url: '<?= base_url() ?>dasbor/ajaxChart/',
        datatype: 'json',
        success: function(result){
          result = JSON.parse(result);
          dataIzin = result.donatIzin;
          lineInput = result.lineInput;
          lineDur = result.lineDur;
        },
        error: function(){
          console.log('There was a problem with the request.');
        },
        complete: function() {

         $.getScript("<?= base_url() ?>dist/js/dasbor/chart_init.js", function() {
          console.log('loaded script and content');
        });
       }
     });
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
  document.getElementById("timer").innerHTML = days + "d " + hours + "h "
  + minutes + "m " + seconds + "s ";

  // If the count down is finished, write some text 
  if (distance < 0) {
  	clearInterval(x);
  	document.getElementById("timer").innerHTML = "Waktu Habis";
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

  $('#timebarLabel').text(p + ' %');

  $('#timebar').attr({
    'aria-valuenow': p, 
    style: 'width: ' + p + '%'
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

colorPos();
colorNeg();

</script>