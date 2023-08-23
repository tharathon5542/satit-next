<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Operation extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // if (!$this->session->userdata('up_login_oauth_uid')) {
        //     redirect('/');
        // }
    }

    public function index()
    {
        //    echo "Index Home";
    }

 
    public function getCourseData()
    {
        $facultyname = "'" . $this->input->post('id') . "'";
        $coursesql = "SELECT * FROM `cwie_course_old` LEFT JOIN tb_faculty_old ON tb_faculty_old.faculty_id = cwie_course_old.faculty_id WHERE tb_faculty_old.faculty_name_th = $facultyname AND cwie_course_old.cwie_course_status = '1'";
        $coursequery = $this->db->query($coursesql);
        $results = $coursequery->result();
        foreach ($results as $key => $row) {
            echo '<tr>';
            echo '<td>' . intval($key + 1) . '</td>';
            echo '<td>' . $row->cwie_course_name . '</td>';
            if ($row->cwie_course_type_seperate != null) {
                echo '<td>ใช่</td>';
            } else {
                echo '<td></td>';
            }
            if ($row->cwie_course_type_sandwich != null) {
                echo '<td>ใช่</td>';
            } else {
                echo '<td></td>';
            }
            if ($row->cwie_course_type_mix != null) {
                echo '<td>ใช่</td>';
            } else {
                echo '<td></td>';
            }
            echo '</tr>';
        }
    }

    public function getTeacherData()
    {
        $coursename = "'" . $this->input->post('id') . "'";
        $coursesql = "SELECT * FROM `cwie_teacher_training_old` LEFT JOIN cwie_training_course_old ON cwie_training_course_old.cwie_training_course_id  = cwie_teacher_training_old.cwie_training_course_id LEFT JOIN cwie_faculty_position_old ON cwie_faculty_position_old.cwie_faculty_position_id = cwie_teacher_training_old.cwie_teacher_training_cwie_faculty_position WHERE cwie_training_course_old.cwie_training_course_name = $coursename AND cwie_teacher_training_old.cwie_teacher_training_status = '1'";
        $coursequery = $this->db->query($coursesql);
        $results = $coursequery->result();
        foreach ($results as $key => $row) {
            echo '<tr>';
            echo '<td>' . intval($key + 1) . '</td>';
            echo '<td>' . $row->cwie_teacher_training_fullname . '</td>';
            if ($row->cwie_faculty_position_name != null) {
                echo '<td>' . $row->cwie_faculty_position_name . '</td>';
            } else {
                echo '<td></td>';
            }
            echo '</tr>';
        }
    }

    public function getStudentData()
    {
        $coursename = "'" . $this->input->post('id') . "'";
        $coursesql = "SELECT * FROM `cwie_student_training_old` LEFT JOIN tb_faculty_old ON tb_faculty_old.faculty_id = cwie_student_training_old.faculty_id WHERE tb_faculty_old.faculty_name_th = $coursename AND  cwie_student_training_old.cwie_student_training_status = '1'";
        $coursequery = $this->db->query($coursesql);
        $results = $coursequery->result();
        $hokshi = array();
        $hoksarm = array();
        foreach ($results as $key => $row) {
            if ($row->cwie_student_training_year == "2563-64") {
                array_push($hoksarm, $row->cwie_student_training_count);
            } elseif ($row->cwie_student_training_year == "2564-65") {
                array_push($hokshi, $row->cwie_student_training_count);
            }
        }
        echo '<tr>';
        echo '<td>' . $hoksarm[0] . '</td>';
        echo '<td>' . $hokshi[0] . '</td>';
        echo '<td>คน</td>';
        echo '</tr>';
    }

    public function getInternplaceDataCount()
    {
        $coursename = $this->input->post('id');
        if ($coursename == "คณะเทคโนโลยีอุตสาหกรรม") {
            echo '<tr>';
            echo '<td>54</td>';
            echo '<td>0</td>';
            echo '<td>54</td>';
            echo '</tr>';
        } elseif ($coursename == "คณะมนุษยศาสตร์") {
            echo '<tr>';
            echo '<td>230</td>';
            echo '<td>0</td>';
            echo '<td>230</td>';
            echo '</tr>';
        } elseif ($coursename == "คณะครุศาสตร์") {
            echo '<tr>';
            echo '<td>401</td>';
            echo '<td>0</td>';
            echo '<td>401</td>';
            echo '</tr>';
        } elseif ($coursename == "คณะวิทยาการจัดการ") {
            echo '<tr>';
            echo '<td>11</td>';
            echo '<td>0</td>';
            echo '<td>11</td>';
            echo '</tr>';
        } elseif ($coursename == "วิทยาลัยการแพทย์พื้นบ้านและการแพทย์ทางเลือก") {
            echo '<tr>';
            echo '<td>13</td>';
            echo '<td>19</td>';
            echo '<td>32</td>';
            echo '</tr>';
        } elseif ($coursename == "สำนักวิชาวิทยาศาสตร์สุขภาพ") {
            echo '<tr>';
            echo '<td>5</td>';
            echo '<td>0</td>';
            echo '<td>5</td>';
            echo '</tr>';
        } elseif ($coursename == "สำนักวิชาคอมพิวเตอร์และเทคโนโลยีสารสนเทศ") {
            echo '<tr>';
            echo '<td>3</td>';
            echo '<td>0</td>';
            echo '<td>3</td>';
            echo '</tr>';
        } elseif ($coursename == "สำนักวิชาสังคมศาสตร์") {
            echo '<tr>';
            echo '<td>8</td>';
            echo '<td>0</td>';
            echo '<td>8</td>';
            echo '</tr>';
        } elseif ($coursename == "สำนักวิชานิติศาสตร์") {
            echo '<tr>';
            echo '<td>20</td>';
            echo '<td>0</td>';
            echo '<td>20</td>';
            echo '</tr>';
        } elseif ($coursename == "สำนักวิชาการท่องเที่ยว") {
            echo '<tr>';
            echo '<td>136</td>';
            echo '<td>1</td>';
            echo '<td>137</td>';
            echo '</tr>';
        } elseif ($coursename == "สำนักวิชาบัญชี") {
            echo '<tr>';
            echo '<td>69</td>';
            echo '<td>0</td>';
            echo '<td>69</td>';
            echo '</tr>';
        }
    }

    public function getInternplaceData()
    {
        $coursesql = "SELECT * FROM `cwie_intern_place_old` WHERE cwie_intern_place_old.cwie_intern_place_year = '2564' AND  cwie_intern_place_old.cwie_intern_place_status = '1' GROUP BY cwie_intern_place_old.cwie_intern_place_name";
        $coursequery = $this->db->query($coursesql);
        $results = $coursequery->result();
        foreach ($results as $key => $row) {
            echo '<tr>';
            echo '<td>' . intval($key + 1) . '</td>';
            echo '<td>' . $row->cwie_intern_place_name . '</td>';
            echo '</tr>';
        }
    }

    public function getMouInData()
    {
        $coursesql = "SELECT * FROM `cwie_mou_place_old` WHERE cwie_mou_place_old.cwie_mou_place_year = '2564' AND  cwie_mou_place_old.cwie_mou_place_type = '0' AND  cwie_mou_place_old.cwie_mou_place_status = '1'";
        $coursequery = $this->db->query($coursesql);
        $results = $coursequery->result();
        foreach ($results as $key => $row) {
            echo '<tr>';
            echo '<td>' . intval($key + 1) . '</td>';
            echo '<td>' . $row->cwie_mou_place_name . '</td>';
            echo '<td>' . $row->cwie_mou_place_about . '</td>';
            echo '</tr>';
        }
    }

    public function getMouOutData()
    {
        $coursesql = "SELECT * FROM `cwie_mou_place_old` WHERE cwie_mou_place_old.cwie_mou_place_year = '2564' AND cwie_mou_place_old.cwie_mou_place_type = '1' AND  cwie_mou_place_old.cwie_mou_place_status = '1'";
        $coursequery = $this->db->query($coursesql);
        $results = $coursequery->result();
        foreach ($results as $key => $row) {
            echo '<tr>';
            echo '<td>' . intval($key + 1) . '</td>';
            echo '<td><img width="100px" src="' . base_url('assets/images/mouflag/' . $row->cwie_mou_place_flag) . '.jpg" alt=""></td>';
            echo '<td>' . $row->cwie_mou_place_name . '</td>';
            echo '<td>' . $row->cwie_mou_place_about . '</td>';
            echo '<td><a href="' . base_url("assets/images/mouflag/") . $row->cwie_mou_place_image . '" data-lightbox="image"><button type="button" class="btn btn-success">ดู</button></a></td>';
            echo '</tr>';
        }
    }

    public function getFacultyData()
    {
        $coursename = $this->input->post('id');
        $coursesql = "SELECT * FROM `tb_faculty_old` WHERE tb_faculty_old.faculty_id = '$coursename' AND tb_faculty_old.showStatus = '1'";
        $coursequery = $this->db->query($coursesql);
        $results = $coursequery->row();
        if ($results->faculty_name_th == "สำนักวิชาบัญชี") {
            for ($i = 1; $i <= 13; $i++) {
                echo " <img style=" . 'display:block;margin-left:auto;margin-right:auto' . " src=" . base_url('assets/presentation/report-2/07.สำนักวิชาวิชาบัญชี/' . $i . '.jpg') . " >";
            }
        } elseif ($results->faculty_name_th == "คณะครุศาสตร์") {
            for ($i = 1; $i <= 22; $i++) {
                echo " <img style=" . 'display:block;margin-left:auto;margin-right:auto' . " src=" . base_url('assets/presentation/report-1/01.คณะครุศาสตร์/' . $i . '.jpg') . " >";
            }
        } elseif ($results->faculty_name_th == "คณะมนุษยศาสตร์") {
            for ($i = 1; $i <= 37; $i++) {
                echo " <img style=" . 'display:block;margin-left:auto;margin-right:auto' . " src=" . base_url('assets/presentation/report-1/02.คณะมนุษยศาสตร์/' . $i . '.jpg') . " >";
            }
        } elseif ($results->faculty_name_th == "สำนักวิชาวิทยาศาสตร์สุขภาพ") {
            for ($i = 1; $i <= 34; $i++) {
                echo " <img style=" . 'display:block;margin-left:auto;margin-right:auto' . " src=" . base_url('assets/presentation/report-2/12.สำนักวิชาวิทยาศาสตร์สุขภาพ/' . $i . '.jpg') . " >";
            }
        } elseif ($results->faculty_name_th == "คณะเทคโนโลยีอุตสาหกรรม") {
            for ($i = 1; $i <= 67; $i++) {
                echo " <img style=" . 'display:block;margin-left:auto;margin-right:auto' . " src=" . base_url('assets/presentation/report-2/09.คณะเทคโนโลยีอุตสาหกรรม/' . $i . '.jpg') . " >";
            }
        } elseif ($results->faculty_name_th == "สำนักวิชานิติศาสตร์") {
            for ($i = 1; $i <= 19; $i++) {
                echo " <img style=" . 'display:block;margin-left:auto;margin-right:auto' . " src=" . base_url('assets/presentation/report-1/04.สำนักวิชานิติศาสตร์/' . $i . '.jpg') . " >";
            }
        } elseif ($results->faculty_name_th == "คณะวิทยาการจัดการ") {
            for ($i = 1; $i <= 13; $i++) {
                echo " <img style=" . 'display:block;margin-left:auto;margin-right:auto' . " src=" . base_url('assets/presentation/report-1/06.คณะวิทยาการจัดการ/' . $i . '.jpg') . " >";
            }
        } elseif ($results->faculty_name_th == "สำนักวิชาคอมพิวเตอร์และเทคโนโลยีสารสนเทศ") {
            for ($i = 1; $i <= 6; $i++) {
                echo " <img style=" . 'display:block;margin-left:auto;margin-right:auto' . " src=" . base_url('assets/presentation/report-2/11.สำนักวิชาคอมพิวเตอร์และเทคโนโลยีสารสนเทศ/' . $i . '.jpg') . " >";
            }
        } elseif ($results->faculty_name_th == "สำนักวิชาสังคมศาสตร์") {
            for ($i = 1; $i <= 13; $i++) {
                echo " <img style=" . 'display:block;margin-left:auto;margin-right:auto' . " src=" . base_url('assets/presentation/report-1/03.สำนักวิชาสังคมศาสตร์/' . $i . '.jpg') . " >";
            }
        } elseif ($results->faculty_name_th == "วิทยาลัยการแพทย์พื้นบ้านและการแพทย์ทางเลือก") {
            for ($i = 1; $i <= 11; $i++) {
                echo " <img style=" . 'display:block;margin-left:auto;margin-right:auto' . " src=" . base_url('assets/presentation/report-2/13.วิทยาลัยการแพทย์ฯ/' . $i . '.jpg') . " >";
            }
        } elseif ($results->faculty_name_th == "สำนักวิชารัฐศาสตร์และรัฐประศาสนศาสตร์") {
            echo " <span class=" . 'text-danger' . ">*ไม่มีข้อมูลรายงานผลให้แสดง</span>";
        } elseif ($results->faculty_name_th == "คณะวิทยาศาสตร์และเทคโนโลยี") {
            echo " <span class=" . 'text-danger' . ">*ไม่มีข้อมูลรายงานผลให้แสดง</span>";
        } elseif ($results->faculty_name_th == "สำนักวิชาการท่องเที่ยว") {
            echo " <span class=" . 'text-danger' . ">*ไม่มีข้อมูลรายงานผลให้แสดง</span>";
        }
    }

    public function getFacultyData0()
    {
        $coursename = $this->input->post('id');
        $coursesql = "SELECT * FROM `tb_faculty_old` WHERE tb_faculty_old.faculty_id = '$coursename' AND tb_faculty_old.showStatus = '1'";
        $coursequery = $this->db->query($coursesql);
        $results = $coursequery->row();
        if ($results->faculty_name_th == "สำนักวิชาบัญชี") {
            for ($i = 1; $i <= 20; $i++) {
                echo " <img style=" . 'display:block;margin-left:auto;margin-right:auto' . " src=" . base_url('assets/presentation/report-2/07.สำนักวิชาวิชาบัญชี/slide/' . $i . '.jpg') . " >";
            }
        } elseif ($results->faculty_name_th == "คณะครุศาสตร์") {
            for ($i = 1; $i <= 22; $i++) {
                echo " <img style=" . 'display:block;margin-left:auto;margin-right:auto' . " src=" . base_url('assets/presentation/report-1/01.คณะครุศาสตร์/slide/' . $i . '.jpg') . " >";
            }
        } elseif ($results->faculty_name_th == "คณะมนุษยศาสตร์") {
            echo "<span class=" . 'text-danger' . ">*ไม่มีข้อมูลสไลด์นำเสนอให้แสดง</span>";
        } elseif ($results->faculty_name_th == "สำนักวิชาวิทยาศาสตร์สุขภาพ") {
            for ($i = 1; $i <= 34; $i++) {
                echo " <img style=" . 'display:block;margin-left:auto;margin-right:auto' . " src=" . base_url('assets/presentation/report-2/12.สำนักวิชาวิทยาศาสตร์สุขภาพ/slide/' . $i . '.jpg') . " >";
            }
        } elseif ($results->faculty_name_th == "คณะเทคโนโลยีอุตสาหกรรม") {
            for ($i = 1; $i <= 8; $i++) {
                echo " <img style=" . 'display:block;margin-left:auto;margin-right:auto' . " src=" . base_url('assets/presentation/report-2/09.คณะเทคโนโลยีอุตสาหกรรม/slide/' . $i . '.jpg') . " >";
            }
        } elseif ($results->faculty_name_th == "สำนักวิชานิติศาสตร์") {
            for ($i = 1; $i <= 19; $i++) {
                echo " <img style=" . 'display:block;margin-left:auto;margin-right:auto' . " src=" . base_url('assets/presentation/report-1/04.สำนักวิชานิติศาสตร์/slide/' . $i . '.jpg') . " >";
            }
        } elseif ($results->faculty_name_th == "คณะวิทยาการจัดการ") {
            for ($i = 1; $i <= 13; $i++) {
                echo " <img style=" . 'display:block;margin-left:auto;margin-right:auto' . " src=" . base_url('assets/presentation/report-1/06.คณะวิทยาการจัดการ/slide/' . $i . '.jpg') . " >";
            }
        } elseif ($results->faculty_name_th == "สำนักวิชาคอมพิวเตอร์และเทคโนโลยีสารสนเทศ") {
            for ($i = 1; $i <= 34; $i++) {
                echo " <img style=" . 'display:block;margin-left:auto;margin-right:auto' . " src=" . base_url('assets/presentation/report-2/11.สำนักวิชาคอมพิวเตอร์และเทคโนโลยีสารสนเทศ/slide/' . $i . '.jpg') . " >";
            }
        } elseif ($results->faculty_name_th == "สำนักวิชาสังคมศาสตร์") {
            echo "<span class=" . 'text-danger' . ">*ไม่มีข้อมูลสไลด์นำเสนอให้แสดง</span>";
        } elseif ($results->faculty_name_th == "วิทยาลัยการแพทย์พื้นบ้านและการแพทย์ทางเลือก") {
            for ($i = 1; $i <= 42; $i++) {
                echo " <img style=" . 'display:block;margin-left:auto;margin-right:auto' . " src=" . base_url('assets/presentation/report-2/13.วิทยาลัยการแพทย์ฯ/slide/' . $i . '.jpg') . " >";
            }
        } elseif ($results->faculty_name_th == "สำนักวิชารัฐศาสตร์และรัฐประศาสนศาสตร์") {
            for ($i = 1; $i <= 19; $i++) {
                echo " <img style=" . 'display:block;margin-left:auto;margin-right:auto' . " src=" . base_url('assets/presentation/report-2/08.สำนักวิชารัฐศาสตร์และรัฐประศาสนศาสตร์/slide/' . $i . '.jpg') . " >";
            }
        } elseif ($results->faculty_name_th == "คณะวิทยาศาสตร์และเทคโนโลยี") {
            for ($i = 1; $i <= 14; $i++) {
                echo " <img style=" . 'display:block;margin-left:auto;margin-right:auto' . " src=" . base_url('assets/presentation/report-2/10.คณะวิทยาศาสตร์และเทคโนโลยี/slide/' . $i . '.jpg') . " >";
            }
        } elseif ($results->faculty_name_th == "สำนักวิชาการท่องเที่ยว") {
            echo "<span class=" . 'text-danger' . ">*ไม่มีข้อมูลสไลด์นำเสนอให้แสดง</span>";
        }
    }

    public function getFacultyDataVideo()
    {
        $coursename = $this->input->post('id');
        $coursesql = "SELECT * FROM `tb_faculty_old` WHERE tb_faculty_old.faculty_id = '$coursename' AND tb_faculty_old.showStatus = '1'";
        $coursequery = $this->db->query($coursesql);
        $results = $coursequery->row();
        if ($results->faculty_name_th == "สำนักวิชาบัญชี") {
            echo "<iframe src=" . 'https://drive.google.com/file/d/12N1W1bgdXZPuEiiOi9za--mRWkSqr4P_/preview' . " width=" . '640' . " height=" . '480' . " allow=" . 'autoplay' . "></iframe>";
        } elseif ($results->faculty_name_th == "คณะครุศาสตร์") {
            echo "<iframe src=" . 'https://drive.google.com/file/d/1DHJaQkcqjY6KY-jhQM2-UMmwD_RNwHbI/preview' . " width=" . '640' . " height=" . '480' . " allow=" . 'autoplay' . "></iframe>";
        } elseif ($results->faculty_name_th == "คณะมนุษยศาสตร์") {
            echo "<iframe src=" . 'https://drive.google.com/file/d/1CJUIiY92zwt9ceBVhuTEr_Hc48Olq_fK/preview' . " width=" . '640' . " height=" . '480' . " allow=" . 'autoplay' . "></iframe>";
            echo "<iframe src=" . 'https://drive.google.com/file/d/1_-duSdQfeyXxybgXrsSXdQjZ_EfkXwQs/preview' . " width=" . '640' . " height=" . '480' . " allow=" . 'autoplay' . "></iframe>";
        } elseif ($results->faculty_name_th == "สำนักวิชาวิทยาศาสตร์สุขภาพ") {
            echo "<iframe src=" . 'https://drive.google.com/file/d/1R3N9NNtxPm8Y474Iy9yYYnhz0cJm3kxR/preview' . " width=" . '640' . " height=" . '480' . " allow=" . 'autoplay' . "></iframe>";
        } elseif ($results->faculty_name_th == "คณะเทคโนโลยีอุตสาหกรรม") {
            echo "<span class=" . 'text-danger' . ">*ไม่มีข้อมูลวิดีโอนำเสนอให้แสดง</span>";
        } elseif ($results->faculty_name_th == "สำนักวิชานิติศาสตร์") {
            echo "<span class=" . 'text-danger' . ">*ไม่มีข้อมูลวิดีโอนำเสนอให้แสดง</span>";
        } elseif ($results->faculty_name_th == "คณะวิทยาการจัดการ") {
            echo "<span class=" . 'text-danger' . ">*ไม่มีข้อมูลวิดีโอนำเสนอให้แสดง</span>";
        } elseif ($results->faculty_name_th == "สำนักวิชาคอมพิวเตอร์และเทคโนโลยีสารสนเทศ") {
            echo "<iframe src=" . 'https://drive.google.com/file/d/1ZbwfMQ-c_mfMqoogGN6uk1c-k6EG2TH8/preview' . " width=" . '640' . " height=" . '480' . " allow=" . 'autoplay' . "></iframe>";
        } elseif ($results->faculty_name_th == "สำนักวิชาสังคมศาสตร์") {
            echo "<iframe src=" . 'https://drive.google.com/file/d/1biigQYy8W9eYX3e-qR-r40gCiK4BqF2t/preview' . " width=" . '640' . " height=" . '480' . " allow=" . 'autoplay' . "></iframe>";
        } elseif ($results->faculty_name_th == "วิทยาลัยการแพทย์พื้นบ้านและการแพทย์ทางเลือก") {
            echo "<span class=" . 'text-danger' . ">*ไม่มีข้อมูลวิดีโอนำเสนอให้แสดง</span>";
        } elseif ($results->faculty_name_th == "สำนักวิชารัฐศาสตร์และรัฐประศาสนศาสตร์") {
            echo "<span class=" . 'text-danger' . ">*ไม่มีข้อมูลวิดีโอนำเสนอให้แสดง</span>";
        } elseif ($results->faculty_name_th == "คณะวิทยาศาสตร์และเทคโนโลยี") {
            echo "<span class=" . 'text-danger' . ">*ไม่มีข้อมูลวิดีโอนำเสนอให้แสดง</span>";
        } elseif ($results->faculty_name_th == "สำนักวิชาการท่องเที่ยว") {
            echo "<iframe src=" . 'https://drive.google.com/file/d/1eO_Ly5p1NoISdux3eA_WzDsmLcik6kvw/preview' . " width=" . '640' . " height=" . '480' . " allow=" . 'autoplay' . "></iframe>";
        }
    }
}// END CLASS
