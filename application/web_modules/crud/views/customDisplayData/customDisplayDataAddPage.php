<div id="customDisplayDataAddModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">เพิ่มข้อมูลผลการดำเนินงาน</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <form id="addCustomDisplayDataForm" novalidate>
                            <?php if ($this->session->userdata('crudSessionData')['crudPermission'] == 'admin') { ?>
                                <div class="row">
                                    <div class="form-group">
                                        <label class="form-label">สังกัดคณะ (Admin)</label>
                                        <select id="facultyID" name="facultyID" class="form-select" required>
                                            <option value>----- เลือกสังกัดคณะ -----</option>
                                            <?php
                                            $queryFaculty = $this->db->select('faculty_id, faculty_name_th')->get('cwie_faculty');
                                            foreach ($queryFaculty->result() as $faculty) { ?>
                                                <option value="<?php echo $faculty->faculty_id ?>"><?php echo $faculty->faculty_name_th ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label">หัวข้อผลการดำเนินงาน</label>
                                        <input type="text" class="form-control" placeholder="กรุณาป้อนหัวข้อผลการดำเนินงาน" name="dataTitle" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">ปริมาณข้อมูล <small class="text-muted">(เป็นตัวเลข)</small></label>
                                        <input type="text" class="form-control" placeholder="กรุณาป้อนปริมาณข้อมูล" name="data" required>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">หน่วย</label>
                                        <input type="text" class="form-control" placeholder="กรุณาป้อนหน่วย" name="unit" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">ไอคอน <small class="text-muted">(ICON) <a href="<?php echo base_url('crud/CustomDisplayData/iconList') ?>" target="_blank" class="mt-3 text-info text-decoration-underline">รายการไอคอน</a></small></label>
                                        <input type="text" class="form-control" placeholder="ตัวอย่าง icon-line-github" name="icon" required>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">สีการ์ด</label>
                                        <input class="form-control d-block" type="color" name="color">
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
    $('#customDisplayDataAddModal').on('hidden.bs.modal', function() {
        $('#modal-container').html('');
    })

    $("#addCustomDisplayDataForm").validate({
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
            $.ajax({
                url: "<?php echo base_url('crud/CustomDisplayData/onAddCustomDisplayData') ?>",
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

                    showSuccessSweetalert('สำเร็จ!', 'เพิ่มข้อมูลผลการดำเนินงานแล้ว', 1500);
                    setTimeout(function() {
                        $('#customDisplayDataTable').DataTable().ajax.reload();
                        $('#customDisplayDataAddModal').modal('hide');
                    }, 1500)
                },
                error: function(xhr, status, error) {
                    showErrorSweetalert('ผิดพลาด!', error, 1500);
                }
            })
        },
    });
</script>