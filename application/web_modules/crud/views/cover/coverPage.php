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
           
            <div class="card animated bounceIn" style="animation-delay: 0.2s;">
                <div class="card-body text-center">
                    <small class="text-muted">ขนาดไฟล์ 2000 x 1335 (ไม่เกิน 2 MB)</small>
                </div>
            </div>
            <div class="el-element-overlay">
                <div class="card d-block animated bounceIn" style="animation-delay: 0.2s;">
                    <div class="el-card-item ">
                        <div class="el-card-avatar el-overlay-1 ">
                            <img id="coverImageDisplay" src="<?php echo base_url('assets/images/image-holder.jpg') ?>" alt="cover image" />
                            <div class="el-overlay">
                                <ul class="el-info">
                                    <li>
                                        <a id="zoomcoverImagePreview" class="btn default btn-outline image-popup-vertical-fit" href="<?php echo base_url('assets/images/image-holder.jpg') ?>">
                                            <i class="icon-magnifier"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <button class="btn default btn-outline" onclick="profileImageSelect()">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <form id="coverImageForm" enctype="multipart/form-data" novalidate>
                <input type="file" id="coverImage" name="coverImage" accept="image/png, image/jpeg, image/jpg" hidden>
            </form>
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
        fetchCover();

        $('#coverImage').change(function() {
            // Get the form data
            const formData = new FormData($('#coverImageForm')[0]);

            // Submit the form using AJAX
            $.ajax({
                type: 'POST',
                url: "<?php echo base_url('crud/cover/onChangeCoverImage') ?>",
                data: formData,
                dataType: 'json',
                processData: false,
                contentType: false,
                beforeSend: function() {
                    showLoadingSweetalert();
                },
                success: function(response) {
                    if (!response.status) {
                        showErrorSweetalert("ผิดพลาด!", response.errorMessage, 2000);
                        return;
                    }
                    showSuccessSweetalert("สำเร็จ!", "แก้ไขข้อมูลปกเว็บไซต์แล้ว", 1500);
                    setTimeout(function() {
                        fetchCover();
                    }, 1500)
                },
                error: function(xhr, status, error) {
                    showErrorSweetalert('ผิดพลาด!', error, 1500);
                }
            });
        });

        // ==========================================================
    };

    function fetchCover() {
        // get cover
        $.ajax({
            url: "<?php echo base_url('crud/cover/getCoverImage') ?>",
            method: "GET",
            dataType: "json",
            beforeSend: function() {
                showLoadingSweetalert();
            },
            success: function(response) {
                if (!response.status) {
                    showErrorSweetalert("ผิดพลาด!", response.errorMessage);
                    return;
                }

                if (response.data != false) {
                    $('#coverImageDisplay').attr('src', '<?php echo base_url('assets/images/cover/') ?>' + response.data['coverImageName'] + response.data['coverImageType'])
                    $('#zoomcoverImagePreview').attr('href', '<?php echo base_url('assets/images/cover/') ?>' + response.data['coverImageName'] + response.data['coverImageType'])
                }

                Swal.close();
            },
            error: function(xhr, status, error) {
                showErrorSweetalert('ผิดพลาด!', error, 1500);
            }
        });
    }

    function profileImageSelect() {
        $('#coverImage').click();
    }
</script>