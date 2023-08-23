<div id="newsImageAddModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">เพิ่มรูปภาพข่าวประชาสัมพันธ์</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <form id="addNewsImageForm" enctype="multipart/form-data">
                <input type="text" id="newsID" name="newsID" readonly hidden>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">ขนาดไฟล์ไม่เกิน 2 MB (1900 x 1300) สามารถเลือกได้มากกว่า 1 ไฟล์ (ครั้งละไม่เกิน 10 ภาพ)</label>
                        <input type="file" id="newsImage" name="newsImage[]" class="dropify" data-max-file-size="2M" accept="image/png, image/jpeg, image/jpg" multiple/>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success waves-effect waves-light text-white me-auto">เพิ่ม</button>
                    <button type="button" class="btn btn-default waves-effect" data-bs-dismiss="modal">ย้อนกลับ</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>

<script>
    $('#newsImageAddModal').on('hidden.bs.modal', function() {
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

    $('#addNewsImageForm').on('submit', function(event) {
        event.preventDefault();

        if ($('#newsImage').val() == '') {
            showErrorSweetalert('ผิดพลาด!', "กรุณาเลือกไฟล์รูปภาพ", 1500);
            return;
        }

        $.ajax({
            url: "<?php echo base_url('crud/news/onAddNewsImage') ?>",
            method: "POST",
            data: new FormData(this),
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
                showSuccessSweetalert("สำเร็จ!", "เพิ่มรูปภาพข่าวประชาสัมพันธ์แล้ว", 1500);
                setTimeout(function() {
                    fetchNews(currentPageGlobal, true);
                    $("#newsImageAddModal").modal("hide");
                }, 1500)
            },
            error: function(xhr, status, error) {
                showErrorSweetalert('ผิดพลาด!', error, 1500);
            }
        })
    });
</script>