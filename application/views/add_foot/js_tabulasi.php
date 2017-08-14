<script src="<?= base_url() ?>plugins/jQueryUI/jquery-ui.min.js"></script>
<script src="<?= base_url() ?>plugins/pivot/pivot.js"></script>
<script src="<?= base_url() ?>plugins/pivot/d3.min.js"></script>
<script src="<?= base_url() ?>plugins/pivot/c3.min.js"></script>

<script src="<?= base_url() ?>plugins/pivot/export_renderers.js"></script>
<script src="<?= base_url() ?>plugins/pivot/c3_renderers.js"></script>

<script>

// pivot table

var data;
var dataNow;
var loadDone = false;

var getData = function(){

    $.ajax({
        type: 'GET',
        url: '<?= base_url() ?>tabulasi/dataJson/',
        dataType: 'json',
        success: function(result) {

            data = result;
            loadDone = true;

        // default
        if(!dataNow) dataNow = data.group;
        setPivotUI(dataNow);

        toastUp("Berhasil memuat data");

    },
    error: function() {

        console.log('There was a problem with the request.');
    }
}); 
}

$(document).ready(function(){
    // call ajax
    getData();
});

var configList = new Array();

function setPivotUI(data, config = {}, reset = false){

    if (loadDone) {
        var renderers = $.extend($.pivotUtilities.renderers, $.pivotUtilities.export_renderers);
        var renderers = $.extend($.pivotUtilities.renderers, $.pivotUtilities.c3_renderers);

        var functionsConfig = {
            renderers : renderers,
            onRefresh : function(config) {

                var config = $('#output').data('pivotUIOptions');
                var config_copy = JSON.parse(JSON.stringify(config));
                //delete some values which will not serialize to JSON
                delete config_copy["aggregators"];
                delete config_copy["renderers"];

                configList.push(config_copy);
            }
        };

        var mergedConfig = $.extend({}, functionsConfig, config);

        $('#output').pivotUI(data, mergedConfig, reset);
    }  
}   


// NAVIGASI tabulasi

// 1. reload data
$('#reloadTable').click(function(){

    // re-getData
    getData();
});

// 2. save tabulasi
$('#saveTableBtn').click(function(){
    setTimeout(function() { 
        $('#namaTabulasi').focus();
    }, 50);
});

var saveTable = function(){

    var name = $('#namaTabulasi').val(); 
    name = name == '' ? now : name;

    var latest = JSON.stringify(last(configList));

    $.ajax({
      type: 'POST',
      url: '<?= base_url() ?>tabulasi/saveConfig/',
      data: {config : latest, name : name},
      dataType: 'text',
      success: function(text) {

             // console.log(result);
             toastUp(text + " menambahkan tabulasi");
         },
         error: function() {

            console.log('There was a problem with the request.');
        }
    });
}

// enter event
$('#namaTabulasi').keyup(function(e){ 
    var code = e.which; // recommended to use e.which, it's normalized across browsers
    if(code==13)e.preventDefault();
    // if(code==32||code==13||code==188||code==186){
    if(code==13){

        $( '#closeModal' ).trigger( 'click' );
        saveTable();
    } // missing closing if brace
});

$('#saveTable').click(function(){
    saveTable();
});

// 3. open tabulasi
var loadedConfig = new Array();
var selectedConfig;

var loadConfig = function(){

    $.ajax({
      type: 'GET',
      url: '<?= base_url() ?>tabulasi/loadConfig/',
      dataType: 'json',
      success: function(result) {

        $('#listConfig tr').slice(1).remove();
            // console.log(JSON.parse(result[0].tabulation_config));
             // console.log(result);
             $.each(result, function(i, item) {

                var obj = JSON.parse(item.tabulation_config);
                loadedConfig.push(obj);

                var $tr = $('<tr>').append(
                    $('<td>').append('<i class="fa fa-trash"></i>'),
                    $('<td>').text(i+1),
                    $('<td>').text(item.name),
                    $('<td>').append('<input type="radio" name="radioT" value='+ i +'>')
                    ); 
                $tr.appendTo('#listConfig');
        //.appendTo('#records_table');[]
    });

             $('input:radio[name=radioT]').click(function() {

                selectedConfig = loadedConfig[$(this).val()];
                $('#openTable').prop("disabled", false);
            });
         },
         error: function() {

            console.log('There was a problem with the request.');
        }
    });
}

$('#openTableBtn').click(function(){

    loadConfig();
    $('#openTable').prop("disabled", true);
});

$('#openTable').click(function(){

    if (selectedConfig){

        setPivotUI(dataNow, selectedConfig, true);
    }
});

// 4. reset tabulasi
$('#clearTable').click(function(){

    setPivotUI(dataNow, {}, true);
});

var pointer;
// 5. undo
$('#undo').click(function(){

    var backConfig;

    if(!pointer){

        // latest index config
        var now = configList.length - 1; 

        // set pointer to before the latest
        pointer = now - 1;
        backConfig = configList[pointer];
        pointer--;
    }else{

        backConfig = configList[pointer];
        pointer--;
    }

    setPivotUI(dataNow, backConfig, true);
});

// 6. redo
$('#redo').click(function(){

    var fwdConfig;

    if(pointer){

        // set pointer to before the latest
        var fwdConfig = configList[++pointer];
        pointer++;
        setPivotUI(dataNow, fwdConfig, true);
    }
});

// 7. set dataset
$('#selectDataset').change(function () {

 var type = $(this).val();
     //do ajax now
     if (type == 0) {

        dataNow = data.group;
    }
    else{

        dataNow = data.indiv;
    }
    setPivotUI(dataNow);
});

// 8. export TSV
$('#export').click(function(){

    $('.pvtRenderer').val('TSV Export').trigger('change');
});

// end pivot -----

// tooltip jQueryUI
$( function() {
    $( document ).tooltip();
} );

</script>