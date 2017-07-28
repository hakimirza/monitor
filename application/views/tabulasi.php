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

                <button type="button" class="btn btn-default" title="Bersihkan tabel" id="clearTable"><i class="fa fa-eraser"></i></button>
                
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
                  <button type="button" class="btn btn-default" title="Simpan tabulasi" id="saveTable"><i class="fa fa-save"></i></button>
                  <button type="button" class="btn btn-default" title="Buka tabulasi" id="openTable"><i class="fa fa-folder-open-o"></i></button>
                </div>

                <hr>

              </div>
            </div>
            <div class="row">
              <div class="col-xs-12">
               <div id="output"></div>
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

 </section>
 <!-- /.content -->
</div>
  <!-- /.content-wrapper