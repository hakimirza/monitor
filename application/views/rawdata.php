</head>
<body style="overflow-x: auto">
	<div class="row">
		<div class="col-lg-12 col-xs-12">
			<div class="box box-default">
				<div class="box-header with-border">
					<p>
						<a href="<?= base_url().'dasbor/'.$id_proj ?>" title="Dasbor"><i class="icon fa fa-dashboard"></i> Dasbor</a>
						&nbsp;&nbsp;|&nbsp;&nbsp; 
						<a href="<?= base_url().'progres/'.$id_proj ?>" title="Detail Progres"><i class="icon fa fa-sort-amount-desc"></i> Progres</a>
						&nbsp;&nbsp;|&nbsp;&nbsp;
						<a href="<?= base_url().'petugas/'.$id_proj ?>" title="Petugas Cacah"><i class="icon fa fa-group"></i> Petugas</a>
						&nbsp;&nbsp;|&nbsp;&nbsp;
						<a href="<?= base_url().'tabulasi/'.$id_proj ?>" title="Tabulasi"><i class="icon fa fa-table"></i> Tabulasi</a>
					</p>
					<hr>
					<h3>
						Data <?= $namaSurvei.' ('.$type.')' ?>
					</h3>
					<p>Pencacah : <b><?= $namapcl ?></b> &nbsp;&nbsp;|&nbsp;&nbsp; Switch : <a href="<?= base_url().'petugas/lihat_data/'.$id_proj.'/'.$wil.'/'.$idpcl.'/'.$alt ?>">data <?= $alt ?></a></p>

				</div>
				<div class="box-body">

					<table class="table table-bordered table-striped table-hover">
						<thead>
							<tr>
								<?php foreach ($data[0] as $var => $val): ?>

									<th><?= $var ?></th>

								<?php endforeach ?>
							</tr>
						</thead>
						<tbody>

							<?php foreach ($data as $row): ?>

								<tr>
									<?php foreach ($row as $val): ?>

										<td><?= $val ?></td>

									<?php endforeach ?>
								</tr>

							<?php endforeach ?>

						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</body>
</html>