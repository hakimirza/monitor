    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          <?= $title ?>
          <small><?= $nama_survei ?></small>
        </h1>

      </section>

      <!-- Main content -->
      <section class="content">
        <!-- Your Page Content Here -->
        <div class="row">
          <div class="col-lg-3 col-xs-6">

            <!-- count input -->
            <div class="small-box bg-green">
              <div class="inner">
                <p>Input</p>
                <h3 id="inputLabel">...</h3>

                <p>Target: <b><?= $target_input ?></b></p>

              </div>
              <div class="icon">
                <i class="fa fa-file-text-o"></i>
              </div>
              <a href="<?= base_url().'progres/'.$id_proj ?>" class="small-box-footer">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
            </div>
            <!-- progres input -->
            <div class="small-box bg-white">
              <div class="inner">
                <p><b>Progres</b></p>
                <h3 id="progresLabel">...</h3>
                <div class="progress active">
                  <div id="progresBar" class="progress-bar progress-bar-striped progress-positive" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100" style="width: %">
                  </div>
                  <!-- <div class="progress-bar" style="width: <?= $percent_input ?>%"></div> -->
                </div>
              </div>
              <div class="icon">
                <i class="fa fa-file-text-o"></i>
              </div>
            </div>
            <!-- alokasi waktu terpakai -->
            <div class="small-box bg-white">
              <div class="inner">
                <b id="timeLabel" class="x-large">...</b>
                <div class="progress progress-sm active">
                  <div id="timeBar" class="progress-bar progress-bar-striped progress-negative" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100" style="">
                  </div>
                  <!-- <div class="progress-bar" style="width: <?= $percent_input ?>%"></div> -->
                </div>
                <p><b>Alokasi Waktu</b> Terpakai</p>
              </div>
              <div class="icon">
                <i class="fa fa-calendar-o"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-6 col-xs-6">
            <!-- google map -->
            <div class="box box-success">
              <div class="box-header with-border">
                <h3 class="box-title">Peta Progres Input</h3>
                <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" id="loadPins" title="Tampilkan posisi responden">
                    <span></span> Responden&nbsp;&nbsp;
                    <i class="fa fa-map-marker"></i>&nbsp;
                    <i id="cekPin" class="fa fa-square-o"></i>
                  </button>
                </div>
              </div>
              <div class="box-body">

                <!-- <div id="mapid"></div> -->

                <div id="map_dasbor"></div>
              </div>
              <!-- <div class="box-footer"></div> -->
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-xs-6">
            <!-- timer -->
            <div class="small-box bg-yellow">
              <div class="inner">
                <p>Sisa Waktu</p>
                <div id="timer"></div>
                <hr/>

                <p>
                  Mulai:
                  <br/><?= $start ?>
                </p>
                <p>
                  Berakhir:
                  <br/><?= $deadline ?>
                </p>
              </div>
              <div class="icon">
                <i class="fa fa-calendar-o"></i>
              </div>
              <!-- <a href="#" class="small-box-footer">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a> -->
            </div>
            
            <!-- pie chart status respon -->
            <div class="box box-default">
              <div class="box-header with-border">
                <h3 class="box-title">Ketersediaan Responden</h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="chart-responsive">

                      <canvas id="pie_statusKues" height="155" width="205" style="width: 205px; height: 155px;"></canvas>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- row -->
        <div class="row">
          <div class="col-lg-6 col-xs-6">
            <!-- google map -->
            <div class="box box-success">
              <div class="box-header with-border">
                <h3 class="box-title">Jumlah Kuesioner Masuk</h3>
              </div>
              <div class="box-body">

                <canvas id="line_inputHarian" ></canvas>
              </div>
              <!-- <div class="box-footer"></div> -->
            </div>
          </div>
          <div class="col-lg-6 col-xs-6">
            <!-- google map -->
            <div class="box box-warning">
              <div class="box-header with-border">
                <h3 class="box-title">Rata-Rata Durasi Wawancara (menit)</h3>
              </div>
              <div class="box-body">

                <canvas id="line_durasiCacah" ></canvas>
              </div>
              <!-- <div class="box-footer"></div> -->
            </div>
          </div>
        </div>
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
