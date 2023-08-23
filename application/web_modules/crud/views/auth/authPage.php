<body class="fixed-layout">
    <!-- load pre loader component -->
    <?php $this->load->view('z_template/components/preLoaderComp'); ?>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <section id="wrapper">
        <div class="login-register" style="background-color: #F5F5F5;">
            <div class="login-box card shadow" style="border-radius: 25px;">
                <div class="card-body p-5 ">
                    <div class="text-center">
                        <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url('assets/images/logoc@2x-copy.png') ?>" alt="logon" style="object-fit:contain; width:250px"></a>
                    </div>
                    <form class="mt-4" id="onAuthenticationForm" novalidate>
                        <div class="form-horizontal">
                            <div class="form-group">
                                <label class="form-label">User Name</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="กรุณาป้อน Username" name="authenUsername" required>
                                    <span class="input-group-text"><i class="ti-user"></i></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" placeholder="กรุณาป้อน Password" name="authenPassword" required>
                                    <span class="input-group-text"><i class="ti-lock"></i></span>
                                </div>
                            </div>
                            <div class="form-group text-center">
                                <div class="col-xs-12">
                                    <button class="btn w-100 btn-lg btn-info text-white" style="border-radius: 10px;" type="submit" id="btnOnAuthentication">เข้าสู่ระบบ</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>

<script>
    window.onload = function() {
        // ==========================================================
        $("#onAuthenticationForm").validate({
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
                    url: "<?php echo base_url('crud/auth/onSignIn?redirect=') . $this->input->get('redirect')  ?>",
                    method: "POST",
                    data: new FormData(form),
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    beforeSend: function() {
                        showLoadingSweetalert();
                    },
                    success: function(response) {
                        if (!response.status) {
                            showErrorSweetalert("ผิดพลาด!", response.errorMessage);
                            return;
                        }

                        if (response.redirectURL != null) {
                            $(location).attr('href', response.redirectURL);
                            return;
                        }

                        $(location).attr('href', '<?php echo base_url('crud/index'); ?>');
                    },
                    error: function(xhr, status, error) {
                        showErrorSweetalert('ผิดพลาด!', error, 1500);
                    }
                })
            },
        });
        // ==========================================================
    };
</script>