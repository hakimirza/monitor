<?php 
$username = $this->session->userdata('nama');
$avatar = $this->session->userdata('avatar');
 ?>
<!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- Sidebar user panel (optional) -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?= $avatar ?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?= $username ?></p>
          <!-- Status -->
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>

      <!-- search form (Optional) -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Cari...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->

      <!-- Sidebar Menu -->
      <ul class="sidebar-menu">
        <li class="header">MENU</li>
        <!-- Optionally, you can add icons to the links -->
        <li class="active"><a href="<?= base_url().'dasbor/'.$id_proj ?>"><i class="fa fa-dashboard"></i> <span>Dasbor</span></a></li>
        <li><a href="<?= base_url().'progres/'.$id_proj ?>"><i class="fa fa-sort-amount-desc"></i> <span>Detail Progres</span></a></li>
        <li><a href="<?= base_url().'petugas/'.$id_proj ?>"><i class="fa fa-group"></i> <span>Petugas Cacah</span></a></li>
        <!-- <li><a href="#"><i class="fa fa-group"></i> <span>Petugas</span></a></li> -->
        <li><a href="<?= base_url().'tabulasi/'.$id_proj ?>"><i class="fa fa-table"></i> <span>Tabulasi</span></a></li>
        <!-- <li class="treeview">
          <a href="#"><i class="fa fa- fa-pie-chart"></i> <span>Analisis</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="#">Visualisasi</a></li>
            <li><a href="#">tabulasi</a></li>
          </ul>
        </li> -->
        <!-- <li><a href="#"><i class="fa fa-puzzle-piece"></i> <span>Profil</span></a></li> -->
      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>