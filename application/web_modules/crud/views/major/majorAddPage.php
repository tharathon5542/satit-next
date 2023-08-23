<div id="majorAddModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">เพิ่มข้อมูลสาขา</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                <div class="card wizard-content">
                    <div class="card-body">
                        <form id="addFacultyForm" class="validation-wizard wizard-circle" novalidate>
                            <!-- Step 1 -->
                            <h6>ข้อมูลของสาขา</h6>
                            <section>
                                <?php if ($this->session->userdata('crudSessionData')['crudPermission'] == 'admin') { ?>
                                    <div class="row">
                                        <div class="form-group">
                                            <label class="form-label">สังกัดคณะของสาขา (Admin)</label>
                                            <select name="FacultyID" class="form-select" required>
                                                <option value>----- เลือกคณะสังกัดของสาขา -----</option>
                                                <?php
                                                $queryFaculty = $this->db->get('cwie_faculty');
                                                foreach ($queryFaculty->result() as $faculty) { ?>
                                                    <option value="<?php echo $faculty->faculty_id ?>"><?php echo $faculty->faculty_name_th ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="row">
                                    <div class="form-group">
                                        <label class="form-label">ชื่อสาขา (ภาษาไทย) <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control " placeholder="กรุณาป้อนชื่อสาขาภาษาไทย" name="majorNameTH" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <label class="form-label">ชื่อสาขา (ภาษาอังกฤษ)</label>
                                        <input type="text" class="form-control" placeholder="กรุณาป้อนชื่อสาขาภาษาอังกฤษ" name="majorNameEN">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">เบอร์ติดต่อ</label>
                                            <input type="text" class="form-control" placeholder="กรุณาป้อนเบอร์ติดต่อ" name="majorTel">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">อีเมล</label>
                                            <input type="email" class="form-control" placeholder="กรุณาป้อนอีเมล" name="majorEmail">
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <!-- Step 2 -->
                            <h6>ข้อมูลผู้ประสานงาน</h6>
                            <section>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>ค้นหาข้อมูลบุคลากรจากฐานข้อมูล</label>
                                            <select id="personelSelect2" class="form-control form-select" style="width: 100%; height:36px;">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">ชื่อ <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="กรุณาป้อนชื่อ" id="coordinatorName" name="coordinatorName" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">นามสกุล <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="กรุณาป้อนนามสกุล" id="coordinatorSurname" name="coordinatorSurname" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">เบอร์ติดต่อ <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="กรุณาป้อนชื่อ" id="coordinatorTel" name="coordinatorTel" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">อีเมล</label>
                                            <input type="email" class="form-control" placeholder="กรุณาป้อนอีเมล" name="coordinatorEmail">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">ตำแหน่งผู้ประสานงาน</label>
                                            <input type="text" class="form-control" placeholder="กรุณาป้อนตำแหน่งผู้ประสานงาน" name="coordinatorPosition">
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <!-- Step 3 -->
                            <h6>Authentication</h6>
                            <section>
                                <div class="form-group">
                                    <label class="form-label">User Name</label>
                                    <input type="text" class="form-control " name="majorUsername" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Password</label>
                                    <input type="password" class="form-control " id="majorPassword" name="majorPassword" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control " name="majorConPassword" required>
                                </div>
                            </section>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#majorAddModal').on('hidden.bs.modal', function() {
        $('#modal-container').html('');
    })

    var form = $(".validation-wizard").show();

    $(".validation-wizard").steps({
        headerTag: "h6",
        bodyTag: "section",
        transitionEffect: "fade",
        titleTemplate: '<span class="step">#index#</span> #title#',
        labels: {
            finish: "บันทึกข้อมูล",
            next: "ขั้นตอนถัดไป",
            previous: 'ย้อนกลับ'
        },
        onStepChanging: function(event, currentIndex, newIndex) {
            return currentIndex > newIndex || ((form.find(".body:eq(" + newIndex + ") label.error").remove(), form.find(".body:eq(" + newIndex + ") .error").removeClass("error")), form.validate().settings.ignore = ":disabled,:hidden", form.valid())
        },
        onFinishing: function(event, currentIndex) {
            return form.validate().settings.ignore = ":disabled", form.valid()
        },
        onFinished: function(event, currentIndex) {
            $.ajax({
                url: "<?php echo base_url('crud/major/onAddMajor') ?>",
                method: "POST",
                data: form.serialize(),
                dataType: "json",
                beforeSend: function() {
                    showLoadingSweetalert();
                },
                success: function(response) {
                    console.log(response);
                    if (!response.status) {
                        showErrorSweetalert('ผิดพลาด!', response.errorMessage, 1500);
                        return;
                    }

                    showSuccessSweetalert('สำเร็จ!', response.message, 1500);
                    setTimeout(function() {
                        $('#majorTable').DataTable().ajax.reload();
                        $('#majorAddModal').modal('hide');
                    }, 1500)
                },
                error: function(xhr, status, error) {
                    showErrorSweetalert('ผิดพลาด!', error, 1500);
                }
            })
        }
    }), $(".validation-wizard").validate({
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
            majorConPassword: {
                equalTo: majorPassword
            },
        },
        messages: {
            majorConPassword: {
                equalTo: "กรุณาป้อนยืนยันรหัสผ่านให้ตรงกับรหัสผ่าน",
            },
            majorEmail: "กรุณาป้อน Email ให้ถูกต้อง",
            coordinatorEmail: "กรุณาป้อน Email ให้ถูกต้อง",
        },
    })

    $("#personelSelect2").select2({
        placeholder: 'กรุณาป้อนชื่อ หรือนามสกุลเพื่อคนหาบุคลากรภายใน',
        dropdownParent: $('#majorAddModal'),
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
</script>