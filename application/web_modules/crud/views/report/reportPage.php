    <!-- load pre loader component -->
    <?php $this->load->view('z_template/components/preloaderComp'); ?>

    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">

        <!-- load pre loader component -->
        <?php $this->load->view('z_template/components/topbarComp'); ?>

        <!-- load pre loader component -->
        <?php $this->load->view('z_template/components/leftbarComp'); ?>

        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">

                <!-- load bread crumb component -->
                <?php $this->load->view('z_template/components/breadCrumbComp', isset($page) ? $page : ''); ?>

                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-lg-6 col-sm-12">
                        <div class="card animated bounceIn bg-primary" style="animation-delay: 0.3s;">
                            <div class="card-body">
                                <div class="col">
                                    <h3 class="text-center text-white font-weight-bold">รายงานผลและข้อมูลนำเสนอที่ผ่านมา</h3>
                                    <div class="text-center text-white display-3"><i class="fas fa-file-pdf"></i></div>
                                    <div class="text-center mt-3">
                                        <button type="button" data-id="F01" class="btn btn-light btn-rounded" data-toggle="modal" data-target="#viewmodal"><i class="fa-solid fa-magnifying-glass"></i> เปิดดู</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        <div class="card animated bounceIn delay-5s bg-info" style="animation-delay: 0.4s;">
                            <div class="card-body">
                                <div class="col">
                                    <h3 class="text-center text-white font-weight-bold">แบบเสนอข้อมูล (Template)</h3>
                                    <div class="text-center text-white display-3"><i class="fas fa-file-word"></i></div>
                                    <div class="text-center mt-3">
                                        <a href="<?php echo base_url('assets/files/templates.zip') ?>" target="_self" class="btn btn-light btn-rounded"><i class="fas fa-download"></i> ดาวน์โหลด</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="card animated bounceIn bg-success" style="animation-delay: 0.5s;">
                            <div class="card-body">
                                <div class="col">
                                    <h3 class="text-center text-white font-weight-bold">ส่งรายงานผลการดำเนินงาน และงานนำเสนอ ประจำปี 2023</h3>
                                    <div class="text-center text-white display-3"><i class=" fab fa-google-drive"></i></div>
                                    <div class="text-center mt-3">
                                        <a href="<?php echo isset($this->session->userdata('crudSessionData')['crudLink']) ? $this->session->userdata('crudSessionData')['crudLink'] : '' ?>" target="_blank" class="btn btn-light btn-rounded <?php echo isset($this->session->userdata('crudSessionData')['crudLink']) ? '' : 'disabled' ?>"><i class="fas fa-external-link-alt "></i> เปิดลิงก์</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- load foot component -->
        <?php $this->load->view('z_template/components/footComp'); ?>
    </div>

    <!-- modal container -->
    <div id="modal-container"></div>

    <script>
        window.onload = function() {
            // ==========================================================

            // ==========================================================
        };
    </script>