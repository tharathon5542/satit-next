<div id="videoEditModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">แก้ไขข้อมูลวิดิโอ</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item"> <a id="navTabVideoFile" class="nav-link active " data-bs-toggle="tab" href="#videoFileTabPane" role="tab"><span class="hidden-sm-up"><i class="fas fa-upload"></i></span> <span class="hidden-xs-down">อัปโหลดวิดีโอ</span></a> </li>
                    <li class="nav-item"> <a id="navTabVideoURL" class="nav-link active" data-bs-toggle="tab" href="#videoURLTabPane" role="tab"><span class="hidden-sm-up"><i class="fas fa-link"></i></span> <span class="hidden-xs-down">วิดีโอ URL (Youtube)</span></a> </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content tabcontent-border">
                    <div class="tab-pane active" id="videoFileTabPane" role="tabpanel">
                        <form id="editVideoForm" enctype="multipart/form-data">
                            <input type="text" name="videoID" readonly hidden>
                            <div class="p-20">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group ">
                                            <label class="form-label">หัวข้อวิดีโอ</label>
                                            <input type="text" class="form-control" name="videoTitle" placeholder="กรุณาป้อนหัวข้อวิดีโอ" value="" required>
                                        </div>
                                    </div>
                                </div>
                                <!-- File select zone -->
                                <div class="row">
                                    <div class="col-12 col-lg-6">
                                        <div class="form-group ">
                                            <div class="row">
                                                <div class="col-6">
                                                    <label class="form-label">วิดีโอ MP4 (100 MB)</label>
                                                </div>
                                                <div class="col-6 ">
                                                    <div class="form-check form-switch ">
                                                        <input type="checkbox" class="form-check-input" id="generateThumbnail" name="generateThumbnail">
                                                        <label class="form-check-label" for="generateThumbnail">สร้าง Thumbnail</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="input-group custom-file-button">
                                                <label class="input-group-text" for="videoFile">กรุณาเลือกไฟล์</label>
                                                <input type="file" class="form-control" id="videoFile" name="videoFile" accept="video/*">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <div class="form-group ">
                                            <div class="row">
                                                <label class="form-label">ภาพปกวิดีโอ <span class="text-muted">(Optional)</span></label>
                                            </div>
                                            <div class="input-group custom-file-button">
                                                <label class="input-group-text" for="videoThumbnail">กรุณาเลือกไฟล์</label>
                                                <input type="file" class="form-control" id="videoThumbnail" name="videoThumbnail" accept="image/png, image/gif, image/jpeg">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <!-- ------------ -->
                                <!-- preview zone -->
                                <div class="row">
                                    <div class="col-12 col-lg-6">
                                        <video id="videoPreview" width="100%" height="100%" controls hidden></video>
                                    </div>
                                    <div class="col-12 col-lg-6 mt-4 mt-lg-0">
                                        <img id="videoThumbnailPreview" src="#" alt="video thumbnail" width="100%" height="100%" hidden />
                                    </div>
                                </div>
                                <!-- ------------ -->
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-success waves-effect waves-light text-white me-auto">บันทึกข้อมูล</button>
                                <button type="button" class="btn btn-default waves-effect" data-bs-dismiss="modal">ย้อนกลับ</button>
                            </div>
                        </form>
                    </div>
                    <form id="editVideoUrlForm" enctype="multipart/form-data">
                        <div class="tab-pane active" id="videoURLTabPane" role="tabpanel">
                            <input type="text" name="videoID" readonly hidden>
                            <div class="p-20">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group ">
                                            <label class="form-label">หัวข้อวิดีโอ</label>
                                            <input type="text" class="form-control" name="videoTitle" placeholder="กรุณาป้อนหัวข้อวิดีโอ" value="" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group ">
                                            <div class="row">
                                                <div class="col-12 d-flex no-block">
                                                    <label class="form-label">วิดีโอ URL (Youtube)</label>
                                                    <?php if ($this->session->userdata('crudSessionData')['crudPermission'] == 'faculty') { ?>
                                                        <div class="form-check form-switch ms-4">
                                                            <input type="checkbox" class="form-check-input" id="welcomeVideo" name="welcomeVideo">
                                                            <label class="form-check-label" for="welcomeVideo">วิดิโอแนะนำหน่วยงาน</label>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <input type="url" class="form-control" id="videoURL" name="videoURL" placeholder="กรุณาป้อนวิดีโอ URL" value="" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-info waves-effect waves-light text-white me-auto">บันทึกข้อมูล</button>
                                <button type="button" class="btn btn-default waves-effect" data-bs-dismiss="modal">ย้อนกลับ</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
</div>

<script>
    $('#videoEditModal').on('hidden.bs.modal', function() {
        $('#modal-container').html('');
    })

    $("#editVideoForm").validate({
        ignore: "input[type=hidden]",
        errorClass: "text-danger",
        successClass: "text-success",
        highlight: function(element, errorClass) {
            $(element).removeClass(errorClass)
        },
        unhighlight: function(element, errorClass) {
            $(element).removeClass(errorClass)
        },
        errorPlacement: function(error, element) {
            error.insertAfter(element)
        },
        messages: {
            videoURL: {
                url: "กรุณาป้อน URL ให้ถูกต้อง"
            },
        },
        submitHandler: function(form) {
            Swal.fire({
                title: 'แจ้งเตือน',
                text: 'ยืนยันการแก้ไขข้อมูลวิดิโอ?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'ยืนยัน',
                cancelButtonText: 'ย้อนกลับ',
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "<?php echo base_url('crud/video/onEditVideo') ?>",
                        method: "POST",
                        data: new FormData(form),
                        dataType: "json",
                        contentType: false,
                        processData: false,
                        beforeSend: function() {
                            showLoadingSweetalert();
                        },
                        success: function(response) {
                            if (!response.status) {
                                showErrorSweetalert("ผิดพลาด!", response.errorMessage, 2000);
                                return;
                            }
                            showSuccessSweetalert('สำเร็จ!', 'แก้ไขข้อมูลวิดิโอแล้ว', 1500);
                            setTimeout(function() {
                                fetchVideo();
                                $("#videoEditModal").modal("hide");
                            }, 1500)
                        },
                        error: function(xhr, status, error) {
                            showErrorSweetalert('ผิดพลาด!', error, 1500);
                        }
                    })
                }
            })

        },
    });

    $("#editVideoUrlForm").validate({
        ignore: "input[type=hidden]",
        errorClass: "text-danger",
        successClass: "text-success",
        highlight: function(element, errorClass) {
            $(element).removeClass(errorClass)
        },
        unhighlight: function(element, errorClass) {
            $(element).removeClass(errorClass)
        },
        errorPlacement: function(error, element) {
            error.insertAfter(element)
        },
        messages: {
            videoURL: {
                url: "กรุณาป้อน URL ให้ถูกต้อง"
            },
        },
        submitHandler: function(form) {
            $.ajax({
                url: "<?php echo base_url('crud/video/onEditVideoURL') ?>",
                method: "POST",
                data: new FormData(form),
                dataType: "json",
                contentType: false,
                processData: false,
                beforeSend: function() {
                    showLoadingSweetalert();
                },
                success: function(response) {
                    if (!response.status) {
                        showErrorSweetalert("ผิดพลาด!", response.errorMessage, 2000);
                        return;
                    }
                    showSuccessSweetalert('สำเร็จ!', 'แก้ไขข้อมูลวิดิโอแล้ว', 1500);
                    setTimeout(function() {
                        fetchVideo();
                        $("#videoEditModal").modal("hide");
                    }, 1500)
                },
                error: function(xhr, status, error) {
                    showErrorSweetalert('ผิดพลาด!', error, 1500);
                }
            })
        },
    });

    // on video select set video preview
    $('#videoFile').on("change", function(evt) {
        $('#videoPreview').attr('src', URL.createObjectURL(this.files[0]));
        $("#videoPreview")[0].load();
        $('#videoPreview').removeAttr('hidden');
    });

    // on thumbnail select set video thumbnail preview
    $('#videoThumbnail').on("change", function(evt) {
        $('#videoThumbnailPreview').removeAttr('hidden');
        if (this.files && this.files[0]) {
            $('#videoThumbnailPreview').attr('src',
                window.URL.createObjectURL(this.files[0]));
        }
    });
</script>