<!-- ============================================================== -->
<!-- Topbar header - style you can find in pages.scss -->
<!-- ============================================================== -->
<header class="topbar">
    <nav class="navbar top-navbar navbar-expand-md navbar-dark">
        <!-- ============================================================== -->
        <!-- Logo -->
        <!-- ============================================================== -->
        <div class="navbar-header">
            <a class="navbar-brand" href="<?php echo base_url('crud') ?>">
                <b><img src="<?php echo base_url('assets/images/logo-mini-cwie.png') ?>" alt="homepage" class="light-logo" /></b>
            </a>
        </div>

        <div class="navbar-collapse">
            <!-- ============================================================== -->
            <!-- toggle and nav items -->
            <!-- ============================================================== -->
            <ul class="navbar-nav me-auto">
                <li class="d-none d-md-block d-lg-block">
                    <a href="<?php echo base_url('crud') ?>" class="p-l-15">
                        <img src="<?php echo base_url('assets/images/cwie-logo-text.png') ?>" alt="home" class="light-logo" alt="home" />
                    </a>
                </li>
            </ul>
            <!-- ============================================================== -->
            <!-- User profile -->
            <!-- ============================================================== -->
            <ul class="navbar-nav my-lg-0">
                <li class="nav-item dropdown u-pro">
                    <a class="nav-link dropdown-toggle waves-effect waves-dark profile-pic" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="<?php echo $this->session->userdata('crudSessionData')['crudProfileImage'] ?>" alt="user">
                        <span class="hidden-md-down">
                            <?php echo isset($this->session->userdata('crudSessionData')['crudSurname']) ? $this->session->userdata('crudSessionData')['crudName'] . ' ' .  $this->session->userdata('crudSessionData')['crudSurname'] . ' (' . ucfirst($this->session->userdata('crudSessionData')['crudPermission']) . ')' : $this->session->userdata('crudSessionData')['crudName'] . ' ' . '(' . ucfirst($this->session->userdata('crudSessionData')['crudPermission']) . ')' ?> &nbsp;<i class="fa fa-angle-down"></i>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end animated flipInY">
                        <a href="<?php echo base_url('crud/profile') . $this->session->userdata('crudSessionData')['crudPermission'] ?>" class="dropdown-item"><i class="fas fa-user-circle"></i> <?php echo in_array($this->session->userdata('crudSessionData')['crudPermission'], ['faculty', 'major']) ? 'ข้อมูลหน่วยงาน' : 'ข้อมูลส่วนตัว' ?></a>
                        <a href="<?php echo base_url('crud/help') ?>" class="dropdown-item"><i class="fas fa-question-circle"></i> คู่มือ</a>
                        <div class="dropdown-divider"></div>
                        <a href="<?php echo base_url('crud/auth/onSignOut') ?>" class="dropdown-item"><i class="fa fa-power-off"></i> ออกจากระบบ</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>