<script>
//  ====================================
// get parents
function get_parents(id = ''){

    $.ajax({
      type: 'GET',
      url: '<?= base_url() ?>progres/getParents/' + id,
      datatype: 'json',
      success: function(result){

        var data = JSON.parse(result);

        // breadcrumbs(data);
        table_label(data);
        jeniscol = data[data.length - 1].col;
    },
    error: function(){
        console.log('There was a problem with your parents ;)');
    }
});
}

function table_label(data){

    var i = data.length - 1;
    var data = data[i];

    var title = $('#table-area');
    var col = $('#col-jenis');

    title.empty();
    title.append(data.jenis + ' <b>' + data.name + '</b>');
    // col.text(data.col);
}

//  ====================================
// data table

function table_init(data, wil){

$('#tabel-petugas').DataTable().destroy();
$('#tabel-petugas tbody').empty();

$.each(data, function(i, item) {

    var progres = item.input/item.target*100;
    progres = Math.round(progres * 100)/100;

    var urlProv = '<?= base_url() ?>progres/<?= $id_proj ?>/' + item.idprov;
    var urlKab = '<?= base_url() ?>progres/<?= $id_proj ?>/' + item.idkab;

    var $tr = $('<tr id="'+ item.id +'">').append(
        $('<td>').text(i+1),
        $('<td>').text(item.id),
        $('<td>').text(item.name),
        $('<td class="colwil1">').append('<a href="'+ urlProv +'" title = "'+ item.idprov +'">' + item.prov + '</a>'),
        $('<td class="colwil2">').append('<a href="'+ urlKab +'" title = "'+ item.idkab +'">' + item.kab + '</a>'),
        $('<td>').text(item.input),
        $('<td>').text(item.target),
        $('<td>').append(`
            <div class="progress progress-striped progress-bg-grey active">
                <div class="progress-bar progress-positive" aria-valuenow="` + progres + `" style="width: ` + progres + `%">
                    ` + progres + `%
                </div>
            </div>`),
        $('<td>').append(`
            <button class="btn btn-default" type="button" data-toggle="collapse" data-target="#extra_`+ item.id +`" aria-expanded="false" aria-controls="collapseExample">
             <i class="icon fa fa-line-chart"></i>
         </button>
         `)
        );

    $tr.appendTo('#tabel-petugas tbody');

    // var table = $('#tabel-petugas').DataTable();
    // // extra info
    // var tr = $('#'+item.id);
    // var row = table.row( tr );
    // row.child( format(item.id) ).show();

});

// colorizing the bars
colorPos();

// removing redundant cols
if (wil.length >= 2) {

    $( ".colwil1" ).remove();
} 
if (wil.length == 4 ){

    $( ".colwil2" ).remove();
}

// init datatable
var table = $('#tabel-petugas').DataTable({
    "columnDefs": [
    { "orderable": false, "targets": -1 }
    ]
});


// var table = $('#tabel-petugas').DataTable();

// $('#tabel-petugas tbody').on('click', 'button', function () {

//     var tr = $(this).closest('tr');
//     var row = table.row( tr );

//     if ( row.child.isShown() ) {
//             // This row is already open - close it
//             // row.child.hide();
//             // tr.removeClass('shown');
//         }
//         else {
//             // Open this row
//             row.child( format() ).show();
//             // tr.addClass('shown');
//         }
//     } );

}
// end table_init

function format (id) {
    
    return `
    <div class="collapse" id="extra_`+id+`">
        content of `+id+` row
    </div>
    `;
}

//  ====================================

// main loader

// default
mainLoader(<?= $wil ?>);

function mainLoader(wil = ''){

    $.ajax({
      type: 'GET',
      url: '<?= base_url() ?>petugas/data/<?= $id_proj ?>/' + wil,
      datatype: 'json',
      success: function(result){

        var data = JSON.parse(result);

        table_init(data, String(wil));

        colorPos();
        idNow = wil;
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

    mainLoader(idNow);
});

</script>