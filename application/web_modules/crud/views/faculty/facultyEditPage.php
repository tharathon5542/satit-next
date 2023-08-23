<div id="facultyEditModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">แก้ไขข้อมูลคณะ</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item"> <a class="nav-link active" data-bs-toggle="tab" href="#facultyDetail" role="tab"><span class="hidden-sm-up"><i class="fas fa-users"></i></span> <span class="hidden-xs-down">ข้อมูลของคณะ</span></a> </li>
                    <li class="nav-item"> <a class="nav-link" data-bs-toggle="tab" href="#coordinator" role="tab"><span class="hidden-sm-up"><i class="fas fa-user"></i></span> <span class="hidden-xs-down">ข้อมูลผู้ประสานงาน</span></a> </li>
                    <li class="nav-item"> <a class="nav-link" data-bs-toggle="tab" href="#cwiePolicy" role="tab"><span class="hidden-sm-up"><i class="fas fa-handshake"></i></span> <span class="hidden-xs-down">นโยบาย CWIE</span></a> </li>
                    <li class="nav-item"> <a class="nav-link" data-bs-toggle="tab" href="#facultySetting" role="tab"><span class="hidden-sm-up"><i class="fas fa-cog"></i></span> <span class="hidden-xs-down">ความปลอดภัย</span></a> </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content tabcontent-border">
                    <!-- tab 1 -->
                    <div class="tab-pane active" id="facultyDetail" role="tabpanel">
                        <form id="facultyDetailForm" enctype="multipart/form-data" novalidate>
                            <input type="text" name="facultyID" readonly hidden>
                            <div class="p-20 pb-0">
                                <div class="row el-element-overlay d-flex no-block justify-content-center">
                                    <div class="col-lg-4 col-xlg-3 col-md-5">
                                        <div class="card d-block">
                                            <div class="el-card-item ">
                                                <div class="el-card-avatar el-overlay-1 ">
                                                    <img id="facultyImagePreview" src="" alt="facultyIMG" />
                                                    <div class="el-overlay">
                                                        <ul class="el-info">
                                                            <li>
                                                                <button type="button" class="btn default btn-outline" onclick="facultyImageSelect()">
                                                                    <i class="fas fa-edit"></i>
                                                                </button>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="file" id="facultyImage" name="facultyImage" hidden>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label">ชื่อคณะ (ภาษาไทย) <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="กรุณาป้อนชื่อคณะภาษาไทย" id="facultyNameTH" name="facultyNameTH" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label">ชื่อคณะ (ภาษาอังกฤษ)</label>
                                            <input type="text" class="form-control" placeholder="กรุณาป้อนชื่อคณะภาษาอังกฤษ" id="facultyNameEN" name="facultyNameEN">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">เบอร์ติดต่อ</label>
                                            <input type="text" class="form-control" placeholder="กรุณาป้อนเบอร์ติดต่อ" id="facultyTel" name="facultyTel">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">อีเมล</label>
                                            <input type="email" class="form-control" placeholder="กรุณาป้อนอีเมล" id="facultyEmail" name="facultyEmail">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label">ชื่อเว็บไซต์</label>
                                            <div class="input-group">
                                                <span class="input-group-text">https://cwie-next.crru.ac.th/faculty/</span>
                                                <input type="text" class="form-control" placeholder="กรุณาป้อนชื่อเว็บไซต์" id="facultyWebsite" name="facultyWebsite">
                                                <span class="input-group-text"><a href="" id="facultyExternalLink" target="_blank" class="text-info"> <i class="fas fa-external-link-alt"></i></a></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label">ลิงก์ผลงาน (Google Drive)</label>
                                            <input type="url" class="form-control" placeholder="กรุณาป้อนลิงก์ผลงาน" id="facultyLink" name="facultyLink">
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
                    <!-- tab 2 -->
                    <div class="tab-pane" id="coordinator" role="tabpanel">
                        <form id="coordinatorForm" novalidate>
                            <input type="text" name="facultyID" readonly hidden>
                            <div class="p-20 pb-0">
                                <div class="row">
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
                                                <input type="text" class="form-control" placeholder="กรุณาป้อนชื่อ" id="coordinatorName" name="coordinatorName" value="" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">นามสกุล</label>
                                                <input type="text" class="form-control" placeholder="กรุณาป้อนนามสกุล" id="coordinatorSurname" name="coordinatorSurname" value="" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-12">
                                            <div class="form-group">
                                                <label class="form-label">เบอร์ติดต่อ</label>
                                                <input type="text" class="form-control" placeholder="กรุณาป้อนเบอร์ติดต่อ" id="coordinatorTel" name="coordinatorTel" value="" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-12">
                                            <div class="form-group">
                                                <label class="form-label">อีเมล</label>
                                                <input type="email" class="form-control" placeholder="กรุณาป้อนอีเมล" id="coordinatorEmail" name="coordinatorEmail" value="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-12">
                                            <div class="form-group">
                                                <label class="form-label">ตำแหน่งผู้ประสานงาน</label>
                                                <input type="text" class="form-control" placeholder="กรุณาป้อนตำแหน่งผู้ประสานงาน" id="coordinatorPosition" name="coordinatorPosition" value="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-success waves-effect waves-light text-white me-auto">บันทึกข้อมูล</button>
                                    <button type="button" class="btn btn-default waves-effect" data-bs-dismiss="modal">ย้อนกลับ</button>
                                </div>
                            </div>
                        </form>
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
                                            <textarea class="form-control" rows="7" id="facultyCwiePolicy" name="facultyCwiePolicy"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-success waves-effect waves-light text-white me-auto">บันทึกข้อมูล</button>
                                    <button type="button" class="btn btn-default waves-effect" data-bs-dismiss="modal">ย้อนกลับ</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- tab 4 -->
                    <div class="tab-pane" id="facultySetting" role="tabpanel">
                        <form id="facultySettingForm" novalidate>
                            <input type="text" name="facultyID" readonly hidden>
                            <div class="p-20 pb-0">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label">รหัสผ่านใหม่</label>
                                            <input type="password" class="form-control" id="facultyNewPassword" name="facultyNewPassword" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label">ยืนยันรหัสผ่านใหม่</label>
                                            <input type="password" class="form-control" name="facultyConNewPassword" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-info waves-effect waves-light text-white me-auto">เปลี่ยนรหัสผ่าน</button>
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
    $('#facultyEditModal').on('hidden.bs.modal', function() {
        $('#modal-container').html('');
    })

    $("#facultyDetailForm").validate({
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
            error.insertAfter(element.closest('div.input-group').length ? element.closest('div.input-group') : element)
        },
        messages: {
            facultyLink: "กรุณาป้อน URL ให้ถูกต้อง",
            facultyEmail: "กรุณาป้อน Email ให้ถูกต้อง",
        },
        submitHandler: function(form) {
            Swal.fire({
                title: 'แจ้งเตือน',
                text: 'ยืนยันการแก้ไขข้อมูลคณะ?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'ยืนยัน',
                cancelButtonText: 'ย้อนกลับ',
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "<?php echo base_url('crud/faculty/onEditFaculty') ?>",
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
                            showSuccessSweetalert('สำเร็จ!', 'แก้ไขข้อมูลคณะแล้ว', 1500);
                            $('#facultyWebsite').val(response.facultyWebsite);
                            $('#facultyExternalLink').attr('href', '/faculty/' + response.facultyWebsite);
                            setTimeout(function() {
                                $('#facultyTable').DataTable().ajax.reload();
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
            error.insertAfter(element)
        },
        messages: {
            coordinatorEmail: "กรุณาป้อน Email ให้ถูกต้อง"
        },
        submitHandler: function(form) {
            Swal.fire({
                title: 'ยืนยันการแก้ไขข้อมูลผู้ประสานงาน?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'ยืนยัน',
                cancelButtonText: 'ย้อนกลับ',
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "<?php echo base_url('crud/faculty/onEditFacultyCoordinator') ?>",
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
                            showSuccessSweetalert('สำเร็จ!', 'แก้ไขข้อมูลผู้ประสานงานแล้ว', 1500);
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
            error.insertAfter(element.closest('div.input-group').length ? element.closest('div.input-group') : element)
        },
        submitHandler: function(form) {
            Swal.fire({
                title: 'แจ้งเตือน',
                text: 'ยืนยันการแก้ไขข้อมูลคณะ?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'ยืนยัน',
                cancelButtonText: 'ย้อนกลับ',
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "<?php echo base_url('crud/faculty/onEditFacultyCwiePolicy') ?>",
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
                            showSuccessSweetalert('สำเร็จ!', 'แก้ไขข้อมูลคณะแล้ว', 1500);
                            setTimeout(function() {
                                $('#facultyTable').DataTable().ajax.reload();
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

    $("#facultySettingForm").validate({
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
        rules: {
            facultyConNewPassword: {
                equalTo: facultyNewPassword
            },
        },
        messages: {
            facultyConNewPassword: {
                equalTo: "กรุณาป้อนยืนยันรหัสผ่านให้ตรงกับรหัสผ่าน"
            },
        },
        submitHandler: function(form) {
            Swal.fire({
                title: 'ยืนยันการเปลี่ยนรหัสผ่าน?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'ยืนยัน',
                cancelButtonText: 'ย้อนกลับ',
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "<?php echo base_url('crud/faculty/onEditFacultyPassword') ?>",
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
                            showSuccessSweetalert('สำเร็จ!', 'เปลี่ยนรหัสผ่านของคณะแล้ว', 1500);
                            setTimeout(function() {
                                $('#facultyEditModal').modal('hide');
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

    $('#facultyImage').on('change', function(e) {
        var file = e.target.files[0]; // get the file
        // read the file as a URL and set the preview image src
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#facultyImagePreview').attr('src', e.target.result);
        };
        reader.readAsDataURL(file);
    });

    $("#personelSelect2").select2({
        placeholder: 'กรุณาป้อนชื่อ หรือนามสกุลเพื่อคนหาบุคลากรภายใน',
        dropdownParent: $('#facultyEditModal'),
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

    function facultyImageSelect() {
        $('#facultyImage').click();
    }
</script>