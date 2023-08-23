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
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle active" data-bs-toggle="dropdown" href="javascript:void(0)" role="button">
                        <span class="hidden-sm-up"></span> <span class="hidden-xs-down">ข้อมูลหน่วยงาน</span>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item active" href="#profile" role="tab" data-bs-toggle="tab">ข้อมูลคณะ</a>
                        <a class="dropdown-item" href="#coordiantor" role="tab" data-bs-toggle="tab">ข้อมูลผู้ประสานงาน</a>
                        <a class="dropdown-item" href="#cwiePolicy" role="tab" data-bs-toggle="tab">นโยบาย CWIE</a>
                    </div>
                </li>
                <li class="nav-item"> <a class="nav-link" data-bs-toggle="tab" href="#setting" role="tab">เปลี่ยนรหัสผ่าน</a></li>
            </ul>
            <div class="tab-content">
                <!-- tab 1 -->
                <div class="tab-pane active" id="profile" role="tabpanel">
                    <div class="card-body">
                        <form id="profileForm" enctype="multipart/form-data" novalidate>
                            <input type="file" id="profileImage" name="profileImage" accept="image/png, image/jpeg, image/jpg, image/gif" hidden>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label">ชื่อคณะ (ภาษาไทย)</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="กรุณาป้อนชื่อคณะภาษาไทย" name="profileName" value="<?php echo $this->session->userdata('crudSessionData')['crudName'] ?>" required>
                                            <span class="input-group-text"><i class="fas fa-users"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label">ชื่อคณะ (ภาษาอังกฤษ)</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="กรุณาป้อนชื่อคณะภาษาอังกฤษ" name="profileNameEN" value="<?php echo $this->session->userdata('crudSessionData')['crudNameEN'] ?>">
                                            <span class="input-group-text"><i class="fas fa-users"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">เบอร์ติดต่อ</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="กรุณาป้อนเบอร์ติดต่อ" name="profileTel" value="<?php echo $this->session->userdata('crudSessionData')['crudTel'] ?>">
                                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">อีเมล</label>
                                        <div class="input-group">
                                            <input type="email" class="form-control" placeholder="กรุณาป้อนอีเมล" name="profileEmail" value="<?php echo $this->session->userdata('crudSessionData')['crudEmail'] ?>">
                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label">ชื่อเว็บไซต์</label>
                                        <div class="input-group">
                                            <span class="input-group-text">https://cwie-next.crru.ac.th/faculty/</span>
                                            <input type="text" class="form-control" placeholder="กรุณาป้อนชื่อเว็บไซต์" name="profileWebsite" value="<?php echo $this->session->userdata('crudSessionData')['crudWebsite'] ?>">
                                            <span class="input-group-text"><a id="facultyWebsiteLink" href="<?php echo base_url('faculty/' . $this->session->userdata('crudSessionData')['crudWebsite']) ?>" target="_blank" class="text-info"> <i class="fas fa-external-link-alt"></i></a></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <label class="form-label">สีกิจกรรมคณะ</label>
                                    <input class="form-control d-block" type="color" value="<?php echo $this->session->userdata('crudSessionData')['crudEventColor'] ?>" id="profileEventColor" name="profileEventColor">
                                </div>
                            </div>
                            <!-- <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label">ลิงก์ผลงาน (Google Drive)</label>
                                        <div class="input-group">
                                            <input type="url" class="form-control" placeholder="กรุณาป้อนลิงก์ผลงาน" name="profileLink" value="<?php echo $this->session->userdata('crudSessionData')['crudLink'] ?>">
                                            <span class="input-group-text"><i class="fab fa-google-drive"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                            <hr>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <button class="btn btn-success text-white">บันทึกข้อมูล</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- tab 2 -->
                <div class="tab-pane" id="coordiantor" role="tabpanel">
                    <div class="card-body">
                        <form id="coordinatorForm" novalidate>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label">ค้นหาข้อมูลบุคลากรจากฐานข้อมูล</label>
                                        <select id="personelSelect2" class="form-control form-select" style="width: 100%; height:36px;">
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">ชื่อ</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="กรุณาป้อนชื่อ" id="coordinatorName" name="coordinatorName" value="<?php echo $this->session->userdata('crudSessionData')['crudCoordinatorName'] ?>" required>
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">นามสกุล</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="กรุณาป้อนนามสกุล" id="coordinatorSurname" name="coordinatorSurname" value="<?php echo $this->session->userdata('crudSessionData')['crudCoordinatorSurname'] ?>" required>
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">เบอร์ติดต่อ</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="กรุณาป้อนเบอร์ติดต่อ" id="coordinatorTel" name="coordinatorTel" value="<?php echo $this->session->userdata('crudSessionData')['crudCoordinatorTel'] ?>" required>
                                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">อีเมล</label>
                                        <div class="input-group">
                                            <input type="email" class="form-control" placeholder="กรุณาป้อนอีเมล" name="coordinatorEmail" value="<?php echo $this->session->userdata('crudSessionData')['crudCoordinatorEmail'] ?>">
                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label">ตำแหน่ง</label>
                                        <input type="text" class="form-control" placeholder="กรุณาป้อนตำแหน่งผู้ประสานงาน" id="coordinatorPosition" name="coordinatorPosition" value="<?php echo $this->session->userdata('crudSessionData')['crudCoordinatorPosition'] ?>">
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
                <!-- tab 3 -->
                <div class="tab-pane" id="cwiePolicy" role="tabpanel">
                    <form id="cwiePolicyForm" novalidate>
                        <input type="text" name="facultyID" readonly hidden>
                        <div class="p-20 pb-0">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label">นโยบาย CWIE</label>
                                        <textarea  name="facultyCwiePolicy" class="form-control" rows="10"><?php echo $this->session->userdata('crudSessionData')['crudCwiePolicy'] ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <button class="btn btn-success text-white">บันทึกข้อมูล</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- tab 4 -->
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
                    title: 'ยืนยันการแก้ไขข้อมูล?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'ยืนยัน',
                    cancelButtonText: 'ย้อนกลับ',
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: "<?php echo base_url('crud/ProfileFaculty/onEditProfileFaculty') ?>",
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
                                showSuccessSweetalert("สำเร็จ!", "แก้ไขข้อมูลหน่วยงานแล้ว");
                                $('#facultyWebsiteLink').attr('href', response.facultyWebsite);
                            },
                            error: function(xhr, status, error) {
                                showErrorSweetalert('ผิดพลาด!', error, 1500);
                            }
                        })
                    }
                })
            },
        });

        $("#coordinatorForm").validate({
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
                coordinatorEmail: "กรุณาป้อน Email ให้ถูกต้อง",
            },
            submitHandler: function(form) {

                Swal.fire({
                    title: 'ยืนยันการแก้ไขข้อมูล?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'ยืนยัน',
                    cancelButtonText: 'ย้อนกลับ',
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: "<?php echo base_url('crud/ProfileFaculty/onEditFacultyCoordinator') ?>",
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
                                showSuccessSweetalert("สำเร็จ!", "แก้ไขข้อมูลผู้ประสานงานแล้ว");
                            },
                            error: function(xhr, status, error) {
                                showErrorSweetalert('ผิดพลาด!', error, 1500);
                            }
                        })
                    }
                })
            },
        });

        $("#cwiePolicyForm").validate({
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
            submitHandler: function(form) {
                Swal.fire({
                    title: 'ยืนยันการแก้ไขข้อมูล?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'ยืนยัน',
                    cancelButtonText: 'ย้อนกลับ',
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: "<?php echo base_url('crud/ProfileFaculty/onEditFacultyCwiePolicy') ?>",
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
                                showSuccessSweetalert("สำเร็จ!", "แก้ไขข้อมูลนโยบาย CWIE แล้ว");
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
                            url: "<?php echo base_url('crud/ProfileFaculty/onEditFacultyPassword') ?>",
                            method: "POST",
                            data: new FormData(form),
                            contentType: false,
                            processData: false,
                            dataType: "json",
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

        $("#personelSelect2").select2({
            placeholder: 'กรุณาป้อนชื่อ หรือนามสกุลเพื่อคนหาบุคลากรภายใน',
            ajax: {
                url: "<?php echo base_url('crud/utility/getPersonel') ?>",
                type: "POST",
                dataType: 'json',
                delay: 1000,
                data: function(params) {
                    return {
                        searchTerm: params.term // search term
                    };
                },
                processResults: function(data) {
                    return {
                        results: data
                    };
                },
                cache: true,
            }
        });

        $('#personelSelect2').change(function() {
            $.ajax({
                url: "<?php echo base_url('crud/Utility/getPersonel/') ?>" + $(this).val(),
                type: "POST",
                dataType: 'json',
                success: function(data) {
                    $("#coordinatorName").val(data[0].th_ed + data[0].fname_th);
                    $("#coordinatorSurname").val(data[0].lanme_th);
                    $("#coordinatorTel").val(data[0].mobile_no);
                }
            })
        });

        tinymce.init({
            selector: '.textarea-tinymce',
            paste_as_text: true,
        });

        // ==========================================================
    }

    function profileImageSelect() {
        $('#profileImage').click();
    }
</script>