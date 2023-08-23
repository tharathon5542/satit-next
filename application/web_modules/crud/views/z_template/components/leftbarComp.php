<!-- ============================================================== -->
<!-- Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->
<div class="side-mini-panel">
    <ul class="mini-nav">
        <div class="togglediv"><a href="javascript:void(0)" id="togglebtn"><i class="ti-menu"></i></a></div>
        <!-- Menu -->
        <li class="">
            <a href="javascript:void(0)"><i class="ti-layout-grid2"></i></a>
            <div class="sidebarmenu">
                <!-- Left navbar-header -->
                <h3 class="menu-title">Menu <?php echo '( ' . ucfirst($this->session->userdata('crudSessionData')['crudPermission']) . ' )' ?> </h3>
                <ul class="sidebar-menu">
                    <li>
                        <a href="<?php echo base_url('crud/index') ?>"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                    </li>
                    <?php { ?>
                        <?php if ($this->session->userdata('crudSessionData')['crudPermission'] == 'admin') { ?>
                            <!-- admin menu -->
                            <li class="menu">
                                <a href="javascript:void(0)"><i class="fas fa-database"></i> จัดการข้อมูลคณะ|สาขา<i class="fa fa-angle-left float-end"></i></a>
                                <ul class="sub-menu">
                                    <li><a href="<?php echo base_url('crud/faculty') ?>"><i class="fas fa-database"></i> ข้อมูลคณะ</a></li>
                                    <li><a href="<?php echo base_url('crud/major') ?>"><i class="fas fa-database"></i> ข้อมูลสาขา</a></li>
                                </ul>
                            </li>
                            <li class="menu">
                                <a href="javascript:void(0)"><i class="fas fa-database"></i> จัดการข้อมูลหลักสูตร CWIE<i class="fa fa-angle-left float-end"></i></a>
                                <ul class="sub-menu">
                                    <li><a href="<?php echo base_url('crud/course') ?>"><i class="fas fa-book"></i> ข้อมูลหลักสูตร</a></li>
                                    <li><a href="<?php echo base_url('crud/year') ?>"><i class="fas fa-calendar"></i> ข้อมูลปีการศึกษา</a></li>
                                    <li><a href="<?php echo base_url('crud/CategoryCourse') ?>"><i class="fas fa-book"></i> ข้อมูลประเภทหลักสูตร CWIE</a></li>
                                    <li><a href="<?php echo base_url('crud/isced') ?>"><i class="fas fa-database"></i> ข้อมูล ISCED 2013</a></li>
                                    <li><a href="<?php echo base_url('crud/profession') ?>"><i class="fas fa-user-tie"></i> ข้อมูลวิชาชีพ</a></li>
                                </ul>
                            </li>
                            <li class="menu">
                                <a href="javascript:void(0)"><i class="fas fa-database"></i> จัดการข้อมูลบุคลากร CWIE<i class="fa fa-angle-left float-end"></i></a>
                                <ul class="sub-menu">
                                    <li><a href="<?php echo base_url('crud/personnel') ?>"><i class="fas fa-database"></i> ข้อมูลบุคลากร CWIE</a></li>
                                    <li><a href="<?php echo base_url('crud/pstype') ?>"><i class="fas fa-database"></i> ข้อมูลประเภทบุคลากร</a></li>
                                    <li><a href="<?php echo base_url('crud/pstraining') ?>"><i class="fas fa-database"></i> ข้อมูลการฝึกอบรม</a></li>
                                    <li><a href="<?php echo base_url('crud/pstrophy') ?>"><i class="fas fa-database"></i> ข้อมูลรางวัล</a></li>
                                </ul>
                            </li>
                            <li class="menu">
                                <a href="javascript:void(0)"><i class="fas fa-database"></i> จัดการข้อมูลเครือข่าย CWIE<i class="fa fa-angle-left float-end"></i></a>
                                <ul class="sub-menu">
                                    <li><a href="<?php echo base_url('crud/workplace') ?>"><i class="fas fa-building"></i> ข้อมูลเครือข่าย CWIE</a></li>
                                    <li><a href="<?php echo base_url('crud/WPType') ?>"><i class="fas fa-database"></i> ประเภทเครือข่าย CWIE</a></li>
                                </ul>
                            </li>
                            <li class="menu">
                                <a href="javascript:void(0)"><i class="fas fa-globe"></i> จัดการข้อมูลเว็บไซต์<i class="fa fa-angle-left float-end"></i></a>
                                <ul class="sub-menu">
                                    <li><a href="<?php echo base_url('crud/video') ?>"><i class="fas fa-video"></i> ข้อมูลวิดิโอ</a></li>
                                    <li><a href="<?php echo base_url('crud/news') ?>"><i class="far fa-newspaper"></i> ข่าวประชาสัมพันธ์</a></li>
                                    <li><a href="<?php echo base_url('crud/banner') ?>"><i class="fas fa-images"></i> แบนเนอร์</a></li>
                                    <li><a href="<?php echo base_url('crud/customDisplayData') ?>"><i class="fas fa-database"></i> ข้อมูลผลการดำเนินงาน</a></li>
                                </ul>
                            </li>
                        <?php } ?>
                    <?php } ?>
                    <?php { ?>
                        <?php if ($this->session->userdata('crudSessionData')['crudPermission'] == 'faculty') { ?>
                            <!-- faculty menu -->
                            <li class="menu">
                                <a href="javascript:void(0)"><i class=" fas fa-globe"></i> จัดการข้อมูลเว็บไซต์<i class="fa fa-angle-left float-end"></i></a>
                                <ul class="sub-menu">
                                    <li><a href="<?php echo base_url('crud/cover') ?>"><i class="fas fa-images"></i> ภาพปกเว็บไซต์</a></li>
                                    <li><a href="<?php echo base_url('crud/video') ?>"><i class="fas fa-video"></i> ข้อมูลวิดิโอ</a></li>
                                    <li><a href="<?php echo base_url('crud/news') ?>"><i class="far fa-newspaper"></i> ข่าวประชาสัมพันธ์</a></li>
                                    <li><a href="<?php echo base_url('crud/customDisplayData') ?>"><i class="fas fa-database"></i> ข้อมูลผลการดำเนินงาน</a></li>
                                </ul>
                            </li>
                            <li><a href="<?php echo base_url('crud/major') ?>"><i class="fas fa-users"></i> ข้อมูลสาขา</a></li>
                        <?php } ?>
                    <?php } ?>
                    <?php { ?>
                        <?php if ($this->session->userdata('crudSessionData')['crudPermission'] == 'major') { ?>
                            <!-- major menu -->
                            <li class="menu">
                                <a href="javascript:void(0)"><i class="fas fa-database"></i> จัดการข้อมูล<i class="fa fa-angle-left float-end"></i></a>
                                <ul class="sub-menu">
                                    <li><a href="<?php echo base_url('crud/course') ?>"><i class="fas fa-book"></i> ข้อมูลหลักสูตร</a></li>
                                    <li><a href="<?php echo base_url('crud/personnel') ?>"><i class="fas fa-users"></i> ข้อมูลบุคลากร CWIE</a></li>
                                    <li><a href="<?php echo base_url('crud/workplace') ?>"><i class="fas fa-building"></i> ข้อมูลเครือข่าย CWIE</a></li>
                                </ul>
                            </li>
                        <?php } ?>
                    <?php } ?>
                </ul>
            </div>
        </li>
        <!-- Chat -->
        <li class=""><a href="javascript:void(0)"><i class="far fa-comments"></i></a>
            <div class="sidebarmenu">
                <h3 class="menu-title">Chat</h3>
                <ul class="sidebar-menu">
                    <li><a href="chat"><i class="fas fa-comments"></i> ระบบส่งข้อความ</a></li>
                </ul>
            </div>
        </li>
        <!-- Mail SMS-->
        <?php if ($this->session->userdata('crudSessionData')['crudPermission'] == 'admin') { ?>
            <li class=""><a href="javascript:void(0)"><i class="ti-email"></i></a>
                <div class="sidebarmenu">
                    <!-- Left navbar-header -->
                    <h3 class="menu-title">E-mail | SMS</h3>
                    <ul class="sidebar-menu">
                        <li><a href="mail"><i class="far fa-envelope"></i> Mailbox</a></li>
                        <li><a href="<?php echo base_url('crud/sms') ?>"><i class="fas fa-sms"></i> SMS</a></li>
                    </ul>
                    <!-- Left navbar-header end -->
                </div>
            </li>
        <?php } ?>
    </ul>
</div>