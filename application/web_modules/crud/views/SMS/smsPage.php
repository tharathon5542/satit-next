    <!-- load pre loader component -->
    <?php $this->load->view('z_template/components/preloaderComp'); ?>

    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">

        <!-- load pre loader component -->
        <?php $this->load->view('z_template/components/topbarComp'); ?>

        <!-- load pre loader component -->
        <?php $this->load->view('z_template/components/leftbarComp'); ?>

        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">

                <!-- load bread crumb component -->
                <?php $this->load->view('z_template/components/breadCrumbComp', isset($page) ? $page : ''); ?>

                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-12">
                        <div class="card animated bounceInRight">
                            <div class="card-header bg-info">
                                <div class="d-flex no-block align-items-center">
                                    <h4 class="m-b-0 text-white">ระบบส่งข้อความ SMS</h4>
                                </div>
                            </div>
                            <div class="card-body ">
                                <form id="sendSMSForm" novalidate>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label class="form-label">ผู้ให้บริการ</label>
                                                <div class="input-group">
                                                    <select id="provider" name="provider" class="form-select">
                                                        <option value="1">TH SMS</option>
                                                        <option value="0">CRRU SMS</option>
                                                    </select>
                                                    <div class="input-group-append">
                                                        <button type="button" onclick="checkCredit()" class="btn btn-info text-white" type="button">ตรวจเครดิต</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="form-label">เบอร์ติดต่อ</label>
                                                <div class="tags-default">
                                                    <input type="text" id="tels" name="tels" placeholder="กรุณาป้อนเบอร์ติดต่อ" required />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="form-label">ข้อความ SMS</label>
                                                        <small id="charCount" class="form-text text-muted">0/160</small>
                                                        <small id="creditCount" class="form-text text-muted"> | ใช้ 0 เครดิต ต่อ 1 เบอร์ติดต่อ</small>
                                                        <textarea id="message" name="message" class="form-control" rows="5" placeholder="กรุณาป้อนข้อความ SMS" required></textarea>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <button class="btn btn-success text-white"><i class="bi bi-send-check"></i> ส่ง SMS</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- load foot component -->
        <?php $this->load->view('z_template/components/footComp'); ?>
    </div>

    <!-- modal container -->
    <div id="modal-container"></div>

    <script>
        window.onload = function() {
            // ==========================================================

            // Initialize character count
            updateCharCount($("#message").val().length);

            // Update character count on input
            $("#message").on("input", function() {
                var charCount = $(this).val().length;
                updateCharCount(charCount);
            });

            $('#tels').tagsinput({
                trimValue: true,
                maxChars: 10,
                tagClass: 'custom-label-for-tags-input label-info'
            });

            $("#sendSMSForm").validate({
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
                    error.insertAfter(element.closest('div.tags-default').length ? element.closest('div.tags-default') : element)
                },
                submitHandler: function(form) {
                    const provider = $('#provider').val();
                    $.ajax({
                        url: "<?php echo base_url('crud/sms/onSendSMS/') ?>" + provider,
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
                            showSuccessSweetalert('สำเร็จ!', 'ส่งข้อความ SMS แล้ว ใช้ ' + response.creditUsage + ' เครดิต เหลือ ' + response.creditRemain, 1500);
                        },
                        error: function(xhr, status, error) {
                            showErrorSweetalert('ผิดพลาด!', error, 1500);
                        }
                    })
                },
            });

            // ==========================================================
        };

        function updateCharCount(count) {
            let creditCount = Math.ceil(count / 160);
            $("#charCount").text(count + "/160");
            $("#creditCount").text('| ใช้ ' + creditCount + ' เครดิต ต่อ 1 เบอร์ติดต่อ');
        }

        function checkCredit() {
            const provider = $('#provider').val();
            $.ajax({
                url: "<?php echo base_url('crud/sms/onCheckCredit/') ?>" + provider,
                method: "POST",
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

                    showSuccessSweetalert("จำนวนเครดิต : " + response.data + ' เครดิต', '', 3000);
                },
                error: function(xhr, status, error) {
                    showErrorSweetalert('ผิดพลาด!', error, 1500);
                }
            })
        }
    </script>