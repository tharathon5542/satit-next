<div class="section footer-stick pt-2 bg-white">
    <div class="container">
        <div class="fancy-title title-bottom-border">
            <h3><i class="fa-solid fa-square-poll-vertical"></i> ภาพรวมผลการดำเนินงาน CRRU-CWIE ประจำปีการศึกษา 2564</h3>
        </div>
        <div class="row clearfix align-items-stretch bottommargin-lg">


            <button data-bs-toggle="modal" data-bs-target="#viewcoursemodal" class="col-lg-4 btn col-md-6 text-center center col-padding shadow" style="background-color: #8DB89D;">
                <i class="i-plain i-xlarge mx-auto icon-book3"></i>
                <div class="counter counter-lined"><span data-from="10" data-to="<?php
                                                                                    $sql = "select * from cwie_course_old where cwie_course_old.cwie_course_status = '1'";
                                                                                    $query = $this->db->query($sql);
                                                                                    $count = $query->num_rows();
                                                                                    echo $count;
                                                                                    ?>" data-refresh-interval="50" data-speed="2000"></span><br>
                    <h3>หลักสูตร</h3>
                </div>
                <h5>ที่จัดการเรียนการสอนรูปแบบ CWIE</h5>
            </button>

            <button data-bs-toggle="modal" data-bs-target="#viewinstructormodal" class="col-lg-4 col-md-6 btn center col-padding" style="background-color:#D3D39A;">
                <i class="i-plain i-xlarge mx-auto icon-chalkboard-teacher"></i>
                <div class="counter counter-lined"><span data-from="50" data-to="<?php $sql = "select * from cwie_teacher_training_old where cwie_teacher_training_old.cwie_teacher_training_status = '1'";
                                                                                    $query = $this->db->query($sql);
                                                                                    $count = $query->num_rows();
                                                                                    echo intval($count + 42);
                                                                                    ?>" data-refresh-interval="100" data-speed="2500"></span><br>
                    <h3>คน</h3>
                </div>
                <h5>คณาจารย์นิเทศ CWIE</h5>
            </button>

            <button data-bs-toggle="modal" data-bs-target="#viewstudentmodal" class="col-lg-4 col-md-6 btn center col-padding" style="background-color: #FCF8D6;">
                <i class="i-plain i-xlarge mx-auto icon-line-users"></i>
                <div class="counter counter-lined"><span data-from="2000" data-to="<?php $sql = "SELECT * FROM `cwie_student_training_old` LEFT JOIN tb_faculty_old ON tb_faculty_old.faculty_id = cwie_student_training_old.faculty_id WHERE  cwie_student_training_count != 0 AND cwie_student_training_year = '2564-65' AND cwie_student_training_status = '1'";
                                                                                    $query = $this->db->query($sql);
                                                                                    $count = 0;
                                                                                    foreach ($query->result() as $key => $row) {
                                                                                        $count += $row->cwie_student_training_count;
                                                                                    }
                                                                                    echo intval($count - 604);
                                                                                    ?>" data-refresh-interval="25" data-speed="3500"></span><br>
                    <h3>คน</h3>
                </div>
                <h5>นักศึกษา CWIE</h5>
            </button>

            <button data-bs-toggle="modal" data-bs-target="#viewestimatemodal" class="col-lg-4 col-md-6 btn center col-padding" style="background-color: #E0D8C3;">
                <i class="i-plain i-xlarge mx-auto icon-line2-graph"></i>
                <div class="counter counter-lined">
                    <h2>ระดับ<br>ดีมาก</h2>
                </div>
                <h5>ผลการประเมินความพึงพอใจ<br>จากเครือข่าย CWIE </h5>
            </button>

            <button data-bs-toggle="modal" data-bs-target="#viewinternplacemodal" class="col-lg-4 col-md-6 btn center col-padding" style="background-color: #D2B0A2">
                <i class="i-plain i-xlarge mx-auto icon-building2"></i>
                <div class="counter counter-lined"><span data-from="500" data-to="970" data-refresh-interval="30" data-speed="2700"></span><br>
                    <h3>แห่ง</h3>
                </div>
                <h5>แหล่งฝึก CWIE</h5>
            </button>

            <button data-bs-toggle="modal" data-bs-target="#viewmodal" class="col-lg-4 col-md-6 btn center col-padding" style="background-color: #99C4A2;">
                <i class="i-plain i-xlarge mx-auto icon-handshake1"></i>
                <div class="counter counter-lined"><span data-from="1" data-to="29" data-refresh-interval="30" data-speed="2700"></span><br>
                    <h3>แห่ง</h3>
                </div>
                <h5>ความร่วมมือ (MOU) CWIE</h5>
            </button>

            <br>

        </div>
    </div>
    <div class="section footer-stick pt-2 bg-white">
        <div class="container">
            <div class="fancy-title title-bottom-border">
                <h3><i class="fa-solid fa-briefcase"></i> ภาวะการมีงานทำของบัณฑิตที่สำเร็จการศึกษา ย้อนหลัง 4 ปี</h3>
            </div>
            <div class="row">
                <canvas id="myChartGraduateWork" width="400px" height="400px"></canvas>
            </div>
            <div class="row" style="text-align: right;">

                <span style="font-size: 12px;">ที่มาของข้อมูล : http://orasis.crru.ac.th (ระบบภาวะการมีงานทำของผู้สำเร็จการศึกษา
                    มร.ชร.)</span>

            </div>
        </div>
    </div>
    <div class="modal fade" id="viewmodal" tabindex="-1" aria-labelledby="viewmodal" aria-hidden="true">
        <div class="modal-dialog fullscreen-modal-dialog" style="max-width: 5000px;">
            <div class="modal-content container">
                <div class="modal-header">
                    <h5 class="modal-title th-font" id="registercoursetitle">ข้อตกลงความร่วมมือระหว่างภาคีที่เกี่ยวข้องกับการจัดทำหลักสูตร CWIE ประจำปีการศึกษา 2564</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body-open">
                    <div class="container">

                        <div class="row pt-4 pb-4">
                            <div class="col-md-12">
                                <div class="row text-center pt-4">
                                    <h4>ข้อตกลงความร่วมมือ (Memorandum of Understanding) </h4>
                                    <h4 style="line-height: 1%;">ระหว่างภาคีที่เกี่ยวข้องกับการจัดทำหลักสูตร CWIE</h4>
                                </div>
                                <div class="tabs side-tabs mb-0 clearfix" id="tab-6">

                                    <ul class="tab-nav tab-nav2 clearfix">
                                        <li><a href="#tabs-outc"><i class="fa-solid fa-plane-departure"></i> ต่างประเทศ</a></li>
                                        <li><a href="#tabs-inc"><i class="icon-home2"></i> ภายในประเทศ</a></li>

                                    </ul>

                                    <div class="tab-container">

                                        <div class="tab-content clearfix" id="tabs-inc">
                                            <div class="row text-center">
                                                <div class="table-responsive" style="max-height:600px;overflow:scroll;">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>สถาบัน/เครือข่าย CWIE /หน่วยงาน</th>
                                                                <th>เรื่อง/เกี่ยวกับ</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="mouplacein">
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-content clearfix" id="tabs-outc">
                                            <div class="row text-center">
                                                <div class="table-responsive" style="max-height:600px;overflow:scroll;">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>ประเทศ</th>
                                                                <th>สถาบัน/เครือข่าย CWIE /หน่วยงาน</th>
                                                                <th>เรื่อง/เกี่ยวกับ</th>
                                                                <th>รูปภาพ</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="mouplaceout">
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="modal1 mfp-hide" id="myModal1">
                                                <div class="block mx-auto" style="background-color: #FFF; max-width: 500px;">
                                                    <div class="feature-box fbox-center fbox-effect fbox-lg border-bottom-0 mb-0" style="padding: 40px;">
                                                        <div class="fbox-icon">
                                                            <a href="#"><i class="icon-screen i-alt"></i></a>
                                                        </div>
                                                        <div class="fbox-content">
                                                            <h3>Responsive Layout<span class="subtitle">Adapts well on Devices</span></h3>
                                                        </div>
                                                    </div>
                                                    <div class="section center m-0" style="padding: 30px;">
                                                        <a href="#" class="button" onClick="$.magnificPopup.close();return false;">Don't Show me Again</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="user_id" value="">
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="viewinternplacemodal" tabindex="-1" aria-labelledby="viewinternplacemodal" aria-hidden="true">
        <div class="modal-dialog fullscreen-modal-dialog" style="max-width: 5000px;">
            <div class="modal-content container">
                <div class="modal-header">
                    <h5 class="modal-title th-font" id="viewinternplacemodaltitle">รายชื่อหน่วยงานภายนอก/เครือข่าย CWIE ที่รับนักศึกษาหลักสูตร CWIE ประจำปีการศึกษา 2564</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body-open">
                    <div class="container">
                        <div class="tabs tabs-bb clearfix" id="tab-9">

                            <ul class="tab-nav clearfix">
                                <li><a href="#tabs-interplace-num" class="bg-success text-white border border-light" style="opacity: 0.5;">จำนวนเครือข่าย CWIE สำหรับการฝึก CWIE ทั้งหมด</a></li>
                                <li><a href="#tabs-internplace-all" class="bg-success text-white border border-light" style="opacity: 0.5;">รายชื่อหน่วยงานภายนอก/เครือข่าย CWIE ที่รับนักศึกษาหลักสูตร CWIE ประจำปีการศึกษา 2564</a></li>
                            </ul>

                            <div class="tab-container">

                                <div class="tab-content clearfix" id="tabs-interplace-num">
                                    <div class="row pt-4 pb-4">
                                        <div class="col-md-12">
                                            <div class="row text-center pt-4">
                                                <div class="row pt-4 pb-6">
                                                    <div class="col-md-6">
                                                        <canvas id="myChartInternplace" width="400px" height="400px"></canvas>
                                                    </div>
                                                    <div class="col-md-6 pt-4">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <h4>จำนวนเครือข่าย CWIE สำหรับการฝึก CWIE จำแนกตามหน่วยงานจัดการศึกษา ทั้งหมด</h4>
                                                                <p id="internplacecountlabel"></p>
                                                            </div>
                                                        </div>
                                                        <div class="row text-center">
                                                            <div class="table-responsive">
                                                                <table class="table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>ในประเทศ</th>
                                                                            <th>ต่างประเทศ</th>
                                                                            <th>รวม</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="internplacecount">
                                                                    </tbody>
                                                                </table>
                                                                <span id="internplacecounttips" class="text-danger text-center">*คลิกที่พื้นที่กราฟด้านซ้ายเพื่อดูจำนวนเครือข่าย CWIE  CWIE</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-content clearfix" id="tabs-internplace-all">
                                    <div class="row pt-4 pb-4">
                                        <div class="col-md-12">
                                            <div class="row text-center pt-4">
                                                <h4>รายชื่อหน่วยงานภายนอก/เครือข่าย CWIE ที่รับนักศึกษาหลักสูตร CWIE ประจำปีการศึกษา 2564</h4>
                                            </div>
                                            <div class="row text-center">
                                                <div class="table-responsive" style="max-height:600px;overflow:scroll;">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>รายชื่อหน่วยงาน </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="internplace">
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>
                    <input type="hidden" name="user_id" value="">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="viewestimatemodal" tabindex="-1" aria-labelledby="viewestimatemodal" aria-hidden="true">
        <div class="modal-dialog fullscreen-modal-dialog" style="max-width: 5000px;">
            <div class="modal-content container">
                <div class="modal-header">
                    <h5 class="modal-title th-font" id="estimatetitle">ผลการดำเนินงาน ผลการประเมินความพึงพอใจจากเครือข่าย CWIE  CWIE ประจำปีการศึกษา 2564</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body-open">
                    <div class="row text-center pt-4">
                        <h4>ผลการประเมินความพึงพอใจจากเครือข่าย CWIE  CWIE มีคะแนนเฉลี่ยอยู่ที่ 91.14 คะแนน ซึ่งอยู่ในระดับ ดีมาก</h4>
                    </div>
                    <div class="row pt-4 pb-6">
                        <div class="col-md-4">
                        </div>
                        <div class="col-md-4">
                            <canvas id="myChartEstimate" width="400px" height="400px"></canvas>
                        </div>
                        <div class="col-md-4">

                        </div>
                    </div>
                    <input type="hidden" name="user_id" value="">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="viewstudentmodal" tabindex="-1" aria-labelledby="viewstudentmodal" aria-hidden="true">
        <div class="modal-dialog fullscreen-modal-dialog" style="max-width: 5000px;">
            <div class="modal-content container">
                <div class="modal-header">
                    <h5 class="modal-title th-font" id="studentmodaltitle">ผลการดำเนินงาน จำนวนนักศึกษา CWIE ประจำปีการศึกษา 2564</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body-open">
                    <div class="row pt-4 pb-4">
                        <div class="col-md-6">
                            <canvas id="myChartStudent" width="400px" height="400px"></canvas>
                        </div>
                        <div class="col-md-6">
                            <input id="test" type="text" value="" hidden>
                            <div class="row text-center pt-4">
                                <h4>จำนวนนักศึกษา CWIE จำแนกตามหน่วยงานจัดการศึกษา</h4>
                                <p id="trainingstudent"></p>
                            </div>
                            <div class="row text-center">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>ปีการศึกษา 2563-2564</th>
                                                <th>ปีการศึกษา 2564-2565</th>
                                                <th>หน่วย</th>
                                            </tr>
                                        </thead>
                                        <tbody id="students">
                                        </tbody>
                                    </table>
                                    <span id="studentstips" class="text-danger text-center">*คลิกที่พื้นที่กราฟด้านซ้ายเพื่อดูจำนวนนักศึกษา CWIE</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="viewinstructormodal" tabindex="-1" aria-labelledby="viewinstructormodal" aria-hidden="true">
        <div class="modal-dialog fullscreen-modal-dialog" style="max-width: 5000px;">
            <div class="modal-content container">
                <div class="modal-header">
                    <h5 class="modal-title th-font" id="registerinstructortitle">ผลการดำเนินงาน รายชื่อคณาจารย์นิเทศหลักสูตร CWIE มหาวิทยาลัยราชภัฏเชียงราย ที่ผ่านการอบรมหลักสูตร
                        ที่กระทรวงการอุดมศึกษา วิทยาศาสตร์ วิจัยและนวัตกรรม (อว.) รับรอง ประจำปีการศึกษา 2564</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body-open">
                    <div class="row pt-4 pb-4">
                        <div class="col-md-6">
                            <canvas id="myChartTraining" width="400px" height="400px"></canvas>
                        </div>
                        <div class="col-md-6">
                            <input id="test" type="text" value="" hidden>
                            <div class="row text-center pt-4">
                                <h4>รายชื่อคณาจารย์นิเทศหลักสูตร CWIE จำแนกตามชื่อหลักสูตรและผู้จัดอบรม</h4>
                                <p id="trainingcourse"></p>
                            </div>
                            <div class="row text-center">
                                <div class="table-responsive" style="max-height:600px;overflow:scroll;">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>ชื่อ-สกุล</th>
                                                <th>ตำแหน่ง</th>
                                            </tr>
                                        </thead>
                                        <tbody id="trainings">
                                        </tbody>
                                    </table>
                                    <span id="trainingstips" class="text-danger text-center">*คลิกที่พื้นที่กราฟด้านซ้ายเพื่อดูรายชื่อคณาจารย์นิเทศหลักสูตร CWIE</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="viewcoursemodal" tabindex="-1" aria-labelledby="viewcoursemodal" aria-hidden="true">
        <div class="modal-dialog fullscreen-modal-dialog" style="max-width: 5000px;">
            <div class="modal-content container">
                <div class="modal-header">
                    <h5 class="modal-title th-font" id="viewcoursemodaltitle">ผลการดำเนินงาน การจัดการเรียนการสอน CWIE ประจำปีการศึกษา 2564</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body-open">
                    <div class="row pt-4 pb-4">
                        <div class="col-md-6">
                            <canvas id="myChart" width="400px" height="400px"></canvas>
                        </div>
                        <div class="col-md-6">
                            <input id="test" type="text" value="" hidden>
                            <div class="row text-center pt-4">
                                <h4>รายชื่อหลักสูตร มร.ชร. จำแนกตามรูปแบบของ CWIE</h4>
                                <p id="faculty"></p>
                            </div>
                            <div class="row text-center">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>รายชื่อหลักสูตร CWIE</th>
                                                <th>Separate</th>
                                                <th>Sandwich</th>
                                                <th>Mix</th>
                                            </tr>
                                        </thead>
                                        <tbody id="courses">
                                        </tbody>
                                    </table>
                                    <span id="coursetips" class="text-danger text-center">*คลิกที่พื้นที่กราฟด้านซ้ายเพื่อดูข้อมูลของแต่ละคณะ/สำนักวิชา</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="user_id" value="">
                </div>
            </div>
        </div>
    </div>
    <!-- Charts JS
	============================================= -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.0/dist/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>

    <script>

        const ctx = document.getElementById('myChart');
        const ctt = document.getElementById('myChartTraining');
        const cts = document.getElementById('myChartStudent');
        const cte = document.getElementById('myChartEstimate');
        const cti = document.getElementById('myChartInternplace');
        const ctg = document.getElementById('myChartGraduateWork');
        const centerText = {
            id: 'centerText',
            afterDatasetDraw(chart, args, options) {
                const {
                    ctx,
                    chartArea: {
                        left,
                        right,
                        top,
                        bottom,
                        width,
                        height
                    }
                } =
                chart;

                ctx.save();
                ctx.font = 'bolder 30px Arial';
                ctx.textAlign = 'center';
                ctx.fillStyle = 'rgba(42,29,65,1)';
                ctx.fillText('<?php $sql = "select * from cwie_course_old where cwie_course_old.cwie_course_status = '1'";
                                $query = $this->db->query($sql);
                                $count = $query->num_rows();
                                echo $count;
                                ?> หลักสูตร', width / 2, height / 2 + top);
                ctx.restore();
            }
        }

        const centerText2 = {
            id: 'centerText2',
            afterDatasetDraw(chart, args, options) {
                const {
                    ctx,
                    chartArea: {
                        left,
                        right,
                        top,
                        bottom,
                        width,
                        height
                    }
                } =
                chart;

                ctx.save();
                ctx.font = 'bolder 30px Arial';
                ctx.textAlign = 'center';
                ctx.fillStyle = 'rgba(42,29,65,1)';
                ctx.fillText('<?php $sql = "select * from cwie_teacher_training_old where cwie_teacher_training_old.cwie_teacher_training_status = '1'";
                                $query = $this->db->query($sql);
                                $count = $query->num_rows();
                                echo intval($count + 42);
                                ?> คน', width / 2, height / 2 + top);
                ctx.restore();
            }
        }

        const centerText3 = {
            id: 'centerText3',
            afterDatasetDraw(chart, args, options) {
                const {
                    ctx,
                    chartArea: {
                        left,
                        right,
                        top,
                        bottom,
                        width,
                        height
                    }
                } =
                chart;

                ctx.save();
                ctx.font = 'bolder 30px Arial';
                ctx.textAlign = 'center';
                ctx.fillStyle = 'rgba(42,29,65,1)';
                ctx.fillText('<?php $sql = "SELECT * FROM `cwie_student_training_old` LEFT JOIN tb_faculty_old ON tb_faculty_old.faculty_id = cwie_student_training_old.faculty_id WHERE  cwie_student_training_count != 0 AND cwie_student_training_year = '2564-65' AND cwie_student_training_status = '1'";
                                $query = $this->db->query($sql);
                                $count = 0;
                                foreach ($query->result() as $key => $row) {
                                    $count += $row->cwie_student_training_count;
                                }
                                echo intval($count - 604);
                                ?> คน', width / 2, height / 2 + top);
                ctx.restore();
            }
        }

        const centerText4 = {
            id: 'centerText4',
            afterDatasetDraw(chart, args, options) {
                const {
                    ctx,
                    chartArea: {
                        left,
                        right,
                        top,
                        bottom,
                        width,
                        height
                    }
                } =
                chart;

                ctx.save();
                ctx.font = 'bolder 30px Arial';
                ctx.textAlign = 'center';
                ctx.fillStyle = 'rgba(42,29,65,1)';
                ctx.fillText('91.14', width / 2, height / 2 + top);
                ctx.restore();
            }
        }

        const centerText5 = {
            id: 'centerText5',
            afterDatasetDraw(chart, args, options) {
                const {
                    ctx,
                    chartArea: {
                        left,
                        right,
                        top,
                        bottom,
                        width,
                        height
                    }
                } =
                chart;

                ctx.save();
                ctx.font = 'bolder 30px Arial';
                ctx.textAlign = 'center';
                ctx.fillStyle = 'rgba(42,29,65,1)';
                ctx.fillText('970 สถานที่', width / 2, height / 2 + top);
                ctx.restore();
            }
        }

        const myChartEstimate = new Chart(cte, {
            plugins: [ChartDataLabels, centerText4],
            type: 'doughnut',
            data: {
                labels: [
                    'ด้านคุณธรรมจริยธรรม',
                    'ด้านความรู้',
                    'ด้านทักษะทางปัญญา',
                    'ด้านทักษะความสัมพันธ์ระหว่างบุคคลและความรับผิดชอบ',
                    'ด้านทักษะการวิเคราะห์เชิงตัวเลข การสื่อสาร และการใช้ IT'
                ],
                datasets: [{
                    label: 'student',
                    data: [
                        94.72, 85.42, 90.28, 94.72, 90.56
                    ],
                    backgroundColor: [
                        'rgb(246, 217, 226)',
                        'rgb(202, 202, 221)',
                        'rgb(254, 237, 228)',
                        'rgb(248, 214, 203)',
                        'rgb(210, 199, 194)'
                    ],
                    // borderColor: [
                    //     'rgba(255, 99, 132, 1)',
                    //     'rgba(54, 162, 235, 1)',
                    //     'rgba(255, 206, 86, 1)',
                    //     'rgba(75, 192, 192, 1)',
                    //     'rgba(153, 102, 255, 1)',
                    //     'rgba(255, 159, 64, 1)'
                    // ],
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: true,
                        position: "bottom",
                        align: "center",
                        fontFamily: "Allianz-Neo",
                        textDirection: 'ltr',
                        labels: {
                            usePointStyle: true,
                            fontColor: "#006192",
                        }
                    },
                },
            },
        });


        const myChartStudent = new Chart(cts, {
            plugins: [ChartDataLabels, centerText3],
            type: 'doughnut',
            data: {
                labels: [
                    <?php
                    $facultychartsql = "SELECT * FROM `cwie_student_training_old` LEFT JOIN tb_faculty_old ON tb_faculty_old.faculty_id = cwie_student_training_old.faculty_id WHERE  cwie_student_training_count != 0 AND cwie_student_training_year = '2564-65' AND cwie_student_training_status = '1'";
                    $facultychartquery = $this->db->query($facultychartsql);
                    $resultfac = $facultychartquery->result();
                    foreach ($resultfac as $key => $row) {
                    ?> '<?php echo $row->faculty_name_th ?>',
                    <?php } ?>
                ],
                datasets: [{
                    label: 'student',
                    data: [
                        <?php
                        foreach ($resultfac as $key => $row) {
                        ?> '<?php echo $row->cwie_student_training_count ?>',
                        <?php } ?>
                    ],
                    backgroundColor: [
                        <?php
                        foreach ($resultfac as $key => $row) {
                        ?> '<?php echo $row->faculty_color ?>',
                        <?php } ?>
                    ],
                    // borderColor: [
                    //     'rgba(255, 99, 132, 1)',
                    //     'rgba(54, 162, 235, 1)',
                    //     'rgba(255, 206, 86, 1)',
                    //     'rgba(75, 192, 192, 1)',
                    //     'rgba(153, 102, 255, 1)',
                    //     'rgba(255, 159, 64, 1)'
                    // ],
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: true,
                        position: "bottom",
                        align: "center",
                        fontFamily: "Allianz-Neo",
                        textDirection: 'ltr',
                        labels: {
                            usePointStyle: true,
                            fontColor: "#006192",
                        }
                    },
                },
            },
        });


        const myChartTraining = new Chart(ctt, {
            plugins: [ChartDataLabels, centerText2],
            type: 'doughnut',
            data: {
                labels: [
                    <?php
                    $trainingsql = "SELECT * FROM `cwie_training_course_old` WHERE cwie_training_course_old.cwie_training_course_year = '2564' AND cwie_training_course_old.cwie_training_course_status = '1'";
                    $trainingquery = $this->db->query($trainingsql);
                    $results = $trainingquery->result();
                    foreach ($results as $key => $row) {
                    ?> '<?php echo $row->cwie_training_course_name ?>',
                    <?php } ?>
                ],
                datasets: [{
                    label: 'course',
                    data: [
                        <?php
                        foreach ($results as $key => $row) {
                            $trainingsql = "SELECT * FROM `cwie_teacher_training_old` WHERE cwie_teacher_training_old.cwie_training_course_id = $row->cwie_training_course_id AND cwie_teacher_training_old.cwie_teacher_training_status = '1'";
                            $trainingquery = $this->db->query($trainingsql);
                            $counts = $trainingquery->num_rows();
                            echo $counts . ',';
                        }
                        ?>
                    ],
                    backgroundColor: [
                        <?php
                        foreach ($results as $key => $row) {
                        ?> '<?php echo $row->cwie_training_course_color ?>',
                        <?php } ?>
                    ],
                    // borderColor: [
                    //     'rgba(255, 99, 132, 1)',
                    //     'rgba(54, 162, 235, 1)',
                    //     'rgba(255, 206, 86, 1)',
                    //     'rgba(75, 192, 192, 1)',
                    //     'rgba(153, 102, 255, 1)',
                    //     'rgba(255, 159, 64, 1)'
                    // ],
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: true,
                        position: "bottom",
                        align: "center",
                        fontFamily: "Allianz-Neo",
                        textDirection: 'ltr',
                        labels: {
                            usePointStyle: true,
                            fontColor: "#006192",
                        }
                    },
                },
            },
        });

        const myChart = new Chart(ctx, {
            plugins: [ChartDataLabels, centerText],
            type: 'doughnut',
            data: {
                labels: [
                    <?php
                    $facultychartsql = "SELECT * FROM `tb_faculty_old` WHERE tb_faculty_old.showStatus = '1'";
                    $facultychartquery = $this->db->query($facultychartsql);
                    $resultfac = $facultychartquery->result();
                    foreach ($resultfac as $key => $row) {
                    ?> '<?php echo $row->faculty_name_th ?>',
                    <?php } ?>
                ],
                datasets: [{
                    label: 'training',
                    data: [<?php
                            foreach ($resultfac as $key => $row) {
                                $coursesql = "SELECT * FROM `cwie_course_old` LEFT JOIN tb_faculty_old ON tb_faculty_old.faculty_id = cwie_course_old.faculty_id WHERE tb_faculty_old.faculty_name_th = '" . $row->faculty_name_th . "' AND cwie_course_old.cwie_course_status = '1'";
                                $coursequery = $this->db->query($coursesql);
                                $counts = $coursequery->num_rows();
                                echo $counts, ',';
                            }
                            ?>],
                    backgroundColor: [
                        <?php
                        foreach ($resultfac as $key => $row) {
                        ?> '<?php echo $row->faculty_color ?>',
                        <?php } ?>
                    ],
                    // borderColor: [
                    //     'rgba(255, 99, 132, 1)',
                    //     'rgba(54, 162, 235, 1)',
                    //     'rgba(255, 206, 86, 1)',
                    //     'rgba(75, 192, 192, 1)',
                    //     'rgba(153, 102, 255, 1)',
                    //     'rgba(255, 159, 64, 1)'
                    // ],
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: true,
                        position: "bottom",
                        align: "center",
                        fontFamily: "Allianz-Neo",
                        textDirection: 'ltr',
                        labels: {
                            usePointStyle: true,
                            fontColor: "#006192",
                        }
                    },
                },
            },
        });

        const myChartInternplace = new Chart(cti, {
            plugins: [ChartDataLabels, centerText5],
            type: 'doughnut',
            data: {
                labels: [
                    'คณะเทคโนโลยีอุตสาหกรรม',
                    'คณะมนุษยศาสตร์',
                    'คณะครุศาสตร์',
                    'คณะวิทยาการจัดการ',
                    'วิทยาลัยการแพทย์พื้นบ้านและการแพทย์ทางเลือก',
                    'สำนักวิชาวิทยาศาสตร์สุขภาพ',
                    'สำนักวิชาคอมพิวเตอร์และเทคโนโลยีสารสนเทศ',
                    'สำนักวิชาสังคมศาสตร์',
                    'สำนักวิชานิติศาสตร์',
                    'สำนักวิชาการท่องเที่ยว',
                    'สำนักวิชาบัญชี',
                ],
                datasets: [{
                    label: 'training',
                    data: [54, 230, 401, 11, 32, 5, 3, 8, 20, 137, 69],
                    backgroundColor: [
                        <?php
                        foreach ($resultfac as $key => $row) {
                        ?> '<?php echo $row->faculty_color ?>',
                        <?php } ?>
                    ],
                    // borderColor: [
                    //     'rgba(255, 99, 132, 1)',
                    //     'rgba(54, 162, 235, 1)',
                    //     'rgba(255, 206, 86, 1)',
                    //     'rgba(75, 192, 192, 1)',
                    //     'rgba(153, 102, 255, 1)',
                    //     'rgba(255, 159, 64, 1)'
                    // ],
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: true,
                        position: "bottom",
                        align: "center",
                        fontFamily: "Allianz-Neo",
                        textDirection: 'ltr',
                        labels: {
                            usePointStyle: true,
                            fontColor: "#006192",
                        }
                    },
                },
            },
        });

        const myChartGraduateWork = new Chart(ctg, {
            plugins: [ChartDataLabels],
            data: {
                datasets: [{
                    type: 'bar',
                    label: '2560',
                    data: [3599, 2105, 1377, 728, 58.48],
                    backgroundColor: [
                        'rgba(246, 236, 175)',
                        'rgba(246, 236, 175)',
                        'rgba(246, 236, 175)',
                        'rgba(246, 236, 175)',
                    ],
                }, {
                    type: 'bar',
                    label: '2561',
                    data: [2157, 1797, 1052, 745, 56.92],
                    backgroundColor: [
                        'rgba(255, 173, 192)',
                        'rgba(255, 173, 192)',
                        'rgba(255, 173, 192)',
                        'rgba(255, 173, 192)',
                    ],
                }, {
                    type: 'bar',
                    label: '2562',
                    data: [3161, 1823, 1071, 752, 57.67],
                    backgroundColor: [
                        'rgba(187, 157, 204)',
                        'rgba(187, 157, 204)',
                        'rgba(187, 157, 204)',
                        'rgba(187, 157, 204)',
                    ],
                }, {
                    type: 'bar',
                    label: '2563',
                    data: [2752, 1753, 1088, 665, 63.69],
                    backgroundColor: [
                        'rgba(202, 229, 218)',
                        'rgba(202, 229, 218)',
                        'rgba(202, 229, 218)',
                        'rgba(202, 229, 218)',
                    ],
                }, ],
                labels: ['จำนวนบัณฑิตจบ', 'ได้งานทำ', 'ได้งานตรงสาขา', 'ไม่ตรงสาขา', 'ร้อยละ']
            },
            options: {
                plugins: {
                    legend: {
                        display: true,
                        position: "bottom",
                        align: "center",
                        fontFamily: "Allianz-Neo",
                        textDirection: 'ltr',
                        labels: {
                            usePointStyle: true,
                            fontColor: "#006192",
                        }
                    },
                },
            },
        });

        function clickHandlerInternplace(evt) {
            const color = [
                <?php
                foreach ($resultfac as $key => $row) {
                ?> '<?php echo $row->faculty_color ?>',
                <?php } ?>
            ];
            myChartInternplace.config.data.datasets[0].backgroundColor = color;
            const points = myChartInternplace.getElementsAtEventForMode(evt, 'nearest', {
                intersect: true
            }, true);
            if (points.length) {
                const firstPoint = points[0];
                var label = myChartInternplace.data.labels[firstPoint.index];
                var value = myChartInternplace.data.datasets[firstPoint.datasetIndex].data[firstPoint.index];
                document.getElementById('test').value = label;
            }
            myChartInternplace.data.datasets[points[0].datasetIndex].backgroundColor[points[0].index] = 'rgb(42, 29, 65)';
            myChartInternplace.update();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('operation/getInternplaceDataCount') ?>",
                data: {
                    id: label,
                }
            }).done(function(data) {
                $("#internplacecountlabel").html(label);
                $("#internplacecount").html(data);
                document.getElementById('internplacecounttips').hidden = true;
            });
        }

        function clickHandlerStudent(evt) {
            const color = [
                <?php
                foreach ($resultfac as $key => $row) {
                ?> '<?php echo $row->faculty_color ?>',
                <?php } ?>
            ];
            myChartStudent.config.data.datasets[0].backgroundColor = color;
            const points = myChartStudent.getElementsAtEventForMode(evt, 'nearest', {
                intersect: true
            }, true);
            if (points.length) {
                const firstPoint = points[0];
                var label = myChartStudent.data.labels[firstPoint.index];
                var value = myChartStudent.data.datasets[firstPoint.datasetIndex].data[firstPoint.index];
                document.getElementById('test').value = label;
            }
            myChartStudent.data.datasets[points[0].datasetIndex].backgroundColor[points[0].index] = 'rgb(42, 29, 65)';
            myChartStudent.update();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('operation/getStudentData') ?>",
                data: {
                    id: label,
                }
            }).done(function(data) {
                $("#trainingstudent").html(label);
                $("#students").html(data);
                document.getElementById('studentstips').hidden = true;
            });
        }


        function clickHandlerTeacher(evt) {
            const color = [
                <?php
                foreach ($results as $key => $row) {
                ?> '<?php echo $row->cwie_training_course_color ?>',
                <?php } ?>
            ];
            myChartTraining.config.data.datasets[0].backgroundColor = color;
            const points = myChartTraining.getElementsAtEventForMode(evt, 'nearest', {
                intersect: true
            }, true);
            if (points.length) {
                const firstPoint = points[0];
                var label = myChartTraining.data.labels[firstPoint.index];
                var value = myChartTraining.data.datasets[firstPoint.datasetIndex].data[firstPoint.index];
                document.getElementById('test').value = label;
            }
            myChartTraining.data.datasets[points[0].datasetIndex].backgroundColor[points[0].index] = 'rgb(42, 29, 65)';
            myChartTraining.update();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('operation/getTeacherData') ?>",
                data: {
                    id: label,
                }
            }).done(function(data) {
                $("#trainingcourse").html(label);
                $("#trainings").html(data);
                document.getElementById('trainingstips').hidden = true;
            });
        }

        function clickHandler(evt) {
            const color = [
                <?php
                foreach ($resultfac as $key => $row) {
                ?> '<?php echo $row->faculty_color ?>',
                <?php } ?>
            ];
            myChart.config.data.datasets[0].backgroundColor = color;
            const points = myChart.getElementsAtEventForMode(evt, 'nearest', {
                intersect: true
            }, true);
            if (points.length) {
                const firstPoint = points[0];
                var label = myChart.data.labels[firstPoint.index];
                var value = myChart.data.datasets[firstPoint.datasetIndex].data[firstPoint.index];
                document.getElementById('test').value = label;
            }
            //myChart.data.datasets[0].backgroundColor = 'rgba(251, 85, 85, 0.4)';
            myChart.data.datasets[points[0].datasetIndex].backgroundColor[points[0].index] = 'rgb(42, 29, 65)';
            myChart.update();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('operation/getCourseData') ?>",
                data: {
                    id: label,
                }
            }).done(function(data) {
                $("#faculty").html("คณะ/สำนักวิชา " + label);
                $("#courses").html(data);
                document.getElementById('coursetips').hidden = true;
            });
        }
        cts.onclick = clickHandlerStudent;
        ctt.onclick = clickHandlerTeacher;
        ctx.onclick = clickHandler;
        cti.onclick = clickHandlerInternplace;
    </script>