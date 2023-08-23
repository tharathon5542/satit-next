<div id="yearEditModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">แก้ไขข้อมูลปีการศึกษา</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                <form id="editYearForm" novalidate>
                    <input type="text" name="yearID" readonly hidden>
                    <div class="row">
                        <div class="form-group">
                            <label class="form-label">ปีการศึกษา</label>
                            <div class="input-group">
                                <span class="input-group-text">ปีการศึกษาพุทธศักราช</span>
                                <input type="text" class="form-control" placeholder="กรุณาป้อนปีการศึกษา" id="yearTitle" name="yearTitle" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-info waves-effect waves-light text-white me-auto">บันทึกข้อมูล</button>
                        <button type="button" class="btn btn-default waves-effect" data-bs-dismiss="modal">ย้อนกลับ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $('#yearEditModal').on('hidden.bs.modal', function() {
        $('#modal-container').html('');
    })

    $("#editYearForm").validate({
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
                text: 'ยืนยันการแก้ไขข้อมูลปีการศึกษา?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'ยืนยัน',
                cancelButtonText: 'ย้อนกลับ',
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "<?php echo base_url('crud/year/onEditYear') ?>",
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
                            showSuccessSweetalert('สำเร็จ!', 'แก้ไขข้อมูลปีการศึกษาแล้ว', 1500);
                            setTimeout(function() {
                                $('#yearTable').DataTable().ajax.reload();
                                $('#yearEditModal').modal('hide');
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
</script>