<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Course extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // check session
        if (!$this->session->userdata('crudSessionData')) {
            $redirectURL = str_replace('/index.php', '', current_url());
            redirect(base_url('crud/auth?redirect=') . $redirectURL);
            return;
        }
    }

    private function mainVariable()
    {
        $reponse['title'] = 'CRRU-CWIE | MIS';
        $reponse['description'] = 'CWIE';
        $reponse['author'] = 'CLLI Devs';
        return $reponse;
    }

    private function checkPermission($acceptPermissionList = [])
    {
        if (!in_array($this->session->userdata('crudSessionData')['crudPermission'], $acceptPermissionList))
            return false;
        return true;
    }

    /*
    | --------------------------------------------------------------------------------
    | Load View Section
    | --------------------------------------------------------------------------------
    */
    public function index()
    {
        if (!$this->checkPermission(['admin', 'major'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        $response = $this->mainVariable();
        $response['page'] = 'Course';

        $this->load->view('z_template/header', $response);
        $this->load->view('course/coursePage', $response);
        $this->load->view('z_template/footer');
    }

    public function editModal($courseID = null)
    {
        if (!$this->checkPermission(['admin', 'major'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        if ($courseID == null) {
            $response = ['status' => false, 'errorMessage' =>  "Parameter Not Found!"];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        $response = [
            'status' => true,
            'courseData' => $this->getCourse($courseID),
            'data' =>  $this->load->view('course/courseEditPage', null, true)
        ];
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function addModal()
    {
        if (!$this->checkPermission(['admin', 'major'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        $response = ['status' => true, 'data' =>  $this->load->view('course/courseAddPage', null, true)];
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    /*
    | --------------------------------------------------------------------------------
    | Functions Section
    | --------------------------------------------------------------------------------
    */

    public function getCourse($courseID = null)
    {
        if (!$this->checkPermission(['admin', 'major'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // query course by id
        if ($courseID != null) {
            $queryCourse = $this->db->get_where('cwie_course', array('course_id' => $courseID));

            if ($queryCourse->num_rows() <= 0) {
                header('Content-Type: application/json');
                echo json_encode($response = ['status' => 'false', 'errorMessage' => 'Course Not Found!']);
                return;
            }

            $response = [
                'courseID' => $queryCourse->row()->course_id,
                'courseYear' => $queryCourse->row()->year_id,
                'courseCode' => $queryCourse->row()->course_code,
                'courseName' => $queryCourse->row()->course_name,
                'courseNameEN' => $queryCourse->row()->course_name_en,
                'courseHardSkill' => $queryCourse->row()->course_hard_skill,
                'courseSoftSkill' => $queryCourse->row()->course_soft_skill,
                'courseGrade' => $queryCourse->row()->course_grade,
                'courseCategory' => $queryCourse->row()->course_category_id,
                'courseISCED' => $queryCourse->row()->isced_id,
                'courseProfession' => $queryCourse->row()->profession_id,
                'courseCoordinatorName' => $queryCourse->row()->course_coordinator_name,
                'courseCoordinatorSurname' => $queryCourse->row()->course_coordinator_surname,
                'courseCoordinatorTel' => $queryCourse->row()->course_coordinator_tel,
                'courseCoordinatorEmail' => $queryCourse->row()->course_coordinator_email,
                'courseTags' => $queryCourse->row()->course_tags,
                'courseChecoCode' => $queryCourse->row()->course_checo_code,
                'courseChecoAcknowledge' => $queryCourse->row()->course_checo_acknowledge,
                'courseChecoOperation' => $queryCourse->row()->course_checo_operation,
                'courseMajorID' => $queryCourse->row()->major_id,
            ];
            return $response;
        }

        // query course by major
        if ($this->session->userdata('crudSessionData')['crudPermission'] == 'major') {

            $queryCourse = $this->db->join('cwie_major', 'cwie_course.major_id = cwie_major.major_id', 'left')
                ->join('cwie_year', 'cwie_course.year_id = cwie_year.year_id', 'left')
                ->order_by('course_datetime', 'DESC')
                ->get_where('cwie_course', array('cwie_course.major_id' => $this->session->userdata('crudSessionData')['crudId']));

            foreach ($queryCourse->result() as $course) {
                $queryData[] = [
                    'courseID' => $course->course_id,
                    'courseYear' => $course->year_title,
                    'courseCode' => $course->course_code,
                    'courseName' => $course->course_name,
                    'courseInfoFile' => $course->course_info_file,
                    'courseInfoFileType' => $course->course_info_file_type,
                    'majorNameTH' => $course->major_name_th
                ];
            }

            header('Content-Type: application/json');
            echo json_encode($response = ['status' => 'true', 'data' => isset($queryData) ? $queryData : []]);
            return;
        }

        // query course
        $cwieCourse = $this->db->join('cwie_major', 'cwie_course.major_id = cwie_major.major_id', 'left')
            ->join('cwie_year', 'cwie_course.year_id = cwie_year.year_id', 'left')
            ->order_by('course_datetime', 'DESC')
            ->get_where('cwie_course');
        foreach ($cwieCourse->result() as $course) {
            $queryData[] = [
                'courseID' => $course->course_id,
                'courseYear' => $course->year_title,
                'courseCode' => $course->course_code,
                'courseName' => $course->course_name,
                'courseInfoFile' => $course->course_info_file,
                'courseInfoFileType' => $course->course_info_file_type,
                'majorNameTH' => $course->major_name_th
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => 'true', 'data' => isset($queryData) ? $queryData : []]);
    }

    public function onAddCourse()
    {
        if (!$this->checkPermission(['admin', 'major'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // validate courseYear
        $this->form_validation->set_rules('courseYear', '', 'trim|required');
        // validate courseGrade
        $this->form_validation->set_rules('courseGrade', '', 'trim|required');
        // validate courseCode
        $this->form_validation->set_rules('courseCode', '', 'trim');
        // validate courseName
        $this->form_validation->set_rules('courseName', '', 'trim|required');
        // validate courseNameEN
        $this->form_validation->set_rules('courseNameEN', '', 'trim');
        // validate courseISCED
        $this->form_validation->set_rules('courseISCED', '', 'trim');
        // validate courseCwieCategory
        $this->form_validation->set_rules('courseCwieCategory', '', 'trim');
        // validate courseHardSkills
        $this->form_validation->set_rules('courseHardSkills', '', 'trim');
        // validate courseSoftSkills
        $this->form_validation->set_rules('courseSoftSkills', '', 'trim');
        // validate courseProfession
        $this->form_validation->set_rules('courseProfession', '', 'trim');
        // validate courseTags
        $this->form_validation->set_rules('courseTags', '', 'trim');
        // validate courseChecoCode
        $this->form_validation->set_rules('courseChecoCode', '', 'trim');
        // validate courseChecoAcknowledge
        $this->form_validation->set_rules('courseChecoAcknowledge', '', 'trim');
        // validate courseChecoOperation
        $this->form_validation->set_rules('courseChecoOperation', '', 'trim');
        // validate courseCoordinatorName
        $this->form_validation->set_rules('courseCoordinatorName', '', 'trim|required');
        // validate courseCoordinatorSurname
        $this->form_validation->set_rules('courseCoordinatorSurname', '', 'trim|required');
        // validate courseCoordinatorTel
        $this->form_validation->set_rules('courseCoordinatorTel', '', 'trim|required');
        // validate courseCoordinatorEmail
        $this->form_validation->set_rules('courseCoordinatorEmail', '', 'trim');

        // On validation errors
        if (!$this->form_validation->run()) {
            $response = ['status' => false, 'errorMessage' => 'Validatation Error !'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // post course variable with xss clean
        if ($this->input->post('courseMajorID', true)) {
            $majorID = $this->input->post('courseMajorID', true);
        }
        $courseYear = $this->input->post('courseYear', true);
        $courseGrade = $this->input->post('courseGrade', true);
        $courseCode = $this->input->post('courseCode', true);
        $courseName = $this->input->post('courseName', true);
        $courseNameEN = $this->input->post('courseNameEN', true) ? $this->input->post('courseNameEN', true) : null;
        $courseISCED = $this->input->post('courseISCED', true) ? $this->input->post('courseISCED', true) : null;
        $courseCwieCategory = $this->input->post('courseCwieCategory', true) ? $this->input->post('courseCwieCategory', true) : null;
        $courseHardSkills = $this->input->post('courseHardSkills', true) ? $this->input->post('courseHardSkills', true) : null;
        $courseSoftSkills = $this->input->post('courseSoftSkills', true) ? $this->input->post('courseSoftSkills', true) : null;
        $courseProfession = $this->input->post('courseProfession', true) ? $this->input->post('courseProfession', true) : null;
        $courseTags = $this->input->post('courseTags', true) ? $this->input->post('courseTags', true) : null;
        $courseChecoCode = $this->input->post('courseChecoCode', true) ? $this->input->post('courseChecoCode', true) : null;
        $courseChecoAcknowledge = $this->input->post('courseChecoAcknowledge', true) ? $this->input->post('courseChecoAcknowledge', true) : null;
        $courseChecoOperation = $this->input->post('courseChecoOperation', true) ? $this->input->post('courseChecoOperation', true) : null;
        $courseCoordinatorName = $this->input->post('courseCoordinatorName', true);
        $courseCoordinatorSurname = $this->input->post('courseCoordinatorSurname', true);
        $courseCoordinatorTel = $this->input->post('courseCoordinatorTel', true);
        $courseCoordinatorEmail = $this->input->post('courseCoordinatorEmail', true) ? $this->input->post('courseCoordinatorEmail', true) : null;

        // course insert data
        $courseInsertData = [
            'year_id' => $courseYear,
            'course_code' => $courseCode,
            'course_name' => $courseName,
            'course_name_en' => $courseNameEN,
            'course_hard_skill' => $courseHardSkills,
            'course_soft_skill' => $courseSoftSkills,
            'course_grade' => $courseGrade,
            'course_category_id' => $courseCwieCategory,
            'isced_id' => $courseISCED,
            'profession_id' => $courseProfession,
            'course_coordinator_name' => $courseCoordinatorName,
            'course_coordinator_surname' => $courseCoordinatorSurname,
            'course_coordinator_tel' => $courseCoordinatorTel,
            'course_coordinator_email' => $courseCoordinatorEmail,
            'course_tags' => $courseTags,
            'course_checo_code' => $courseChecoCode,
            'course_checo_acknowledge' => $courseChecoAcknowledge,
            'course_checo_operation' => $courseChecoOperation,
            'major_id' => isset($majorID) ? $majorID : $this->session->userdata('crudSessionData')['crudId'],
        ];

        if (!$this->db->insert('cwie_course', $courseInsertData)) {
            $response = ['status' => false, 'errorMessage' => 'DB ERROR! : ' . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => true]);
    }

    public function onEditCourse()
    {
        if (!$this->checkPermission(['admin', 'major'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // validate courseYear
        $this->form_validation->set_rules('courseYear', '', 'trim|required');
        // validate courseGrade
        $this->form_validation->set_rules('courseGrade', '', 'trim|required');
        // validate courseCode
        $this->form_validation->set_rules('courseCode', '', 'trim');
        // validate courseName
        $this->form_validation->set_rules('courseName', '', 'trim|required');
        // validate courseNameEN
        $this->form_validation->set_rules('courseNameEN', '', 'trim');
        // validate courseISCED
        $this->form_validation->set_rules('courseISCED', '', 'trim');
        // validate courseCwieCategory
        $this->form_validation->set_rules('courseCwieCategory', '', 'trim');
        // validate courseHardSkills
        $this->form_validation->set_rules('courseHardSkills', '', 'trim');
        // validate courseSoftSkills
        $this->form_validation->set_rules('courseSoftSkills', '', 'trim');
        // validate courseProfession
        $this->form_validation->set_rules('courseProfession', '', 'trim');
        // validate courseTags
        $this->form_validation->set_rules('courseTags', '', 'trim');
        // validate courseChecoCode
        $this->form_validation->set_rules('courseChecoCode', '', 'trim');
        // validate courseChecoAcknowledge
        $this->form_validation->set_rules('courseChecoAcknowledge', '', 'trim');
        // validate courseChecoOperation
        $this->form_validation->set_rules('courseChecoOperation', '', 'trim');
        // validate courseCoordinatorName
        $this->form_validation->set_rules('courseCoordinatorName', '', 'trim|required');
        // validate courseCoordinatorSurname
        $this->form_validation->set_rules('courseCoordinatorSurname', '', 'trim|required');
        // validate courseCoordinatorTel
        $this->form_validation->set_rules('courseCoordinatorTel', '', 'trim|required');
        // validate courseCoordinatorEmail
        $this->form_validation->set_rules('courseCoordinatorEmail', '', 'trim');

        // On validation errors
        if (!$this->form_validation->run()) {
            $response = ['status' => false, 'errorMessage' => 'Validatation Error !'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // post course variable with xss clean
        $courseID = $this->input->post('courseID', true);
        if ($this->input->post('courseMajorID', true)) {
            $majorID = $this->input->post('courseMajorID', true);
        }
        $courseYear = $this->input->post('courseYear', true);
        $courseGrade = $this->input->post('courseGrade', true);
        $courseCode = $this->input->post('courseCode', true);
        $courseName = $this->input->post('courseName', true);
        $courseNameEN = $this->input->post('courseNameEN', true) ? $this->input->post('courseNameEN', true) : null;
        $courseISCED = $this->input->post('courseISCED', true) ? $this->input->post('courseISCED', true) : null;
        $courseCwieCategory = $this->input->post('courseCwieCategory', true) ? $this->input->post('courseCwieCategory', true) : null;
        $courseHardSkills = $this->input->post('courseHardSkills', true) ? $this->input->post('courseHardSkills', true) : null;
        $courseSoftSkills = $this->input->post('courseSoftSkills', true) ? $this->input->post('courseSoftSkills', true) : null;
        $courseProfession = $this->input->post('courseProfession', true) ? $this->input->post('courseProfession', true) : null;
        $courseTags = $this->input->post('courseTags', true) ? $this->input->post('courseTags', true) : null;
        $courseChecoCode = $this->input->post('courseChecoCode', true) ? $this->input->post('courseChecoCode', true) : null;
        $courseChecoAcknowledge = $this->input->post('courseChecoAcknowledge', true) ? $this->input->post('courseChecoAcknowledge', true) : null;
        $courseChecoOperation = $this->input->post('courseChecoOperation', true) ? $this->input->post('courseChecoOperation', true) : null;
        $courseCoordinatorName = $this->input->post('courseCoordinatorName', true);
        $courseCoordinatorSurname = $this->input->post('courseCoordinatorSurname', true);
        $courseCoordinatorTel = $this->input->post('courseCoordinatorTel', true);
        $courseCoordinatorEmail = $this->input->post('courseCoordinatorEmail', true) ? $this->input->post('courseCoordinatorEmail', true) : null;

        // course update data
        $courseUpdateData = [
            'year_id' => $courseYear,
            'course_code' => $courseCode,
            'course_name' => $courseName,
            'course_name_en' => $courseNameEN,
            'course_hard_skill' => $courseHardSkills,
            'course_soft_skill' => $courseSoftSkills,
            'course_grade' => $courseGrade,
            'course_category_id' => $courseCwieCategory,
            'isced_id' => $courseISCED,
            'profession_id' => $courseProfession,
            'course_coordinator_name' => $courseCoordinatorName,
            'course_coordinator_surname' => $courseCoordinatorSurname,
            'course_coordinator_tel' => $courseCoordinatorTel,
            'course_coordinator_email' => $courseCoordinatorEmail,
            'course_tags' => $courseTags,
            'course_checo_code' => $courseChecoCode,
            'course_checo_acknowledge' => $courseChecoAcknowledge,
            'course_checo_operation' => $courseChecoOperation,
            'major_id' => isset($majorID) ? $majorID : $this->session->userdata('crudSessionData')['crudId'],
        ];

        if (!$this->db->update('cwie_course', $courseUpdateData, array('course_id' => $courseID))) {
            $response = ['status' => false, 'errorMessage' => 'DB ERROR! : ' . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => true]);
    }

    public function onUploadCourseFile($courseID)
    {
        if (!$this->checkPermission(['admin', 'major'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        if ($courseID == null) {
            $response = ['status' => false, 'errorMessage' =>  "Parameter Not Found!"];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // if upload training file
        if (!empty($_FILES['file']['name'])) {
            // Load the string helper
            $this->load->helper('string');

            $config['upload_path'] = './assets/files/courseFiles';
            $config['allowed_types'] = 'xls|xlsx';
            $config['max_size'] = '10240'; // 10mb      

            $courseFileName = random_string('alnum', 30);
            $courseFileExtention = explode(".", $_FILES["file"]["name"]);
            $config['file_name'] = $courseFileName . "." . $courseFileExtention[count($courseFileExtention) - 1];
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('file')) {
                $response = ['status' => false, 'errorMessage' => 'File Upload Error! : ' . $this->upload->display_errors()];
                header('Content-Type: application/json');
                echo json_encode($response);
                return;
            }

            $insertCourseFileData = [
                'course_info_file' => $courseFileName,
                'course_info_file_type' => '.' . $courseFileExtention[count($courseFileExtention) - 1],
            ];

            // query to check if there is an exist course file
            $queryExistCourseFile = $this->db->get_where('cwie_course', array('course_id' => $courseID));
            if ($queryExistCourseFile->row()->course_info_file != null) {
                if (file_exists('./assets/files/courseFiles/' . $queryExistCourseFile->row()->course_info_file . $queryExistCourseFile->row()->course_info_file_type)) {
                    unlink('./assets/files/courseFiles/' . $queryExistCourseFile->row()->course_info_file . $queryExistCourseFile->row()->course_info_file_type);
                }
            }

            if (!$this->db->update('cwie_course', $insertCourseFileData, array('course_id' => $courseID))) {
                if (file_exists('./assets/files/courseFiles/' . $courseFileName . "." . $courseFileExtention[count($courseFileExtention) - 1])) {
                    unlink('./assets/files/courseFiles/' . $courseFileName . "." . $courseFileExtention[count($courseFileExtention) - 1]);
                }
                $response = ['status' => false, 'errorMessage' => 'DB ERROR! : ' . $this->db->error()['message']];
                header('Content-Type: application/json');
                echo json_encode($response);
                return;
            }
        }

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => true]);
    }

    public function onDeleteCourse($courseID = null)
    {
        if (!$this->checkPermission(['admin', 'major'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // if course id not set
        if ($courseID == null) {
            $response = ['status' => false, 'errorMessage' => "Parameter Not Found!"];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // query course error
        $queryCourse = $this->db->get_where('cwie_course', array('course_id' => $courseID));

        // if not found course by id
        if ($queryCourse->num_rows() <= 0) {
            $response = ['status' => false, 'errorMessage' => "Course Not Found!"];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // query to check if there is an exist course file
        $queryExistCourseFile = $this->db->get_where('cwie_course', array('course_id' => $courseID));
        if ($queryExistCourseFile->row()->course_info_file != null) {
            if (file_exists('./assets/files/courseFiles/' . $queryExistCourseFile->row()->course_info_file . $queryExistCourseFile->row()->course_info_file_type)) {
                unlink('./assets/files/courseFiles/' . $queryExistCourseFile->row()->course_info_file . $queryExistCourseFile->row()->course_info_file_type);
            }
        }

        // if delete course error
        if (!$this->db->delete('cwie_course', array('course_id' => $courseID))) {
            $response = ['status' => false, 'errorMessage' => "DB Error! " . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => true]);
    }
}
