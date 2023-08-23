<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Faculty extends CI_Controller
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
        if (!$this->checkPermission(['admin'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        $response = $this->mainVariable();
        $response['page'] = 'Faculty';

        $this->load->view('z_template/header', $response);
        $this->load->view('faculty/facultyPage', $response);
        $this->load->view('z_template/footer');
    }

    public function editModal($facultyID = null)
    {
        if (!$this->checkPermission(['admin'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        if ($facultyID == null) {
            $response = ['status' => false, 'errorMessage' =>  "Parameter Not Found!"];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // query faculty data
        $queryFacultyData = $this->db->get_where('cwie_faculty', array('faculty_id' => $facultyID));

        // if not found faculty by id
        if ($queryFacultyData->num_rows() <= 0) {
            $response = ['status' => false, 'errorMessage' =>  "Faculty Not Found!"];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // query faculty profile image
        $queryFacultyProfileImageData = $this->db->get_where('cwie_profile_image', array('auth_id' => $queryFacultyData->row()->auth_id));

        // if not found faculty profile image by id
        if ($queryFacultyProfileImageData->num_rows() <= 0) {
            $facultyImage = 'https://robohash.org/' . $queryFacultyData->row()->auth_id . '.png';
        }

        $response = [
            'status' => true,
            'facultyImage' => isset($facultyImage) ? $facultyImage : base_url('assets/images/profile/') . $queryFacultyProfileImageData->row()->profile_image_name . $queryFacultyProfileImageData->row()->profile_image_type,
            'facultyID' => $queryFacultyData->row()->faculty_id,
            'facultyNameTH' => $queryFacultyData->row()->faculty_name_th,
            'facultyNameEN' => $queryFacultyData->row()->faculty_name_en,
            'facultyTel' => $queryFacultyData->row()->faculty_tel,
            'facultyEmail' => $queryFacultyData->row()->faculty_email,
            'facultyWebsite' => $queryFacultyData->row()->faculty_website,
            'facultyLink' => $queryFacultyData->row()->faculty_link,
            'facultyCwiePolicy' => $queryFacultyData->row()->faculty_cwie_policy,
            'coordinatorName' => $queryFacultyData->row()->faculty_coordinator_name,
            'coordinatorSurname' => $queryFacultyData->row()->faculty_coordinator_surname,
            'coordinatorTel' => $queryFacultyData->row()->faculty_coordinator_tel,
            'coordinatorEmail' => $queryFacultyData->row()->faculty_coordinator_email,
            'coordinatorPosition' => $queryFacultyData->row()->faculty_coordinator_position,
            'data' =>  $this->load->view('faculty/facultyEditPage', null, true)
        ];
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function addModal()
    {
        if (!$this->checkPermission(['admin'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        $response = ['status' => true, 'data' =>  $this->load->view('faculty/facultyAddPage', null, true)];
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    /*
    | --------------------------------------------------------------------------------
    | Functions Section
    | --------------------------------------------------------------------------------
    */

    public function getFaculty($facultyID = null)
    {
        if (!$this->checkPermission(['admin'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // query faculty by id
        if ($facultyID != null) {
            $queryFaculty = $this->db->get_where('cwie_faculty', array('faculty_id' => $facultyID));

            if ($queryFaculty->num_rows() <= 0) {
                header('Content-Type: application/json');
                echo json_encode($response = ['status' => 'false', 'errorMessage' => 'Faculty Not Found!']);
                return;
            }

            $response = [
                'status' => 'true',
                'facultyID' => $queryFaculty->row()->faculty_id,
                'facultyNameTH' => $queryFaculty->row()->faculty_name_th,
                'facultyNameEN' => $queryFaculty->row()->faculty_name_en,
            ];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // query faculty
        $queryFaculty = $this->db->order_by('faculty_id', 'DESC')->get('cwie_faculty');
        foreach ($queryFaculty->result() as $faculty) {
            $queryData[] = [
                'facultyID' => $faculty->faculty_id,
                'facultyNameTH' => $faculty->faculty_name_th,
                'facultyLink' => $faculty->faculty_link,
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => 'true', 'data' => isset($queryData) ? $queryData : []]);
    }

    public function onAddFaculty()
    {
        if (!$this->checkPermission(['admin'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // validate facultyNameTH
        $this->form_validation->set_rules('facultyNameTH', '', 'trim|required');
        // validate facultyNameEN
        $this->form_validation->set_rules('facultyNameEN', '', 'trim');
        // validate facultyTel
        $this->form_validation->set_rules('facultyTel', '', 'trim');
        // validate facultyEmail
        $this->form_validation->set_rules('facultyEmail', '', 'trim|valid_email');
        // validate facultyWebsite
        $this->form_validation->set_rules('facultyWebsite', '', 'trim');
        // validate facultyCwiePolicy
        $this->form_validation->set_rules('facultyCwiePolicy', '', 'trim');
        // validate facultyLink
        $this->form_validation->set_rules('facultyLink', '', 'trim');
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
        // validate facultyUsername
        $this->form_validation->set_rules('facultyUsername', '', 'trim|required');
        // validate facultyPassword
        $this->form_validation->set_rules('facultyPassword', '', 'trim|required');
        // validate facultyConPassword
        $this->form_validation->set_rules('facultyConPassword', '', 'trim|required|matches[facultyPassword]');

        // On validation errors
        if (!$this->form_validation->run()) {
            $response = ['status' => false, 'errorMessage' => 'Validatation Error !'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // post faculty variable with xss clean
        $facultyNameTH = $this->input->post('facultyNameTH', true);
        $facultyNameEN = $this->input->post('facultyNameEN', true) ? $this->input->post('facultyNameEN', true) : null;
        $facultyTel = $this->input->post('facultyTel', true) ? $this->input->post('facultyTel', true) : null;
        $facultyEmail = $this->input->post('facultyEmail', true) ? $this->input->post('facultyEmail', true) : null;
        $facultyWebsite = $this->input->post('facultyWebsite', true) ? preg_replace("/[^a-zA-Z0-9_\x{0E00}-\x{0E7F}]/u", '-', $this->input->post('facultyWebsite', true)) : preg_replace("/[^a-zA-Z0-9_\x{0E00}-\x{0E7F}]/u", '-', $this->input->post('facultyNameTH', true));
        $facultyCwiePolicy = $this->input->post('facultyCwiePolicy', true) ? $this->input->post('facultyCwiePolicy', true) : null;
        $facultyLink = $this->input->post('facultyLink', true) ? $this->input->post('facultyLink', true) : null;
        $coordinatorName = $this->input->post('coordinatorName', true) ? $this->input->post('coordinatorName', true) : null;
        $coordinatorSurname = $this->input->post('coordinatorSurname', true) ? $this->input->post('coordinatorSurname', true) : null;
        $coordinatorTel = $this->input->post('coordinatorTel', true) ? $this->input->post('coordinatorTel', true) : null;
        $coordinatorEmail = $this->input->post('coordinatorEmail', true) ? $this->input->post('coordinatorEmail', true) : null;
        $coordinatorPosition = $this->input->post('coordinatorPosition', true) ? $this->input->post('coordinatorPosition', true) : null;

        // check website duplicate
        if ($this->db->get_where('cwie_faculty', array('faculty_website' => $facultyWebsite))->num_rows() > 0) {
            $response = ['status' => false, 'errorMessage' => 'Website Link Duplicate!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // post authentication variable with xss clean
        $username = $this->input->post('facultyUsername', true);
        $password = $this->input->post('facultyConPassword', true);

        if ($this->db->get_where('cwie_authentication', array('auth_username' => $username))->num_rows() > 0) {
            $response = ['status' => false, 'errorMessage' => 'มี User Name นี้อยู่ในระบบแล้ว'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        if (!$this->db->insert('cwie_authentication', array('auth_username' => $username, 'auth_password' => password_hash($password, PASSWORD_DEFAULT), 'auth_type' => '1'))) {
            $response = ['status' => false, 'errorMessage' => 'DB ERROR! authentication step : ' . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // auth id after insert auth data
        $authenticationID = $this->db->insert_id();

        // faculty insert data
        $facultyInsertData = [
            'faculty_name_th' => $facultyNameTH,
            'faculty_name_en' => $facultyNameEN,
            'faculty_tel' => $facultyTel,
            'faculty_email' => $facultyEmail,
            'faculty_website' => $facultyWebsite,
            'faculty_link' => $facultyLink,
            'faculty_cwie_policy' => $facultyCwiePolicy,
            'faculty_coordinator_name' => $coordinatorName,
            'faculty_coordinator_surname' => $coordinatorSurname,
            'faculty_coordinator_tel' => $coordinatorTel,
            'faculty_coordinator_email' => $coordinatorEmail,
            'faculty_coordinator_position' => $coordinatorPosition,
            'auth_id' => $authenticationID
        ];

        if (!$this->db->insert('cwie_faculty', $facultyInsertData)) {
            $response = ['status' => false, 'errorMessage' => 'DB ERROR! faculty step : ' . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => true, 'message' => 'เพิ่มข้อมูล ' . $facultyNameTH . ' แล้ว']);
    }

    public function onEditFaculty()
    {
        if (!$this->checkPermission(['admin'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // validate facultyID
        $this->form_validation->set_rules('facultyID', '', 'trim|required');
        // validate facultyNameTH
        $this->form_validation->set_rules('facultyNameTH', '', 'trim|required');
        // validate facultyNameEN
        $this->form_validation->set_rules('facultyNameEN', '', 'trim');
        // validate facultyTel
        $this->form_validation->set_rules('facultyTel', '', 'trim');
        // validate facultyEmail
        $this->form_validation->set_rules('facultyEmail', '', 'trim|valid_email');
        // validate facultyWebsite
        $this->form_validation->set_rules('facultyWebsite', '', 'trim');
        // validate facultyLink
        $this->form_validation->set_rules('facultyLink', '', 'trim');

        // On validation errors
        if (!$this->form_validation->run()) {
            $response = ['status' => false, 'errorMessage' => 'Validatation Error !'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // post faculty variable with xss clean
        $facultyID = $this->input->post('facultyID', true);
        $facultyNameTH = $this->input->post('facultyNameTH', true);
        $facultyNameEN = $this->input->post('facultyNameEN', true) ? $this->input->post('facultyNameEN', true) : null;
        $facultyTel = $this->input->post('facultyTel', true) ? $this->input->post('facultyTel', true) : null;
        $facultyEmail = $this->input->post('facultyEmail', true) ? $this->input->post('facultyEmail', true) : null;
        $facultyWebsite = $this->input->post('facultyWebsite', true) ? preg_replace("/[^a-zA-Z0-9_\x{0E00}-\x{0E7F}]/u", '-', $this->input->post('facultyWebsite', true)) : preg_replace("/[^a-zA-Z0-9_\x{0E00}-\x{0E7F}]/u", '-', $facultyNameTH);
        $facultyLink = $this->input->post('facultyLink', true) ? $this->input->post('facultyLink', true) : null;

        // check website duplicate
        if ($this->db->get_where('cwie_faculty', array('faculty_website' => $facultyWebsite, 'faculty_website !=' => null, 'faculty_id !=' => $facultyID))->num_rows() > 0) {
            $response = ['status' => false, 'errorMessage' => 'Website Link Duplicate!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // faculty update data
        $facultyUpdateData = [
            'faculty_name_th' => $facultyNameTH,
            'faculty_name_en' => $facultyNameEN,
            'faculty_tel' => $facultyTel,
            'faculty_email' => $facultyEmail,
            'faculty_website' => $facultyWebsite,
            'faculty_link' => $facultyLink,
        ];

        if (!empty($_FILES['facultyImage']['name'])) {
            // Load the string helper
            $this->load->helper('string');

            // query faculty data
            $queryFacultyData = $this->db->get_where('cwie_faculty', array('faculty_id' => $facultyID));

            if ($queryFacultyData->num_rows() <= 0) {
                $response = ['status' => false, 'errorMessage' => 'Faculty Not Found!'];
                header('Content-Type: application/json');
                echo json_encode($response);
                return;
            }

            // query to check if there is an exist profile image
            $queryExistProfileImage = $this->db->get_where('cwie_profile_image', array('auth_id' => $queryFacultyData->row()->auth_id));

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
                if (!$this->db->delete('cwie_profile_image', array('auth_id' => $queryFacultyData->row()->auth_id))) {
                    $response = ['status' => false, 'errorMessage' => 'DB ERROR! : ' . $this->db->error()['message']];
                    header('Content-Type: application/json');
                    echo json_encode($response);
                    return;
                }
            }

            $newFileName = random_string('alnum', 30);
            $fileExtention = explode(".", $_FILES["facultyImage"]["name"]);
            $config['upload_path'] = './assets/images/profile';
            $config['file_name'] = $newFileName . "." . $fileExtention[count($fileExtention) - 1];
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size'] = '2048';
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('facultyImage')) {
                $response = ['status' => false, 'errorMessage' => 'Image Upload Error! : ' . $this->upload->display_errors()];
                header('Content-Type: application/json');
                echo json_encode($response);
                return;
            }

            // profile image data
            $profileImageData = [
                'profile_image_name' =>  $newFileName,
                'profile_image_type' => '.' . $fileExtention[count($fileExtention) - 1],
                'auth_id' => $queryFacultyData->row()->auth_id
            ];

            // insert profileImageData
            if (!$this->db->insert('cwie_profile_image', $profileImageData)) {
                $response = ['status' => false, 'errorMessage' => 'DB ERROR! : ' . $this->db->error()['message']];
                header('Content-Type: application/json');
                echo json_encode($response);
                return;
            }
        }

        if (!$this->db->update('cwie_faculty', $facultyUpdateData, array('faculty_id' => $facultyID))) {
            $response = ['status' => false, 'errorMessage' => 'DB ERROR! : ' . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => true, 'message' => 'แก้ไขข้อมูล ' . $facultyNameTH . 'แล้ว', 'facultyWebsite' => $facultyWebsite]);
    }

    public function onEditFacultyCoordinator()
    {
        if (!$this->checkPermission(['admin'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // validate facultyID
        $this->form_validation->set_rules('facultyID', '', 'trim|required');
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
        $facultyID = $this->input->post('facultyID', true);
        $coordinatorName = $this->input->post('coordinatorName', true);
        $coordinatorSurname = $this->input->post('coordinatorSurname', true) ? $this->input->post('coordinatorSurname', true) : null;
        $coordinatorTel = $this->input->post('coordinatorTel', true) ? $this->input->post('coordinatorTel', true) : null;
        $coordinatorEmail = $this->input->post('coordinatorEmail', true) ? $this->input->post('coordinatorEmail', true) : null;
        $coordinatorPosition = $this->input->post('coordinatorPosition', true) ? $this->input->post('coordinatorPosition', true) : null;

        // faculty update data
        $CoodinatorUpdateData = [
            'faculty_coordinator_name' => $coordinatorName,
            'faculty_coordinator_surname' => $coordinatorSurname,
            'faculty_coordinator_tel' => $coordinatorTel,
            'faculty_coordinator_email' => $coordinatorEmail,
            'faculty_coordinator_position' => $coordinatorPosition
        ];

        if (!$this->db->update('cwie_faculty', $CoodinatorUpdateData, array('faculty_id' => $facultyID))) {
            $response = ['status' => false, 'errorMessage' => 'DB ERROR! : ' . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => true]);
    }

    function onEditFacultyCwiePolicy()
    {
        if (!$this->checkPermission(['admin'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // validate facultyID
        $this->form_validation->set_rules('facultyID', '', 'trim|required');
        // validate cwie policy
        $this->form_validation->set_rules('facultyCwiePolicy', '', 'trim');

        // post coordinator variable with xss clean
        $facultyID = $this->input->post('facultyID', true);
        $facultyCwiePolicy = $this->input->post('facultyCwiePolicy', true);

        // faculty update data
        $facultyCwiePolicyUpdate = [
            'faculty_cwie_policy' => $facultyCwiePolicy,
        ];

        if (!$this->db->update('cwie_faculty', $facultyCwiePolicyUpdate, array('faculty_id' => $facultyID))) {
            $response = ['status' => false, 'errorMessage' => 'DB ERROR! : ' . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => true]);
    }

    public function onEditFacultyPassword()
    {
        if (!$this->checkPermission(['admin'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // validate facultyID
        $this->form_validation->set_rules('facultyID', '', 'trim|required');
        // validate facultyNewPassword
        $this->form_validation->set_rules('facultyNewPassword', '', 'trim|required');
        // validate facultyConNewPassword
        $this->form_validation->set_rules('facultyConNewPassword', '', 'trim|required|matches[facultyNewPassword]');

        // On validation errors
        if (!$this->form_validation->run()) {
            $response = ['status' => false, 'errorMessage' => 'Validatation Error !'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // post faculty variable with xss clean
        $facultyID = $this->input->post('facultyID', true);
        $facultyConNewPassword = $this->input->post('facultyConNewPassword', true);

        // query Faculty data
        $queryFacultyData = $this->db->get_where('cwie_faculty', array('faculty_id' => $facultyID));

        // if not found Faculty by id
        if ($queryFacultyData->num_rows() <= 0) {
            $response = ['status' => false, 'errorMessage' => "Faculty Not Found!"];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // faculty update data
        $facultyNewPasswordData = [
            'auth_password' => password_hash($facultyConNewPassword, PASSWORD_DEFAULT),
        ];

        if (!$this->db->update('cwie_authentication', $facultyNewPasswordData, array('auth_id' => $queryFacultyData->row()->auth_id))) {
            $response = ['status' => false, 'errorMessage' => 'DB ERROR! : ' . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => true]);
    }

    public function onDeleteFaculty($facultyID = null)
    {
        if (!$this->checkPermission(['admin'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // if faculty id not set
        if ($facultyID == null) {
            $response = ['status' => false, 'errorMessage' => "Parameter Not Found!"];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // if query faculty error
        if (!$queryFaculty = $this->db->select('auth_id')->get_where('cwie_faculty', array('faculty_id' => $facultyID))) {
            $response = ['status' => false, 'errorMessage' => "DB Error! " . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // if not found faculty by id
        if ($queryFaculty->num_rows() <= 0) {
            $response = ['status' => false, 'errorMessage' => "Faculty Not Found!"];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // if delete faculty error
        if (!$this->db->delete('cwie_authentication', array('auth_id' => $queryFaculty->row()->auth_id))) {
            $response = ['status' => false, 'errorMessage' => "DB Error! " . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => true]);
    }
}
