<div id="categoryEditModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">แก้ไขข้อมูลประเภทหลักสูตร CWIE</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                <form id="editCategoryForm" novalidate>
                    <input type="hidden" name="categoryID">
                    <div class="row">
                        <div class="form-group">
                            <label class="form-label">ชื่อประเภทหลักสูตร CWIE</label>
                            <input type="text" class="form-control" placeholder="กรุณาป้อนชื่อประเภทหลักสูตร CWIE" id="categoryName" name="categoryName" required>
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
    $('#categoryEditModal').on('hidden.bs.modal', function() {
        $('#modal-container').html('');
    })

    $("#editCategoryForm").validate({
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
                text: 'ยืนยันการแก้ไขข้อมูลประเภทหลักสูตร CWIE?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'ยืนยัน',
                cancelButtonText: 'ย้อนกลับ',
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "<?php echo base_url('crud/categoryCourse/onEditCategory') ?>",
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
                            showSuccessSweetalert('สำเร็จ!', 'แก้ไขข้อมูลประเภทหลักสูตร CWIE แล้ว', 1500);
                            setTimeout(function() {
                                $('#categoryTable').DataTable().ajax.reload();
                                $('#categoryEditModal').modal('hide');
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