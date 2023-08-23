<!-- Top Bar
============================================= -->
<div id="top-bar">
    <div class="container clearfix">
        <div class="row justify-content-between">
            <div class="col-6 col-md-auto">
                <!-- Top Social
				============================================= -->
                <ul id="top-social">
                    <li><a href="https://www.crru.ac.th/2021/" target="_blank" class="si-facebook"><span class="ts-icon"><i class="icon-university"></i></span><span class="ts-text">มหาวิทยาลัยราชภัฏเชียงราย</span></a></li>
                    <li><a href="https://clli.crru.ac.th/" target="_blank" class="si-github"><span class="ts-icon"><i class="icon-school"></i></span><span class="ts-text">สถาบันการเรียนรู้ตลอดชีวิต</span></a></li>
                    <li><a href="https://creditbank.crru.ac.th/" target="_blank" class="si-twitter"><span class="ts-icon"><i class="icon-piggy-bank"></i></span><span class="ts-text">คลังหน่วยกิต</span></a></li>
                    <li><a href="https://lifelong.crru.ac.th/" target="_blank" class="si-dribbble"><span class="ts-icon"><i class="icon-book"></i></span><span class="ts-text">หลักสูตรส่งเสริมทักษะ</span></a></li>
                </ul>

            </div>
            <div class="col-6 col-md-auto">
                <ul class="top-links-container">
                    <li class="top-links-item"><a href="crud">เข้าสู่ระบบ</a></li>
                </ul>
            </div>
        </div>
    </div>
</div> 
</div>
</div>

<!-- Header
============================================= -->
<header id="header" class="header-size-sm" data-sticky-shrink="false">
    <div class="container">
        <div class="header-row">

            <!-- Logo
			============================================= -->
            <div id="logo" class="ms-auto ms-lg-0 me-lg-auto">
                <a href="<?php echo base_url() ?>" class="standard-logo"><img src="<?php echo base_url('assets/images/logoc@2x.png') ?>" alt="CWIE Logo"></a>
                <a href="<?php echo base_url() ?>" class="retina-logo"><img src="<?php echo base_url('assets/images/logoc@2x.png') ?>" alt="CWIE Logo"></a>
            </div>

            <div class="header-misc d-none d-lg-flex">
                <ul class="header-extras">
                    <li>
                        <i class="i-plain icon-call m-0"></i>
                        <div class="he-text">
                            เบอร์ติดต่อ
                            <span>053-776-008 ต่อ 1007</span>
                        </div>
                    </li>
                    <li>
                        <i class="i-plain icon-line2-envelope m-0"></i>
                        <div class="he-text">
                            อีเมล
                            <span>clli@crru.ac.th</span>
                        </div>
                    </li>
                    <li>
                        <i class="i-plain icon-line-clock m-0"></i>
                        <div class="he-text">
                            เวลาทำการ
                            <span>จันทร์ - ศุกร์ | 08:30 - 16:30</span>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div id="header-wrap">
        <div class="container">
            <div class="header-row justify-content-between flex-row-reverse flex-lg-row justify-content-lg-center">

                <div id="primary-menu-trigger">
                    <svg class="svg-trigger" viewBox="0 0 100 100">
                        <path d="m 30,33 h 40 c 3.722839,0 7.5,3.126468 7.5,8.578427 0,5.451959 -2.727029,8.421573 -7.5,8.421573 h -20"></path>
                        <path d="m 30,50 h 40"></path>
                        <path d="m 70,67 h -40 c 0,0 -7.5,-0.802118 -7.5,-8.365747 0,-7.563629 7.5,-8.634253 7.5,-8.634253 h 20"></path>
                    </svg>
                </div>

                <!-- Primary Navigation
				============================================= -->
                <nav class="primary-menu with-arrows">
                    <ul class="menu-container">
                        <li class="menu-item <?php echo $page == 'index' ? 'current' : ''; ?> "><a class="menu-link" href="<?php echo base_url() ?>">
                                <div>หน้าหลัก</div>
                            </a></li>
                        <li class="menu-item <?php echo in_array($page, ['about', 'board', 'news']) ? 'current' : ''; ?>"><a class="menu-link" href="<?php echo base_url('about') ?>">
                                <div>เกี่ยวกับ CWIE</div>
                            </a>
                            <ul class="sub-menu-container">
                                <li class="menu-item"><a class="menu-link" href="<?php echo base_url('about') ?>">
                                        <div>เกี่ยวกับ CWIE</div>
                                    </a></li>
                                <li class="menu-item"><a class="menu-link" href="<?php echo base_url('board') ?>">
                                        <div>คณะกรรมการ</div>
                                    </a></li>
                                <li class="menu-item"><a class="menu-link" href="<?php echo base_url('news') ?>">
                                        <div>ข่าวประชาสัมพันธ์</div>
                                    </a></li>
                                <li class="menu-item"><a class="menu-link" href="<?php echo base_url('quality') ?>">
                                        <div>การประกันคุณภาพ</div>
                                    </a></li>
                                <li class="menu-item"><a class="menu-link" href="<?php echo base_url('trophy') ?>">
                                        <div>รางวัลและความภาคภูมิใจ</div>
                                    </a></li>
                            </ul>
                        </li>
                        <li class="menu-item <?php echo $page == '5' ? 'current' : ''; ?>">
                            <a class="menu-link" href="#">
                                <div> นักศึกษา CWIE</div>
                            </a>
                        </li>
                        <li class="menu-item <?php echo $page == '5' ? 'current' : ''; ?>">
                            <a class="menu-link" href="#">
                                <div>เครือข่ายเครือข่าย CWIE </div>
                            </a>
                        </li>
                        <li class="menu-item <?php echo $page == '5' ? 'current' : ''; ?>">
                            <a class="menu-link" href="<?php echo base_url('#facultyList') ?>">
                                <div>หน่วยงานจัดการศึกษา</div>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <div class="header-wrap-clone"></div>

</header>