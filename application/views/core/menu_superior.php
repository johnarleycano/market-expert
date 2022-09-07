<nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
        <div class="me-3">
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-bs-toggle="minimize">
                <span class="icon-menu"></span>
            </button>
        </div>
        <div>
            <a class="navbar-brand brand-logo" href="<?php echo site_url(); ?>">
                <img src="<?php echo base_url(); ?>images/logo.png" alt="logo" />
            </a>
            <a class="navbar-brand brand-logo-mini" href="<?php echo site_url(); ?>">
                <img src="<?php echo base_url(); ?>images/logo.png" alt="logo" />
            </a>
        </div>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-top"> 
        <ul class="navbar-nav">
            <li class="nav-item font-weight-semibold d-none d-lg-block ms-0">
                <h1 class="welcome-text">
                    <span class="text-black fw-bold" id="titulo_modulo"><?php if (isset($datos)) echo $datos['titulo']; ?></span> 
                    <span id="subtitulo_modulo"><?php if (isset($datos)) echo $datos['subtitulo']; ?></span>
                </h1>
                <h3 class="welcome-sub-text" id="descripcion_modulo"><?php if (isset($datos)) echo $datos['descripcion']; ?></h3>
            </li>
        </ul>

        <ul class="navbar-nav ms-auto">
            <li class="nav-item font-weight-semibold d-block d-lg-none">
                <h3 class="welcome-sub-text"><?php echo "{$this->session->userdata('Nombres')} {$this->session->userdata('Apellidos')}"; ?></h3>
            </li>

            <li class="nav-item dropdown user-dropdown">
                <a class="nav-link" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                    <img class="img-xs rounded-circle" src="<?php echo base_url(); ?>images/faces/face0.jpg" alt="Profile image">
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                    <div class="dropdown-header text-center">
                        <img class="img-md rounded-circle" src="<?php echo base_url(); ?>images/faces/face0.jpg" alt="Profile image">
                        <p class="mb-1 mt-3 font-weight-semibold"><?php echo "{$this->session->userdata('Nombres')} {$this->session->userdata('Apellidos')}"; ?></p>
                        <p class="fw-light text-muted mb-0"><?php echo $this->session->userdata('Email'); ?></p>
                    </div>
                    <a class="dropdown-item" href="<?php echo site_url('sesion/cerrar'); ?>"><i class="dropdown-item-icon mdi mdi-power text-primary me-2"></i>Salir</a>
                </div>
            </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-bs-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
        </button>
    </div>
</nav>