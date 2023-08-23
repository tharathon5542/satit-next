<div id="bannerAddModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">อัปโหลดแบนเนอร์</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <form id="addBannerForm" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="bannerFile" class="form-label">ขนาดไฟล์ 1920 x 1000 (ไม่เกิน 2 MB) </label>
                        <div class="input-group">
                            <input type="file" id="bannerFile" name="bannerFile" class="dropify" data-max-file-size="2M" accept="image/png, image/jpeg, image/jpg" required />
                        </div>
                    </div>
                    <div class="form-group col-lg-6 col-sm-12">
                        <label for="bannerOrder" class="form-label">ลำดับการแสดงแบนเนอร์</label>
                        <div class="input-group mb-3">
                            <input type="number" class="form-control" id="bannerOrder" name="bannerOrder" min="1" value="1" onkeydown="return false">
                            <span class="input-group-text">
                                <div class="form-check form-switch">
                                    <input type="checkbox" class="form-check-input" id="bannerDisplay" name="bannerDisplay" checked>
                                    <label class="form-check-label" for="bannerDisplay">แสดงแบนเนอร์บนเว็บไซต์</label>
                                </div>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success waves-effect waves-light text-white me-auto">อัปโหลด</button>
                    <button type="button" class="btn btn-default waves-effect" data-bs-dismiss="modal">ย้อนกลับ</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>

<script>
    $('#bannerAddModal').on('hidden.bs.modal', function() {
        $('#modal-container').html('');
    })

    // innitilize dropify
    $('.dropify').dropify({
        messages: {
            'default': 'ลาก หรือเลือกไฟล์เพื่อทำการอัปโหลด',
            'replace': 'ลาก หรือเลือกไฟล์เพื่อทำการเปลี่ยน',
            'remove': 'ลบรายการ',
        },
    });

    $("#addBannerForm").validate({
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
                url: "<?php echo base_url('crud/banner/onAddBanner') ?>",
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
                    showSuccessSweetalert("สำเร็จ!", "เพิ่มข้อมูลแบนเนอร์แล้ว", 1500);
                    setTimeout(function() {
                        fetchBanner();
                        $("#bannerAddModal").modal("hide");
                    }, 1500)
                },
                error: function(xhr, status, error) {
                    showErrorSweetalert('ผิดพลาด!', error, 1500);
                }
            })
        },
        messages: {
            bannerFile: "กรุณาเลือกไฟล์รูปภาพ",
        },
    });
</script>