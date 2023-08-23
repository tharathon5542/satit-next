<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Students extends CI_Controller
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
    public function list($courseID = null)
    {
        if (!$this->checkPermission(['admin', 'major'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        if ($courseID == null) {
            $response = ['status' => false, 'errorMessage' => 'Parameter Not Found!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        $response = $this->mainVariable();
        $response['page'] = 'Students';

        $courseData = $this->db->get_where('cwie_course', array('course_id' => $courseID));
        if ($courseData->num_rows() <= 0) {
            $response = ['status' => false, 'errorMessage' => 'Course Not Found!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        $response['courseData'] = $courseData;

        $this->load->view('z_template/header', $response);
        $this->load->view('students/studentsPage', $response);
        $this->load->view('z_template/footer');
    }
    /*
    | --------------------------------------------------------------------------------
    | Functions Section
    | --------------------------------------------------------------------------------
    */

    public function getStudentInCourse($courseID = null)
    {
        if (!$this->checkPermission(['admin', 'major'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        if ($courseID == null) {
            header('Content-Type: application/json');
            echo json_encode($response = ['status' => 'false', 'errorMessage' => 'Parameter Not Found!']);
            return;
        }

        // query student in course data
        $queryStudentData = $this->db->order_by('student_id', 'DESC')->get_where('cwie_students', array('course_id' => $courseID));
        foreach ($queryStudentData->result() as $studentData) {

            $apiStudentData = $this->getStudent($studentData->student_code, true);

            $queryData[] = [
                'studentID' => $studentData->student_id,
                'studentCode' => $studentData->student_code,
                'studentNameSurname' => $apiStudentData->studentData[0]->pname . $apiStudentData->studentData[0]->fname . ' ' . $apiStudentData->studentData[0]->lname,
                'studentMajor' => $apiStudentData->studentData[0]->major_name,
                'studentFaculty' => $apiStudentData->studentData[0]->faculty,
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => 'true', 'data' => isset($queryData) ? $queryData : []]);
    }

    public function getStudent($studentCode = null, $returnVariable = false)
    {
        if ($studentCode == null) {
            header('Content-Type: application/json');
            echo json_encode($response = ['status' => 'false', 'errorMessage' => 'Parameter Not Found!']);
            return;
        }

        $url = 'https://orasis.crru.ac.th/orasis_crru/mis_export/clli_student_link/get_student';
        $myvars = 'citizen_id=' . $studentCode . '&token=' . 'CLLI@CRRU#ACCESS2022@DATALINKCHECKING!!';

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $myvars);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        if ($returnVariable) {
            return json_decode(curl_exec($ch));
        }

        $response = json_decode(curl_exec($ch));

        header('Content-Type: application/json');
        echo json_encode($response);
        return;
    }

    public function onSubmitStudent()
    {
        if (!$this->checkPermission(['admin', 'major'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // validate courseID
        $this->form_validation->set_rules('courseID', '', 'trim|required');

        // On validation errors
        if (!$this->form_validation->run()) {
            $response = ['status' => false, 'errorMessage' => 'Validatation Error !'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        $courseID = $this->input->post('courseID', true);
        $studentID = $this->input->post('studentID', true);
        $studentCode = $this->input->post('studentCode', true);

        $this->db->trans_begin();

        if (count($studentID) > 0) {
            $c = 0;
            for ($i = count($studentCode) - count($studentID); $i <= count($studentID); $i++) {
                $studentUpdateData = [
                    'student_code' => $studentCode[$i]
                ];
                if (!$this->db->update('cwie_students', $studentUpdateData, array('student_id' => $studentID[$c]))) {
                    $this->db->trans_rollback();
                    $response = ['status' => false, 'errorMessage' => 'DB ERROR! : ' . $this->db->error()['message']];
                    header('Content-Type: application/json');
                    echo json_encode($response);
                    return;
                }
                $c++;
            }
        }

        if (count($studentCode) > count($studentID)) {
            $reverseStudentCode = array_reverse($studentCode);
            for ($i = count($studentID); $i < count($studentCode); $i++) {
                // if empty string
                if ($reverseStudentCode[$i] == '') {
                    continue;
                }
                // check duplicate student code in course
                $queryCheckDuplicateStudentCode = $this->db->get_where('cwie_students', array('student_code' =>  $reverseStudentCode[$i], 'course_id' => $courseID));
                if ($queryCheckDuplicateStudentCode->num_rows() > 0) {
                    continue;
                }
                // insert student data
                $studentInsertData = [
                    'student_code' => $reverseStudentCode[$i],
                    'course_id' => $courseID
                ];
                if (!$this->db->insert('cwie_students', $studentInsertData)) {
                    $this->db->trans_rollback();
                    $response = ['status' => false, 'errorMessage' => 'DB ERROR! : ' . $this->db->error()['message']];
                    header('Content-Type: application/json');
                    echo json_encode($response);
                    return;
                }
            }
        }

        $this->db->trans_commit();

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => true]);
    }

    public function onDeleteStudent($studentID = null)
    {
        if (!$this->checkPermission(['admin', 'major'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // if studentID id not set
        if ($studentID == null) {
            $response = ['status' => false, 'errorMessage' => "Parameter Not Found!"];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // if delete student error
        if (!$this->db->delete('cwie_students', array('student_id' => $studentID))) {
            $response = ['status' => false, 'errorMessage' => "DB Error! " . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => true]);
    }
}
