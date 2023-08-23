<div id="newsEditModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">แก้ไขข่าวประชาสัมพันธ์</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <form id="editNewsForm" enctype="multipart/form-data">
                <input type="text" id="newsID" name="newsID" readonly hidden>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">หัวข้อข่าวประชาสัมพันธ์</label>
                                <input type="text" class="form-control" id="newsTitle" name="newsTitle" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="form-label">เนื้อหาข่าว</label>
                                <textarea class="textarea-tinymce" id="newsDetail" name="newsDetail"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="form-label">ลิ้งก์ URL <span class="text-mute">(Optional)</span></label>
                                <input type="text" class="form-control" id="newsUrl" name="newsUrl">
                            </div>
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
    $('#newsEditModal').on('hidden.bs.modal', function() {
        $('#modal-container').html('');
    })

    // Destroy existing instance of TinyMCE
    tinymce.remove('#newsDetail');

    tinymce.init({
        selector: '#newsDetail',
        paste_as_text: true,
        entity_encoding: "numeric"
    });

    $("#editNewsForm").validate({
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
        submitHandler: function(form) {
            Swal.fire({
                title: 'แจ้งเตือน',
                text: 'ยืนยันการแก้ไขข้อข่าวประชาสัมพันธ์?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'ยืนยัน',
                cancelButtonText: 'ย้อนกลับ',
            }).then((result) => {
                if (result.value) {
                    tinyMCE.triggerSave();
                    $.ajax({
                        url: "<?php echo base_url('crud/news/onEditNews') ?>",
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
                            showSuccessSweetalert('สำเร็จ!', 'แก้ไขข้อมูลข่าวประชาสัมพันธ์แล้ว', 1500);
                            setTimeout(function() {
                                fetchNews(currentPageGlobal);
                                $("#newsEditModal").modal("hide");
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