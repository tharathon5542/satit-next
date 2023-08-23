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
            <div class="d-flex no-block align-items-center mb-4">
                <h4>ข้อมูลวิดิโอ</h4>
                <button class="btn btn-success text-white ms-auto" onclick="openAddModal()">เพิ่มวิดิโอ</button>
            </div>
            <!-- ============================================================== -->
            <!-- video container -->
            <!-- ============================================================== -->
            <div id="videoContainer" class="row el-element-overlay">
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
        fetchVideo();

    };

    function fetchVideo() {
        // get video
        $.ajax({
            url: "<?php echo base_url('crud/video/getVideo') ?>",
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
                $("#videoContainer").empty();
                $.each(response.data, function(index, value) {
                    if (value.videoType == 'youtube') {
                        var video = `
                            <div class="el-card-item">
                                <div class="el-card-avatar el-overlay-1"> 
                                    <img class="img-fluid" src="${value.videoThumbnailName}" alt="thumbnail" />
                                    <div class="el-overlay">
                                        <ul class="el-info">
                                            <li>
                                                <a class="btn default btn-outline popup-youtube" href="${value.videoName}">
                                                 <i class="icon-magnifier"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        `;
                    } else {
                        var video = `
                        <div class="el-card-item">
                                <div class="el-card-avatar el-overlay-1"> 
                                    <img class="img-fluid" src="<?php echo base_url('assets/images/videoThumbnail/') ?>${value.videoThumbnailName}${value.videoThumbnailType}" alt="thumbnail" />
                                    <div class="el-overlay">
                                        <ul class="el-info">
                                            <li>
                                                <a class="btn default btn-outline popup-youtube" href="<?php echo base_url('assets/videos/') ?>${value.videoName}${value.videoType}">
                                                 <i class="icon-magnifier"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        `;
                    }

                    let videoCard = `
                    <div class="col-xs-12 col-md-6 col-lg-4">
                        <div class="card shadow ">
                            <div class="card-body">
                                <h5 class="card-title">${value.videoType == 'youtube' ? '<i class="fab fa-youtube"></i>' : '<i class="fas fa-video"></i>'}</h5>
                                ${typeof video != 'undefined' ? video : ''}
                               ${value.videoTitle}</br>
                                <small>ลงโดย : ${value.videoAuthor}</small></br>
                                <small>วันที่ : ${value.videoDateTH} เวลา : ${value.videoTime}</small>
                            </div>
                            <div class="card-footer d-flex no-block">
                                <button class="btn btn-info text-white ms-auto" onClick="openEditModal(${value.videoID})"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-danger text-white ms-2" onClick="onDeleteVideo(${value.videoID})"><i class="fas fa-trash-alt" ></i></button>
                            </div>
                        </div>
                    </div>`;

                    $('#videoContainer').append(videoCard);

                    $(".popup-youtube").magnificPopup({
                        type: "iframe",
                        mainClass: "mfp-fade",
                        removalDelay: 160,
                        preloader: false,
                        fixedContentPos: false,
                    });

                    // adjust this value to control the delay between animations
                    let delayFactor = 0.2;
                    // animation after add
                    $('.card').each(function(index) {
                        $(this).addClass('animated bounceIn').css('animation-delay', (index + 1) * delayFactor + 's').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
                            $(this).removeClass('animated bounceIn').css('animation-delay', '');
                        });
                    });

                });

                Swal.close();
            },
            error: function(xhr, status, error) {
                showErrorSweetalert('ผิดพลาด!', error, 1500);
            }
        });
    }

    function openAddModal() {
        // Load modal content using AJAX
        $.ajax({
            url: "<?php echo base_url('crud/video/addModal') ?>",
            dataType: "json",
            success: function(response) {
                if (!response.status) {
                    showErrorSweetalert("ผิดพลาด!", response.errorMessage);
                    return;
                }
                // Insert modal content into the page
                $("#modal-container").html(response.data);
                // Show the modal
                $("#videoAddModal").modal("show");

            },
            error: function(xhr, status, error) {
                showErrorSweetalert('ผิดพลาด!', error, 1500);
            }
        });
    }

    function openEditModal(videoID) {
        // Load modal content using AJAX
        $.ajax({
            url: "<?php echo base_url('crud/video/editModal/') ?>" + videoID,
            dataType: "json",
            success: function(response) {
                if (!response.status) {
                    showErrorSweetalert("ผิดพลาด!", response.errorMessage);
                    return;
                }

                // Insert modal content into the page
                $("#modal-container").html(response.data);

                $('input[name="videoID"]').val(response.videoResponse['videoID']);
                $('input[name="videoTitle"]').val(response.videoResponse['videoTitle']);

                if (response.videoResponse['videoType'] == 'youtube') {
                    $('#navTabVideoFile').addClass('d-none');
                    $('#videoFileTabPane').addClass('d-none');
                    $('#videoURL').val(response.videoResponse['videoName']);
                    response.videoResponse['isWelcomeVideo'] ? $('#welcomeVideo').attr('checked', 'checked') : $('#welcomeVideo').removeAttr('checked') ;

                } else {
                    $('#navTabVideoURL').addClass('d-none');
                    $('#videoURLTabPane').addClass('d-none');
                    $('#videoPreview').attr('src', '<?php echo base_url('assets/videos/') ?>' + response.videoResponse['videoName'] + response.videoResponse['videoType']);
                    $('#videoThumbnailPreview').attr('src', '<?php echo base_url('assets/images/videoThumbnail/') ?>' + response.videoResponse['videoThumbnailName'] + response.videoResponse['videoThumbnailType']);
                    $('#videoPreview').removeAttr('hidden');
                    $('#videoThumbnailPreview').removeAttr('hidden');
                }

                // Show the modal
                $("#videoEditModal").modal("show");

            },
            error: function(xhr, status, error) {
                showErrorSweetalert('ผิดพลาด!', error, 1500);
            }
        });
    }

    function onDeleteVideo(videoID) {
        // Display a SweetAlert confirmation dialog
        Swal.fire({
            title: 'ยืนยันการลบ?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'ยืนยันการลบ',
            cancelButtonText: 'ย้อนกลับ',
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: '<?php echo base_url('crud/video/onDeleteVideo/') ?>' + videoID,
                    type: "POST",
                    dataType: "json",
                    success: function(response) {
                        if (!response.status) {
                            showErrorSweetalert("ผิดพลาด!", response.errorMessage);
                            return;
                        }
                        showSuccessSweetalert("สำเร็จ!", "ลบข้อมูลแล้ว", 1500);
                        setTimeout(function() {
                            fetchVideo();
                        }, 1500)
                    },
                    error: function(xhr, status, error) {
                        showErrorSweetalert('ผิดพลาด!', error, 1500);
                    }
                });
            }
        })
    }
</script>