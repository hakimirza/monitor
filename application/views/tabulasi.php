<!-- Content Wrapper. Contains page content ^_^ -->
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
            <div class="row">
              <div class="col-xs-12">
                <!-- <h3 class="box-title">
                  <b>Filter</b>
                </h3> -->
              </div>
            </div>
          </div>

          <!-- /.box-header -->
          <div class="box-body">
            <div class="row">
              <div class="col-xs-12">

                <button type="button" class="btn btn-default" title="Bersihkan tabel" id="clearTableBtn" data-toggle="modal" data-target="#isClear"><i class="fa fa-eraser"></i></button>

                <span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span>

                <button type="button" class="btn btn-default" title="Undo" id="undo"><i class="fa fa-reply"></i></button>
                <button type="button" class="btn btn-default" title="Redo" id="redo"><i class="fa fa-share"></i></button>

                <div class="pull-right">
                  <select class="form-control" id="selectDataset">
                    <option value=0>Tipe Dataset : Grup</option>
                    <option value=1>Tipe Dataset : Individu</option>
                  </select>
                </div>
                <div class="pull-right">
                  <span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span>
                </div>
                <div class="pull-right">
                  <button type="button" class="btn btn-default" title="Ekspor ke TSV" id="export"><i class="fa fa-print"></i></button>
                </div>
                <div class="pull-right">
                  <span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span>
                </div>
                <div class="pull-right">

                  <button type="button" class="btn btn-default" title="Muat ulang data" id="reloadTable"><i class="fa fa-refresh"></i></button>
                  <button type="button" class="btn btn-default" title="Simpan tabulasi" id="saveTableBtn" data-toggle="modal" data-target="#saveTableModal"><i class="fa fa-save"></i></button>
                  <button type="button" class="btn btn-default" title="Buka tabulasi" id="openTableBtn" data-toggle="modal" data-target="#openTableModal"><i class="fa fa-folder-open-o"></i></button>
                </div>

                <hr>

              </div>
            </div>
            <div class="row">
              <div class="col-xs-8">
               <div id="output"></div>
             </div>
             <div class="col-xs-4">
             </div>
           </div>
         </div>
         <!-- /.box-body -->
       </div>
       <!-- /.box -->
     </div>  
     <!-- /.col -->
   </div>
   <!-- /.row -->

   <!-- Modal konfirmasi reset -->
   <div class="modal" id="isClear" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-body">
          <h4><i class="fa fa-exclamation-circle"></i> Bersihkan tabel?</h4>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
          <button type="button" class="btn btn-danger" id="clearTable" data-dismiss="modal"><i class="fa fa-eraser"></i> Bersihkan</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal save config -->
  <div class="modal" id="saveTableModal" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-body">

          <div class="form-group" id="guoblok">
            <label>Judul tabulasi</label>
            <input class="form-control input-lg" type="text" placeholder="Nama layout tabulasi" id="namaTabulasi" autofocus="">
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal" id="closeModal">Batal</button>
          <button type="button" class="btn btn-primary" id="saveTable" data-dismiss="modal"><i class="fa fa-save"></i> Simpan</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal open config -->
  <div class="modal" id="openTableModal" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Daftar tabulasi</h4>
        </div>
        
        <div class="modal-body">
          <table class="table table-hover">
            <tbody id="listConfig">
              <tr>
                <th></th>
                <th>No</th>
                <th>Judul</th>
                <th>Pilih</th>
              </tr>
            </tbody>
          </table>  
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
          <button type="button" class="btn btn-primary" id="openTable" data-dismiss="modal"><i class="fa fa-cloud-download"></i> Muat</button>
        </div>
      </div>
    </div>
  </div>

</section>
<!-- /.content -->
</div>
  <!-- /.content-wrapper