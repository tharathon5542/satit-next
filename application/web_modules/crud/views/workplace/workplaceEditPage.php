<div id="workplaceEditModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">แก้ไขข้อมูลเครือข่าย CWIE</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                <div class="card wizard-content">
                    <div class="card-body">
                        <form id="editWorkplaceForm" class="validation-wizard wizard-circle" novalidate>
                            <!-- Step 1 -->
                            <h6>ข้อมูลเครือข่าย CWIE </h6>
                            <section>
                                <input type="text" id="workplaceID" name="workplaceID" readonly hidden>
                                <?php if ($this->session->userdata('crudSessionData')['crudPermission'] == 'admin') { ?>
                                    <div class="row">
                                        <div class="form-group">
                                            <label class="form-label">สังกัดสาขา (Admin)</label>
                                            <select id="majorID" name="majorID" class="form-select" required>
                                                <option value>----- เลือกสังกัดสาขา -----</option>
                                                <?php
                                                $queryMajor = $this->db->select('major_id, major_name_th, faculty_name_th')->join('cwie_faculty', 'cwie_major.faculty_id = cwie_faculty.faculty_id')->get('cwie_major');
                                                foreach ($queryMajor->result() as $major) { ?>
                                                    <option value="<?php echo $major->major_id ?>"><?php echo $major->major_name_th ?> (<?php echo $major->faculty_name_th ?>)</option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="form-label">สถานะการตรวจสอบ</label>
                                                <select id="workplaceStatus" name="workplaceStatus" class="form-select" required>
                                                    <option value="0">รอการตรวจสอบ</option>
                                                    <option value="1">ผ่านการตรวจสอบแล้ว</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label">หลักสูตร</label>
                                            <div class="select2CustomContainer">
                                                <select id="courseID" name="courseID[]" style="width: 100%;" required multiple>
                                                    <?php
                                                    $this->db->join('cwie_major', 'cwie_course.major_id = cwie_major.major_id', 'left');
                                                    $this->db->where('cwie_course.major_id', $this->session->userdata('crudSessionData')['crudId']);
                                                    $this->db->or_where('\'admin\'', $this->session->userdata('crudSessionData')['crudPermission']);
                                                    $queryCourse = $this->db->get('cwie_course');
                                                    foreach ($queryCourse->result() as $course) { ?>
                                                        <option value="<?php echo $course->course_id ?>"><?php echo $course->course_name . ' (' . $course->major_name_th . ')'; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">ประเภทเครือข่าย CWIE </label>
                                            <select id="workplaceType" name="workplaceType" class="form-select" required>
                                                <?php
                                                $queryWorkplaceType = $this->db->get('cwie_workplace_type');
                                                foreach ($queryWorkplaceType->result() as $Type) { ?>
                                                    <option value="<?php echo $Type->workplace_type_id ?>"><?php echo $Type->workplace_type ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label">ชื่อเครือข่าย CWIE </label>
                                            <input type="text" class="form-control " placeholder="กรุณาป้อนชื่อเครือข่าย CWIE " id="workplaceName" name="workplaceName" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">เบอร์ติดต่อ</label>
                                            <input type="text" class="form-control" placeholder="กรุณาป้อนเบอร์ติดต่อ" id="workplaceTel" name="workplaceTel" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">อีเมล <small class="text-muted">(Optional)</small></label>
                                            <input type="email" class="form-control" placeholder="กรุณาป้อนอีเมล" id="workplaceEmail" name="workplaceEmail">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label">ตำแหน่งงาน </label>
                                            <input type="text" class="form-control " placeholder="กรุณาป้อนตำแหน่ง" id="workplaceWorkType" name="workplaceWorkType" required>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <!-- Step 2 -->
                            <h6>ข้อมูลที่อยู่เครือข่าย CWIE </h6>
                            <section>
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">รหัสไปรษณีย์</label>
                                            <select id="workplaceZipCode" name="workplaceZipCode" class="form-control form-select" style="width: 100%; height:36px;">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">ตำบล</label>
                                            <select id="workplaceSubDistrict" name="workplaceSubDistrict" class="form-control form-select" style="width: 100%; height:36px;">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">อำเภอ</label>
                                            <select id="workplaceDistrict" name="workplaceDistrict" class="form-control form-select" style="width: 100%; height:36px;">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">จังหวัด</label>
                                            <select id="workplaceProvince" name="workplaceProvince" class="form-control form-select" style="width: 100%; height:36px;">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">ประเทศ</label>
                                            <select id="workplaceCountry" name="workplaceCountry" class="form-control form-select" style="width: 100%; height:36px;">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label">ที่อยู่ บ้านเลขที่ ถนน หมู่ หมู่บ้าน</label>
                                            <textarea id="workplaceAddress" name="workplaceAddress" cols="30" rows="5" class="form-control" placeholder="กรุณาป้อนที่อยู่ บ้านเลขที่ ถนน หมู่ หมู่บ้าน"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">ละติจูด</label>
                                            <input type="text" class="form-control" placeholder="กรุณาป้อนละติจูด" id="workplaceLat" name="workplaceLat">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">ลองจิจูด</label>
                                            <input type="text" class="form-control" placeholder="กรุณาป้อนลองจิจูด" id="workplaceLong" name="workplaceLong">
                                        </div>
                                    </div>
                                </div> -->
                            </section>
                            <!-- Step 3 -->
                            <h6>ความร่วมมือ MOU</h6>
                            <section>
                                <div class="row">
                                    <div class="col-12">
                                        <button class="btn btn-success text-white" type="button" onclick="addWorkplaceMouField();"><i class="fa fa-plus"></i> เพิ่มหัวข้อการทำ MOU</button>
                                    </div>
                                </div>
                                <hr>
                                <div id="workplaceMouField"></div>
                            </section>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    $('#workplaceEditModal').on('hidden.bs.modal', function() {
        $('#modal-container').html('');
    })

    var form = $(".validation-wizard").show();

    $(".validation-wizard").steps({
        headerTag: "h6",
        bodyTag: "section",
        transitionEffect: "fade",
        enableAllSteps: true,
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

            const formData = new FormData($('#editWorkplaceForm')[0]);

            $.ajax({
                url: "<?php echo base_url('crud/workplace/onEditWorkplace') ?>",
                method: "POST",
                data: formData,
                contentType: false,
                processData: false,
                dataType: "json",
                beforeSend: function() {
                    showLoadingSweetalert();
                },
                success: function(response) {
                    if (!response.status) {
                        showErrorSweetalert('ผิดพลาด!', response.errorMessage, 1500);
                        return;
                    }

                    showSuccessSweetalert('สำเร็จ!', response.message, 1500);
                    setTimeout(function() {
                        $('#workplaceTable').DataTable().ajax.reload();
                        $('#workplaceEditModal').modal('hide');
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
        messages: {
            workplaceEmail: {
                email: 'กรุณาป้อนอีเมลให้ถูกต้อง'
            },
        },
    })

    $("#courseID").select2({
        dropdownParent: $('#workplaceEditModal'),
    });

    $("#workplaceZipCode").select2({
        placeholder: 'กรุณาป้อนรหัสไปรษณีย์',
        dropdownParent: $('#workplaceEditModal'),
        tags: true,
        allowClear: true,
        ajax: {
            url: "<?php echo base_url('crud/utility/getZipCode') ?>",
            type: "POST",
            dataType: 'json',
            delay: 500,
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

    $("#workplaceSubDistrict").select2({
        placeholder: 'กรุณาป้อนตำบล',
        dropdownParent: $('#workplaceEditModal'),
        tags: true,
        allowClear: true,
        ajax: {
            url: "<?php echo base_url('crud/utility/getSubDistrict') ?>",
            type: "POST",
            dataType: 'json',
            delay: 500,
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

    $("#workplaceDistrict").select2({
        placeholder: 'กรุณาป้อนอำเภอ',
        dropdownParent: $('#workplaceEditModal'),
        tags: true,
        allowClear: true,
        ajax: {
            url: "<?php echo base_url('crud/utility/getDistrict') ?>",
            type: "POST",
            dataType: 'json',
            delay: 500,
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

    $("#workplaceProvince").select2({
        placeholder: 'กรุณาป้อนจังหวัด',
        dropdownParent: $('#workplaceEditModal'),
        tags: true,
        allowClear: true,
        ajax: {
            url: "<?php echo base_url('crud/utility/getProvince') ?>",
            type: "POST",
            dataType: 'json',
            delay: 500,
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

    $("#workplaceCountry").select2({
        placeholder: 'กรุณาป้อนประเทศ',
        dropdownParent: $('#workplaceEditModal'),
        tags: true,
        allowClear: true,
        ajax: {
            url: "<?php echo base_url('crud/utility/getCountry') ?>",
            type: "POST",
            dataType: 'json',
            delay: 500,
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

    function fileSelectClick(elementFileSelectID) {
        $('#' + elementFileSelectID).click();
    }

    function onFileSelectChange(elementDisplayID, fileParam) {
        var file = fileParam.files[0]; // get the file

        if (!file) {
            $('#' + elementDisplayID).val('');
            return;
        }

        $('#' + elementDisplayID).val(file.name);
    }

    function viewFile(file) {
        window.open(file, '_blank');
    }

    function onDelMouFile(id, fieldID) {
        // Display a SweetAlert confirmation dialog
        Swal.fire({
            title: 'แจ้งเตือน',
            text: 'ยืนยันการลบไฟล์?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'ยืนยันการลบ',
            cancelButtonText: 'ย้อนกลับ',
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: '<?php echo base_url('crud/workplace/onDeleteMouFile/') ?>' + id,
                    type: "POST",
                    dataType: "json",
                    success: function(response) {
                        if (!response.status) {
                            showErrorSweetalert("ผิดพลาด!", response.errorMessage);
                            return;
                        }
                        showSuccessSweetalert("สำเร็จ!", response.message, 1500);
                        removeWorkplaceMouField(fieldID);
                    },
                    error: function(xhr, status, error) {
                        showErrorSweetalert('ผิดพลาด!', error, 1500);
                    }
                });
            }
        })
    }

    function setWorkplaceMouField(mouID, mouDetail, mouFile) {
        workplaceMouFieldCount++;
        let workplaceMouField = document.getElementById('workplaceMouField')
        let element = document.createElement("div");
        element.setAttribute("class", "card removeClassID-" + workplaceMouFieldCount);

        element.innerHTML = `
            <div class="card-header bg-success text-white d-flex no-block">
                ความร่วมมือ MOU
                <button type="button" class="btn-close ms-auto" onclick="onDelMouFile(${mouID}, ${workplaceMouFieldCount});" aria-hidden="true"></button>
            </div>
            <div class="card-body shadow">
                <input type="text" class="form-control" name="mouID[]" value="${mouID}" hidden required>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label class="form-label">เรื่อง / เกี่ยวกับ</label>
                            <textarea class="form-control" placeholder="กรุณาป้อนรายละเอียด" name="mouDetail[]" rows="5" required>${mouDetail}</textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                                <label class="form-label">ไฟล์ข้อมูลการทำ MOU</label>
                                <div class="input-group">
                                    <input id="mouFileDisplayID-${workplaceMouFieldCount}" type="text" class="form-control" readonly>
                                    <div class="input-group-append ms-1">
                                        <button id="mouFileLinkID-${workplaceMouFieldCount}" class="btn btn-success text-white h-100" type="button" ><i class="fas fa-list"></i></button>
                                    </div>
                                    <div class="input-group-append ms-1">
                                        <button onclick="fileSelectClick('mouFile-${workplaceMouFieldCount}')" class="btn btn-info text-white h-100" type="button"><i class="fas fa-edit"></i></button>
                                    </div>
                                </div>
                                <input onchange="onFileSelectChange('mouFileDisplayID-${workplaceMouFieldCount}', this)" type="file" class="form-control" id="mouFile-${workplaceMouFieldCount}" name="mouFile[]" accept=".doc, .docx, .pdf, image/png, image/jpeg, image/jpg" hidden >
                            </div>
                    </div>
                </div>
            </div>
        `;
        workplaceMouField.appendChild(element)

        $('#mouFileDisplayID-' + workplaceMouFieldCount).val(mouFile);
        $('#mouFileLinkID-' + workplaceMouFieldCount).attr('onclick', 'viewFile(\'<?php echo base_url('assets/files/mouFiles/') ?>' + mouFile + '\')');
    }

    function addWorkplaceMouField() {
        workplaceMouFieldCount++;
        let workplaceMouField = document.getElementById('workplaceMouField')
        let element = document.createElement("div");
        element.setAttribute("class", "card removeClassID-" + workplaceMouFieldCount);

        element.innerHTML = `
            <div class="card-header bg-success text-white d-flex no-block">
                ความร่วมมือ MOU
                <button type="button" class="btn-close ms-auto" onclick="removeWorkplaceMouField(${workplaceMouFieldCount});" aria-hidden="true"></button>
            </div>
            <div class="card-body shadow">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label class="form-label">เรื่อง / เกี่ยวกับ</label>
                            <textarea class="form-control" placeholder="กรุณาป้อนรายละเอียด" name="mouDetail[]" rows="5" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label class="form-label">ไฟล์ข้อมูลการทำ MOU</label>
                            <input type="file" class="form-control" name="mouFile[]" accept=".doc, .docx, .pdf, image/png, image/jpeg, image/jpg" required>
                        </div>
                    </div>
                </div>
            </div>
        `;
        workplaceMouField.appendChild(element)
    }

    function removeWorkplaceMouField(workplaceMouFieldCount) {
        $('.removeClassID-' + workplaceMouFieldCount).remove();
    }
</script>