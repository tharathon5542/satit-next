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

            <div id="bannerContainer" class="row el-element-overlay"></div>
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
        fetchBanner();
        // ==========================================================
    };

    function fetchBanner() {
        // get banner
        $.ajax({
            url: "<?php echo base_url('crud/banner/getBanner') ?>",
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

                $("#bannerContainer").children().remove();

                let addBannerCard = `
                    <div id="addBannerCard" class="col-lg-4 col-md-6 ${response.data.length > 0 ? 'd-none' : 'animated bounceIn'}">
                        <div class="el-card-item shadow">
                            <div class="el-card-avatar el-overlay-1"> <img class="img-fluid" src="<?php echo base_url('assets/images/background/image-holder.png') ?>" alt="Add Banner" />
                                <div class="el-overlay">
                                    <ul class="el-info">
                                        <li>
                                            <button class="btn default btn-outline" onclick="openAddModal()">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    `;

                $('#bannerContainer').append(addBannerCard);

                $.each(response.data, function(index, value) {
                    let bannerResponse = `
                        <div class="col-lg-4 col-md-6 ">
                            <div class="el-card-item shadow">
                                <div class="el-card-avatar el-overlay-1"> 
                                    <img class="img-fluid" src="${value.bannerPath}" alt="user" ${value.bannerDisplay == false ? 'style="filter: blur(5px);"' : ''} />
                                    <div class="el-overlay">
                                        <ul class="el-info">
                                            <li>
                                                <a class="btn default btn-outline image-popup-vertical-fit" href="${value.bannerPath}">
                                                    <i class="icon-magnifier"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <button class="btn default btn-outline" onclick="openEditModal(${value.bannerID})">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                            </li>
                                            <li>
                                                <button class="btn default btn-outline" onClick="onDelete(${value.bannerID})">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    $('#addBannerCard').before(bannerResponse);

                    // adjust this value to control the delay between animations
                    let delayFactor = 0.2;
                    // animation after add
                    $('#addBannerCard').prev().addClass('animated bounceIn').css('animation-delay', index * delayFactor + 's').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
                        $(this).removeClass('animated bounceIn').css('animation-delay', ''); // reset the animation delay
                    });

                    setTimeout(function() {
                        $('#addBannerCard').removeClass('d-none');
                        $('#addBannerCard').addClass('animated bounceIn').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
                            $(this).removeClass('animated bounceIn');
                        });
                    }, response.data.length * 200); // delay the animation by the total number of banners * 200 milliseconds

                });

                $('.image-popup-vertical-fit').magnificPopup({
                    type: 'image',
                    closeOnContentClick: true,
                    mainClass: 'mfp-img-mobile mfp-fade',
                    image: {
                        verticalFit: true
                    },
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
            url: "<?php echo base_url('crud/banner/addModal') ?>",
            dataType: "json",
            success: function(response) {
                if (!response.status) {
                    showErrorSweetalert("ผิดพลาด!", response.errorMessage);
                    return;
                }
                // Insert modal content into the page
                $("#modal-container").html(response.data);
                // Show the modal
                $("#bannerAddModal").modal("show");
            },
            error: function(xhr, status, error) {
                showErrorSweetalert('ผิดพลาด!', error, 1500);
            }
        });
    }

    function openEditModal(bannerID) {
        // Load modal content using AJAX
        $.ajax({
            url: "<?php echo base_url('crud/banner/editModal/') ?>" + bannerID,
            type: 'GET',
            dataType: "json",
            success: function(response) {
                if (!response.status) {
                    showErrorSweetalert("ผิดพลาด!", response.errorMessage);
                    return;
                }
                // Insert modal content into the page
                $("#modal-container").html(response.data);

                // set data to form field
                $('#banerID').val(response.bannerResponse.bannerID);
                $('#bannerFile').dropify({
                    messages: {
                        'default': 'ลาก หรือเลือกไฟล์เพื่อทำการอัปโหลด',
                        'replace': 'ลาก หรือเลือกไฟล์เพื่อทำการเปลี่ยน',
                    },
                    'defaultFile': '<?php echo base_url('assets/images/bannerSlider/') ?>' + response.bannerResponse.bannerImageName + response.bannerResponse.bannerImageType
                });
                $('#bannerOrder').val(response.bannerResponse.bannerImageOrder);
                $('#bannerDisplay').prop('checked', response.bannerResponse.bannerImageDisplay == 1 ? true : false);

                // Show the modal
                $("#bannerEditModal").modal("show");
            },
            error: function(xhr, status, error) {
                showErrorSweetalert('ผิดพลาด!', error, 1500);
            }
        });
    }

    function onDelete(bannerID) {
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
                    url: '<?php echo base_url('crud/banner/onDeleteBanner/') ?>' + bannerID,
                    type: 'POST',
                    dataType: 'json',
                    success: function(response) {
                        if (!response.status) {
                            showErrorSweetalert("ผิดพลาด!", response.errorMessage);
                            return;
                        }
                        showSuccessSweetalert("สำเร็จ!", "ลบข้อมูลแล้ว", 1500);
                        setTimeout(function() {
                            fetchBanner();
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