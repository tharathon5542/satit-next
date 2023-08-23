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
                        <div class="card">
                            <div class="card-header bg-info">
                                <div class="d-flex no-block align-items-center">
                                    <h4 class="m-b-0 text-white">ตารางข้อมูลนักศึกษา</h4>
                                </div>
                            </div>
                            <div class="card-body animated bounceIn">
                                <a href="<?php echo base_url('crud/course') ?>" class="btn btn-secondary"><i class="fas fa-arrow-circle-left"></i> ย้อนกลับ</a>
                                <h4 class="my-4 text-center"><?php echo $courseData->row()->course_name ?></h4>
                                <div class="d-flex no-block">
                                    <button class="btn btn-success text-white mb-4 ms-auto" style="height: 100%;" type="button" onclick="addStudentField();"><i class="fa fa-plus"></i> เพิ่มรายชื่อนักศึกษา</button>
                                </div>
                                <form id="addStudentForm" novalidate>
                                    <input type="hidden" name="courseID" value="<?php echo $courseData->row()->course_id ?>">
                                    <div id="studentField"></div>
                                    <button class="btn btn-success text-white"><i class="fas fa-save"></i> บักทึกข้อมูล</button>
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
            showLoadingSweetalert();

            setStudentData('<?php echo $courseData->row()->course_id ?>');

            addStudentField();

            $("#addStudentForm").validate({
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
                messages: {
                    "studentCode[]": "กรุณาป้อนข้อมูลช่องนี้"
                },
                submitHandler: function(form) {
                    Swal.fire({
                        title: 'แจ้งเตือน',
                        text: 'ยืนยันการบันทึกข้อมูลนักศึกษา?',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'ยืนยัน',
                        cancelButtonText: 'ย้อนกลับ',
                    }).then((result) => {
                        if (result.value) {
                            $.ajax({
                                url: "<?php echo base_url('crud/students/onSubmitStudent') ?>",
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
                                    showSuccessSweetalert("สำเร็จ!", "บันทึกข้อมูลนักศึกษาแล้ว");
                                    location.reload();
                                },
                                error: function(xhr, status, error) {
                                    showErrorSweetalert('ผิดพลาด!', error, 1500);
                                }
                            })
                        }
                    })
                },
            });
            // ==========================================================
        };

        let studentCount = 1;

        function searchStudent(studentCode, elementId) {

            if (studentCode.value == '') {
                return;
            }

            $.ajax({
                url: '<?php echo base_url('crud/students/getStudent/') ?>' + studentCode.value,
                type: "POST",
                dataType: "json",
                beforeSend: function() {
                    showLoadingSweetalert();
                },
                success: function(response) {
                    if (!response['is_found']) {
                        showErrorSweetalert("ผิดพลาด!", 'ไม่พบข้อมูลนักศึกษา');
                        studentCode.value = '';
                        $('#nameSurname-' + elementId).val('')
                        $('#major-' + elementId).val('')
                        $('#faculty-' + elementId).val('')
                        return;
                    }
                    $('#nameSurname-' + elementId).val(response['studentData'][0].pname + response['studentData'][0].fname + ' ' + response['studentData'][0].lname)
                    $('#major-' + elementId).val(response['studentData'][0].major_name)
                    $('#faculty-' + elementId).val(response['studentData'][0].faculty)
                    swal.close();
                },
                error: function(xhr, status, error) {
                    showErrorSweetalert('ผิดพลาด!', error, 1500);
                }
            });
        }

        function addStudentField() {
            studentCount++;
            var studentField = document.getElementById('studentField')
            var element = document.createElement("div");
            element.setAttribute("class", "form-group removeclass" + studentCount);
            var removeElementClass = 'removeclass' + studentCount;
            element.innerHTML = `
                <div class="row">
                    <div class="col-sm-3 nopadding">
                        <div class="form-group">
                            <label class="form-label">รหัสนักศึกษา | บัตรประชาชน</label>
                            <input type="number" class="form-control" id="studentCode-${studentCount}" name="studentCode[]" onChange="searchStudent(this, ${studentCount})" placeholder="กรุณาป้อนรหัสนักศึกษา">
                        </div>
                    </div>
                    <div class="col-sm-3 nopadding">
                        <div class="form-group">
                            <label class="form-label">ชื่อ - นามสกุล</label>
                            <input type="text" class="form-control" id="nameSurname-${studentCount}" readonly>
                        </div>
                    </div>
                    <div class="col-sm-3 nopadding">
                        <div class="form-group">
                            <label class="form-label">สาขา</label>
                            <input type="text" class="form-control" id="major-${studentCount}" readonly >
                        </div>
                    </div>
                    <div class="col-sm-3 nopadding">
                        <div class="form-group">
                            <label class="form-label">คณะ</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="faculty-${studentCount}" readonly >
                                <div class="input-group-append">
                                    <button class="btn btn-danger text-white" style="height: 100%;" type="button" onclick="removeStudentField(${studentCount});"><i class="fa fa-minus"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            studentField.prepend(element)
        }

        function removeStudentField(rid) {
            if ($('#studentField').find('div.row').length > 1)
                $('.removeclass' + rid).remove();
        }

        function setStudentData(courseID) {
            $.ajax({
                url: '<?php echo base_url('crud/students/getStudentInCourse/') ?>' + courseID,
                type: "POST",
                dataType: "json",
                beforeSend: function() {
                    showLoadingSweetalert();
                },
                success: function(response) {
                    if (!response.status) {
                        showErrorSweetalert("ผิดพลาด!", response.errorMessage);
                        return;
                    }

                    // loop each student data
                    $.each(response.data, function(index, value) {
                        studentCount++;
                        var studentField = document.getElementById('studentField')
                        var element = document.createElement("div");
                        element.setAttribute("class", "form-group removeclass" + studentCount);
                        var removeElementClass = 'removeclass' + studentCount;
                        element.innerHTML = `
                            <input type="hidden" name="studentID[]" value="${value.studentID}">
                            <div class="row">
                                <div class="col-sm-3 nopadding">
                                    <div class="form-group">
                                        <label class="form-label">รหัสนักศึกษา | บัตรประชาชน</label>
                                        <input type="number" class="form-control" id="studentCode-${studentCount}" name="studentCode[]" onChange="searchStudent(this, ${studentCount})" value="${value.studentCode}" placeholder="กรุณาป้อนรหัสนักศึกษา">
                                    </div>
                                </div>
                                <div class="col-sm-3 nopadding">
                                    <div class="form-group">
                                        <label class="form-label">ชื่อ - นามสกุล</label>
                                        <input type="text" class="form-control" id="nameSurname-${studentCount}" value="${value.studentNameSurname}" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-3 nopadding">
                                    <div class="form-group">
                                        <label class="form-label">สาขา</label>
                                        <input type="text" class="form-control" id="major-${studentCount}" value="${value.studentMajor}" readonly >
                                    </div>
                                </div>
                                <div class="col-sm-3 nopadding">
                                    <div class="form-group">
                                        <label class="form-label">คณะ</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="faculty-${studentCount}" value="${value.studentFaculty}" readonly >
                                            <div class="input-group-append">
                                                <button class="btn btn-danger text-white" style="height: 100%;" type="button" onclick="onDeleteStudentData(${value.studentID},${studentCount});"><i class="fa fa-minus"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                        studentField.append(element)
                    });

                    swal.close()
                },
                error: function(xhr, status, error) {
                    showErrorSweetalert('ผิดพลาด!', error, 1500);
                }
            });
        }

        function onDeleteStudentData(studentID, elementID) {
            // Display a SweetAlert confirmation dialog
            Swal.fire({
                title: 'แจ้งเตือน',
                text: 'ยืนยันการลบข้อมูลนักศึกษา?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'ยืนยัน',
                cancelButtonText: 'ย้อนกลับ',
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: '<?php echo base_url('crud/students/onDeleteStudent/') ?>' + studentID,
                        type: "POST",
                        dataType: "json",
                        success: function(response) {
                            if (!response.status) {
                                showErrorSweetalert("ผิดพลาด!", response.errorMessage);
                                return;
                            }
                            showSuccessSweetalert("สำเร็จ!", "ลบข้อมูลนักศึกษาแล้ว", 1500);
                            removeStudentField(elementID);
                        },
                        error: function(xhr, status, error) {
                            showErrorSweetalert('ผิดพลาด!', error, 1500);
                        }
                    });
                }
            })
        }
    </script>