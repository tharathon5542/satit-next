<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Personnel extends CI_Controller
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
        $response['page'] = 'CWIE Personnel';

        $this->load->view('z_template/header', $response);
        $this->load->view('cwiePersonnel/cwiePersonnelPage', $response);
        $this->load->view('z_template/footer');
    }

    public function editModal($personnelID = null)
    {
        if (!$this->checkPermission(['admin', 'major'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        if ($personnelID == null) {
            $response = ['status' => false, 'errorMessage' =>  "Parameter Not Found!"];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        $response = [
            'status' => true,
            'queryData' => $this->getPersonnel($personnelID),
            'data' =>  $this->load->view('cwiePersonnel/cwiePersonnelEditPage', null, true)
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

        $response = ['status' => true, 'data' =>  $this->load->view('cwiepersonnel/cwiePersonnelAddPage', null, true)];
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    /*
    | --------------------------------------------------------------------------------
    | Functions Section
    | --------------------------------------------------------------------------------
    */

    public function getPersonnel($personnelID = null)
    {
        if (!$this->checkPermission(['admin', 'major'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // query personnel by id
        if ($personnelID != null) {
            $queryPersonnel = $this->db->get_where('cwie_personnel', array('cwie_personnel.personnel_id' => $personnelID));

            if ($queryPersonnel->num_rows() <= 0) {
                header('Content-Type: application/json');
                echo json_encode($response = ['status' => 'false', 'errorMessage' => 'Personnel Not Found!']);
                return;
            }

            // query personnel course
            $personnelCourse = $this->db->get_where('cwie_personnel_course', array('personnel_id' => $personnelID));
            foreach ($personnelCourse->result() as $course) {
                $courseSet[] = [$course->course_id];
            }

            // query personnel training files
            $personnelTrainingFile = $this->db->get_where('cwie_personnel_training_file', array('personnel_id' => $personnelID));
            foreach ($personnelTrainingFile->result() as $trainingFile) {
                $trainingFileSet[] = [
                    'trainingFileID' => $trainingFile->personnel_training_file_id,
                    'trainingID' => $trainingFile->personnel_training_id,
                    'trainingDate' => $trainingFile->personnel_training_file_date,
                    'trainingFile' => $trainingFile->personnel_training_file,
                    'trainingFileType' => $trainingFile->personnel_training_file_type,
                ];
            }

            // query personnel trophy files
            $personnelTrophyFile = $this->db->get_where('cwie_personnel_trophy_file', array('personnel_id' => $personnelID));
            foreach ($personnelTrophyFile->result() as $trophyFile) {
                $trophyFileSet[] = [
                    'trophyFileID' => $trophyFile->personnel_trophy_file_id,
                    'trophyID' => $trophyFile->personnel_trophy_id,
                    'trophyDate' => $trophyFile->personnel_trophy_file_date,
                    'trophyFile' => $trophyFile->personnel_trophy_file,
                    'trophyFileType' => $trophyFile->personnel_trophy_file_type,
                ];
            }

            $response = [
                'personnelID' => $personnelID,
                'personnelCourseSet' => isset($courseSet) ? $courseSet : [],
                'personnelCitizenID' => $queryPersonnel->row()->personnel_cityzen_id,
                'personnelTypeID' => $queryPersonnel->row()->personnel_type_id,
                'personnelName' => $queryPersonnel->row()->personnel_name,
                'personnelSurname' => $queryPersonnel->row()->personnel_surname,
                'personnelTel' => $queryPersonnel->row()->personnel_tel,
                'personnelPosition' => $queryPersonnel->row()->personnel_postion,
                'personnelEmail' => $queryPersonnel->row()->personnel_email,
                'personnelMajorID' => $queryPersonnel->row()->major_id,
                'personnelEXP' => $queryPersonnel->row()->personnel_exp,
                'personnelTrainingFiles' => isset($trainingFileSet) ? $trainingFileSet : [],
                'personnelTrophyFiles' => isset($trophyFileSet) ? $trophyFileSet : []
            ];
            return $response;
        }

        // query personnel by major
        if ($this->session->userdata('crudSessionData')['crudPermission'] == 'major') {
            // query personnel
            $queryPersonnel = $this->db
                ->order_by('personnel_id', 'DESC')
                ->get_where('cwie_personnel', array('major_id' => $this->session->userdata('crudSessionData')['crudId']));
            foreach ($queryPersonnel->result() as $personnel) {
                $queryData[] = [
                    'personnelID' => $personnel->personnel_id,
                    'personnelName' => $personnel->personnel_name . ' ' . $personnel->personnel_surname,
                    'personnelTel' => $personnel->personnel_tel,
                    'personnelEmail' => $personnel->personnel_email,
                ];
            }

            header('Content-Type: application/json');
            echo json_encode($response = ['status' => 'true', 'data' => isset($queryData) ? $queryData : []]);
            return;
        }

        // query personnel
        $queryPersonnel = $this->db
            ->order_by('personnel_id', 'DESC')
            ->get('cwie_personnel');
        foreach ($queryPersonnel->result() as $personnel) {
            $queryData[] = [
                'personnelID' => $personnel->personnel_id,
                'personnelName' => $personnel->personnel_name . ' ' . $personnel->personnel_surname,
                'personnelTel' => $personnel->personnel_tel,
                'personnelEmail' => $personnel->personnel_email,
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => 'true', 'data' => isset($queryData) ? $queryData : []]);
    }

    public function onAddPersonnel()
    {
        if (!$this->checkPermission(['admin', 'major'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // validate courseID
        $this->form_validation->set_rules('courseID[]', '', 'trim|required');
        // validate personnelCitizenID
        $this->form_validation->set_rules('personnelCitizenID', '', 'trim|required');
        // validate personnelType
        $this->form_validation->set_rules('personnelType', '', 'trim|required');
        // validate personnelName
        $this->form_validation->set_rules('personnelName', '', 'trim|required');
        // validate personnelSurname
        $this->form_validation->set_rules('personnelSurname', '', 'trim|required');
        // validate personnelTel
        $this->form_validation->set_rules('personnelTel', '', 'trim|required');
        // validate personnelEmail
        $this->form_validation->set_rules('personnelEmail', '', 'trim|valid_email');
        // validate personnelPosition
        $this->form_validation->set_rules('personnelPosition', '', 'trim');
        // validate personnelEXP
        $this->form_validation->set_rules('personnelEXP', '', 'trim');

        // On validation errors
        if (!$this->form_validation->run()) {
            $response = ['status' => false, 'errorMessage' => 'Validatation Error !'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // post personnel variable with xss clean
        if ($this->input->post('majorID', true)) {
            $majorID = $this->input->post('majorID', true);
        }
        $courseID = $this->input->post('courseID', true);
        $personnelCitizenID = $this->input->post('personnelCitizenID', true);
        $personnelType = $this->input->post('personnelType', true);
        $personnelName = $this->input->post('personnelName', true);
        $personnelSurname = $this->input->post('personnelSurname', true);
        $personnelTel = $this->input->post('personnelTel', true);
        $personnelPosition = $this->input->post('personnelPosition', true) ? $this->input->post('personnelPosition', true) : null;
        $personnelEmail = $this->input->post('personnelEmail', true) ? $this->input->post('personnelEmail', true) : null;
        $personnelEXP = $this->input->post('personnelEXP', true) ? $this->input->post('personnelEXP', true) : null;

        // personnel insert data
        $personnelInsertData = [
            'major_id' => isset($majorID) ? $majorID : $this->session->userdata('crudSessionData')['crudId'],
            'personnel_cityzen_id' => $personnelCitizenID,
            'personnel_type_id' => $personnelType,
            'personnel_name' => $personnelName,
            'personnel_surname' => $personnelSurname,
            'personnel_tel' => $personnelTel,
            'personnel_postion' => $personnelPosition,
            'personnel_email' => $personnelEmail,
            'personnel_exp' => $personnelEXP,
        ];

        $this->db->trans_begin();

        if (!$this->db->insert('cwie_personnel', $personnelInsertData)) {
            $response = ['status' => false, 'errorMessage' => 'DB ERROR! : ' . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        $personnelID = $this->db->insert_id();

        foreach ($courseID as $id) {
            // personnel course insert data
            $personnelCourseData = [
                'personnel_id' => $personnelID,
                'course_id' => $id
            ];

            // insert personnel course
            if (!$this->db->insert('cwie_personnel_course', $personnelCourseData)) {
                $this->db->trans_rollback();
                $response = ['status' => false, 'errorMessage' => 'DB ERROR! : ' . $this->db->error()['message']];
                header('Content-Type: application/json');
                echo json_encode($response);
                return;
            }
        }

        // if upload training file
        if (!empty($_FILES['personnelTrainingFile']['name'])) {

            // Load the string helper
            $this->load->helper('string');

            $config['upload_path'] = './assets/files/personnelFiles';
            $config['allowed_types'] = 'doc|docx|pdf|jpg|jpeg|png';
            $config['max_size'] = '10240'; // 10mb

            $uploadedFilePath = array();

            for ($i = 0; $i < count($_FILES['personnelTrainingFile']['name']); $i++) {

                $personnelTrainingID = $this->input->post('personnelTrainingID', true)[$i];
                $personnelTrainingDate = $this->input->post('personnelTrainingDate', true)[$i];

                $trainingFileName = random_string('alnum', 30);
                $trainingFileExtention = explode(".", $_FILES["personnelTrainingFile"]["name"][$i]);
                $config['file_name'] = $trainingFileName . "." . $trainingFileExtention[count($trainingFileExtention) - 1];
                $this->upload->initialize($config);

                $_FILES['TrainingFile']['name'] = $_FILES['personnelTrainingFile']['name'][$i];
                $_FILES['TrainingFile']['type'] = $_FILES['personnelTrainingFile']['type'][$i];
                $_FILES['TrainingFile']['tmp_name'] = $_FILES['personnelTrainingFile']['tmp_name'][$i];
                $_FILES['TrainingFile']['error'] = $_FILES['personnelTrainingFile']['error'][$i];
                $_FILES['TrainingFile']['size'] = $_FILES['personnelTrainingFile']['size'][$i];

                if (!$this->upload->do_upload('TrainingFile')) {
                    $this->db->trans_rollback();

                    // Delete the uploaded file
                    foreach ($uploadedFilePath as $filePath) {
                        unlink('./assets/files/personnelFiles/' . $filePath);
                    }

                    $response = ['status' => false, 'errorMessage' => 'File Upload Error! : ' . $this->upload->display_errors()];
                    header('Content-Type: application/json');
                    echo json_encode($response);
                    return;
                }

                $uploadedFilePath[] .= $trainingFileName . "." . $trainingFileExtention[count($trainingFileExtention) - 1];

                $insertPersonnelTrainingFileData = [
                    'personnel_id' => $personnelID,
                    'personnel_training_id' => $personnelTrainingID,
                    'personnel_training_file_date' => $personnelTrainingDate,
                    'personnel_training_file' => $trainingFileName,
                    'personnel_training_file_type' => '.' . $trainingFileExtention[count($trainingFileExtention) - 1],
                ];

                if (!$this->db->insert('cwie_personnel_training_file', $insertPersonnelTrainingFileData)) {
                    $this->db->trans_rollback();
                    $response = ['status' => false, 'errorMessage' => 'DB ERROR! : ' . $this->db->error()['message']];
                    header('Content-Type: application/json');
                    echo json_encode($response);
                    return;
                }
            }
        }

        // if upload trophy file
        if (!empty($_FILES['personnelTrophyFile']['name'])) {
            // Load the string helper
            $this->load->helper('string');

            $config['upload_path'] = './assets/files/personnelFiles';
            $config['allowed_types'] = 'doc|docx|pdf|jpg|jpeg|png';
            $config['max_size'] = '10240'; // 10mb

            $uploadedFilePath = array();

            for ($i = 0; $i < count($_FILES['personnelTrophyFile']['name']); $i++) {

                $personnelTrophyID = $this->input->post('personnelTrophyID', true)[$i];
                $personnelTrophyDate = $this->input->post('personnelTrophyDate', true)[$i];

                $trophyFileName = random_string('alnum', 30);
                $trophyFileExtention = explode(".", $_FILES["personnelTrophyFile"]["name"][$i]);
                $config['file_name'] = $trophyFileName . "." . $trophyFileExtention[count($trophyFileExtention) - 1];
                $this->upload->initialize($config);

                $_FILES['TrophyFile']['name'] = $_FILES['personnelTrophyFile']['name'][$i];
                $_FILES['TrophyFile']['type'] = $_FILES['personnelTrophyFile']['type'][$i];
                $_FILES['TrophyFile']['tmp_name'] = $_FILES['personnelTrophyFile']['tmp_name'][$i];
                $_FILES['TrophyFile']['error'] = $_FILES['personnelTrophyFile']['error'][$i];
                $_FILES['TrophyFile']['size'] = $_FILES['personnelTrophyFile']['size'][$i];

                if (!$this->upload->do_upload('TrophyFile')) {
                    $this->db->trans_rollback();

                    // Delete the uploaded file
                    foreach ($uploadedFilePath as $filePath) {
                        unlink('./assets/files/personnelFiles/' . $filePath);
                    }

                    $response = ['status' => false, 'errorMessage' => 'File Upload Error! : ' . $this->upload->display_errors()];
                    header('Content-Type: application/json');
                    echo json_encode($response);
                    return;
                }

                $uploadedFilePath[] = $trophyFileName . "." . $trophyFileExtention[count($trophyFileExtention) - 1];

                $insertPersonnelTrophyFileData = [
                    'personnel_id' => $personnelID,
                    'personnel_trophy_id' => $personnelTrophyID,
                    'personnel_trophy_file_date' => $personnelTrophyDate,
                    'personnel_trophy_file' => $trophyFileName,
                    'personnel_trophy_file_type' => '.' . $trophyFileExtention[count($trophyFileExtention) - 1],
                ];

                if (!$this->db->insert('cwie_personnel_trophy_file', $insertPersonnelTrophyFileData)) {
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

    public function onEditPersonnel()
    {
        if (!$this->checkPermission(['admin', 'major'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // validate courseID
        $this->form_validation->set_rules('courseID[]', '', 'trim|required');
        // validate personnelCitizenID
        $this->form_validation->set_rules('personnelCitizenID', '', 'trim|required');
        // validate personnelType
        $this->form_validation->set_rules('personnelType', '', 'trim|required');
        // validate personnelName
        $this->form_validation->set_rules('personnelName', '', 'trim|required');
        // validate personnelSurname
        $this->form_validation->set_rules('personnelSurname', '', 'trim|required');
        // validate personnelTel
        $this->form_validation->set_rules('personnelTel', '', 'trim|required');
        // validate personnelPosition
        $this->form_validation->set_rules('personnelPosition', '', 'trim');
        // validate personnelEmail
        $this->form_validation->set_rules('personnelEmail', '', 'trim|valid_email');
        // validate personnelEXP
        $this->form_validation->set_rules('personnelEXP', '', 'trim');

        // On validation errors
        if (!$this->form_validation->run()) {
            $response = ['status' => false, 'errorMessage' => 'Validatation Error !'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // post personnel variable with xss clean
        $personnelID = $this->input->post('personnelID', true);
        if ($this->input->post('majorID', true)) {
            $majorID = $this->input->post('majorID', true);
        }
        $courseID = $this->input->post('courseID', true);
        $personnelCitizenID = $this->input->post('personnelCitizenID', true);
        $personnelType = $this->input->post('personnelType', true);
        $personnelName = $this->input->post('personnelName', true);
        $personnelSurname = $this->input->post('personnelSurname', true);
        $personnelTel = $this->input->post('personnelTel', true);
        $personnelPosition = $this->input->post('personnelPosition', true) ? $this->input->post('personnelPosition', true) : null;
        $personnelEmail = $this->input->post('personnelEmail', true) ? $this->input->post('personnelEmail', true) : null;
        $personnelEXP = $this->input->post('personnelEXP', true) ? $this->input->post('personnelEXP', true) : null;

        $personnelTrainingFileID = $this->input->post('personnelTrainingFileID', true);
        $personnelTrainingID = $this->input->post('personnelTrainingID', true);
        $personnelTrainingDate = $this->input->post('personnelTrainingDate', true);

        $personnelTrophyFileID = $this->input->post('personnelTrophyFileID', true);
        $personnelTrophyID = $this->input->post('personnelTrophyID', true);
        $personnelTrophyDate = $this->input->post('personnelTrophyDate', true);

        // personnel update data
        $personnelUpdateData = [
            'major_id' => isset($majorID) ? $majorID : $this->session->userdata('crudSessionData')['crudId'],
            'personnel_cityzen_id' => $personnelCitizenID,
            'personnel_type_id' => $personnelType,
            'personnel_name' => $personnelName,
            'personnel_surname' => $personnelSurname,
            'personnel_tel' => $personnelTel,
            'personnel_postion' => $personnelPosition,
            'personnel_email' => $personnelEmail,
            'personnel_exp' => $personnelEXP,
        ];

        $this->db->trans_begin();

        if (!$this->db->update('cwie_personnel', $personnelUpdateData, array('personnel_id' => $personnelID))) {
            $response = ['status' => false, 'errorMessage' => 'DB ERROR! : ' . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // delete old personnel course
        if (!$this->db->delete('cwie_personnel_course', array('personnel_id' => $personnelID))) {
            $this->db->trans_rollback();
            $response = ['status' => false, 'errorMessage' => 'DB ERROR! : ' . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        foreach ($courseID as $id) {
            // personnel course insert data
            $personnelCourseData = [
                'personnel_id' => $personnelID,
                'course_id' => $id
            ];

            // insert personnel course
            if (!$this->db->insert('cwie_personnel_course', $personnelCourseData)) {
                $this->db->trans_rollback();
                $response = ['status' => false, 'errorMessage' => 'DB ERROR! : ' . $this->db->error()['message']];
                header('Content-Type: application/json');
                echo json_encode($response);
                return;
            }
        }

        // update exist personnel file
        if (count($personnelTrainingFileID) > 0) {

            // Load the string helper
            $this->load->helper('string');

            $config['upload_path'] = './assets/files/personnelFiles';
            $config['allowed_types'] = 'doc|docx|pdf|jpg|jpeg|png';
            $config['max_size'] = '10240'; // 10mb

            for ($i = 0; $i < count($personnelTrainingFileID); $i++) {

                // quest old exist file
                $queryOldExistFile = $this->db->select('personnel_training_file, personnel_training_file_type')->get_where('cwie_personnel_training_file', array('personnel_training_file_id' => $personnelTrainingFileID[$i]));

                if (!empty($_FILES['personnelTrainingFile']['name'][$i])) {
                    $trainingFileName = random_string('alnum', 30);
                    $trainingFileExtention = explode(".", $_FILES["personnelTrainingFile"]["name"][$i]);
                    $config['file_name'] = $trainingFileName . "." . $trainingFileExtention[count($trainingFileExtention) - 1];
                    $this->upload->initialize($config);

                    $_FILES['TrainingFile']['name'] = $_FILES['personnelTrainingFile']['name'][$i];
                    $_FILES['TrainingFile']['type'] = $_FILES['personnelTrainingFile']['type'][$i];
                    $_FILES['TrainingFile']['tmp_name'] = $_FILES['personnelTrainingFile']['tmp_name'][$i];
                    $_FILES['TrainingFile']['error'] = $_FILES['personnelTrainingFile']['error'][$i];
                    $_FILES['TrainingFile']['size'] = $_FILES['personnelTrainingFile']['size'][$i];

                    if (!$this->upload->do_upload('TrainingFile')) {
                        $this->db->trans_rollback();
                        $response = ['status' => false, 'errorMessage' => 'File Upload Error! : ' . $this->upload->display_errors()];
                        header('Content-Type: application/json');
                        echo json_encode($response);
                        return;
                    }

                    $filePath = $queryOldExistFile->row()->personnel_training_file . $queryOldExistFile->row()->personnel_training_file_type;
                    if (file_exists('./assets/files/personnelFiles/' . $filePath)) {
                        unlink('./assets/files/personnelFiles/' . $filePath);
                    }
                }

                $updateExistPersonnelFileData = [
                    'personnel_training_id' =>  $personnelTrainingID[$i],
                    'personnel_training_file_date' =>  $personnelTrainingDate[$i],
                    'personnel_training_file' =>  isset($trainingFileName) ? $trainingFileName : $queryOldExistFile->row()->personnel_training_file,
                    'personnel_training_file_type' => isset($trainingFileExtention) ? '.' . $trainingFileExtention[count($trainingFileExtention) - 1]  : $queryOldExistFile->row()->personnel_training_file_type,
                ];

                if (!$this->db->update('cwie_personnel_training_file', $updateExistPersonnelFileData, array('personnel_training_file_id' => $personnelTrainingFileID[$i]))) {
                    $this->db->trans_rollback();
                    $response = ['status' => false, 'errorMessage' => 'DB ERROR! : ' . $this->db->error()['message']];
                    header('Content-Type: application/json');
                    echo json_encode($response);
                    return;
                }
            }
        }

        if (count($personnelTrophyFileID) > 0) {

            for ($i = 0; $i < count($personnelTrophyFileID); $i++) {


                // unlink old exist file
                $queryOldExistFile = $this->db->select('personnel_trophy_file, personnel_trophy_file_type')->get_where('cwie_personnel_trophy_file', array('personnel_trophy_file_id' => $personnelTrophyFileID[$i]));

                if (!empty($_FILES['personnelTrophyFile']['name'][$i])) {
                    $trophyFileName = random_string('alnum', 30);
                    $trophyFileExtention = explode(".", $_FILES["personnelTrophyFile"]["name"][$i]);
                    $config['file_name'] = $trophyFileName . "." . $trophyFileExtention[count($trophyFileExtention) - 1];
                    $this->upload->initialize($config);

                    $_FILES['TrophyFile']['name'] = $_FILES['personnelTrophyFile']['name'][$i];
                    $_FILES['TrophyFile']['type'] = $_FILES['personnelTrophyFile']['type'][$i];
                    $_FILES['TrophyFile']['tmp_name'] = $_FILES['personnelTrophyFile']['tmp_name'][$i];
                    $_FILES['TrophyFile']['error'] = $_FILES['personnelTrophyFile']['error'][$i];
                    $_FILES['TrophyFile']['size'] = $_FILES['personnelTrophyFile']['size'][$i];

                    if (!$this->upload->do_upload('TrophyFile')) {
                        $this->db->trans_rollback();
                        $response = ['status' => false, 'errorMessage' => 'File Upload Error! : ' . $this->upload->display_errors()];
                        header('Content-Type: application/json');
                        echo json_encode($response);
                        return;
                    }

                    $filePath = $queryOldExistFile->row()->personnel_trophy_file . $queryOldExistFile->row()->personnel_trophy_file_type;
                    if (file_exists('./assets/files/personnelFiles/' . $filePath)) {
                        unlink('./assets/files/personnelFiles/' . $filePath);
                    }
                }

                $updateExistPersonnelFileData = [
                    'personnel_trophy_id' =>  $personnelTrophyID[$i],
                    'personnel_trophy_file_date' =>  $personnelTrophyDate[$i],
                    'personnel_trophy_file' =>  isset($trophyFileName) ? $trophyFileName : $queryOldExistFile->row()->personnel_trophy_file,
                    'personnel_trophy_file_type' =>  isset($trophyFileExtention) ? '.' . $trophyFileExtention[count($trophyFileExtention) - 1] : $queryOldExistFile->row()->personnel_trophy_file_type,
                ];

                if (!$this->db->update('cwie_personnel_trophy_file', $updateExistPersonnelFileData, array('personnel_trophy_file_id' => $personnelTrophyFileID[$i]))) {
                    $this->db->trans_rollback();
                    $response = ['status' => false, 'errorMessage' => 'DB ERROR! : ' . $this->db->error()['message']];
                    header('Content-Type: application/json');
                    echo json_encode($response);
                    return;
                }
            }
        }

        // if new personnel training file upload
        if (count($personnelTrainingID) > count($personnelTrainingFileID)) {
            // Load the string helper
            $this->load->helper('string');

            $config['upload_path'] = './assets/files/personnelFiles';
            $config['allowed_types'] = 'doc|docx|pdf|jpg|jpeg|png';
            $config['max_size'] = '10240'; // 10mb

            $uploadedFilePath = array();

            for ($i = count($personnelTrainingFileID); $i < count($personnelTrainingID); $i++) {

                $personnelTrainingID = $this->input->post('personnelTrainingID', true)[$i];
                $personnelTrainingDate = $this->input->post('personnelTrainingDate', true)[$i];

                $trainingFileName = random_string('alnum', 30);
                $trainingFileExtention = explode(".", $_FILES["personnelTrainingFile"]["name"][$i]);
                $config['file_name'] = $trainingFileName . "." . $trainingFileExtention[count($trainingFileExtention) - 1];
                $this->upload->initialize($config);

                $_FILES['TrainingFile']['name'] = $_FILES['personnelTrainingFile']['name'][$i];
                $_FILES['TrainingFile']['type'] = $_FILES['personnelTrainingFile']['type'][$i];
                $_FILES['TrainingFile']['tmp_name'] = $_FILES['personnelTrainingFile']['tmp_name'][$i];
                $_FILES['TrainingFile']['error'] = $_FILES['personnelTrainingFile']['error'][$i];
                $_FILES['TrainingFile']['size'] = $_FILES['personnelTrainingFile']['size'][$i];

                if (!$this->upload->do_upload('TrainingFile')) {
                    $this->db->trans_rollback();

                    // Delete the uploaded file
                    foreach ($uploadedFilePath as $filePath) {
                        unlink('./assets/files/personnelFiles/' . $filePath);
                    }

                    $response = ['status' => false, 'errorMessage' => 'File Upload Error! : ' . $this->upload->display_errors()];
                    header('Content-Type: application/json');
                    echo json_encode($response);
                    return;
                }

                $uploadedFilePath[] .= $trainingFileName . "." . $trainingFileExtention[count($trainingFileExtention) - 1];

                $insertPersonnelTrainingFileData = [
                    'personnel_id' => $personnelID,
                    'personnel_training_id' => $personnelTrainingID,
                    'personnel_training_file_date' => $personnelTrainingDate,
                    'personnel_training_file' => $trainingFileName,
                    'personnel_training_file_type' => '.' . $trainingFileExtention[count($trainingFileExtention) - 1],
                ];

                if (!$this->db->insert('cwie_personnel_training_file', $insertPersonnelTrainingFileData)) {
                    $this->db->trans_rollback();
                    $response = ['status' => false, 'errorMessage' => 'DB ERROR! : ' . $this->db->error()['message']];
                    header('Content-Type: application/json');
                    echo json_encode($response);
                    return;
                }
            }
        }

        // if new personnel trophy file upload
        if (count($personnelTrophyID) > count($personnelTrophyFileID)) {
            // Load the string helper
            $this->load->helper('string');

            $config['upload_path'] = './assets/files/personnelFiles';
            $config['allowed_types'] = 'doc|docx|pdf|jpg|jpeg|png';
            $config['max_size'] = '10240'; // 10mb

            $uploadedFilePath = array();

            for ($i = count($personnelTrophyFileID); $i < count($personnelTrophyID); $i++) {

                $personnelTrophyID = $this->input->post('personnelTrophyID', true)[$i];
                $personnelTrophyDate = $this->input->post('personnelTrophyDate', true)[$i];

                $trophyFileName = random_string('alnum', 30);
                $trophyFileExtention = explode(".", $_FILES["personnelTrophyFile"]["name"][$i]);
                $config['file_name'] = $trophyFileName . "." . $trophyFileExtention[count($trophyFileExtention) - 1];
                $this->upload->initialize($config);

                $_FILES['TrophyFile']['name'] = $_FILES['personnelTrophyFile']['name'][$i];
                $_FILES['TrophyFile']['type'] = $_FILES['personnelTrophyFile']['type'][$i];
                $_FILES['TrophyFile']['tmp_name'] = $_FILES['personnelTrophyFile']['tmp_name'][$i];
                $_FILES['TrophyFile']['error'] = $_FILES['personnelTrophyFile']['error'][$i];
                $_FILES['TrophyFile']['size'] = $_FILES['personnelTrophyFile']['size'][$i];

                if (!$this->upload->do_upload('TrophyFile')) {
                    $this->db->trans_rollback();

                    // Delete the uploaded file
                    foreach ($uploadedFilePath as $filePath) {
                        unlink('./assets/files/personnelFiles/' . $filePath);
                    }

                    $response = ['status' => false, 'errorMessage' => 'File Upload Error! : ' . $this->upload->display_errors()];
                    header('Content-Type: application/json');
                    echo json_encode($response);
                    return;
                }

                $uploadedFilePath[] = $trophyFileName . "." . $trophyFileExtention[count($trophyFileExtention) - 1];

                $insertPersonnelTrophyFileData = [
                    'personnel_id' => $personnelID,
                    'personnel_trophy_id' => $personnelTrophyID,
                    'personnel_trophy_file_date' => $personnelTrophyDate,
                    'personnel_trophy_file' => $trophyFileName,
                    'personnel_trophy_file_type' => '.' . $trophyFileExtention[count($trophyFileExtention) - 1],
                ];

                if (!$this->db->insert('cwie_personnel_trophy_file', $insertPersonnelTrophyFileData)) {
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

    public function onDeletePersonnel($personnelID = null)
    {
        if (!$this->checkPermission(['admin', 'major'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // if personnel id not set
        if ($personnelID == null) {
            $response = ['status' => false, 'errorMessage' => "Parameter Not Found!"];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // if query personnel error
        if (!$queryPersonnel = $this->db->select('personnel_id')->get_where('cwie_personnel', array('personnel_id' => $personnelID))) {
            $response = ['status' => false, 'errorMessage' => "DB Error! " . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // if not found personnel by id
        if ($queryPersonnel->num_rows() <= 0) {
            $response = ['status' => false, 'errorMessage' => "Personnel Not Found!"];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // if delete personnel error
        if (!$this->db->delete('cwie_personnel', array('personnel_id' => $queryPersonnel->row()->personnel_id))) {
            $response = ['status' => false, 'errorMessage' => "DB Error! " . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => true]);
    }

    public function onDeletePersonnelFile($fileID = null)
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

        $type = $this->input->post('type', true);

        $this->db->trans_begin();

        if ($type == 0) {
            // if query training File error
            if (!$queryPersonnelFile = $this->db->get_where('cwie_personnel_training_file', array('personnel_training_file_id' => $fileID))) {
                $response = ['status' => false, 'errorMessage' => "DB Error! " . $this->db->error()['message']];
                header('Content-Type: application/json');
                echo json_encode($response);
                return;
            }

            // if not found personnel File by id
            if ($queryPersonnelFile->num_rows() <= 0) {
                $response = ['status' => false, 'errorMessage' => "Personnel File Not Found!"];
                header('Content-Type: application/json');
                echo json_encode($response);
                return;
            }

            // if delete personnel File data error
            if (!$this->db->delete('cwie_personnel_training_file', array('personnel_training_file_id' => $queryPersonnelFile->row()->personnel_training_file_id))) {
                $response = ['status' => false, 'errorMessage' => "DB Error! " . $this->db->error()['message']];
                header('Content-Type: application/json');
                echo json_encode($response);
                return;
            }

            $filePath = $queryPersonnelFile->row()->personnel_training_file . $queryPersonnelFile->row()->personnel_training_file_type;
        } else {
            if (!$queryPersonnelFile = $this->db->get_where('cwie_personnel_trophy_file', array('personnel_trophy_file_id' => $fileID))) {
                $response = ['status' => false, 'errorMessage' => "DB Error! " . $this->db->error()['message']];
                header('Content-Type: application/json');
                echo json_encode($response);
                return;
            }

            // if not found personnel File by id
            if ($queryPersonnelFile->num_rows() <= 0) {
                $response = ['status' => false, 'errorMessage' => "Personnel File Not Found!"];
                header('Content-Type: application/json');
                echo json_encode($response);
                return;
            }

            // if delete personnel File data error
            if (!$this->db->delete('cwie_personnel_trophy_file', array('personnel_trophy_file_id' => $queryPersonnelFile->row()->personnel_trophy_file_id))) {
                $response = ['status' => false, 'errorMessage' => "DB Error! " . $this->db->error()['message']];
                header('Content-Type: application/json');
                echo json_encode($response);
                return;
            }

            $filePath = $queryPersonnelFile->row()->personnel_trophy_file . $queryPersonnelFile->row()->personnel_trophy_file_type;
        }

        if (file_exists('./assets/files/personnelFiles/' . $filePath)) {
            // unlink file
            if (!unlink('./assets/files/personnelFiles/' . $filePath)) {
                $this->db->trans_rollback();
                $response = ['status' => false, 'errorMessage' => 'Failed to unlink Personnel file : ' . error_get_last()['message']];
                header('Content-Type: application/json');
                echo json_encode($response);
                return;
            }
        }

        $this->db->trans_commit();

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => true, 'message' => 'ลบไฟล์หลักฐานแล้ว']);
    }
}
