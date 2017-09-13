<script>

    var id_proj = '<?= $id_proj ?>';
// state of now-selected locus
var idNow = '<?= $wil ?>';
var uriProg = '<?= base_url() ?>progres/'+ id_proj +'/';

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

        var urlProv = uriProg + item.idprov;
        var urlKab = uriProg + item.idkab;

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
                <button class="btn btn-default" type="button">
                 <i class="icon fa fa-caret-down"></i>
             </button>
             `)
            );

        $tr.appendTo('#tabel-petugas tbody');

    });

// colorizing the bars
colorPos();

// removing redundant cols
colRemover();

// init datatable
var table = $('#tabel-petugas').DataTable({
    "columnDefs": [
    { "orderable": false, "targets": -1 }
    ]
});

$.each(data, function(i, item) {

        // extra info
        var tr = $('#'+item.id);
        var row = table.row( tr );
        var content1 = placeLoc(item.id);
        var content2 = item.input != 0 ? placeXtra(item.id) : '<span class="badge bg-yellow"><i class="icon fa fa-warning"></i></span> Petugas belum mengirim kuesioner';
        
        row.child(content1 + content2);

    });

tableListener(table);

}
// end table_init

function colRemover(){

    // removing redundant cols
    if (String(idNow).length >= 2) {

        $( ".colwil1" ).remove();
    } 
    if (String(idNow).length == 4 ){

        $( ".colwil2" ).remove();
    }
}

function tableListener(table){

    $('#tabel-petugas tbody').on('click', 'button', function () {

        var tr = $(this).closest('tr');
        var id = tr.attr('id');
        var row = table.row( tr );

        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            // tr.removeClass('shown');
        }
        else {
            // Open this row
            chart(id);
            beban(id);
            row.child.show();
            // tr.addClass('shown');
        }
    } );
}

    // used in chart_init.js
    var dataIzin = new Array();
    var lineInput = {};
    var lineDur = {};
    var donat = new Array();
    var line1 = new Array();
    var line2 = new Array();

    function chart(id) {

        var currentReq = null;

        currentReq = $.ajax({
          type: 'GET',
          url: '<?= base_url() ?>petugas/dataXtra/'+ id_proj + '/' + id + '/' + 'chart' + '/' + idNow,
          datatype: 'json',
          success: function(result){

            var data = JSON.parse(result);
            
            if(data){

                dataIzin = data.donatIzin;
                lineInput = data.lineInput;
                lineDur = data.lineDur;

                if(typeof donat[id] !== 'undefined'){

                  replaceData(donat[id], '', dataIzin);
                  replaceData(line1[id], lineInput.date , lineInput.count);
                  replaceData(line2[id], lineDur.date, lineDur.dur);

              }else{
                chart_init(id);
            }
        }
    },
    error: function(){
        console.log('There was a problem with Xtra request.');
    },
    complete: function(){
    }
});
    }

    function beban(id){

        currentReq = $.ajax({
          type: 'GET',
          url: '<?= base_url() ?>petugas/dataXtra/'+ id_proj + '/' + id + '/' + 'loc' + '/' + idNow,
          datatype: 'json',
          success: function(result){

            var data = JSON.parse(result);
            fillBeban(data);
            colRemover();

        },
        error: function(){
            console.log('There was a problem with beban request.');
        }
    });
    }

    function fillBeban(data){

        $.each(data, function(i, item) {

            var urlProv = uriProg + item.idprov;
            var urlKab = uriProg + item.idkab;
            var urlKec = uriProg + item.idkec;
            var urlDes = uriProg + item.iddes;

            var $tr = $('<tr id="'+ item.id +'">').append(
                $('<td>').text(i+1),
                $('<td class="colwil1">').append('<a href="'+ urlProv +'" title = "'+ item.idprov +'">' + item.prov + '</a>'),
                $('<td class="colwil2">').append('<a href="'+ urlKab +'" title = "'+ item.idkab +'">' + item.kab + '</a>'),
                $('<td>').append('<a href="'+ urlKec +'" title = "'+ item.idkec +'">' + item.kec + '</a>'),
                $('<td>').append('<a href="'+ urlDes +'" title = "'+ item.iddes +'">' + item.des + '</a>'),
                $('<td>').text(item.bs),
                $('<td>').text(item.target),
                $('<td>').append('<a href="<?= base_url() ?>petugas/lihat_data/'+ id_proj +'/'+ item.idbs +'/'+ item.id +'" title="Lihat data"><i class="icon fa fa-eye"></i></a>')
                );

            $('#beban_'+item.id).empty();
            $tr.appendTo('#beban_'+item.id);
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

    function placeLoc(id){

        return `
        <div class="row">
            <div class="col-lg-8 col-xs-8">
                <h5><i class="icon fa fa-map-pin"></i> Beban cacah</h5>
                <div class="row">
                  <div class="col-md-12">
                    <table class="table table-condensed">
                        <thead>
                            <th>No</th>
                            <th class="colwil1">Provinsi</th>
                            <th class="colwil2">Kabupaten</th>
                            <th>Kecamatan</th>
                            <th>Desa</th>
                            <th>Blok Sensus</th>
                            <th>Target</th>
                            <th></th>
                        </thead>
                        <tbody id="beban_`+ id +`">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div><hr>
    `;
}

function placeXtra(id){

    return `
    <div class="row">
      <div class="col-lg-4 col-xs-4">
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">Input Harian</h3>
        </div>
        <div class="box-body">

            <canvas id="line_input`+ id +`" ></canvas>
        </div>
    </div>
</div>
<div class="col-lg-4 col-xs-4">
    <div class="box box-warning">
      <div class="box-header with-border">
        <h3 class="box-title">Rata-Rata Durasi Wawancara Harian(menit)</h3>
    </div>
    <div class="box-body">

        <canvas id="line_durasi`+ id +`" ></canvas>
    </div>
</div>
</div>
<div class="col-lg-3 col-xs-3">
    <div class="box box-default">
      <div class="box-header with-border">
        <h3 class="box-title">Ketersediaan Responden</h3>
    </div>
    <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <div class="chart-responsive">

                <canvas id="pie_ijin`+ id +`" height="155" width="205" style="width: 205px; height: 155px;"></canvas>
            </div>
        </div>
    </div>
</div>
</div>
</div>
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
      url: '<?= base_url() ?>petugas/data/'+ id_proj +'/' + wil,
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

$('#reload').click(function(){

    mainLoader(idNow);
});

</script>
<script src="<?= base_url() ?>plugins/chartjs/Chart.min.js"></script>
<script src="<?= base_url() ?>plugins/chartjs/Chart.PieceLabel.js"></script>
<script src="<?= base_url() ?>dist/js/pcl/chart_init.js"></script>