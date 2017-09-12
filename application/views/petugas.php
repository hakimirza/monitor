<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="row">
    <div class="col-xs-12">
      <section class="content-header">
        <h1>
          <?= $title ?>
          <small><?= $namaSurvei ?></small>
        </h1>

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
              <i class="fa fa-table"></i>
              Tabel Pencacah <span id="table-area"></span>
            </h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse">
                <i class="fa fa-minus"></i>
              </button>
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <table id="tabel-petugas" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>No</th>
                  <th>ID</th>
                  <th>Nama</th>
                  <!-- <th id="col-jenis">...</th> -->
                  <th class="colwil1">Provinsi</th>
                  <th class="colwil2">Kabupaten/Kota</th>
                  <th>Input</th>
                  <th>Target</th>
                  <th>Progres</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1</td>
                  <td>4.3401</td>
                  <td>Superman</td>
                  <td>DI Yogyakarta</td>
                  <td>Sleman</td>
                  <td>7</td>
                  <td>20</td>
                  <td>
                    <div class="progress progress-striped progress-bg-grey active">
                      <div class="progress-bar progress-positive" aria-valuenow="` + item.progresWil + `" style="width:37%">
                        37%
                      </div>
                    </div>
                  </td>
                  <td>
                    <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                      ...
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
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