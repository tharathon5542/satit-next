<div id="newsAddModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">เพิ่มข่าวประชาสัมพันธ์</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="card wizard-content">
                <div class="card-body">
                    <form id="addNewsForm" class="validation-wizard wizard-circle" novalidate>
                        <!-- Step 1 -->
                        <h6>ข้อมูลข่าวประชาสัมพันธ์</h6>
                        <section>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label">หัวข้อข่าวประชาสัมพันธ์</label>
                                        <input type="text" class="form-control" name="newsTitle" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">เนื้อหาข่าว</label>
                                        <textarea class="textarea-tinymce" name="newsDetail"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">ลิ้งก์ URL <span class="text-mute">(Optional)</span></label>
                                        <input type="text" class="form-control" name="newsUrl">
                                    </div>
                                </div>
                            </div>
                        </section>
                        <!-- Step 2 -->
                        <h6>รูปภาพข่าวประชาสัมพันธ์</h6>
                        <section>
                            <div class="form-group">
                                <label class="form-label">ขนาดไฟล์ไม่เกิน 2 MB (1900 x 1300) สามารถเลือกได้มากกว่า 1 ไฟล์ (ครั้งละไม่เกิน 10 ภาพ)</label>
                                <input type="file" id="newsImage" name="newsImage[]" class="dropify" data-max-file-size="2M" accept="image/png, image/jpeg, image/jpg" multiple />
                            </div>
                        </section>
                    </form>
                </div>
            </div>
        </div>
        </form>
    </div>
</div>
</div>
</div>

<script>
    $('#newsAddModal').on('hidden.bs.modal', function() {
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

    var form = $(".validation-wizard").show();

    $(".validation-wizard").steps({
        headerTag: "h6",
        bodyTag: "section",
        transitionEffect: "fade",
        titleTemplate: '<span class="step">#index#</span> #title#',
        labels: {
            finish: "บันทึกข้อมูล",
            next: "ขั้นตอนถัดไป",
            previous: 'ย้อนกลับ'
        },
        onStepChanging: function(event, currentIndex, newIndex) {
            return currentIndex > newIndex || ((form.find(".body:eq(" + newIndex + ") label.error").remove(), form.find(".body:eq(" + newIndex + ") .error").removeClass("error")), form.validate().settings.ignore = ":disabled,:hidden", form.valid())
        },
        onFinishing: function(event, currentIndex) {
            return form.validate().settings.ignore = ":disabled", form.valid()
        },
        onFinished: function(event, currentIndex) {
            tinyMCE.triggerSave();
            var formData = new FormData(form[0]);
            $.ajax({
                url: "<?php echo base_url('crud/news/onAddNews') ?>",
                method: "POST",
                data: formData,
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
                    showSuccessSweetalert('สำเร็จ!', 'เพิ่มข้อมูลข่าวประชาสัมพันธ์แล้ว', 1500);
                    setTimeout(function() {
                        fetchNews(1);
                        $("#newsAddModal").modal("hide");
                    }, 1500)
                },
                error: function(xhr, status, error) {
                    showErrorSweetalert('ผิดพลาด!', error, 1500);
                }
            });
        }
    }), $(".validation-wizard").validate({
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
    })

    tinymce.init({
        selector: '.textarea-tinymce',
        paste_as_text: true,
        entity_encoding: "numeric"
    });
</script>