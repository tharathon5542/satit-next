<div id="workplaceTypeAddModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">เพิ่มข้อมูลประเภทเครือข่าย CWIE </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <form id="addWorkPlaceTypeForm" novalidate>
                        <div class="row">
                            <div class="form-group">
                                <label class="form-label">ประเภทเครือข่าย CWIE </label>
                                <input type="text" class="form-control" placeholder="กรุณาป้อนประเภทเครือข่าย CWIE " name="workplaceType" required>
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

<script>
    $('#workplaceTypeAddModal').on('hidden.bs.modal', function() {
        $('#modal-container').html('');
    })

    $("#addWorkPlaceTypeForm").validate({
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
                url: "<?php echo base_url('crud/WPType/onAddWorkplaceType') ?>",
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
                    showSuccessSweetalert('สำเร็จ!', 'เพิ่มข้อมูลประเภทเครือข่าย CWIE แล้ว', 1500);
                    setTimeout(function() {
                        $('#workplaceTypeTable').DataTable().ajax.reload();
                        $('#workplaceTypeAddModal').modal('hide');
                    }, 1500)
                },
                error: function(xhr, status, error) {
                    showErrorSweetalert('ผิดพลาด!', error, 1500);
                }
            })
        },
    });
</script>