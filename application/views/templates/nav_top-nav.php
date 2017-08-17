</head>
<?php 
$username = $this->session->userdata('nama');
$avatar = $this->session->userdata('avatar');
?>

<body class="hold-transition skin-black layout-top-nav" onload="startTime()">

  <div class="wrapper">

    <!-- Main Header -->
    <header class="main-header">

      <!-- Header Navbar -->
      <nav class="navbar navbar-static-top" role="navigation">
        <div class="container">
          <!-- Logo -->
          <a href="<?= base_url() ?>" class="logo navbar-brand">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b><i class="fa fa-tv"></i></b></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>MONITOR</b>ING <i class="fa fa-tv"></i></span>
          </a>
          
          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

              <!-- clock -->
              <li>
                <a href="#" data-toggle="control-sidebar" onclick="sidebarSwitch('date')" "><span id="clock"></span></a>
              </li>

              <!-- User Account Menu -->
              <li class="dropdown user user-menu">
                <!-- Menu Toggle Button -->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <!-- The user image in the navbar-->
                  <img src="<?= $avatar ?>" class="user-image" alt="User Image">
                  <!-- hidden-xs hides the username on small devices so only the image appears. -->
                  <span class="hidden-xs"><?= $username ?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- The user image in the menu -->
                  <li class="user-header">
                    <img src="<?= $avatar ?>" class="img-circle" alt="User Image">

                    <p>
                      <?= $username ?>
                      <!-- <small>Member since Jan. 2012</small> -->
                    </p>
                  </li>

                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="#" class="btn btn-default btn-flat">Profile</a>
                    </div>
                    <div class="pull-right">
                      <a href="<?= base_url().'logout' ?>" class="btn btn-default btn-flat">Log out</a>
                    </div>
                  </li>
                </ul>
              </li>
              <!-- Control Sidebar Toggle Button -->
              <li>
                <a href="#" data-toggle="control-sidebar" onclick="sidebarSwitch('settings')"><i class="fa fa-gears"></i></a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </header>