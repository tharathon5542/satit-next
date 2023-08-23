<?php
if ($this->session->userdata('moduleYearID') && $this->session->userdata('moduleYearID') != '0') {
    // query course by year
    $queryCoursesData = $this->db->select('COUNT(*) AS numCourse')
        ->join('cwie_major', 'cwie_course.major_id = cwie_major.major_id')
        ->get_where('cwie_course', array('cwie_major.faculty_id' => $facultyData['facultyID'], 'cwie_course.year_id' => $this->session->userdata('moduleYearID')));
    // query cwie personnel by year
    $queryPersonnelData = $this->db->select('COUNT(*) AS numPersonnel')
        ->join('cwie_major', 'cwie_personnel.major_id = cwie_major.major_id')
        ->join('cwie_personnel_course', 'cwie_personnel.personnel_id = cwie_personnel_course.personnel_id')
        ->join('cwie_course', 'cwie_personnel_course.course_id = cwie_course.course_id')
        ->get_where('cwie_personnel', array('cwie_major.faculty_id' => $facultyData['facultyID'], 'cwie_course.year_id' => $this->session->userdata('moduleYearID')));
    // query student by year
    $queryStudentData = $this->db->select('COUNT(*) as numStudent')
        ->join('cwie_course', 'cwie_students.course_id = cwie_course.course_id')
        ->join('cwie_major', 'cwie_course.major_id = cwie_major.major_id')
        ->get_where('cwie_students', array('cwie_major.faculty_id' => $facultyData['facultyID'], 'cwie_course.year_id' => $this->session->userdata('moduleYearID')));
    // query workplace by year
    $queryWorkplaceData = $this->db->select('COUNT(*) as numWorkplace')
        ->join('cwie_major', 'cwie_workplace.major_id = cwie_major.major_id')
        ->join('cwie_workplace_course', 'cwie_workplace.workplace_id = cwie_workplace_course.workplace_id')
        ->join('cwie_course', 'cwie_workplace_course.course_id = cwie_course.course_id')
        ->get_where('cwie_workplace', array('cwie_major.faculty_id' => $facultyData['facultyID'], 'status' => '1', 'cwie_course.year_id' => $this->session->userdata('moduleYearID')));
    // query workplace mou by year
    $queryWorkplaceMouData = $this->db->select('COUNT(*) as numWorkplaceMou')
        ->join('cwie_workplace', 'cwie_workplace_mou_file.workplace_id = cwie_workplace.workplace_id')
        ->join('cwie_workplace_course', 'cwie_workplace.workplace_id = cwie_workplace_course.workplace_id')
        ->join('cwie_course', 'cwie_workplace_course.course_id = cwie_course.course_id')
        ->join('cwie_major', 'cwie_workplace.major_id = cwie_major.major_id')
        ->get_where('cwie_workplace_mou_file', array('cwie_major.faculty_id' => $facultyData['facultyID'], 'status' => '1', 'cwie_course.year_id' => $this->session->userdata('moduleYearID')));
} else {
    // query courses all year
    $queryCoursesData = $this->db->select('COUNT(*) AS numCourse')
        ->join('cwie_major', 'cwie_course.major_id = cwie_major.major_id')
        ->get_where('cwie_course', array('cwie_major.faculty_id' => $facultyData['facultyID']));
    // query cwie personnel all year
    $queryPersonnelData = $this->db->select('COUNT(*) AS numPersonnel')
        ->join('cwie_major', 'cwie_personnel.major_id = cwie_major.major_id')
        ->get_where('cwie_personnel', array('cwie_major.faculty_id' => $facultyData['facultyID']));
    // query student all year
    $queryStudentData = $this->db->select('COUNT(*) as numStudent')
        ->join('cwie_course', 'cwie_students.course_id = cwie_course.course_id')
        ->join('cwie_major', 'cwie_course.major_id = cwie_major.major_id')
        ->get_where('cwie_students', array('cwie_major.faculty_id' => $facultyData['facultyID']));
    // query workplace all year
    $queryWorkplaceData = $this->db->select('COUNT(*) as numWorkplace')
        ->join('cwie_major', 'cwie_workplace.major_id = cwie_major.major_id')
        ->get_where('cwie_workplace', array('cwie_major.faculty_id' => $facultyData['facultyID'], 'status' => '1'));
    // query workplace mou all year
    $queryWorkplaceMouData = $this->db->select('COUNT(*) as numWorkplaceMou')
        ->join('cwie_workplace', 'cwie_workplace_mou_file.workplace_id = cwie_workplace.workplace_id')
        ->join('cwie_major', 'cwie_workplace.major_id = cwie_major.major_id')
        ->get_where('cwie_workplace_mou_file', array('cwie_major.faculty_id' => $facultyData['facultyID'], 'status' => '1'));
}
?>
<div class="row clearfix align-items-stretch px-6">
    <button onclick="courseDetailModal(<?php echo $facultyData['facultyID'] ?>)" class="col-12 col-md-6 col-lg-4 col-xl dark  col-padding shadow" style="background-color: #000000;border-radius: 0%;">
        <i class="i-plain i-xlarge mx-auto icon-book3"></i>
        <div class="counter counter-lined">
            <span data-from="0" data-to="<?php echo $queryCoursesData->row()->numCourse; ?>" data-refresh-interval="50" data-speed="2000"></span><br>
            <h3>หลักสูตร</h3>
        </div>
        <h5>การเรียนการสอนรูปแบบ CWIE</h5>
    </button>

    <button onclick="cwiePersonalModal(<?php echo $facultyData['facultyID'] ?>)" class="col-12 col-md-6 col-lg-4 col-xl btn dark center col-padding" style="background-color: #231023; border-radius: 0%;">
        <i class="i-plain i-xlarge mx-auto icon-chalkboard-teacher"></i>
        <div class="counter counter-lined">
            <span data-from="0" data-to="<?php echo $queryPersonnelData->row()->numPersonnel; ?>" data-refresh-interval="100" data-speed="2500"></span><br>
            <h3>คน</h3>
        </div>
        <h5>บุคลากร CWIE</h5>
    </button>

    <button onclick="cwieSutdents(<?php echo $facultyData['facultyID'] ?>)" class="col-12 col-md-6 col-lg-4 col-xl btn dark center col-padding" style="background-color: #2A1D41;border-radius: 0%;">
        <i class="i-plain i-xlarge mx-auto icon-line-users"></i>
        <div class="counter counter-lined">
            <span data-from="0" data-to="<?php echo $queryStudentData->row()->numStudent; ?>" data-refresh-interval="25" data-speed="3500"></span><br>
            <h3>คน</h3>
        </div>
        <h5>นักศึกษา CWIE</h5>
    </button>

    <button onclick="cwieWorkplace(<?php echo $facultyData['facultyID'] ?>)" class="col-12 col-md-6 col-lg-4 col-xl btn dark center col-padding" style="background-color: #515278;border-radius: 0%;">
        <i class="i-plain i-xlarge mx-auto icon-building2"></i>
        <div class="counter counter-lined">
            <span data-from="0" data-to="<?php echo $queryWorkplaceData->row()->numWorkplace; ?>" data-refresh-interval="30" data-speed="2700"></span><br>
            <h3>แห่ง</h3>
        </div>
        <h5>เครือข่าย CWIE</h5>
    </button>

    <button onclick="cwieWorkplaceMou(<?php echo $facultyData['facultyID'] ?>)" class="col-12 col-md-6 col-lg-4 col-xl btn dark center col-padding" style="background-color: #626386;border-radius: 0%;">
        <i class="i-plain i-xlarge mx-auto icon-handshake1"></i>
        <div class="counter counter-lined">
            <span data-from="0" data-to="<?php echo $queryWorkplaceMouData->row()->numWorkplaceMou; ?>" data-refresh-interval="30" data-speed="2700"></span><br>
            <h3>แห่ง</h3>
        </div>
        <h5>ความร่วมมือ (MOU)</h5>
    </button>

    <?php
    // query custom display data
    $queryCustomDisplayData = $this->db->get_where('cwie_custom_display_data', array('faculty_id' => $facultyData['facultyID']));
    if ($queryCustomDisplayData->num_rows() > 0) {
        foreach ($queryCustomDisplayData->result() as $customDisplayData) { ?>
            <div class="col-12 col-md-6 col-lg-4 col-xl dark center col-padding" style="background-color: <?php echo $customDisplayData->custom_display_data_color ?>;border-radius: 0%;">
                <i class="i-plain i-xlarge mx-auto <?php echo $customDisplayData->custom_display_data_icon ?>"></i>
                <div class="counter counter-lined">
                    <span data-from="0" data-to="<?php echo $customDisplayData->custom_display_data ?>" data-refresh-interval="30" data-speed="2700"></span><br>
                    <h3><?php echo $customDisplayData->custom_display_data_unit ?></h3>
                </div>
                <h5><?php echo $customDisplayData->custom_display_data_title ?></h5>
            </div>
    <?php }
    }  ?>
