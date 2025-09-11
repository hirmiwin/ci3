<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="<?php base_url() ?>" class="brand-link">
    <img src="<?php echo base_url('aset/dist/img/logo.png'); ?>" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">Rapor | AIS</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- User Panel -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <!-- User Image -->
      </div>
      <div class="info">
        <a href="#" class="d-block"><?php echo $this->session->userdata('nama'); ?></a>
      </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Dashboard -->
        <li class="nav-item">
          <a href="<?php echo site_url('dashboard'); ?>"
            class="nav-link <?php echo ($this->uri->segment(1) == 'dashboard') ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
          </a>
        </li>

        <!-- Admin Menu Items -->
        <?php if ($this->session->userdata('role') == 'admin'): ?>
          <!-- Data Master -->
          <li class="nav-item has-treeview <?php echo (in_array($this->uri->segment(1), ['user', 'kelas', 'siswa', 'pelajaran'])) ? 'menu-open' : ''; ?>">
            <a href="#" class="nav-link <?php echo (in_array($this->uri->segment(1), ['user', 'kelas', 'siswa', 'pelajaran'])) ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-database"></i>
              <p>
                Data Master
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo site_url('#'); ?>" class="nav-link <?php echo ($this->uri->segment(1) == '#') ? 'active' : ''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Tahun Ajaran</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo site_url('user'); ?>" class="nav-link <?php echo ($this->uri->segment(1) == 'user') ? 'active' : ''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>User</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo site_url('kelas'); ?>" class="nav-link <?php echo ($this->uri->segment(1) == 'kelas') ? 'active' : ''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Kelas</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo site_url('siswa'); ?>" class="nav-link <?php echo ($this->uri->segment(1) == 'siswa') ? 'active' : ''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Siswa</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo site_url('pelajaran'); ?>" class="nav-link <?php echo ($this->uri->segment(1) == 'pelajaran') ? 'active' : ''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Mata Pelajaran</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="<?php echo site_url('pembelajaran'); ?>" class="nav-link <?php echo ($this->uri->segment(1) == 'pembelajaran') ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-book-open"></i>
              <p>Data Mengajar</p>
            </a>
          </li>
        <?php endif; ?>

        <!-- Teacher Menu Items -->
        <?php if ($this->session->userdata('role') == 'admin' || $this->session->userdata('role') == 'guru'): ?>
          <!-- Nilai Mid Test -->
          <li class="nav-item has-treeview <?php echo ($this->uri->segment(1) == 'nilaimid' || $this->uri->segment(1) == 'rapormid' || $this->uri->segment(1) == 'nilaideskripsimid') ? 'menu-open' : ''; ?>">
            <a href="#" class="nav-link <?php echo ($this->uri->segment(1) == 'nilaimid' || $this->uri->segment(1) == 'rapormid' || $this->uri->segment(1) == 'nilaideskripsimid') ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-book"></i>
              <p>
                Nilai Tengah Semester
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo site_url('nilaimid'); ?>"
                  class="nav-link <?php echo ($this->uri->segment(1) == 'nilaimid') ? 'active' : ''; ?>">
                  <i class="nav-icon far fa-circle"></i>
                  <p>Input NTS</p>
                </a>
              </li>
              <?php if ($this->session->userdata('role') == 'admin' || is_wali_kelas($this->session->userdata('id'))): ?>
                <li class="nav-item">
                  <a href="<?php echo site_url('nilaideskripsimid'); ?>"
                    class="nav-link <?php echo ($this->uri->segment(1) == 'nilaideskripsimid') ? 'active' : ''; ?>">
                    <i class="nav-icon far fa-circle"></i>
                    <p>Input Nilai Deskripsi</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo site_url('rapormid'); ?>"
                    class="nav-link <?php echo ($this->uri->segment(1) == 'rapormid') ? 'active' : ''; ?>">
                    <i class="nav-icon far fa-circle"></i>
                    <p>Rapor Mid Semester</p>
                  </a>
                </li>
              <?php endif; ?>
            </ul>
          </li>

          <!-- Nilai UAS -->
          <li class="nav-item has-treeview <?php echo ($this->uri->segment(1) == 'nilaifinal' || $this->uri->segment(1) == 'nilaifinalmanual'|| $this->uri->segment(1) == 'raporfinal' || $this->uri->segment(1) == 'nilaideskripsifinal') ? 'menu-open' : ''; ?>">
            <a href="#" class="nav-link <?php echo ($this->uri->segment(1) == 'nilaifinal' || $this->uri->segment(1) == 'nilaifinalmanual'|| $this->uri->segment(1) == 'raporfinal' || $this->uri->segment(1) == 'nilaideskripsifinal') ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-book"></i>
              <p>
                Nilai Akhir Semester
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo site_url('nilaifinal'); ?>"
                  class="nav-link <?php echo ($this->uri->segment(1) == 'nilaifinal') ? 'active' : ''; ?>">
                  <i class="nav-icon far fa-circle"></i>
                  <p>Input NAS</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo site_url('nilaifinalmanual/input_nilai'); ?>"
                  class="nav-link <?php echo ($this->uri->segment(1) == 'nilaifinalmanual' && $this->uri->segment(2) == 'input_nilai') ? 'active' : ''; ?>">
                  <i class="nav-icon far fa-circle"></i>
                  <p>Input Manual English</p>
                </a>
              </li>
              <?php if ($this->session->userdata('role') == 'admin' || is_wali_kelas($this->session->userdata('id'))): ?>
                <li class="nav-item">
                  <a href="<?php echo site_url('nilaideskripsifinal'); ?>"
                    class="nav-link <?php echo ($this->uri->segment(1) == 'nilaideskripsifinal') ? 'active' : ''; ?>">
                    <i class="nav-icon far fa-circle"></i>
                    <p>Input Nilai Deskripsi</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo site_url('raporfinal'); ?>"
                    class="nav-link <?php echo ($this->uri->segment(1) == 'raporfinal') ? 'active' : ''; ?>">
                    <i class="nav-icon far fa-circle"></i>
                    <p>Rapor Akhir Semester</p>
                  </a>
                </li>
              <?php endif; ?>
            </ul>
          </li>


        <?php endif; ?>
        <!-- Logout -->
        <li class="nav-item">
          <a href="<?php echo site_url('login/logout'); ?>" class="nav-link">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            <p>Logout</p>
          </a>
        </li>
      </ul>
    </nav>
  </div>
</aside>