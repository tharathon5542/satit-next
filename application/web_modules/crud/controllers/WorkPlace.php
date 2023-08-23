<?php
defined('BASEPATH') or exit('No direct script access allowed');

class WorkPlace extends CI_Controller
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
        $response['page'] = 'Work Place';

        $this->load->view('z_template/header', $response);
        $this->load->view('workplace/workPlacePage', $response);
        $this->load->view('z_template/footer');
    }

    public function editModal($workplaceID = null)
    {
        if (!$this->checkPermission(['admin', 'major'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        if ($workplaceID == null) {
            $response = ['status' => false, 'errorMessage' =>  "Parameter Not Found!"];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        $response = [
            'status' => true,
            'queryData' => $this->getWorkPlace($workplaceID),
            'data' =>  $this->load->view('workplace/workplaceEditPage', null, true)
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

        $response = ['status' => true, 'data' =>  $this->load->view('workplace/workplaceAddPage', null, true)];
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    /*
    | --------------------------------------------------------------------------------
    | Functions Section
    | --------------------------------------------------------------------------------
    */

    public function getWorkPlace($workPlaceID = null)
    {
        if (!$this->checkPermission(['admin', 'major'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // query workplace by id
        if ($workPlaceID != null) {
            $queryWorkplace = $this->db->get_where('cwie_workplace', array('workplace_id' => $workPlaceID));

            if ($queryWorkplace->num_rows() <= 0) {
                header('Content-Type: application/json');
                echo json_encode($response = ['status' => 'false', 'errorMessage' => 'Workplace Not Found!']);
                return;
            }

            // query workplace course
            $workplaceCourse = $this->db->get_where('cwie_workplace_course', array('workplace_id' => $workPlaceID));
            foreach ($workplaceCourse->result() as $course) {
                $courseSet[] = [$course->course_id];
            }

            // query mou files
            $mouFiles = $this->db->get_where('cwie_workplace_mou_file', array('workplace_id' => $workPlaceID));
            foreach ($mouFiles->result() as $mouFile) {
                $mouFileSet[] = [
                    'mouID' => $mouFile->workplace_mou_id,
                    'mouDetail' => $mouFile->workplace_mou_detail,
                    'mouFileName' => $mouFile->workplace_mou_file,
                    'mouFileType' => $mouFile->workplace_mou_file_type,
                ];
            }

            $response = [
                'status' => 'true',
                'majorID' => $queryWorkplace->row()->major_id,
                'workplaceID' => $queryWorkplace->row()->workplace_id,
                'workplaceCourseSet' => isset($courseSet) ? $courseSet : [],
                'workplaceName' => $queryWorkplace->row()->workplace_name,
                'workplaceType' => $queryWorkplace->row()->workplace_type_id,
                'workplaceWorkType' => $queryWorkplace->row()->workplace_work_type,
                'workplaceAddress' => $queryWorkplace->row()->workplace_address,
                'workplaceZipcode' => $queryWorkplace->row()->workplace_zipcode,
                'workplaceSubDistrict' => $queryWorkplace->row()->workplace_sub_district,
                'workplaceDistrict' => $queryWorkplace->row()->workplace_district,
                'workplaceProvince' => $queryWorkplace->row()->workplace_province,
                'workplaceCountry' => $queryWorkplace->row()->workplace_country,
                'workplaceTel' => $queryWorkplace->row()->workplace_tel,
                'workplaceEmail' => $queryWorkplace->row()->workplace_email,
                'workplaceLat' => $queryWorkplace->row()->workplace_lat,
                'workplaceLong' => $queryWorkplace->row()->workplace_long,
                'wokrplaceMouFiles' => isset($mouFileSet) ? $mouFileSet : [],
                'workplaceStatus' => $queryWorkplace->row()->status,
            ];
            return $response;
        }

        // query work place major
        if ($this->session->userdata('crudSessionData')['crudPermission'] == 'major') {
            $queryWorkplace = $this->db->select('workplace_id, workplace_name, workplace_work_type, workplace_country, status')
                ->order_by('workplace_id', 'DESC')
                ->get_where('cwie_workplace', array('major_id' => $this->session->userdata('crudSessionData')['crudId']));
            foreach ($queryWorkplace->result() as $workplace) {
                $queryData[] = [
                    'workPlaceID' => $workplace->workplace_id,
                    'workPlaceName' => $workplace->workplace_name,
                    'workPlaceWorkType' => $workplace->workplace_work_type,
                    'workPlaceCountry' => $workplace->workplace_country,
                    'workPlaceStatus' => $workplace->status == '0' ? 'รอการตรวจสอบ' : 'ผ่านการตรวจสอบแล้ว',
                ];
            }
            header('Content-Type: application/json');
            echo json_encode($response = ['status' => 'true', 'data' => isset($queryData) ? $queryData : []]);
            return;
        }

        // query work place
        $queryWorkplace = $this->db->select('workplace_id, workplace_name, workplace_work_type, workplace_country, status')
            ->order_by('workplace_id', 'DESC')
            ->get('cwie_workplace');
        foreach ($queryWorkplace->result() as $workplace) {
            $queryData[] = [
                'workPlaceID' => $workplace->workplace_id,
                'workPlaceName' => $workplace->workplace_name,
                'workPlaceWorkType' => $workplace->workplace_work_type,
                'workPlaceCountry' => $workplace->workplace_country,
                'workPlaceStatus' => $workplace->status == '0' ? 'รอการตรวจสอบ' : 'ผ่านการตรวจสอบแล้ว',
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => 'true', 'data' => isset($queryData) ? $queryData : []]);
    }

    public function onAddWorkplace()
    {
        if (!$this->checkPermission(['admin', 'major'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // validate courseID
        $this->form_validation->set_rules('courseID[]', '', 'trim|required');
        // validate workplaceName
        $this->form_validation->set_rules('workplaceName', '', 'trim|required');
        // validate workplaceWorkType
        $this->form_validation->set_rules('workplaceWorkType', '', 'trim|required');
        // validate workplaceType
        $this->form_validation->set_rules('workplaceType', '', 'trim|required');
        // validate workplaceTel
        $this->form_validation->set_rules('workplaceTel', '', 'trim|required');
        // validate workplaceEmail
        $this->form_validation->set_rules('workplaceEmail', '', 'trim|valid_email');
        // validate workplaceAddress
        $this->form_validation->set_rules('workplaceAddress', '', 'trim');
        // validate workplaceZipCode
        $this->form_validation->set_rules('workplaceZipCode', '', 'trim');
        // validate workplaceSubDistrict
        $this->form_validation->set_rules('workplaceSubDistrict', '', 'trim');
        // validate workplaceDistrict
        $this->form_validation->set_rules('workplaceDistrict', '', 'trim');
        // validate workplaceProvince
        $this->form_validation->set_rules('workplaceProvince', '', 'trim');
        // validate workplaceCountry
        $this->form_validation->set_rules('workplaceCountry', '', 'trim');
        // validate workplaceLat
        $this->form_validation->set_rules('workplaceLat', '', 'trim');
        // validate workplaceLong
        $this->form_validation->set_rules('workplaceLong', '', 'trim');

        // On validation errors
        if (!$this->form_validation->run()) {
            $response = ['status' => false, 'errorMessage' => 'Validatation Error !'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // post faculty variable with xss clean
        $majorID = $this->input->post('majorID', true) ? $this->input->post('majorID', true) : $this->session->userdata('crudSessionData')['crudId'];
        $courseID = $this->input->post('courseID', true);
        $workplaceName = $this->input->post('workplaceName', true);
        $workplaceWorkType = $this->input->post('workplaceWorkType', true);
        $workplaceType = $this->input->post('workplaceType', true);
        $workplaceTel = $this->input->post('workplaceTel', true);
        $workplaceEmail = $this->input->post('workplaceEmail', true) ? $this->input->post('workplaceEmail', true) : null;
        $workplaceAddress = $this->input->post('workplaceAddress', true) ? $this->input->post('workplaceAddress', true) : null;
        $workplaceZipCode = $this->input->post('workplaceZipCode', true) ? $this->input->post('workplaceZipCode', true) : null;
        $workplaceSubDistrict = $this->input->post('workplaceSubDistrict', true) ? $this->input->post('workplaceSubDistrict', true) : null;
        $workplaceDistrict = $this->input->post('workplaceDistrict', true) ? $this->input->post('workplaceDistrict', true) : null;
        $workplaceProvince = $this->input->post('workplaceProvince', true) ? $this->input->post('workplaceProvince', true) : null;
        $workplaceCountry = $this->input->post('workplaceCountry', true) ? $this->input->post('workplaceCountry', true) : null;
        $workplaceLat = $this->input->post('workplaceLat', true) ? $this->input->post('workplaceLat', true) : null;
        $workplaceLong = $this->input->post('workplaceLong', true) ? $this->input->post('workplaceLong', true) : null;

        // workplace insert data
        $workplaceInsertData = [
            'workplace_name' => $workplaceName,
            'workplace_type_id' => $workplaceType,
            'workplace_work_type' => $workplaceWorkType,
            'workplace_address' => $workplaceAddress,
            'workplace_zipcode' => $workplaceZipCode,
            'workplace_sub_district' => $workplaceSubDistrict,
            'workplace_district' => $workplaceDistrict,
            'workplace_province' => $workplaceProvince,
            'workplace_country' => $workplaceCountry,
            'workplace_tel' => $workplaceTel,
            'workplace_email' => $workplaceEmail,
            'workplace_lat' => $workplaceLat,
            'workplace_long' => $workplaceLong,
            'status' => '0',
            'major_id' => $majorID,
        ];

        $this->db->trans_begin();

        if (!$this->db->insert('cwie_workplace', $workplaceInsertData)) {
            $response = ['status' => false, 'errorMessage' => 'DB ERROR! workplace step : ' . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        $workplaceID = $this->db->insert_id();

        foreach ($courseID as $id) {
            // personnel course insert data
            $workplaceCourseData = [
                'workplace_id' => $workplaceID,
                'course_id' => $id
            ];

            // insert personnel course
            if (!$this->db->insert('cwie_workplace_course', $workplaceCourseData)) {
                $this->db->trans_rollback();
                $response = ['status' => false, 'errorMessage' => 'DB ERROR! : ' . $this->db->error()['message']];
                header('Content-Type: application/json');
                echo json_encode($response);
                return;
            }
        }

        // if upload training file
        if (!empty($_FILES['mouFile']['name'])) {

            // Load the string helper
            $this->load->helper('string');

            $config['upload_path'] = './assets/files/mouFiles';
            $config['allowed_types'] = 'doc|docx|pdf|jpg|jpeg|png';
            $config['max_size'] = '10240'; // 10mb

            $uploadedFilePath = array();

            for ($i = 0; $i < count($_FILES['mouFile']['name']); $i++) {

                $mouDetail = $this->input->post('mouDetail', true)[$i];

                $mouFileName = random_string('alnum', 30);
                $mouFileExtention = explode(".", $_FILES["mouFile"]["name"][$i]);
                $config['file_name'] = $mouFileName . "." . $mouFileExtention[count($mouFileExtention) - 1];
                $this->upload->initialize($config);

                $_FILES['file']['name'] = $_FILES['mouFile']['name'][$i];
                $_FILES['file']['type'] = $_FILES['mouFile']['type'][$i];
                $_FILES['file']['tmp_name'] = $_FILES['mouFile']['tmp_name'][$i];
                $_FILES['file']['error'] = $_FILES['mouFile']['error'][$i];
                $_FILES['file']['size'] = $_FILES['mouFile']['size'][$i];

                if (!$this->upload->do_upload('file')) {
                    $this->db->trans_rollback();

                    // Delete the uploaded file
                    foreach ($uploadedFilePath as $filePath) {
                        unlink('./assets/files/mouFiles/' . $filePath);
                    }

                    $response = ['status' => false, 'errorMessage' => 'File Upload Error! : ' . $this->upload->display_errors()];
                    header('Content-Type: application/json');
                    echo json_encode($response);
                    return;
                }

                $uploadedFilePath[] .= $mouFileName . "." . $mouFileExtention[count($mouFileExtention) - 1];

                $insertMouFileData = [
                    'workplace_id' => $workplaceID,
                    'workplace_mou_detail' => $mouDetail,
                    'workplace_mou_file' => $mouFileName,
                    'workplace_mou_file_type' => '.' . $mouFileExtention[count($mouFileExtention) - 1],
                ];

                if (!$this->db->insert('cwie_workplace_mou_file', $insertMouFileData)) {
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
        echo json_encode($response = ['status' => true, 'message' => 'เพิ่มข้อมูลเครือข่าย CWIE แล้ว']);
    }

    public function onEditWorkplace()
    {
        if (!$this->checkPermission(['admin', 'major'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // validate courseID
        $this->form_validation->set_rules('courseID[]', '', 'trim|required');
        // validate workplaceName
        $this->form_validation->set_rules('workplaceName', '', 'trim|required');
        // validate workplaceWorkType
        $this->form_validation->set_rules('workplaceWorkType', '', 'trim|required');
        // validate workplaceType
        $this->form_validation->set_rules('workplaceType', '', 'trim|required');
        // validate workplaceTel
        $this->form_validation->set_rules('workplaceTel', '', 'trim|required');
        // validate workplaceEmail
        $this->form_validation->set_rules('workplaceEmail', '', 'trim|valid_email');
        // validate workplaceAddress
        $this->form_validation->set_rules('workplaceAddress', '', 'trim');
        // validate workplaceZipCode
        $this->form_validation->set_rules('workplaceZipCode', '', 'trim');
        // validate workplaceSubDistrict
        $this->form_validation->set_rules('workplaceSubDistrict', '', 'trim');
        // validate workplaceDistrict
        $this->form_validation->set_rules('workplaceDistrict', '', 'trim');
        // validate workplaceProvince
        $this->form_validation->set_rules('workplaceProvince', '', 'trim');
        // validate workplaceCountry
        $this->form_validation->set_rules('workplaceCountry', '', 'trim');
        // validate workplaceLat
        $this->form_validation->set_rules('workplaceLat', '', 'trim');
        // validate workplaceLong
        $this->form_validation->set_rules('workplaceLong', '', 'trim');

        // On validation errors
        if (!$this->form_validation->run()) {
            $response = ['status' => false, 'errorMessage' => 'Validatation Error !'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // post faculty variable with xss clean
        $workplaceID = $this->input->post('workplaceID', true);
        if ($this->input->post('workplaceStatus', true) != null) {
            $workplaceStatus = $this->input->post('workplaceStatus', true);
        }
        $courseID = $this->input->post('courseID', true);
        $workplaceName = $this->input->post('workplaceName', true);
        $workplaceWorkType = $this->input->post('workplaceWorkType', true);
        $workplaceType = $this->input->post('workplaceType', true);
        $workplaceTel = $this->input->post('workplaceTel', true);
        $workplaceEmail = $this->input->post('workplaceEmail', true) ? $this->input->post('workplaceEmail', true) : null;
        $workplaceAddress = $this->input->post('workplaceAddress', true) ? $this->input->post('workplaceAddress', true) : null;
        $workplaceZipCode = $this->input->post('workplaceZipCode', true) ? $this->input->post('workplaceZipCode', true) : null;
        $workplaceSubDistrict = $this->input->post('workplaceSubDistrict', true) ? $this->input->post('workplaceSubDistrict', true) : null;
        $workplaceDistrict = $this->input->post('workplaceDistrict', true) ? $this->input->post('workplaceDistrict', true) : null;
        $workplaceProvince = $this->input->post('workplaceProvince', true) ? $this->input->post('workplaceProvince', true) : null;
        $workplaceCountry = $this->input->post('workplaceCountry', true) ? $this->input->post('workplaceCountry', true) : null;
        $workplaceLat = $this->input->post('workplaceLat', true) ? $this->input->post('workplaceLat', true) : null;
        $workplaceLong = $this->input->post('workplaceLong', true) ? $this->input->post('workplaceLong', true) : null;

        $mouID = $this->input->post('mouID', true);
        $mouDetail = $this->input->post('mouDetail', true);

        // workplace Update data
        $workplaceUpdateData = [
            'workplace_name' => $workplaceName,
            'workplace_type_id' => $workplaceType,
            'workplace_work_type' => $workplaceWorkType,
            'workplace_address' => $workplaceAddress,
            'workplace_zipcode' => $workplaceZipCode,
            'workplace_sub_district' => $workplaceSubDistrict,
            'workplace_district' => $workplaceDistrict,
            'workplace_province' => $workplaceProvince,
            'workplace_country' => $workplaceCountry,
            'workplace_tel' => $workplaceTel,
            'workplace_email' => $workplaceEmail,
            'workplace_lat' => $workplaceLat,
            'workplace_long' => $workplaceLong,
        ];

        if (isset($workplaceStatus)) {
            $workplaceUpdateData['status'] = $workplaceStatus;
        }

        $this->db->trans_begin();

        if (!$this->db->update('cwie_workplace', $workplaceUpdateData, array('workplace_id' => $workplaceID))) {
            $response = ['status' => false, 'errorMessage' => 'DB ERROR! : ' . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // delete old workplace course
        if (!$this->db->delete('cwie_workplace_course', array('workplace_id' => $workplaceID))) {
            $this->db->trans_rollback();
            $response = ['status' => false, 'errorMessage' => 'DB ERROR! : ' . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        foreach ($courseID as $id) {
            // personnel course insert data
            $workplaceCourseData = [
                'workplace_id' => $workplaceID,
                'course_id' => $id
            ];

            // insert personnel course
            if (!$this->db->insert('cwie_workplace_course', $workplaceCourseData)) {
                $this->db->trans_rollback();
                $response = ['status' => false, 'errorMessage' => 'DB ERROR! : ' . $this->db->error()['message']];
                header('Content-Type: application/json');
                echo json_encode($response);
                return;
            }
        }

        // update exist mou file data
        if (count($mouID) > 0) {
            // Load the string helper
            $this->load->helper('string');

            $config['upload_path'] = './assets/files/mouFiles';
            $config['allowed_types'] = 'doc|docx|pdf|jpg|jpeg|png';
            $config['max_size'] = '10240'; // 10mb

            for ($i = 0; $i < count($mouID); $i++) {

                // quest old exist file
                $queryOldExistFile = $this->db->select('workplace_mou_file, workplace_mou_file_type')->get_where('cwie_workplace_mou_file', array('workplace_mou_id' => $mouID[$i]));

                if (!empty($_FILES['mouFile']['name'][$i])) {
                    $mouFileName = random_string('alnum', 30);
                    $mouFileExtention = explode(".", $_FILES["mouFile"]["name"][$i]);
                    $config['file_name'] = $mouFileName . "." . $mouFileExtention[count($mouFileExtention) - 1];
                    $this->upload->initialize($config);

                    $_FILES['file']['name'] = $_FILES['mouFile']['name'][$i];
                    $_FILES['file']['type'] = $_FILES['mouFile']['type'][$i];
                    $_FILES['file']['tmp_name'] = $_FILES['mouFile']['tmp_name'][$i];
                    $_FILES['file']['error'] = $_FILES['mouFile']['error'][$i];
                    $_FILES['file']['size'] = $_FILES['mouFile']['size'][$i];

                    if (!$this->upload->do_upload('file')) {
                        $this->db->trans_rollback();
                        $response = ['status' => false, 'errorMessage' => 'File Upload Error! : ' . $this->upload->display_errors()];
                        header('Content-Type: application/json');
                        echo json_encode($response);
                        return;
                    }

                    $filePath = $queryOldExistFile->row()->workplace_mou_file . $queryOldExistFile->row()->workplace_mou_file_type;
                    if (file_exists('./assets/files/mouFiles/' . $filePath)) {
                        unlink('./assets/files/mouFiles/' . $filePath);
                    }
                }

                $updateExistMouFileData = [
                    'workplace_mou_detail' =>  $mouDetail[$i],
                    'workplace_mou_file' =>  isset($mouFileName) ? $mouFileName : $queryOldExistFile->row()->workplace_mou_file,
                    'workplace_mou_file_type' => isset($mouFileExtention) ? '.' . $mouFileExtention[count($mouFileExtention) - 1]  : $queryOldExistFile->row()->workplace_mou_file_type,
                ];

                if (!$this->db->update('cwie_workplace_mou_file', $updateExistMouFileData, array('workplace_mou_id' => $mouID[$i]))) {
                    $this->db->trans_rollback();
                    $response = ['status' => false, 'errorMessage' => 'DB ERROR! : ' . $this->db->error()['message']];
                    header('Content-Type: application/json');
                    echo json_encode($response);
                    return;
                }
            }
        }

        // if new mou file upload
        if (count($mouDetail) > count($mouID)) {
            // Load the string helper
            $this->load->helper('string');

            $config['upload_path'] = './assets/files/mouFiles';
            $config['allowed_types'] = 'doc|docx|pdf|jpg|jpeg|png';
            $config['max_size'] = '10240'; // 10mb

            $uploadedFilePath = array();

            for ($i = count($mouID); $i < count($mouDetail); $i++) {

                $mouDetail = $this->input->post('mouDetail', true)[$i];

                $mouFileName = random_string('alnum', 30);
                $mouFileExtention = explode(".", $_FILES["mouFile"]["name"][$i]);
                $config['file_name'] = $mouFileName . "." . $mouFileExtention[count($mouFileExtention) - 1];
                $this->upload->initialize($config);

                $_FILES['file']['name'] = $_FILES['mouFile']['name'][$i];
                $_FILES['file']['type'] = $_FILES['mouFile']['type'][$i];
                $_FILES['file']['tmp_name'] = $_FILES['mouFile']['tmp_name'][$i];
                $_FILES['file']['error'] = $_FILES['mouFile']['error'][$i];
                $_FILES['file']['size'] = $_FILES['mouFile']['size'][$i];

                if (!$this->upload->do_upload('file')) {
                    $this->db->trans_rollback();

                    // Delete the uploaded file
                    foreach ($uploadedFilePath as $filePath) {
                        unlink('./assets/files/mouFiles/' . $filePath);
                    }

                    $response = ['status' => false, 'errorMessage' => 'File Upload Error! : ' . $this->upload->display_errors()];
                    header('Content-Type: application/json');
                    echo json_encode($response);
                    return;
                }

                $uploadedFilePath[] .= $mouFileName . "." . $mouFileExtention[count($mouFileExtention) - 1];

                $insertMouFileData = [
                    'workplace_id' => $workplaceID,
                    'workplace_mou_detail' => $mouDetail,
                    'workplace_mou_file' => $mouFileName,
                    'workplace_mou_file_type' => '.' . $mouFileExtention[count($mouFileExtention) - 1],
                ];

                if (!$this->db->insert('cwie_workplace_mou_file', $insertMouFileData)) {
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
        echo json_encode($response = ['status' => true, 'message' => 'แก้ไขข้อมูลเครือข่าย CWIE แล้ว']);
    }

    public function onDeleteworkPlace($workplaceID = null)
    {
        if (!$this->checkPermission(['admin', 'major'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // if workplaceID id not set
        if ($workplaceID == null) {
            $response = ['status' => false, 'errorMessage' => "Parameter Not Found!"];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // query workplace error
        $queryWorkplace = $this->db->get_where('cwie_workplace', array('workplace_id' => $workplaceID));

        // if not found workplace by id
        if ($queryWorkplace->num_rows() <= 0) {
            $response = ['status' => false, 'errorMessage' => "Workplace Not Found!"];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // if delete workplace error
        if (!$this->db->delete('cwie_workplace', array('workplace_id' => $workplaceID))) {
            $response = ['status' => false, 'errorMessage' => "DB Error! " . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => true]);
    }

    public function onDeleteMouFile($fileID = null)
    {
        if (!$this->checkPermission(['admin', 'major'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // if fileID not set
        if ($fileID == null) {
            $response = ['status' => false, 'errorMessage' => "Parameter Not Found!"];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        $this->db->trans_begin();

        // if query mou File error
        if (!$queryMoulFile = $this->db->get_where('cwie_workplace_mou_file', array('workplace_mou_id' => $fileID))) {
            $response = ['status' => false, 'errorMessage' => "DB Error! " . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // if not found mou File by id
        if ($queryMoulFile->num_rows() <= 0) {
            $response = ['status' => false, 'errorMessage' => "MOU File Not Found!"];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // if delete MOU File data error
        if (!$this->db->delete('cwie_workplace_mou_file', array('workplace_mou_id' => $queryMoulFile->row()->workplace_mou_id))) {
            $response = ['status' => false, 'errorMessage' => "DB Error! " . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        $filePath = $queryMoulFile->row()->workplace_mou_file . $queryMoulFile->row()->workplace_mou_file_type;

        if (file_exists('./assets/files/mouFiles/' . $filePath)) {
            // unlink file
            if (!unlink('./assets/files/mouFiles/' . $filePath)) {

                $this->db->trans_rollback();

                $response = ['status' => false, 'errorMessage' => 'Failed to unlink MOU file : ' . error_get_last()['message']];
                header('Content-Type: application/json');
                echo json_encode($response);
                return;
            }
        }

        $this->db->trans_commit();

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => true, 'message' => 'ลบไฟล์แล้ว']);
    }
}
