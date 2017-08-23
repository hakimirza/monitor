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

        <ol class="breadcrumb" id="bread-place">
          <i class="fa fa-map-marker">&nbsp;&nbsp;</i>
          <li>
            <a href=#>
              ...
            </a>
          </li>
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
              <i class="fa fa-table"></i>
              Tabel Progres <span id="table-area"></span>
            </h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse">
                <i class="fa fa-minus"></i>
              </button>
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <table id="tabel-progres" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>No</th>
                  <th id="col-jenis">...</th>
                  <th>Kode</th>
                  <th>Input</th>
                  <th>Target</th>
                  <th>Progres Input</th>
                </tr>
              </thead>
              <tbody>
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

    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">
              <i class="fa fa-map-o"></i> Peta Progres Input
              &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
              <button type="button" class="btn btn-box-tool" id="loadPins" title="Tampilkan posisi responden">
                <i class="fa fa-map-marker"></i>&nbsp;
                <i id="cekPin" class="fa fa-square-o"></i>&nbsp;
                (<span></span> Responden)
              </button>
            </h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse">
                <i class="fa fa-minus"></i>
              </button>
            </div>

          </div>
          <!-- box-header -->
          <div id="box-map" class="box-body">

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