<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Major extends CI_Controller
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
        if (!$this->checkPermission(['admin', 'faculty'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        $response = $this->mainVariable();
        $response['page'] = 'Major';

        $this->load->view('z_template/header', $response);
        $this->load->view('major/majorPage', $response);
        $this->load->view('z_template/footer');
    }

    public function editModal($majorID = null)
    {
        if (!$this->checkPermission(['admin', 'faculty'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        if ($majorID == null) {
            $response = ['status' => false, 'errorMessage' =>  "Parameter Not Found!"];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // query major data
        $queryMajorData = $this->db->get_where('cwie_major', array('major_id' => $majorID));

        // query major profile image
        $queryMajorProfileImageData = $this->db->get_where('cwie_profile_image', array('auth_id' => $queryMajorData->row()->auth_id));

        // if not found major profile image by id
        if ($queryMajorProfileImageData->num_rows() <= 0) {
            $majorImage = 'https://robohash.org/' . $queryMajorData->row()->auth_id . '.png';
        }

        $response = [
            'status' => true,
            'majorImage' => isset($majorImage) ? $majorImage : base_url('assets/images/profile/') . $queryMajorProfileImageData->row()->profile_image_name . $queryMajorProfileImageData->row()->profile_image_type,
            'majorID' => $queryMajorData->row()->major_id,
            'majorNameTH' => $queryMajorData->row()->major_name_th,
            'majorNameEN' => $queryMajorData->row()->major_name_en,
            'majorTel' => $queryMajorData->row()->major_tel,
            'majorEmail' => $queryMajorData->row()->major_email,
            'coordinatorName' => $queryMajorData->row()->major_coordinator_name,
            'coordinatorSurname' => $queryMajorData->row()->major_coordinator_surname,
            'coordinatorTel' => $queryMajorData->row()->major_coordinator_tel,
            'coordinatorEmail' => $queryMajorData->row()->major_coordinator_email,
            'coordinatorPosition' => $queryMajorData->row()->major_coordinator_position,
            'data' =>  $this->load->view('major/majorEditPage', null, true)
        ];
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function addModal()
    {
        if (!$this->checkPermission(['admin', 'faculty'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        $response = ['status' => true, 'data' =>  $this->load->view('major/majorAddPage', null, true)];
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    /*
    | --------------------------------------------------------------------------------
    | Functions Section
    | --------------------------------------------------------------------------------
    */

    public function getMajor($majorID = null)
    {
        if (!$this->checkPermission(['admin', 'faculty'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // query major by id
        if ($majorID != null) {
            $queryMajor = $this->db->get_where('cwie_major', array('major_id' => $majorID));

            if ($queryMajor->num_rows() <= 0) {
                header('Content-Type: application/json');
                echo json_encode($response = ['status' => 'false', 'errorMessage' => 'Major Not Found!']);
                return;
            }

            $response = [
                'status' => 'true',
                'majorID' => $queryMajor->row()->major_id,
                'majorTH' => $queryMajor->row()->major_name_th,
                'facultyNameEN' => $queryMajor->row()->major_name_en,
            ];
            return $response;
        }

        // query major by faculty
        if ($this->session->userdata('crudSessionData')['crudPermission'] == 'faculty') {
            $queryMajor = $this->db->select('major_id, major_name_th, faculty_name_th')->join('cwie_faculty', 'cwie_major.faculty_id = cwie_faculty.faculty_id', 'left')->order_by('major_id', 'DESC')->get_where('cwie_major', array('cwie_major.faculty_id' => $this->session->userdata('crudSessionData')['crudId']));
            foreach ($queryMajor->result() as $major) {
                $queryData[] = [
                    'majorID' => $major->major_id,
                    'majorNameTH' => $major->major_name_th,
                    'facultyNameTH' => $major->faculty_name_th,
                ];
            }

            header('Content-Type: application/json');
            echo json_encode($response = ['status' => 'true', 'data' => isset($queryData) ? $queryData : []]);
            return;
        }

        // query major
        $queryMajor = $this->db->select('major_id, major_name_th, faculty_name_th')->join('cwie_faculty', 'cwie_major.faculty_id = cwie_faculty.faculty_id', 'left')->order_by('major_id', 'DESC')->get('cwie_major');
        foreach ($queryMajor->result() as $major) {
            $queryData[] = [
                'majorID' => $major->major_id,
                'majorNameTH' => $major->major_name_th,
                'facultyNameTH' => $major->faculty_name_th,
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => 'true', 'data' => isset($queryData) ? $queryData : []]);
    }

    public function onAddMajor()
    {
        if (!$this->checkPermission(['admin', 'faculty'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // validate majorNameTH
        $this->form_validation->set_rules('majorNameTH', '', 'trim|required');
        // validate majorNameEN
        $this->form_validation->set_rules('majorNameEN', '', 'trim');
        // validate majorTel
        $this->form_validation->set_rules('majorTel', '', 'trim');
        // validate majorEmail
        $this->form_validation->set_rules('majorEmail', '', 'trim|valid_email');
        // validate coordinatorName
        $this->form_validation->set_rules('coordinatorName', '', 'trim|required');
        // validate coordinatorSurname
        $this->form_validation->set_rules('coordinatorSurname', '', 'trim|required');
        // validate coordinatorTel
        $this->form_validation->set_rules('coordinatorTel', '', 'trim|required');
        // validate coordinatorEmail
        $this->form_validation->set_rules('coordinatorEmail', '', 'trim|valid_email');
        // validate coordinatorEmail
        $this->form_validation->set_rules('coordinatorPosition', '', 'trim');
        // validate majorUsername
        $this->form_validation->set_rules('majorUsername', '', 'trim|required');
        // validate majorPassword
        $this->form_validation->set_rules('majorPassword', '', 'trim|required');
        // validate majorConPassword
        $this->form_validation->set_rules('majorConPassword', '', 'trim|required|matches[majorPassword]');

        // On validation errors
        if (!$this->form_validation->run()) {
            $response = ['status' => false, 'errorMessage' => 'Validatation Error !'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // post faculty variable with xss clean
        if ($this->input->post('FacultyID', true)) {
            $facultyID = $this->input->post('FacultyID', true);
        }
        $majorNameTH = $this->input->post('majorNameTH', true);
        $majorNameEN = $this->input->post('majorNameEN', true) ? $this->input->post('majorNameEN', true) : null;
        $majorTel = $this->input->post('majorTel', true) ? $this->input->post('majorTel', true) : null;
        $majorEmail = $this->input->post('majorEmail', true) ? $this->input->post('majorEmail', true) : null;
        $coordinatorName = $this->input->post('coordinatorName', true) ? $this->input->post('coordinatorName', true) : null;
        $coordinatorSurname = $this->input->post('coordinatorSurname', true) ? $this->input->post('coordinatorSurname', true) : null;
        $coordinatorTel = $this->input->post('coordinatorTel', true) ? $this->input->post('coordinatorTel', true) : null;
        $coordinatorEmail = $this->input->post('coordinatorEmail', true) ? $this->input->post('coordinatorEmail', true) : null;
        $coordinatorPosition = $this->input->post('coordinatorPosition', true) ? $this->input->post('coordinatorPosition', true) : null;
        // post authentication variable with xss clean
        $username = $this->input->post('majorUsername', true);
        $password = $this->input->post('majorConPassword', true);

        if ($this->db->get_where('cwie_authentication', array('auth_username' => $username))->num_rows() > 0) {
            $response = ['status' => false, 'errorMessage' => 'มี User Name นี้อยู่ในระบบแล้ว'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        if (!$this->db->insert('cwie_authentication', array('auth_username' => $username, 'auth_password' => password_hash($password, PASSWORD_DEFAULT), 'auth_type' => '2'))) {
            $response = ['status' => false, 'errorMessage' => 'DB ERROR! authentication step : ' . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // auth id after insert auth data
        $authenticationID = $this->db->insert_id();

        // faculty insert data
        $majorInsertData = [
            'major_name_th' => $majorNameTH,
            'major_name_en' => $majorNameEN,
            'major_tel' => $majorTel,
            'major_email' => $majorEmail,
            'major_coordinator_name' => $coordinatorName,
            'major_coordinator_surname' => $coordinatorSurname,
            'major_coordinator_tel' => $coordinatorTel,
            'major_coordinator_email' => $coordinatorEmail,
            'major_coordinator_position' => $coordinatorPosition,
            'faculty_id' =>  isset($facultyID) ? $facultyID : $this->session->userdata('crudSessionData')['crudId'],
            'auth_id' => $authenticationID
        ];

        if (!$this->db->insert('cwie_major', $majorInsertData)) {
            $response = ['status' => false, 'errorMessage' => 'DB ERROR! faculty step : ' . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => true, 'message' => 'เพิ่มข้อมูล ' . $majorNameTH . ' แล้ว']);
    }

    public function onEditMajor()
    {
        if (!$this->checkPermission(['admin', 'faculty'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // validate majorID
        $this->form_validation->set_rules('majorID', '', 'trim|required');
        // validate majorNameTH
        $this->form_validation->set_rules('majorNameTH', '', 'trim|required');
        // validate majorNameEN
        $this->form_validation->set_rules('majorNameEN', '', 'trim');
        // validate majorTel
        $this->form_validation->set_rules('majorTel', '', 'trim');
        // validate majorEmail
        $this->form_validation->set_rules('majorEmail', '', 'trim|valid_email');

        // On validation errors
        if (!$this->form_validation->run()) {
            $response = ['status' => false, 'errorMessage' => 'Validatation Error !'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // post major variable with xss clean
        $majorID = $this->input->post('majorID', true);
        $majorNameTH = $this->input->post('majorNameTH', true);
        $majorNameEN = $this->input->post('majorNameEN', true) ? $this->input->post('majorNameEN', true) : null;
        $majorTel = $this->input->post('majorTel', true) ? $this->input->post('majorTel', true) : null;
        $majorEmail = $this->input->post('majorEmail', true) ? $this->input->post('majorEmail', true) : null;

        // major update data
        $majorUpdateData = [
            'major_name_th' => $majorNameTH,
            'major_name_en' => $majorNameEN,
            'major_tel' => $majorTel,
            'major_email' => $majorEmail,
        ];

        if (!empty($_FILES['majorImage']['name'])) {
            // Load the string helper
            $this->load->helper('string');

            // query major data
            $queryMajorData = $this->db->get_where('cwie_major', array('major_id' => $majorID));

            if ($queryMajorData->num_rows() <= 0) {
                $response = ['status' => false, 'errorMessage' => 'Major Not Found!'];
                header('Content-Type: application/json');
                echo json_encode($response);
                return;
            }

            // query to check if there is an exist profile image
            $queryExistProfileImage = $this->db->get_where('cwie_profile_image', array('auth_id' => $queryMajorData->row()->auth_id));

            if ($queryExistProfileImage->num_rows() > 0) {
                if (file_exists('./assets/images/profile/' . $queryExistProfileImage->row()->profile_image_name . $queryExistProfileImage->row()->profile_image_type)) {
                    // delete exist image
                    if (!unlink('./assets/images/profile/' . $queryExistProfileImage->row()->profile_image_name . $queryExistProfileImage->row()->profile_image_type)) {
                        $response = ['status' => false, 'errorMessage' => 'Failed to unlink file : ' . error_get_last()['message']];
                        header('Content-Type: application/json');
                        echo json_encode($response);
                        return;
                    }
                }

                // delete old data
                if (!$this->db->delete('cwie_profile_image', array('auth_id' => $queryMajorData->row()->auth_id))) {
                    $response = ['status' => false, 'errorMessage' => 'DB ERROR! : ' . $this->db->error()['message']];
                    header('Content-Type: application/json');
                    echo json_encode($response);
                    return;
                }
            }

            $newFileName = random_string('alnum', 30);
            $fileExtention = explode(".", $_FILES["majorImage"]["name"]);
            $config['upload_path'] = './assets/images/profile';
            $config['file_name'] = $newFileName . "." . $fileExtention[count($fileExtention) - 1];
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size'] = '2048';
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('majorImage')) {
                $response = ['status' => false, 'errorMessage' => 'Image Upload Error! : ' . $this->upload->display_errors()];
                header('Content-Type: application/json');
                echo json_encode($response);
                return;
            }

            // profile image data
            $profileImageData = [
                'profile_image_name' =>  $newFileName,
                'profile_image_type' => '.' . $fileExtention[count($fileExtention) - 1],
                'auth_id' => $queryMajorData->row()->auth_id
            ];

            // insert profileImageData
            if (!$this->db->insert('cwie_profile_image', $profileImageData)) {
                $response = ['status' => false, 'errorMessage' => 'DB ERROR! : ' . $this->db->error()['message']];
                header('Content-Type: application/json');
                echo json_encode($response);
                return;
            }
        }

        if (!$this->db->update('cwie_major', $majorUpdateData, array('major_id' => $majorID))) {
            $response = ['status' => false, 'errorMessage' => 'DB ERROR! : ' . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => true, 'message' => 'แก้ไขข้อมูล ' . $majorNameTH . 'แล้ว']);
    }

    public function onEditMajorCoordinator()
    {
        if (!$this->checkPermission(['admin', 'faculty'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // validate majorID
        $this->form_validation->set_rules('majorID', '', 'trim|required');
        // validate coordinatorName
        $this->form_validation->set_rules('coordinatorName', '', 'trim|required');
        // validate coordinatorSurname
        $this->form_validation->set_rules('coordinatorSurname', '', 'trim|required');
        // validate coordinatorTel
        $this->form_validation->set_rules('coordinatorTel', '', 'trim|required');
        // validate coordinatorEmail
        $this->form_validation->set_rules('coordinatorEmail', '', 'trim|valid_email');
        // validate coordinatorPosition
        $this->form_validation->set_rules('coordinatorPosition', '', 'trim');

        // On validation errors
        if (!$this->form_validation->run()) {
            $response = ['status' => false, 'errorMessage' => 'Validatation Error !'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // post coordinator variable with xss clean
        $majorID = $this->input->post('majorID', true);
        $coordinatorName = $this->input->post('coordinatorName', true);
        $coordinatorSurname = $this->input->post('coordinatorSurname', true) ? $this->input->post('coordinatorSurname', true) : null;
        $coordinatorTel = $this->input->post('coordinatorTel', true) ? $this->input->post('coordinatorTel', true) : null;
        $coordinatorEmail = $this->input->post('coordinatorEmail', true) ? $this->input->post('coordinatorEmail', true) : null;
        $coordinatorPosition = $this->input->post('coordinatorPosition', true) ? $this->input->post('coordinatorPosition', true) : null;

        // faculty update data
        $CoodinatorUpdateData = [
            'major_coordinator_name' => $coordinatorName,
            'major_coordinator_surname' => $coordinatorSurname,
            'major_coordinator_tel' => $coordinatorTel,
            'major_coordinator_email' => $coordinatorEmail,
            'major_coordinator_position' => $coordinatorPosition
        ];

        if (!$this->db->update('cwie_major', $CoodinatorUpdateData, array('major_id' => $majorID))) {
            $response = ['status' => false, 'errorMessage' => 'DB ERROR! : ' . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => true]);
    }

    public function onEditMajorPassword()
    {
        if (!$this->checkPermission(['admin', 'faculty'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // validate majorID
        $this->form_validation->set_rules('majorID', '', 'trim|required');
        // validate majorNewPassword
        $this->form_validation->set_rules('majorNewPassword', '', 'trim|required');
        // validate majorConNewPassword
        $this->form_validation->set_rules('majorConNewPassword', '', 'trim|required|matches[majorNewPassword]');

        // On validation errors
        if (!$this->form_validation->run()) {
            $response = ['status' => false, 'errorMessage' => 'Validatation Error !'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // post faculty variable with xss clean
        $majorID = $this->input->post('majorID', true);
        $majorConNewPassword = $this->input->post('majorConNewPassword', true);

        // query major data
        $queryMajorData = $this->db->get_where('cwie_major', array('major_id' => $majorID));

        // if not found Major by id
        if ($queryMajorData->num_rows() <= 0) {
            $response = ['status' => false, 'errorMessage' => "Major Not Found!"];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // major update data
        $majorNewPasswordData = [
            'auth_password' => password_hash($majorConNewPassword, PASSWORD_DEFAULT),
        ];

        if (!$this->db->update('cwie_authentication', $majorNewPasswordData, array('auth_id' => $queryMajorData->row()->auth_id))) {
            $response = ['status' => false, 'errorMessage' => 'DB ERROR! : ' . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => true]);
    }

    public function onDeleteMajor($majorID = null)
    {
        if (!$this->checkPermission(['admin', 'faculty'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // if faculty id not set
        if ($majorID == null) {
            $response = ['status' => false, 'errorMessage' => "Parameter Not Found!"];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        //  query major error
        $queryMajor = $this->db->select('auth_id')->get_where('cwie_major', array('major_id' => $majorID));

        // if not found major by id
        if ($queryMajor->num_rows() <= 0) {
            $response = ['status' => false, 'errorMessage' => "Major Not Found!"];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // if delete major error
        if (!$this->db->delete('cwie_authentication', array('auth_id' => $queryMajor->row()->auth_id))) {
            $response = ['status' => false, 'errorMessage' => "DB Error! " . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => true]);
    }
}
