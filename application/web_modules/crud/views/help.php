<body class="skin-default fixed-layout rmv-right-panel">

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

                <div class="row">
                    <div class="col-12">
                        <div class="card animated bounceInRight" style="animation-delay: 0.3s;">
                            <div class="card-body">
                                <iframe class="embed-responsive-item" src="<?php echo base_url('assets/files/cwie2022_help.pdf'); ?>" style="width: 100%; min-height:100vh;">
                                    <p style="font-size: 110%;"><em><strong>ERROR: </strong> An &#105;frame should be displayed here but your browser version does not support &#105;frames. </em>Please update your browser to its most recent version and try again.</p>
                                </iframe>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- load foot component -->
        <?php $this->load->view('z_template/components/footComp'); ?>
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->

</body>