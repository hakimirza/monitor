<!-- Main Footer -->
<footer class="main-footer">
  <!-- To the right -->
  <div class="pull-right hidden-xs">
    
  </div>
  <!-- Default to the left -->
  <strong>2017 &copy; </strong>Monitoring Survei
</footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 2.2.3 -->
<script src="<?= base_url() ?>plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?= base_url() ?>bootstrap/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url() ?>dist/js/app.min.js"></script>

<script>
  $(document).ready(function(){
    
    $('table tr[data-href]').click(function(){
      window.location = $(this).data('href'); //reload current page
      // window.open($(this).data('href')); //new tab directly
      return false;
    });

    // tooltip
    $('[data-toggle="tooltip"]').tooltip(); 
  });

  function startTime() {
    var today = new Date();
    var h = today.getHours();
    var m = today.getMinutes();
    // var s = today.getSeconds();
    m = checkTime(m);
    // s = checkTime(s);
    document.getElementById('clock').innerHTML =
    // h + ":" + m + ":" + s;
    h + ":" + m;
    var t = setTimeout(startTime, 500);
  }
  function checkTime(i) {
    if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
    return i;
  }

  function sidebarSwitch(selected){
    if (selected=='date') {
      $('#control-sidebar-settings-button').removeClass();
      $('#control-sidebar-date-button').removeClass().addClass('active');
      
      $('#control-sidebar-settings-tab').removeClass().addClass('tab-pane');
      $('#control-sidebar-date-tab').removeClass().addClass('tab-pane active');
    }else {
      $('#control-sidebar-date-button').removeClass();
      $('#control-sidebar-settings-button').removeClass().addClass('active');

      $('#control-sidebar-settings-tab').removeClass().addClass('tab-pane active');
      $('#control-sidebar-date-tab').removeClass().addClass('tab-pane');
    }
  }

// custom function to get latest element of an array
last = function(arr){
  return arr[arr.length - 1];
}

//toast
function toastUp(msg) {
  var x = document.getElementById("snackbar");
  x.innerHTML = msg;
  x.className = "show";
  setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
}

//today time
var today = new Date();
var h = today.getHours();
var m = today.getMinutes();
var s = today.getSeconds();
var d = today.getDate();
var mo = today.getMonth();
var y = today.getFullYear();

var now = d + '/' + mo + '/' + y + ' - ' + h + ':' + m + ':' + s;

</script>

<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. Slimscroll is required when using the
     fixed layout. -->
