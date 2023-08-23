<header id="header" class="full-header transparent-header border-full-header dark header-size-custom" data-sticky-shrink="false" data-sticky-class="not-dark" data-sticky-offset="full" data-sticky-offset-negative="100">
    <div id="header-wrap">
        <div class="container">
            <div class="header-row">

                <div id="logo">
                    <a href="<?php echo str_replace('/index.php', '', current_url()); ?>" class="standard-logo" data-dark-logo="<?php echo base_url('assets/images/profile/' . $facultyData['facultyImage']) ?>"><img src="<?php echo base_url('assets/images/profile/' . $facultyData['facultyImage']) ?>" alt="faculty logo"></a>
                </div>

                <div id="primary-menu-trigger">
                    <svg class="svg-trigger" viewBox="0 0 100 100">
                        <path d="m 30,33 h 40 c 3.722839,0 7.5,3.126468 7.5,8.578427 0,5.451959 -2.727029,8.421573 -7.5,8.421573 h -20"></path>
                        <path d="m 30,50 h 40"></path>
                        <path d="m 70,67 h -40 c 0,0 -7.5,-0.802118 -7.5,-8.365747 0,-7.563629 7.5,-8.634253 7.5,-8.634253 h 20"></path>
                    </svg>
                </div>

                <!-- Primary Navigation -->
                <nav class="primary-menu">
                    <ul class="one-page-menu menu-container" data-easing="easeInOutExpo" data-speed="1250" data-offset="65">
                        <li class="menu-item">
                            <a href="#" class="menu-link" data-href="#wrapper">
                                <div>หน้าหลัก</div>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="#" class="menu-link" data-href="#section-about">
                                <div>เกี่ยวกับ</div>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="#" class="menu-link" data-href="#section-news">
                                <div>ข่าว</div>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="#" class="menu-link" data-href="#section-detail">
                                <div>ผลการดำเนินงาน</div>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="#" class="menu-link" data-href="#section-gallery">
                                <div>ภาพกิจกรรม</div>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="#" class="menu-link" data-href="#section-chanel">
                                <div>CWIE Chanels</div>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <div class="header-wrap-clone"></div>
</header>