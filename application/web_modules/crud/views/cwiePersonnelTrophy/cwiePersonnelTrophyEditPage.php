<div id="psTrophyEditModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">แก้ไขข้อมูลรางวัลบุคลากร</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                <div class="card wizard-content">
                    <div class="card-body">
                        <form id="editPsTrophyForm" novalidate>
                            <input type="hidden" name="personnelTrophyID">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label">ชื่อรางวัลบุคลากร</label>
                                        <input type="text" class="form-control" placeholder="กรุณาป้อนชื่อรางวัลบุคลากร" id="personnelTrophyName" name="personnelTrophyName" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label">หน่วยงานที่จัด</label>
                                        <input type="text" class="form-control" placeholder="กรุณาป้อนหน่วยงานที่จัด" id="personnelTrophyAgency" name="personnelTrophyAgency" required>
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
    </div>
</div>

<script>
    $('#psTrophyEditModal').on('hidden.bs.modal', function() {
        $('#modal-container').html('');
    })

    $("#editPsTrophyForm").validate({
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
                url: "<?php echo base_url('crud/pstrophy/onEditPsTrophy') ?>",
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
                    showSuccessSweetalert('สำเร็จ!', 'แก้ไขข้อมูลรางวัลบุคลากรแล้ว', 1500);
                    setTimeout(function() {
                        $('#psTrophyTable').DataTable().ajax.reload();
                        $('#psTrophyEditModal').modal('hide');
                    }, 1500)
                },
                error: function(xhr, status, error) {
                    showErrorSweetalert('ผิดพลาด!', error, 1500);
                }
            })
        },
    });
</script>