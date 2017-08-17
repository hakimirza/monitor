<script>

// load data
$.ajax({
	type: 'GET',
	url: '<?= base_url() ?>home/daftar_survei/',
	dataType: 'json',
	success: function(result) {

		console.log(result);

		$('#tabel-survei-list tbody').empty();
		$('#tabel-survei-list').DataTable().destroy();
			// console.log(JSON.parse(result[0].tabulation_config));
			$.each(result, function(i, item) {

				var $tr = $('<tr data-href="<?= base_url().'dasbor/' ?>' + item.id + '" title="Tampilkan Dasbor ' + item.name + '">').append(
					$('<td>').text(i+1),
					$('<td>').text(item.name),
					$('<td>').append(`
						<span class="label label-` + item.color + `">` + item.status + `</span>`),
					$('<td>').append(`
						<div class="progress progress-striped progress-bg-grey active">
							<div class="progress-bar progress-positive" aria-valuenow="` + item.progres + `" style="width: ` + item.progres + `%">
								` + item.progres + `%
							</div>
						</div>`)
					); 
				$tr.appendTo('#tabel-survei-list tbody');
			});
			recolor();
			$('#tabel-survei-list').DataTable();

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