</div>

<script>
    function courseDetailModal(id) {
        // Load modal content using AJAX
        $.ajax({
            url: "<?php echo base_url('webmodule/module/courseDetailModal/') ?>" + id,
            type: 'POST',
            dataType: "json",
            data: {
                'yearID': <?php echo $this->session->userdata('moduleYearID') ? $this->session->userdata('moduleYearID') : 0 ?>
            },
            beforeSend: function() {
                showLoadingSweetalert();
            },
            success: function(response) {

                if (!response.status) {
                    showErrorSweetalert("ผิดพลาด!", response.errorMessage);
                    return;
                }
                // Insert modal content into the page
                $("#modal-container").html(response.data);

                coursesDataTable = $('#coursesDataTable').DataTable({
                    destroy: true,
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
                    data: response.courseData,
                    columns: [{
                        data: 'courseName',
                        className: 'text-center'
                    }, {
                        data: 'courseGrade',
                        className: 'text-center'
                    }, {
                        data: 'courseCategory',
                        className: 'text-center'
                    }, {
                        data: 'courseMajor',
                        className: 'text-center'
                    }],
                    "language": {
                        "url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/th.json"
                    }
                });

                // Show the modal
                $("#courseDetailModal").modal("show");

                swal.close();
            },
            error: function(xhr, status, error) {
                showErrorSweetalert('ผิดพลาด!', error, 1500);
            }
        });
    }

    function cwiePersonalModal(id) {
        // Load modal content using AJAX
        $.ajax({
            url: "<?php echo base_url('webmodule/module/cwiePersonalModal/') ?>" + id,
            type: 'POST',
            dataType: "json",
            data: {
                'yearID': <?php echo $this->session->userdata('moduleYearID') ? $this->session->userdata('moduleYearID') : 0 ?>
            },
            beforeSend: function() {
                showLoadingSweetalert();
            },
            success: function(response) {

                if (!response.status) {
                    showErrorSweetalert("ผิดพลาด!", response.errorMessage);
                    return;
                }
                // Insert modal content into the page
                $("#modal-container").html(response.data);

                personnelDataTable = $('#personnelDataTable').DataTable({
                    destroy: true,
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
                    data: response.personnelData,
                    columns: [{
                        data: 'personnelNameSurname',
                        className: 'text-start'
                    }, {
                        data: 'personnelType',
                        className: 'text-center'
                    }, {
                        data: 'personnelPosition',
                        className: 'text-center'
                    }],
                    "language": {
                        "url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/th.json"
                    }
                });

                // Show the modal
                $("#personnelDetailModal").modal("show");

                swal.close();
            },
            error: function(xhr, status, error) {
                showErrorSweetalert('ผิดพลาด!', error, 1500);
            }
        });
    }

    function cwieSutdents(id) {
        // Load modal content using AJAX
        $.ajax({
            url: "<?php echo base_url('webmodule/module/cwiePersonalStudents/') ?>" + id,
            type: 'POST',
            dataType: "json",
            data: {
                'yearID': <?php echo $this->session->userdata('moduleYearID') ? $this->session->userdata('moduleYearID') : 0 ?>
            },
            beforeSend: function() {
                showLoadingSweetalert();
            },
            success: function(response) {

                if (!response.status) {
                    showErrorSweetalert("ผิดพลาด!", response.errorMessage);
                    return;
                }
                // Insert modal content into the page
                $("#modal-container").html(response.data);

                studentDataTable = $('#studentDataTable').DataTable({
                    destroy: true,
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
                    data: response.studentData,
                    columns: [{
                        data: 'studentCode',
                        className: 'text-center'
                    }, {
                        data: 'studentNameSurname',
                        className: 'text-start'
                    }, {
                        data: 'studentMajor',
                        className: 'text-center'
                    }, {
                        data: 'studentFaculty',
                        className: 'text-center'
                    }],
                    "language": {
                        "url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/th.json"
                    }
                });

                // Show the modal
                $("#studentDetailModal").modal("show");

                swal.close();
            },
            error: function(xhr, status, error) {
                showErrorSweetalert('ผิดพลาด!', error, 1500);
            }
        });
    }

    function cwieWorkplace(id) {
        // Load modal content using AJAX
        $.ajax({
            url: "<?php echo base_url('webmodule/module/cwieWorkplace/') ?>" + id,
            type: 'POST',
            dataType: "json",
            data: {
                'yearID': <?php echo $this->session->userdata('moduleYearID') ? $this->session->userdata('moduleYearID') : 0 ?>
            },
            beforeSend: function() {
                showLoadingSweetalert();
            },
            success: function(response) {

                if (!response.status) {
                    showErrorSweetalert("ผิดพลาด!", response.errorMessage);
                    return;
                }
                // Insert modal content into the page
                $("#modal-container").html(response.data);

                workplaceDataTable = $('#workplaceDataTable').DataTable({
                    destroy: true,
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
                    data: response.workplaceData,
                    columns: [{
                        data: 'workplaceName',
                        className: 'text-start'
                    }, {
                        data: 'workplaceType',
                        className: 'text-center'
                    }],
                    "language": {
                        "url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/th.json"
                    }
                });

                // Show the modal
                $("#workplaceDetailModal").modal("show");

                swal.close();
            },
            error: function(xhr, status, error) {
                showErrorSweetalert('ผิดพลาด!', error, 1500);
            }
        });
    }

    function cwieWorkplaceMou(id) {
        // Load modal content using AJAX
        $.ajax({
            url: "<?php echo base_url('webmodule/module/cwieWorkplaceMou/') ?>" + id,
            type: 'POST',
            dataType: "json",
            data: {
                'yearID': <?php echo $this->session->userdata('moduleYearID') ? $this->session->userdata('moduleYearID') : 0 ?>
            },
            beforeSend: function() {
                showLoadingSweetalert();
            },
            success: function(response) {

                if (!response.status) {
                    showErrorSweetalert("ผิดพลาด!", response.errorMessage);
                    return;
                }
                // Insert modal content into the page
                $("#modal-container").html(response.data);

                workplaceMouDataTable = $('#workplaceMouDataTable').DataTable({
                    destroy: true,
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
                    data: response.workplaceMouData,
                    columns: [{
                        data: 'workplaceName',
                        className: 'text-start'
                    }, {
                        data: 'workplaceDetail',
                        className: 'text-center'
                    }, {
                        searchable: false,
                        orderable: false,
                        className: 'text-center',
                        data: null,
                        render: function(data, type, row, meta) {
                            var out_put = `
                            <a target="_blank" href="<?php echo base_url('assets/files/mouFiles/') ?>${row.workplaceFile}" class="btn btn-success me-1 text-white" >รายละเอียด</a>
                            `;
                            return out_put;
                        }
                    }],
                    "language": {
                        "url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/th.json"
                    }
                });

                // Show the modal
                $("#workplaceMouDetailModal").modal("show");

                swal.close();
            },
            error: function(xhr, status, error) {
                showErrorSweetalert('ผิดพลาด!', error, 1500);
            }
        });
    }
</script>