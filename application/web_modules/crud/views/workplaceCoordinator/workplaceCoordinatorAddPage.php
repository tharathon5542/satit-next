<div id="wpCoordinatorAddModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">เพิ่มข้อมูลผู้ประสานงาน</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                <div class="card wizard-content">
                    <div class="card-body">
                        <form id="addWpCoordinatorForm" novalidate>
                            <?php if ($this->session->userdata('crudSessionData')['crudPermission'] == 'admin') { ?>
                                <div class="row">
                                    <div class="form-group">
                                        <label class="form-label">เครือข่าย CWIE ของผู้ประสานงาน</label>
                                        <select name="workplaceID" class="form-select" required>
                                            <option value>----- เลือกเครือข่าย CWIE  -----</option>
                                            <?php
                                            $queryWorkplace = $this->db->get('cwie_workplace');
                                            foreach ($queryWorkplace->result() as $workplace) { ?>
                                                <option value="<?php echo $workplace->workplace_id ?>"><?php echo $workplace->workplace_name ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="row">
                                <div class="form-group">
                                    <label class="form-label">หลักสูตร</label>
                                    <select name="courseID" class="form-select" required>
                                        <option value>----- เลือกหลักสูตร -----</option>
                                        <?php
                                        $queryCourse = $this->db->get('cwie_course');
                                        foreach ($queryCourse->result() as $course) { ?>
                                            <option value="<?php echo $course->course_id ?>"><?php echo $course->course_name ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">ชื่อ</label>
                                        <input type="text" class="form-control" placeholder="กรุณาป้อนชื่อ" name="coordinatorName" required>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">นามสกุล</label>
                                        <input type="text" class="form-control" placeholder="กรุณาป้อนนามสกุล" name="coordinatorSurname" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">เบอร์ติดต่อ</label>
                                        <input type="text" class="form-control" placeholder="กรุณาป้อนเบอร์ติดต่อ" name="coordinatorTel" required>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">อีเมล <small class="text-muted">(Optional)</small></label>
                                        <input type="email" class="form-control" placeholder="กรุณาป้อนอีเมล" name="coordinatorEmail">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">ตำแหน่ง</label>
                                        <input type="text" class="form-control" placeholder="กรุณาป้อนตำแหน่ง" name="coordinatorPostion" required>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-success waves-effect waves-light text-white me-auto">เพิ่มข้อมูล</button>
                                <button type="button" class="btn btn-default waves-effect" data-bs-dismiss="modal">ย้อนกลับ</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#wpCoordinatorAddModal').on('hidden.bs.modal', function() {
        $('#modal-container').html('');
    })

    $("#addWpCoordinatorForm").validate({
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
            coordinatorEmail: "กรุณาป้อน Email ให้ถูกต้อง",
        },
        submitHandler: function(form) {
            $.ajax({
                url: "<?php echo base_url('crud/WpCoordinator/onAddWpCoordinator') ?>",
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
                    showSuccessSweetalert('สำเร็จ!', 'เพิ่มข้อมูลผู้ประสานงานแล้ว', 1500);
                    setTimeout(function() {
                        $('#wpCoordinatorTable').DataTable().ajax.reload();
                        $('#wpCoordinatorAddModal').modal('hide');
                    }, 1500)
                },
                error: function(xhr, status, error) {
                    showErrorSweetalert('ผิดพลาด!', error, 1500);
                }
            })
        },
    });
</script>