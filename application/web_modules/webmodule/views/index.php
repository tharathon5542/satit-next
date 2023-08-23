<body class="stretched">

    <div id="wrapper" class="clearfix">

        <!-- load header component -->
        <?php $this->load->view('z_template/components/headerComp', $facultyData) ?>

        <!-- load slider component -->
        <?php $this->load->view('z_template/components/sliderComp', $facultyData) ?>

        <!-- Content
		============================================= -->
        <section id="content">
            <div class="content-wrap py-0">
                <div id="section-about" class="center page-section">
                    <div class="container clearfix">
                        <h2 class="mx-auto bottommargin font-body" style="max-width: 700px; font-size: 40px;">นโยบาย CWIE</h2>
                        <p class="lead mx-auto bottommargin" style="max-width: 800px;"><?php echo $facultyData['facultyCwiePolicy'] ?></p>
                    </div>
                </div>
                <div id="section-news">
                    <div class="section mb-4">
                        <div class="container clearfix">
                            <div class="mx-auto center" style="max-width: 900px;">
                                <h2 class="mb-0 fw-bold ls1">ข่าวประชาสัมพันธ์</h2>
                            </div>
                        </div>
                    </div>
                    <div class="container clearfix">
                        <?php if (isset($newsData)) { ?>
                            <div class="row">
                                <!-- load news component -->
                                <?php $this->load->view('z_template/components/newsComp', $newsData); ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div id="section-detail">
                    <div class="section mb-4">
                        <div class="container clearfix">
                            <div class="d-flex no-block justify-content-center">
                                <h2 class="mb-0 fw-bold ls1">ผลการดำเนินงาน</h2>
                                <select id="moduleYearID" onchange="setYearSessionData(this.value)" class="form-select ms-4" style="width: auto;">
                                    <option value="0">ทุกปีการศึกษา</option>
                                    <?php
                                    // query year
                                    $queryYear = $this->db->get('cwie_year');
                                    foreach ($queryYear->result() as $year) { ?>
                                        <option value="<?php echo $year->year_id ?>">ปีการศึกษา <?php echo $year->year_title ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- load detail data -->
                    <?php $this->load->view('z_template/components/detailDataComp', $facultyData); ?>
                </div>
                <div id="section-gallery">
                    <div class="section mb-4">
                        <div class="container clearfix">
                            <div class="mx-auto center" style="max-width: 900px;">
                                <h2 class="mb-0 fw-bold ls1">รูปภาพกิจกรรม</h2>
                            </div>
                        </div>
                    </div>
                    <div class="container clearfix">
                        <!-- load news / event images component -->
                        <?php $this->load->view('z_template/components/imageGalleryComp', $imagesGalleryData); ?>
                    </div>
                </div>
                <div id="section-chanel" class="page-section pt-0">
                    <div class="section mb-4">
                        <div class="container clearfix">
                            <div class="mx-auto center" style="max-width: 900px;">
                                <h2 class="mb-0 fw-bold ls1">CRRU : CWIE Chanels</h2>
                            </div>
                        </div>
                    </div>
                    <div class="container clearfix">
                        <div class="owl-carousel portfolio-carousel carousel-widget" data-margin="20" data-pagi="false" data-autoplay="5000" data-items-xs="1" data-items-sm="2" data-items-md="3" data-items-lg="4">
                            <!-- load video component -->
                            <?php $this->load->view('z_template/components/videoComp', $videoData); ?>
                        </div>
                    </div>
                </div>
                <!-- ------- -->
            </div>
        </section>

        <div id="modal-container"></div>

    </div>


    <!-- load footer component -->
    <?php $this->load->view('z_template/components/footerComp', $facultyData) ?>
    </div>
</body>

<script>
    window.onload = function() {
        // ==========================================================
        $('#moduleYearID').val('<?php echo $this->session->userdata('moduleYearID') ? $this->session->userdata('moduleYearID') : 0 ?>');
        // ==========================================================
    }

    function setYearSessionData(yearID) {
        $.ajax({
            url: '<?php echo base_url('webmodule/module/setYearSession/') ?>' + yearID,
            type: "POST",
            dataType: "json",
            beforeSend: function() {
                showLoadingSweetalert();
            },
            success: function(response) {
                if (!response.status) {
                    showErrorSweetalert("ผิดพลาด!", response.errorMessage);
                    return;
                }
                location.reload();
            },
            error: function(xhr, status, error) {
                showErrorSweetalert('ผิดพลาด!', error, 1500);
            }
        });
    }
</script>