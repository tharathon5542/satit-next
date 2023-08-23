<div id="personnelAddModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">เพิ่มข้อมูลบุคลากร</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                <div class="card wizard-content">
                    <div class="card-body">
                        <form id="addPersonnelForm" class="validation-wizard wizard-circle" novalidate>
                            <!-- Step 1 -->
                            <h6>ข้อมูลมูลบุคลากร</h6>
                            <section>
                                <?php if ($this->session->userdata('crudSessionData')['crudPermission'] == 'admin') { ?>
                                    <div class="row">
                                        <div class="form-group">
                                            <label class="form-label">สังกัดสาขา (Admin)</label>
                                            <select name="majorID" class="form-select" required>
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
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label">หลักสูตร</label>
                                            <div class="select2CustomContainer">
                                                <select id="courseIDselect2" name="courseID[]" style="width: 100%;" required multiple>
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
                                            <select id="personnelSelect2" style="width: 100%;">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <input type="text" class="form-control" placeholder="กรุณาป้อนเลขบัตรประชาชน" id="personnelCitizenID" name="personnelCitizenID" required hidden>
                                    <div class="col-sm-12 col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label">ประเภทบุคลากร</label>
                                            <select name="personnelType" class="form-select" required>
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
                                        <input type="text" class="form-control" name="personnelPosition" placeholder="กรุณาป้อนข้อมูลตำแหน่งผู้ประสานงาน">
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
    $('#personnelAddModal').on('hidden.bs.modal', function() {
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

            const formData = new FormData($('#addPersonnelForm')[0]);

            $.ajax({
                url: "<?php echo base_url('crud/personnel/onAddPersonnel') ?>",
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
                        showErrorSweetalert("ผิดพลาด!", response.errorMessage, 2000);
                        return;
                    }
                    showSuccessSweetalert('สำเร็จ!', 'เพิ่มข้อมูลบุคลากรแล้ว', 1500);
                    setTimeout(function() {
                        personnelFileFieldCount = 0;
                        $('#personnelTable').DataTable().ajax.reload();
                        $('#personnelAddModal').modal('hide');
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

    $("#courseIDselect2").select2({
        dropdownParent: $('#personnelAddModal'),
    });

    $("#personnelSelect2").select2({
        placeholder: 'กรุณาป้อนชื่อ หรือนามสกุลเพื่อคนหาบุคลากรภายใน',
        dropdownParent: $('#personnelAddModal'),
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

    $('#personnelSelect2').change(function() {
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
                            <input type="file" class="form-control" id="personnelTrainingFile-${personnelFileFieldCount}" name="personnelTrainingFile[]" accept=".doc, .docx, .pdf, image/png, image/jpeg, image/jpg" required>
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
                            <input type="file" class="form-control" id="personnelTrophyFile-${personnelFileFieldCount}" name="personnelTrophyFile[]" accept=".doc, .docx, .pdf, image/png, image/jpeg, image/jpg" required>
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