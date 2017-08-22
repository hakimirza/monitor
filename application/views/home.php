    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <div class="container">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Selamat Datang <?= $this->session->userdata('nama') ?>
            <br>
            <small>Pilih survei untuk dimonitoring <?= $prefix ?><b><?= $area ?></b></small>
          </h1>
       <!--  <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
          <li class="active">Here</li>
        </ol> -->
      </section>

      <!-- Main content -->
      <section class="content">
        <!-- Your Page Content Here -->
        
        <div class="row">
          <div class="col-xs-12">
            <div class="box" id="box-progres">
              <div class="box-header">
                <h3 class="box-title">
                  Daftar Survei Anda
                </h3>

              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <table id="tabel-survei-list" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>No.</th>
                      <th>Nama Survei</th>
                      <th>Status</th>
                      <th>Progres Nasional</th>
                      <th>Progres Daerah&nbsp;&nbsp;</th>
                      <th></th>
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

      </section>
      <!-- /.content -->
    </div>
    <!-- /.container -->
  </div>
  <!-- /.content-wrapper -->
