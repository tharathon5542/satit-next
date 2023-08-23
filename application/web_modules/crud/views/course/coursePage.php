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
                        <div class="card ">
                            <div class="card-header bg-info">
                                <div class="d-flex no-block align-items-center">
                                    <h4 class="m-b-0 text-white">ตารางข้อมูลหลักสูตร</h4>
                                    <button class="btn btn-success text-white ms-auto" onclick="openAddModal()"><i class="fas fa-plus"></i> เพิ่มข้อมูล</button>
                                </div>
                            </div>
                            <div class="card-body animated bounceInUp">
                                <div class="table-responsive">
                                    <table id="courseTable" class="table table-striped border color-table muted-table">
                                        <thead>
                                            <tr>
                                                <th class="col-md-1 tablet desktop">ปีการศึกษา</th>
                                                <th class="col-md-5 tablet desktop">รายชื่อหลักสูตร</th>
                                                <th class="col-md-4 desktop" style="min-width: 220px;">แบบฟอร์มข้อมูล</th>
                                                <th class="col-md-2 desktop" style="min-width: 180px;">เครื่องมือ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
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
            getCourse();

            $('.table-responsive').on('show.bs.dropdown', function() {
                $('.table-responsive').css("overflow", "inherit");
            });

            $('.table-responsive').on('hide.bs.dropdown', function() {
                $('.table-responsive').css("overflow", "auto");
            })
            // ==========================================================
        };

        function getCourse() {
            var courseTable = $('#courseTable').DataTable({
                pageLength: 25,
                responsive: {
                    breakpoints: [{
                            name: 'desktop',
                            width: Infinity
                        },
                        {
                            name: 'tablet',
                            width: 1024
                        }
                    ]
                },
                deferRender: false,
                ajax: {
                    url: "<?php echo base_url('crud/course/getCourse')  ?>",
                    type: 'GET',
                    success: function(response) {
                        courseTable.clear().rows.add(response.data).draw();
                        Swal.close();
                    },
                    error: function(xhr, status, error) {
                        showErrorSweetalert('ผิดพลาด!', error, 1500);
                    }
                },
                columns: [{
                        data: 'courseYear',
                        className: 'text-center'
                    }, {
                        orderable: false,
                        data: 'courseName',
                        className: 'text-center'
                    }, {
                        searchable: false,
                        orderable: false,
                        className: 'text-center',
                        data: null,
                        render: function(data, type, row, meta) {
                            let fileLink = "";
                            if (row.courseInfoFile != null) {
                                fileLink = `
                                    <div class="bg-secondary p-1 rounded">
                                        <a href="<?php echo base_url('assets/files/courseFiles/') ?>${row.courseInfoFile}${row.courseInfoFileType}" class="link-success">อัปโหลดแบบฟอร์มข้อมูลแล้ว <i class="fas fa-external-link-alt"></i></a>
                                    </div><br>
                                `;
                            } else {
                                fileLink = '<div class="bg-secondary text-primary p-1 rounded">ยังไม่ได้อัปโหลดแบบฟอร์มข้อมูล</div><br>';
                            }

                            let out_put = `
                                ${fileLink}
                                <input type="file" id="courseFile${row.courseID}" onchange="uploadCourseFile(${row.courseID}, this)" hidden accept=".xls, .xlsx">
                                <a href="<?php echo base_url('assets/files/courseFiles/courseInfoForm.xlsx') ?>" class="btn btn-info me-1 text-white"><i class="fas fa-download"></i> แบบฟอร์ม</a>
                                <button type="button" class="btn btn-success me-1 text-white" onclick="onCourseFileClick('${row.courseID}')"><i class="fas fa-upload"></i> อัปโหลด</button>
                            `;
                            return out_put;
                        }
                    },
                    {
                        searchable: false,
                        orderable: false,
                        className: 'text-center',
                        data: null,
                        render: function(data, type, row, meta) {
                            var out_put = `
                            <div class="btn-group me-1">
                                <button type="button" class="btn btn-info text-white" onclick="openEditModal('${row.courseID}')"><i class="far fa-edit"></i> แก้ไข</button>
                                <button type="button" class="btn btn-info dropdown-toggle text-white dropdown-toggle-split" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="<?php echo base_url('crud/students/list/') ?>${row.courseID}"><i class="fas fa-graduation-cap"></i> ข้อมูลนักศึกษา</a></a>
                                </div>
                            </div>
                            <button type="button" class="btn btn-danger me-1 text-white" onclick="onDelete('${row.courseID}')"><i class="fas fa-trash"></i> ลบ</button>
                            `;
                            return out_put;
                        }
                    }
                ],
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/th.json"
                }
            });
        }

        function openEditModal(id) {
            // Load modal content using AJAX
            $.ajax({
                url: "<?php echo base_url('crud/course/editModal/') ?>" + id,
                type: 'POST',
                dataType: "json",
                success: function(response) {

                    if (!response.status) {
                        showErrorSweetalert("ผิดพลาด!", response.errorMessage);
                        return;
                    }
                    // Insert modal content into the page
                    $("#modal-container").html(response.data);

                    // set data to form field
                    // tab 1
                    $('#courseID').val(response.courseData['courseID']);
                    $('#courseMajorID').val(response.courseData['courseMajorID']);
                    $('#courseYear').val(response.courseData['courseYear']);
                    $('#courseGrade').val(response.courseData['courseGrade']);
                    $('#courseCode').val(response.courseData['courseCode']);
                    $('#courseName').val(response.courseData['courseName']);
                    $('#courseNameEN').val(response.courseData['courseNameEN']);

                    // tab 2
                    $('#courseISCED').val(response.courseData['courseISCED']);
                    $('#courseCwieCategory').val(response.courseData['courseCategory']);
                    $('#courseHardSkills').val(response.courseData['courseHardSkill']);
                    $('#courseSoftSkills').val(response.courseData['courseSoftSkill']);
                    $('#courseProfession').val(response.courseData['courseProfession']);
                    // Loop through the array of tags
                    $('#courseTags').tagsinput();
                    if (response.courseData['courseTags'] != null) {
                        $.each(response.courseData['courseTags'].split(','), function(index, value) {
                            $('#courseTags').tagsinput('add', value);
                            $('#courseTags').tagsinput('add', value);
                        });
                    }
                    // tab 3
                    $('#courseChecoCode').val(response.courseData['courseChecoCode']);
                    $('#courseChecoAcknowledge').val(response.courseData['courseChecoAcknowledge']);
                    $('#courseChecoOperation').val(response.courseData['courseChecoOperation']);
                    // tab 4
                    $('#courseCoordinatorName').val(response.courseData['courseCoordinatorName']);
                    $('#courseCoordinatorSurname').val(response.courseData['courseCoordinatorSurname']);
                    $('#courseCoordinatorTel').val(response.courseData['courseCoordinatorTel']);
                    $('#courseCoordinatorEmail').val(response.courseData['courseCoordinatorEmail']);
                    // Show the modal
                    $("#courseEditModal").modal("show");
                },
                error: function(xhr, status, error) {
                    showErrorSweetalert('ผิดพลาด!', error, 1500);
                }
            });
        }

        function openAddModal() {
            // Load modal content using AJAX
            $.ajax({
                url: "<?php echo base_url('crud/course/addModal') ?>",
                dataType: "json",
                success: function(response) {
                    if (!response.status) {
                        showErrorSweetalert("ผิดพลาด!", response.errorMessage);
                        return;
                    }
                    // Insert modal content into the page
                    $("#modal-container").html(response.data);
                    // Show the modal
                    $("#courseAddModal").modal("show");
                },
                error: function(xhr, status, error) {
                    showErrorSweetalert('ผิดพลาด!', error, 1500);
                }
            });
        }

        function onDelete(courseID) {
            // Display a SweetAlert confirmation dialog
            Swal.fire({
                title: 'ยืนยันการลบ?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'ยืนยันการลบ',
                cancelButtonText: 'ย้อนกลับ',
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: '<?php echo base_url('crud/course/onDeleteCourse/') ?>' + courseID,
                        type: "POST",
                        dataType: "json",
                        success: function(response) {
                            if (!response.status) {
                                showErrorSweetalert("ผิดพลาด!", response.errorMessage);
                                return;
                            }
                            showSuccessSweetalert("สำเร็จ!", "ลบข้อมูลหลักสูตรแล้ว", 1500);
                            setTimeout(function() {
                                $('#courseTable').DataTable().ajax.reload();
                            }, 1500)
                        },
                        error: function(xhr, status, error) {
                            showErrorSweetalert('ผิดพลาด!', error, 1500);
                        }
                    });
                }
            })
        }

        function onCourseFileClick(courseFileElementID) {
            $('#courseFile' + courseFileElementID).click();
        }

        function uploadCourseFile(courseID, courseFileElement) {
            if (courseFileElement.files.length > 0) {
                const file = courseFileElement.files[0]; // Get the selected file
                // Create a new FormData object and append the file to it
                const formData = new FormData();
                formData.append('file', file);

                // Perform AJAX upload using jQuery
                $.ajax({
                    url: '<?php echo base_url('crud/course/onUploadCourseFile/') ?>' + courseID,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        showSuccessSweetalert("สำเร็จ!", "อัปโหลดแบบฟอร์มหลักสูตรแล้ว", 1500);
                        setTimeout(function() {
                            $('#courseTable').DataTable().ajax.reload();
                        }, 1500)
                    },
                    error: function(xhr, status, error) {
                        showErrorSweetalert('ผิดพลาด!', error, 1500);
                    }
                });
            }
        }
    </script>