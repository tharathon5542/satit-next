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
            <?php
            // load admin profile view
            if ($this->session->userdata('crudSessionData')['crudPermission'] == "admin")
                $this->load->view('profileAdmin');

            // load faculty profile view
            if ($this->session->userdata('crudSessionData')['crudPermission'] == "faculty")
                $this->load->view('profileFaculty');

            // load major profile view
            if ($this->session->userdata('crudSessionData')['crudPermission'] == "major")
                $this->load->view('profileMajor');

            // load workplace profile view
            if ($this->session->userdata('crudSessionData')['crudPermission'] == "workplace")
                $this->load->view('profileWorkplace');

            // load student profile view
            if ($this->session->userdata('crudSessionData')['crudPermission'] == "student")
                $this->load->view('profilestudent');
            ?>

        </div>
    </div>
    <!-- load foot component -->
    <?php $this->load->view('z_template/components/footComp'); ?>
</div>