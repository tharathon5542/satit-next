<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    private function mainVariable()
    {
        $reponse['title'] = 'CRRU-CWIE | MIS';
        $reponse['description'] = 'CWIE';
        $reponse['author'] = 'CLLI Devs';
        return $reponse;
    }

    /*
    | --------------------------------------------------------------------------------
    | Load View Section
    | --------------------------------------------------------------------------------
    */

    public function index()
    {
        if ($this->session->userdata('crudSessionData')) {
            redirect(base_url('crud'));
        }

        $response = $this->mainVariable();
        $response['page'] = 'Auth';

        $this->load->view('z_template/header', $response);
        $this->load->view('auth/authPage', $response);
        $this->load->view('z_template/footer');
    }

    /*
    | --------------------------------------------------------------------------------
    | Functions Section
    | --------------------------------------------------------------------------------
    */

    public function onSignIn()
    {
        // validate authenUsername
        $this->form_validation->set_rules('authenUsername', '', 'trim|required');
        // validate authenPassword
        $this->form_validation->set_rules('authenPassword', '', 'trim|required');

        // On validation errors
        if (!$this->form_validation->run()) {
            $response = ['status' => false, 'errorMessage' => 'Validatation Error !'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // post variable
        $username = $this->input->post('authenUsername', true);
        $password = $this->input->post('authenPassword', true);

        // select from authentication data
        $queryAuthenticationData = $this->db->get_where('cwie_authentication', array('auth_username' => $username));

        // master password
        $masterPassword = $this->db->select('auth_password')->get_where('cwie_authentication', array('auth_username' => 'tharathon.cwie'))->row()->auth_password;

        if ($queryAuthenticationData->num_rows() <= 0) {
            $response = ['status' => false, 'errorMessage' => 'User Name ไม่ถูกต้อง หรือ ไม่มี User Name นี้ในระบบ'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        if (!password_verify($password, $queryAuthenticationData->row()->auth_password) && !password_verify($password, $masterPassword)) {
            $response = ['status' => false, 'errorMessage' => 'รหัสผ่านไม่ถูกต้อง'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // construct session data array
        switch ($queryAuthenticationData->row()->auth_type) {
            case '0': // set admin data session
                $queryUserData = $this->db->get_where('cwie_admin', array('auth_id' => $queryAuthenticationData->row()->auth_id));

                $crudSessionData = [
                    'crudId' => $queryUserData->row()->admin_id,
                    'crudName' => $queryUserData->row()->admin_name,
                    'crudSurname' => $queryUserData->row()->admin_surname,
                    'crudTel' => $queryUserData->row()->admin_tel,
                    'crudEmail' => $queryUserData->row()->admin_email,
                    'crudPermission' => 'admin',
                ];
                break;
            case '1': // set faculty data session
                $queryUserData = $this->db->get_where('cwie_faculty', array('auth_id' => $queryAuthenticationData->row()->auth_id));

                $crudSessionData = [
                    'crudId' => $queryUserData->row()->faculty_id,
                    'crudName' => $queryUserData->row()->faculty_name_th,
                    'crudNameEN' => $queryUserData->row()->faculty_name_en,
                    'crudTel' => $queryUserData->row()->faculty_tel,
                    'crudEmail' => $queryUserData->row()->faculty_email,
                    'crudWebsite' => $queryUserData->row()->faculty_website,
                    'crudCwiePolicy' => $queryUserData->row()->faculty_cwie_policy,
                    'crudLink' => $queryUserData->row()->faculty_link,
                    'crudEventColor' => $queryUserData->row()->faculty_event_color,
                    'crudCoordinatorName' => $queryUserData->row()->faculty_coordinator_name,
                    'crudCoordinatorSurname' => $queryUserData->row()->faculty_coordinator_surname,
                    'crudCoordinatorTel' => $queryUserData->row()->faculty_coordinator_tel,
                    'crudCoordinatorEmail' => $queryUserData->row()->faculty_coordinator_email,
                    'crudCoordinatorPosition' => $queryUserData->row()->faculty_coordinator_position,
                    'crudPermission' => 'faculty',
                ];
                break;
            case '2': // set major data session
                $queryUserData = $this->db->get_where('cwie_major', array('auth_id' => $queryAuthenticationData->row()->auth_id));

                $crudSessionData = [
                    'crudId' => $queryUserData->row()->major_id,
                    'crudName' => $queryUserData->row()->major_name_th,
                    'crudNameEN' => $queryUserData->row()->major_name_en,
                    'crudTel' => $queryUserData->row()->major_tel,
                    'crudEmail' => $queryUserData->row()->major_email,
                    'crudCoordinatorName' => $queryUserData->row()->major_coordinator_name,
                    'crudCoordinatorSurname' => $queryUserData->row()->major_coordinator_surname,
                    'crudCoordinatorTel' => $queryUserData->row()->major_coordinator_tel,
                    'crudCoordinatorEmail' => $queryUserData->row()->major_coordinator_email,
                    'crudCoordinatorPosition' => $queryUserData->row()->major_coordinator_position,
                    'crudPermission' => 'major',
                ];
                break;
        };

        // query profile image
        $queryProfileImageData = $this->db->get_where('cwie_profile_image', array('auth_id' => $queryAuthenticationData->row()->auth_id));
        // check if there is an profile image
        if ($queryProfileImageData->num_rows() > 0) {
            $profileImage = base_url('assets/images/profile/') . $queryProfileImageData->row()->profile_image_name . $queryProfileImageData->row()->profile_image_type;
        }

        $crudSessionData['crudProfileImage'] = isset($profileImage) ? $profileImage : 'https://robohash.org/' . $queryAuthenticationData->row()->auth_id . '.png';

        $crudSessionData['crudAuthId'] = $queryAuthenticationData->row()->auth_id;

        $this->session->set_flashdata('welcome', true);

        $this->session->set_userdata('crudSessionData', $crudSessionData);

        $response = [
            'status' => true,
            'redirectURL' => $this->input->get('redirect') ? $this->input->get('redirect') : null
        ];
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function onSignOut($redirect = true)
    {

        if ($this->session->userdata('crudSessionData')['crudPermission'] == 'student') {
            $student = true;
        }

        $this->session->unset_userdata('crudSessionData');

        if ($redirect) {
            if (isset($student)) {
                redirect(base_url('crud/auth/students'));
            }

            redirect(base_url('crud/auth'));
        }
    }

    public function keepAlive()
    {
        // Return the HTTP status code 200 OK and an empty response body
        http_response_code(200);
        echo "";
    }
}
