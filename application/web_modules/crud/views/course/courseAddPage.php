<div id="courseAddModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">เพิ่มข้อมูลหลักสูตร CWIE</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                <div class="card wizard-content">
                    <div class="card-body">
                        <form id="addCourseForm" class="validation-wizard wizard-circle" novalidate>
                            <!-- Step 1 -->
                            <h6>ข้อมูลหลักสูตร</h6>
                            <section>
                                <?php if ($this->session->userdata('crudSessionData')['crudPermission'] == 'admin') { ?>
                                    <div class="row">
                                        <div class="form-group">
                                            <label class="form-label">สาขาเจ้าของหลักสูตร (Admin)</label>
                                            <select name="courseMajorID" class="form-select" required>
                                                <option value>----- เลือกสาขาเจ้าของหลักสูตร -----</option>
                                                <?php
                                                $queryMajor = $this->db->get('cwie_major');
                                                foreach ($queryMajor->result() as $major) { ?>
                                                    <option value="<?php echo $major->major_id ?>"><?php echo $major->major_name_th ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="row">
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">ปีการศึกษา</label>
                                            <select name="courseYear" class="form-select" required>
                                                <option value>----- เลือกปีการศึกษา -----</option>
                                                <?php
                                                $queryYear = $this->db->get('cwie_year');
                                                foreach ($queryYear->result() as $year) { ?>
                                                    <option value="<?php echo $year->year_id ?>"><?php echo $year->year_title ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">รหัสหลักสูตร</label>
                                            <input type="text" class="form-control" placeholder="กรุณาป้อนรหัสหลักสูตร" name="courseCode">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">ระดับการศึกษา</label>
                                            <select name="courseGrade" class="form-select">
                                                <option value="0">ปริญญาตรี</option>
                                                <option value="1">ปริญญาโท</option>
                                                <option value="2">ปริญญาเอก</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <label class="form-label">ชื่อหลักสูตร (ภาษาไทย)</label>
                                        <input type="text" class="form-control" placeholder="กรุณาป้อนชื่อหลักสูตร" name="courseName" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <label class="form-label">ชื่อหลักสูตร (ภาษาอังกฤษ)</label>
                                        <input type="text" class="form-control" placeholder="กรุณาป้อนชื่อหลักสูตรภาษาอังกฤษ" name="courseNameEN">
                                    </div>
                                </div>
                            </section>
                            <!-- Step 2 -->
                            <h6>ข้อมูล CWIE</h6>
                            <section>
                                <div class="row">
                                    <div class="col-lg-6 col-12">
                                        <div class="form-group">
                                            <label class="form-label">กลุ่มสาขาตามระบบของ ISCED 2013</label>
                                            <select name="courseISCED" class="form-select">
                                                <option value>----- เลือก ISCED -----</option>
                                                <?php
                                                $queryIsced = $this->db->get('cwie_isced');
                                                foreach ($queryIsced->result() as $isced) { ?>
                                                    <option value="<?php echo $isced->isced_id ?>"><?php echo $isced->isced_name ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <div class="form-group">
                                            <label class="form-label">ประเภท CWIE</label>
                                            <select name="courseCwieCategory" class="form-select">
                                                <option value>----- เลือกประเภท CWIE -----</option>
                                                <?php
                                                $queryCategory = $this->db->get('cwie_course_category');
                                                foreach ($queryCategory->result() as $category) { ?>
                                                    <option value="<?php echo $category->course_category_id ?>"><?php echo $category->course_category_name ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Hard Skills (ทักษะด้านวิชาชีพ) ของนักศึกษา</label>
                                            <textarea class="form-control" name="courseHardSkills" rows="5" placeholder="กรุณาป้อนข้อมูลทักษะด้านวิชาชีพ"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Soft Skills (ทักษะด้านการบริหารจัดการความคิดและอารมณ์) ของนักศึกษา</label>
                                            <textarea class="form-control" name="courseSoftSkills" rows="5" placeholder="กรุณาป้อนข้อมูลทักษะด้านการบริหารจัดการความคิดและอารมณ์"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-12">
                                        <div class="form-group">
                                            <label class="form-label">วิชาชีพ</label>
                                            <select name="courseProfession" class="form-select">
                                                <option value>----- เลือกวิชาชีพ -----</option>
                                                <?php
                                                $queryProfession = $this->db->get('cwie_profession');
                                                foreach ($queryProfession->result() as $profession) { ?>
                                                    <option value="<?php echo $profession->profession_id ?>"><?php echo $profession->profession_name ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <div class="form-group">
                                            <label class="form-label">คำค้นหา</label>
                                            <div class="tags-default">
                                                <input type="text" name="courseTags" placeholder="เพิ่มคำค้นหา" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <!-- Step 3 -->
                            <h6>ข้อมูล CHECO</h6>
                            <section>
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">รหัสอ้างอิง CHECO</label>
                                            <input type="text" class="form-control" placeholder="กรุณาป้อนรหัสอ้างอิง CHECO" name="courseChecoCode">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">วันที่รับทราบ</label>
                                            <input type="date" class="form-control" placeholder="กรุณาป้อนวันที่รับทราบ" name="courseChecoAcknowledge">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label">ประเภทการดำเนินการ</label>
                                            <input type="text" class="form-control" placeholder="กรุณาป้อนประเภทการดำเนินการ" name="courseChecoOperation">
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <!-- Step 3 -->
                            <h6>ข้อมูลผู้ประสานงานหลักสูตร</h6>
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
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">ชื่อ</label>
                                            <input type="text" class="form-control" id="courseCoordinatorName" name="courseCoordinatorName" placeholder="กรุณาป้อนข้อมูลชื่อผู้ประสานงาน" required>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">นามสกุล</label>
                                            <input type="text" class="form-control" id="courseCoordinatorSurname" name="courseCoordinatorSurname" placeholder="กรุณาป้อนข้อมูลนามสกุลผู้ประสานงาน" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">เบอร์โทร</label>
                                            <input type="text" class="form-control" id="courseCoordinatorTel" name="courseCoordinatorTel" placeholder="กรุณาป้อนข้อมูลเบอร์โทรผู้ประสานงาน" required>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">อีเมล <span class="text-muted">(Optional)</span></label>
                                            <input type="text" class="form-control" name="courseCoordinatorEmail" placeholder="กรุณาป้อนข้อมูลอีเมลผู้ประสานงาน">
                                        </div>
                                    </div>
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
    $('#courseAddModal').on('hidden.bs.modal', function() {
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
                url: "<?php echo base_url('crud/course/onAddCourse') ?>",
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

                    showSuccessSweetalert('สำเร็จ!', 'เพิ่มข้อมูลหลักสูตรแล้ว', 1500);
                    setTimeout(function() {
                        $('#courseTable').DataTable().ajax.reload();
                        $('#courseAddModal').modal('hide');
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
    })

    $("#personelSelect2").select2({
        placeholder: 'กรุณาป้อนชื่อ หรือนามสกุลเพื่อคนหาบุคลากรภายใน',
        dropdownParent: $('#courseAddModal'),
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
                $("#courseCoordinatorName").val(data[0].th_ed + data[0].fname_th);
                $("#courseCoordinatorSurname").val(data[0].lanme_th);
                $("#courseCoordinatorTel").val(data[0].mobile_no);
            }
        })
    });

    $('input[name="courseTags"]').tagsinput();
</script>