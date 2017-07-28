<script src="<?= base_url() ?>plugins/jQueryUI/jquery-ui.min.js"></script>
<script src="<?= base_url() ?>plugins/pivot/pivot.js"></script>
<script src="<?= base_url() ?>plugins/pivot/export_renderers.js"></script>

<script>

// pivot table

var data;
var dataNow;
var loadDone = false;

var getData = function(){

    $.ajax({
        type: 'POST',
        url: '<?= base_url() ?>tabulasi/dataJson/',
        dataType: 'json',
        success: function(result) {

            data = result;
            loadDone = true;

        // default
        dataNow = data.group;
        setPivotUI(dataNow); 
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

function setPivotUI(data, reset = false){

    if (loadDone) {
        var renderers = $.extend($.pivotUtilities.renderers, $.pivotUtilities.export_renderers);

        $('#output').pivotUI(data, {
            renderers : renderers
        }, reset);
    }  
}   


// Navigasi tabulasi

// 1. reload data
$('#reloadTable').click(function(){

    // re getData
    getData();
});

// 2. save tabulasi

// 3. open tabulasi

// 4. reset tabulasi
$('#clearTable').click(function(){

    setPivotUI(dataNow, true);
});

// 5. set dataset
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

// end pivot -----

// tooltip jQueryUI
$( function() {
    $( document ).tooltip();
} );

</script>