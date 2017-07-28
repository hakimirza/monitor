<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="row">
    <div class="col-xs-12">
      <section class="content-header">
        <h1 title="cuk">
          <?= $title ?>
          <small><?= $namaSurvei ?></small>
        </h1>

        <ol class="breadcrumb">
          <i class="fa fa-map-marker">&nbsp;&nbsp;</i>
          <li>
            <a href=<?= '"'.base_url().'progres/"' ?>>
              INDONESIA
            </a>
          </li>
          <?php if($parents != ''): ?>
            <?php foreach ($parents as $parent): ?>

              <li>
                <a href=<?= '"'.base_url().'progres/'.$parent['id'].'"' ?>>
                  <?= $parent['name']?>
                </a>
              </li> 
            <?php endforeach; ?>
          <?php endif; ?>
        </ol>

      </section>
    </div>
  </div>
  <!-- Main content -->
  <section class="content">

    <!-- Your Page Content Here -->
    <div class="row">
      <div class="col-xs-12">
        <div class="box" id="box-progres">
          <div class="box-header">
            <h3 class="box-title">
              <?= strtoupper($jenisWil) ?><b><?php if ($namaWil != "N/A") { echo ' '.$namaWil;} ?></b>
            </h3>

          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <table id="tabel-progres" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>No.</th>
                  <th><?= $colJenis ?></th>
                  <?php if($jenisWil != 'Kelurahan/Desa' ): ?>
                    <th>Kode Wilayah</th>
                  <?php endif;?>
                  <th>Input</th>
                  <th>Target</th>
                  <th>Progres</th>
                </tr>
              </thead>
              <tbody>
                <?php $i = 1; ?>
                <?php foreach ($forTable as $row): ?>

                  <tr data-href = <?php 
                  if($colJenis == 'Blok Sensus') echo'#'; 
                  else {
                    echo '"'.base_url().'progres/'.$row['id'].'"';
                    echo ' title="Tampilkan Progres Wilayah di Bawah '.$row['nama'].'"';
                  } 
                  ?> id = <?= $row['id']?>>
                  <td><?= $i ?></td>
                  <td><?= $row['nama'] ?></td>
                  <?php if($jenisWil != 'Kelurahan/Desa' ): ?>
                    <td><?= $row['id'] ?></td>
                  <?php endif;?>
                  <td><?= $row['count'] ?></td>
                  <td><?= $row['target'] ?></td>
                  <td>
                    <div class="progress progress-striped progress-bg-grey active">
                      <div class="progress-bar progress-positive" aria-valuenow="<?= $row['count']*100/$row['target'] ?>" style="width: <?= $row['count']*100/$row['target'] ?>%">
                        <?= round($row['count']*100/$row['target'] , 2) ?>%
                      </div>
                    </div>
                  </td>
                </tr>

                <?php $i++; ?>
              <?php endforeach; ?>
            </tbody>
              <!-- <tfoot>
                <tr>
                  <th>No.</th>
                  <th><?= $colJenis ?></th>
                  <?php// if($jenisWil != 'Desa' ): ?>
                    <th>Kode <?php//= $colJenis ?></th>
                  <?php// endif;?>
                  <th>Kuesioner Masuk</th>
                  <th>Progres</th>
                </tr>
              </tfoot> -->
            </table>
            
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
          <a href="#mapid" class="btn btn-default"><i class="fa fa-map-o"></i> Peta Progres Input</a>
            <!-- <a ><h3 class="box-title">
              
            </h3></a> -->

          </div>
          <!-- box-header -->
          <div class="box-body">

            <div id="mapid"></div>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

  </section>
  <!-- /.content -->
</div>
  <!-- /.content-wrapper