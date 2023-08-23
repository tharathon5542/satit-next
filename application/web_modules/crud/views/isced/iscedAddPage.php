<div id="iscedAddModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">เพิ่มข้อมูล ISCED </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                <div class="card wizard-content">
                    <div class="card-body">
                        <form id="addIscedForm" novalidate>
                            <div class="row">
                                <div class="form-group">
                                    <label class="form-label">ชื่อ ISCED </label>
                                    <input type="text" class="form-control" placeholder="กรุณาป้อนชื่อ ISCED " name="iscedName" required>
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
    $('#iscedAddModal').on('hidden.bs.modal', function() {
        $('#modal-container').html('');
    })

    $("#addIscedForm").validate({
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
                url: "<?php echo base_url('crud/isced/onAddIsced') ?>",
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
                    showSuccessSweetalert('สำเร็จ!', 'เพิ่มข้อมูล ISCED แล้ว', 1500);
                    setTimeout(function() {
                        $('#iscedTable').DataTable().ajax.reload();
                        $('#iscedAddModal').modal('hide');
                    }, 1500)
                },
                error: function(xhr, status, error) {
                    showErrorSweetalert('ผิดพลาด!', error, 1500);
                }
            })
        },
    });
</script>