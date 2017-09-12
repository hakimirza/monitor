<script>

// load data
$.ajax({
	type: 'GET',
	url: '<?= base_url() ?>home/daftar_survei/',
	dataType: 'json',
	success: function(result) {

		console.log(result);

		$('#tabel-survei-list').DataTable().destroy();
		$('#tabel-survei-list tbody').empty();
		
		$.each(result, function(i, item) {

			var $tr = $('<tr>').append(
				$('<td>').text(i+1),
				$('<td>').text(item.name),
				$('<td>').append(`
					<span class="label label-` + item.color + `">` + item.status + `</span>`),
				$('<td>').append(`
					<div class="progress progress-striped progress-bg-grey active">
						<div class="progress-bar progress-positive" aria-valuenow="` + item.progres + `" style="width: ` + item.progres + `%">
							` + item.progres + `%
						</div>
					</div>`),
				$('<td>').append(`
					<div class="progress progress-striped progress-bg-grey active">
						<div class="progress-bar progress-positive" aria-valuenow="` + item.progresWil + `" style="width: ` + item.progresWil + `%">
							` + item.progresWil + `%
						</div>
					</div>`),
				$('<td>').append(`<div class="btn-group">
					<button type="button" class="btn btn-block btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
						&nbsp;&nbsp;<i class="fa fa-ellipsis-v"></i>&nbsp;&nbsp;</button>
						<ul class="dropdown-menu" role="menu">
							<li><a href="<?= base_url() ?>dasbor/`+ item.id +`"><i class="fa fa-dashboard"></i> Dasbor</a></li>
							<li><a href="<?= base_url() ?>progres/`+ item.id +`"><i class="fa fa-sort-amount-desc"></i> Detail Progres</a></li>
							<li><a href="<?= base_url() ?>petugas/`+ item.id +`"><i class="fa fa-group"></i> Petugas Cacah</a></li>
							<li><a href="<?= base_url() ?>tabulasi/`+ item.id +`"><i class="fa fa-table"></i> Tabulasi</a></li>
						</ul>
					</div>`)
				); 
			$tr.appendTo('#tabel-survei-list tbody');
		});
		recolor();
		$('#tabel-survei-list').DataTable({
			"columnDefs": [
			{ "orderable": false, "targets": 5 }
			]
		});

	},
	error: function() {

		console.log('There was a problem with the request.');
	}
});

// ganti warna progres
// progres positif
var recolor = function(){

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
};

</script>