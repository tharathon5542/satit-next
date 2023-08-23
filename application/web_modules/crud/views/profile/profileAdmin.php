<div class="row">
    <div class="col-lg-4 col-xlg-3 col-md-5 el-element-overlay">
        <div class="card d-block animated bounceInRight" style="animation-delay: 0.2s;">
            <div class="el-card-item ">
                <div class="el-card-avatar el-overlay-1 ">
                    <img id="profileImagePreview" src="<?php echo $this->session->userdata('crudSessionData')['crudProfileImage'] ?>" alt="user" />
                    <div class="el-overlay">
                        <ul class="el-info">
                            <li>
                                <a id="zoomProfileImagePreview" class="btn default btn-outline image-popup-vertical-fit" href="<?php echo $this->session->userdata('crudSessionData')['crudProfileImage'] ?>">
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
        <div class="card animated bounceInRight" style="animation-delay: 0.2s;">
            <div class="card-body text-center">
                <small class="text-muted">ขนาดไฟล์ 500 x 500 PNG (ไม่เกิน 2 MB)</small>
            </div>
        </div>
    </div>
    <div class="col-lg-8 col-xlg-9 col-md-7">
        <div class="card animated bounceInRight" style="animation-delay: 0.3s;">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs profile-tab" role="tablist">
                <li class="nav-item"> <a class="nav-link active" data-bs-toggle="tab" href="#profile" role="tab">Profile</a> </li>
                <li class="nav-item"> <a class="nav-link " data-bs-toggle="tab" href="#setting" role="tab">Setting</a> </li>
            </ul>
            <div class="tab-content">
                <!-- tab content 1 -->
                <div class="tab-pane active" id="profile" role="tabpanel">
                    <div class="card-body">
                        <form id="profileForm" enctype="multipart/form-data" novalidate>
                            <input type="file" id="profileImage" name="profileImage" accept="image/png, image/jpeg, image/jpg, image/gif" hidden>
                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label class="form-label" for="profileName">ชื่อ</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="profileName" name="profileName" value="<?php echo $this->session->userdata('crudSessionData')['crudName'] ?>" required>
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label class="form-label" for="profileSurname">นามสกุล</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="profileSurname" name="profileSurname" value="<?php echo $this->session->userdata('crudSessionData')['crudSurname'] ?>" required>
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label class="form-label" for="profileTel">เบอร์โทร</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="profileTel" name="profileTel" value="<?php echo $this->session->userdata('crudSessionData')['crudTel'] ?>">
                                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label class="form-label" for="profileEmail">อีเมล</label>
                                        <div class="input-group">
                                            <input type="email" class="form-control" id="profileEmail" name="profileEmail" value="<?php echo $this->session->userdata('crudSessionData')['crudEmail'] ?>">
                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <button class="btn btn-success text-white">บันทึกข้อมูล</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- tab content 2 -->
                <div class="tab-pane" id="setting" role="tabpanel">
                    <div class="card-body">
                        <form id="settingForm" novalidate>
                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label class="form-label" for="oldPassword">รหัสผ่านเดิม</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="oldPassword" name="oldPassword" required>
                                            <span class="input-group-text"><i class="fas fa-lock-open"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label class="form-label" for="newPassword">รหัสผ่านใหม่</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="newPassword" name="newPassword" required>
                                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label class="form-label" for="newConPassword">ยืนยันรหัสผ่านใหม่</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="newConPassword" name="newConPassword" required>
                                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <button class="btn btn-info text-white">เปลี่ยนรหัสผ่าน</button>
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
    window.onload = function() {
        // ==========================================================

        $("#profileForm").validate({
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
                error.insertAfter(element.closest('div.input-group'))
            },
            messages: {
                profileLink: "กรุณาป้อน URL ให้ถูกต้อง",
                profileEmail: "กรุณาป้อน Email ให้ถูกต้อง",
            },
            submitHandler: function(form) {
                Swal.fire({
                    title: 'ยืนยันการแก้ไขโปรไฟล์?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'ยืนยัน',
                    cancelButtonText: 'ย้อนกลับ',
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: "<?php echo base_url('crud/ProfileAdmin/onEditProfileAdmin') ?>",
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
                                showSuccessSweetalert("สำเร็จ!", "แก้ไขข้อมูลโปรไฟล์แล้ว");
                            },
                            error: function(xhr, status, error) {
                                showErrorSweetalert('ผิดพลาด!', error, 1500);
                            }
                        })
                    }
                })
            },
        });

        $("#settingForm").validate({
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
                error.insertAfter(element.closest('div.input-group'))
            },
            rules: {
                newConPassword: {
                    equalTo: newPassword
                },
            },
            messages: {
                newConPassword: {
                    equalTo: "กรุณาป้อนยืนยันรหัสผ่านให้ตรงกับรหัสผ่าน"
                },
            },
            submitHandler: function(form) {
                Swal.fire({
                    title: 'ยืนยันการเปลี่ยนรหัสผ่าน?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'เปลี่ยนรหัสผ่าน',
                    cancelButtonText: 'ย้อนกลับ',
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: "<?php echo base_url('crud/ProfileAdmin/onEditAdminPassword') ?>",
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

                                showSuccessSweetalert("สำเร็จ!", "เปลี่ยนรหัสผ่านแล้ว กรุณาทำการเข้าสู่ระบบอีกครั้ง", 2000);
                                setTimeout(function() {
                                    $(location).attr('href', '<?php echo base_url('crud/auth/onSignOut'); ?>');
                                }, 2000)
                            },
                            error: function(xhr, status, error) {
                                showErrorSweetalert('ผิดพลาด!', error, 1500);
                            }
                        })
                    }
                })
            },
        });

        $('#profileImage').on('change', function(e) {
            var file = e.target.files[0]; // get the file
            // read the file as a URL and set the preview image src
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#zoomProfileImagePreview').attr('href', e.target.result);
                $('#profileImagePreview').attr('src', e.target.result);
            };
            reader.readAsDataURL(file);
        });

        // ==========================================================
    }

    function profileImageSelect() {
        $('#profileImage').click();
    }
</script>