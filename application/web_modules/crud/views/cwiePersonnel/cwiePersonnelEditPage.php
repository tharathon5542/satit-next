<div id="personnelEditModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">แก้ไขข้อมูลบุคลากร</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                <div class="card wizard-content">
                    <div class="card-body">
                        <form id="editPersonnelForm" class="validation-wizard wizard-circle" novalidate>
                            <!-- Step 1 -->
                            <h6>ข้อมูลมูลบุคลากร</h6>
                            <section>
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
                                <?php } ?>
                                <input type="hidden" name="personnelID">
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
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label">ค้นหาข้อมูลบุคลากรจากฐานข้อมูล</label>
                                            <select id="personelSelect2" class="form-control form-select" style="width: 100%; height:36px;">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <input type="text" class="form-control" placeholder="กรุณาป้อนเลขบัตรประชาชน" id="personnelCitizenID" name="personnelCitizenID" required hidden>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">ประเภทบุคลากร</label>
                                            <select id="personnelType" name="personnelType" class="form-select" required>
                                                <option value>----- เลือกประเภทบุคลากร -----</option>
                                                <?php
                                                $queryPersonnelType = $this->db->get('cwie_personnel_type');
                                                foreach ($queryPersonnelType->result() as $personnelType) { ?>
                                                    <option value="<?php echo $personnelType->personnel_type_id ?>"><?php echo $personnelType->personnel_type_title ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">ชื่อ</label>
                                            <input type="text" class="form-control" placeholder="กรุณาป้อนชื่อ" id="personnelName" name="personnelName" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">นามสกุล</label>
                                            <input type="text" class="form-control" placeholder="กรุณาป้อนนามสกุล" id="personnelSurname" name="personnelSurname" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">เบอร์ติดต่อ</label>
                                            <input type="text" class="form-control" placeholder="กรุณาเบอร์ติดต่อ" id="personnelTel" name="personnelTel" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">อีเมล <span class="text-muted">(Optional)</span></label>
                                            <input type="email" class="form-control" placeholder="กรุณาป้อนอีเมล" id="personnelEmail" name="personnelEmail">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <label class="form-label">ตำแหน่ง</label>
                                        <input type="text" class="form-control" id="personnelPosition" name="personnelPosition" placeholder="กรุณาป้อนข้อมูลตำแหน่งผู้ประสานงาน">
                                    </div>
                                </div>
                            </section>
                            <!-- Step 2 -->
                            <h6>ประสบการณ์สอน</h6>
                            <section>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label">ประสบการณ์สอน <span class="text-muted">(Optional)</span></label>
                                            <textarea class="form-control" name="personnelEXP" id="personnelEXP" rows="7" placeholder="กรุณาป้อนประสบการณ์สอน"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <!-- Step 3 -->
                            <h6>การฝึกอบรม | รางวัล</h6>
                            <section>
                                <div class="row">
                                    <div class="col-12 ">
                                        <div class="form-group">
                                            <label class="form-label">ประเภท</label>
                                            <div class="input-group">
                                                <select class="form-select" id="PersonnelFileFieldType">
                                                    <option value="0">การฝึกอบรม</option>
                                                    <option value="1">การรับรางวัล</option>
                                                </select>
                                                <div class="input-group-append ms-1">
                                                    <button class="btn btn-success text-white" type="button" onclick="addPersonnelFileField();"><i class="fa fa-plus"></i> เพิ่มการฝึกอบรม | รางวัล</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div id="personnelFileField"></div>
                            </section>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#personnelEditModal').on('hidden.bs.modal', function() {
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

            const formData = new FormData($('#editPersonnelForm')[0]);

            $.ajax({
                url: "<?php echo base_url('crud/personnel/onEditPersonnel') ?>",
                method: "POST",
                data: formData,
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
                    showSuccessSweetalert('สำเร็จ!', 'แก้ไขข้อมูลบุคลากรแล้ว', 1500);
                    setTimeout(function() {
                        $('#personnelTable').DataTable().ajax.reload();
                        $('#personnelEditModal').modal('hide');
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
            error.insertAfter(element.closest('div.select2CustomContainer').length ? element.closest('div.select2CustomContainer') : element)
        },
        messages: {
            personnelEmail: "กรุณาป้อน Email ให้ถูกต้อง",
            "personnelTrainingID[]": "กรุณาป้อนข้อมูลช่องนี้",
            "personnelTrainingDate[]": "กรุณาป้อนข้อมูลช่องนี้",
            "personnelTrainingFile[]": "กรุณาป้อนข้อมูลช่องนี้",
            "personnelTrophyID[]": "กรุณาป้อนข้อมูลช่องนี้",
            "personnelTrophyDate[]": "กรุณาป้อนข้อมูลช่องนี้",
            "personnelTrophyFile[]": "กรุณาป้อนข้อมูลช่องนี้",
        },
    })

    $("#courseID").select2({
        dropdownParent: $('#personnelEditModal'),
    });

    $("#personelSelect2").select2({
        placeholder: 'กรุณาป้อนชื่อ หรือนามสกุลเพื่อคนหาบุคลากรภายใน',
        dropdownParent: $('#personnelEditModal'),
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
                $("#personnelCitizenID").val(data[0].citizen_id);
                $("#personnelName").val(data[0].th_ed + data[0].fname_th);
                $("#personnelSurname").val(data[0].lanme_th);
                $("#personnelTel").val(data[0].mobile_no);
            }
        })
    });

    function onDelPersonnelFile(type, id, fieldID) {
        // Display a SweetAlert confirmation dialog
        Swal.fire({
            title: 'แจ้งเตือน',
            text: 'ยืนยันการลบไฟล์หลักฐาน?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'ยืนยันการลบ',
            cancelButtonText: 'ย้อนกลับ',
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: '<?php echo base_url('crud/personnel/onDeletePersonnelFile/') ?>' + id,
                    type: "POST",
                    data: {
                        type: type
                    },
                    dataType: "json",
                    success: function(response) {
                        if (!response.status) {
                            showErrorSweetalert("ผิดพลาด!", response.errorMessage);
                            return;
                        }
                        showSuccessSweetalert("สำเร็จ!", response.message, 1500);
                        removePersonnelFileField(fieldID);
                    },
                    error: function(xhr, status, error) {
                        showErrorSweetalert('ผิดพลาด!', error, 1500);
                    }
                });
            }
        })
    }

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

    function setPersonnelFile(type, categoryID, fileID, fileDate, file) {
        personnelFileFieldCount++;
        let personnelFileField = document.getElementById('personnelFileField')
        let element = document.createElement("div");
        element.setAttribute("class", "card removeClassID-" + personnelFileFieldCount);

        if (type == 0) {
            element.innerHTML = `
                <div class="card-header bg-success text-white d-flex no-block">
                    การฝึกอบรม
                    <button type="button" class="btn-close ms-auto" onclick="onDelPersonnelFile(${type},${fileID}, ${personnelFileFieldCount});" aria-hidden="true"></button>
                </div>
                <div class="card-body shadow">
                    <input type="text" class="form-control" name="personnelTrainingFileID[]" value="${fileID}" hidden required>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">การฝึกอบรม</label>
                                <select id="personnelTrainingID-${personnelFileFieldCount}" name="personnelTrainingID[]" class="form-select" required>
                                    <option value>----- เลือกการรับรางวัล -----</option>
                                    <?php
                                    $queryPersonnelTraining = $this->db->get('cwie_personnel_training');
                                    foreach ($queryPersonnelTraining->result() as $personnelTraning) { ?>
                                        <option value="<?php echo $personnelTraning->personnel_training_id ?>"><?php echo $personnelTraning->personnel_training_name ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label class="form-label">วันที่รับ</label>
                                <input type="date" class="form-control" id="personnelTrainingDate-${personnelFileFieldCount}" name="personnelTrainingDate[]" value="${fileDate}" required>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label class="form-label">ไฟล์หลักฐานการฝึกอบรม</label>
                                <div class="input-group">
                                    <input id="personnelTrainingFileDisplayID-${personnelFileFieldCount}" type="text" class="form-control" readonly>
                                    <div class="input-group-append ms-1">
                                        <button id="personnelTrainingFileLinkID-${personnelFileFieldCount}" class="btn btn-success text-white h-100" type="button" ><i class="fas fa-list"></i></button>
                                    </div>
                                    <div class="input-group-append ms-1">
                                        <button onclick="fileSelectClick('personnelTrainingFile-${personnelFileFieldCount}')" class="btn btn-info text-white h-100" type="button"><i class="fas fa-edit"></i></button>
                                    </div>
                                </div>
                                <input onchange="onFileSelectChange('personnelTrainingFileDisplayID-${personnelFileFieldCount}', this)" type="file" class="form-control" id="personnelTrainingFile-${personnelFileFieldCount}" name="personnelTrainingFile[]" accept=".doc, .docx, .pdf, image/png, image/jpeg, image/jpg" hidden >
                            </div>
                        </div>
                    </div>
                </div>
            `;
            personnelFileField.appendChild(element)
        } else {
            element.innerHTML = `
                <div class="card-header bg-primary text-white d-flex no-block">
                    การรับรางวัล
                    <button type="button" class="btn-close ms-auto" onclick="onDelPersonnelFile(${type},${fileID}, ${personnelFileFieldCount});" aria-hidden="true"></button>
                </div>
                <div class="card-body shadow">
                    <input type="text" class="form-control" name="personnelTrophyFileID[]" value="${fileID}" hidden required>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">การรับรางวัล</label>
                                <select id="personnelTrophyID-${personnelFileFieldCount}" name="personnelTrophyID[]" class="form-select" required> 
                                    <option value>----- เลือกการรับรางวัล -----</option>
                                        <?php
                                        $queryPersonnelTrophy = $this->db->get('cwie_personnel_trophy');
                                        foreach ($queryPersonnelTrophy->result() as $personnelTrophy) { ?>
                                                <option value="<?php echo $personnelTrophy->personnel_trophy_id ?>"><?php echo $personnelTrophy->personnel_trophy_name ?></option>
                                        <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label class="form-label">วันที่รับ</label>
                                <input type="date" class="form-control" id="personnelTrophyDate-${personnelFileFieldCount}" name="personnelTrophyDate[]" value="${fileDate}" required>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label class="form-label">ไฟล์หลักฐานการรับรางวัล</label>
                                <div class="input-group">
                                    <input id="personnelTrophyFileDisplayID-${personnelFileFieldCount}" type="text" class="form-control" readonly>
                                    <div class="input-group-append ms-1">
                                        <button id="personnelTrophyFileLinkID-${personnelFileFieldCount}" class="btn btn-success text-white h-100" type="button" ><i class="fas fa-list"></i></button>
                                    </div>
                                    <div class="input-group-append ms-1">
                                        <button onclick="fileSelectClick('personnelTrophyFile-${personnelFileFieldCount}')" class="btn btn-info text-white h-100" type="button"><i class="fas fa-edit"></i></button>
                                    </div>
                                </div>
                                <input onchange="onFileSelectChange('personnelTrophyFileDisplayID-${personnelFileFieldCount}', this)" type="file" class="form-control" id="personnelTrophyFile-${personnelFileFieldCount}" name="personnelTrophyFile[]" accept=".doc, .docx, .pdf, image/png, image/jpeg, image/jpg" hidden >
                            </div>
                        </div>
                    </div>
                </div>
            `;
            personnelFileField.appendChild(element)
        }

        if (type == 0) {
            $('#personnelTrainingID-' + personnelFileFieldCount).val(categoryID);
            $('#personnelTrainingFileDisplayID-' + personnelFileFieldCount).val(file);
            $('#personnelTrainingFileLinkID-' + personnelFileFieldCount).attr('onclick', 'viewFile(\'<?php echo base_url('assets/files/personnelFiles/') ?>' + file + '\')');
        } else {
            $('#personnelTrophyID-' + personnelFileFieldCount).val(categoryID);
            $('#personnelTrophyFileDisplayID-' + personnelFileFieldCount).val(file);
            $('#personnelTrophyFileLinkID-' + personnelFileFieldCount).attr('onclick', 'viewFile(\'<?php echo base_url('assets/files/personnelFiles/') ?>' + file + '\')');
        }
    }

    function addPersonnelFileField() {
        personnelFileFieldCount++;
        let personnelFileField = document.getElementById('personnelFileField')
        let element = document.createElement("div");
        element.setAttribute("class", "card removeClassID-" + personnelFileFieldCount);

        if ($('#PersonnelFileFieldType').val() == 0) {
            element.innerHTML = `
                <div class="card-header bg-success text-white d-flex no-block">
                    การฝึกอบรม
                    <button type="button" class="btn-close ms-auto" onclick="removePersonnelFileField(${personnelFileFieldCount});" aria-hidden="true"></button>
                </div>
                <div class="card-body shadow">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">การฝึกอบรม</label>
                                <select id="personnelTrainingID-${personnelFileFieldCount}" name="personnelTrainingID[]" class="form-select" required>
                                    <option value>----- เลือกการรับรางวัล -----</option>
                                    <?php
                                    $queryPersonnelTraining = $this->db->get('cwie_personnel_training');
                                    foreach ($queryPersonnelTraining->result() as $personnelTraning) { ?>
                                        <option value="<?php echo $personnelTraning->personnel_training_id ?>"><?php echo $personnelTraning->personnel_training_name ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label class="form-label">วันที่รับ</label>
                                <input type="date" class="form-control" id="personnelTrainingDate-${personnelFileFieldCount}" name="personnelTrainingDate[]" required>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label class="form-label">ไฟล์หลักฐานการฝึกอบรม</label>
                                <input type="file" class="form-control" id="personnelTrainingFile-${personnelFileFieldCount}" name="personnelTrainingFile[]" accept=".doc, .docx, .pdf" required>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        } else {
            element.innerHTML = `
                <div class="card-header bg-primary text-white d-flex no-block">
                    การรับรางวัล
                    <button type="button" class="btn-close ms-auto" onclick="removePersonnelFileField(${personnelFileFieldCount});" aria-hidden="true"></button>
                </div>
                <div class="card-body shadow">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">การรับรางวัล</label>
                                <select id="personnelTrophyID-${personnelFileFieldCount}" name="personnelTrophyID[]" class="form-select" required> 
                                    <option value>----- เลือกการรับรางวัล -----</option>
                                        <?php
                                        $queryPersonnelTrophy = $this->db->get('cwie_personnel_trophy');
                                        foreach ($queryPersonnelTrophy->result() as $personnelTrophy) { ?>
                                                <option value="<?php echo $personnelTrophy->personnel_trophy_id ?>"><?php echo $personnelTrophy->personnel_trophy_name ?></option>
                                        <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label class="form-label">วันที่รับ</label>
                                <input type="date" class="form-control" id="personnelTrophyDate-${personnelFileFieldCount}" name="personnelTrophyDate[]" required>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label class="form-label">ไฟล์หลักฐานการรับรางวัล</label>
                                <input type="file" class="form-control" id="personnelTrophyFile-${personnelFileFieldCount}" name="personnelTrophyFile[]" accept=".doc, .docx, .pdf" required>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }

        personnelFileField.appendChild(element)
    }

    function removePersonnelFileField(personnelFileFieldCount) {
        $('.removeClassID-' + personnelFileFieldCount).remove();
    }
</script>