<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ProfileWorkplace extends CI_Controller
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
        $response = $this->mainVariable();
        $response['page'] = 'Profile';

        $this->load->view('z_template/header', $response);
        $this->load->view('profile/profilePage', $response);
        $this->load->view('z_template/footer');
    }

    /*
    | --------------------------------------------------------------------------------
    | Functions Section
    | --------------------------------------------------------------------------------
    */
    public function onEditProfileWorkplace()
    {
        if (!$this->checkPermission(['workplace'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // validate profileName
        $this->form_validation->set_rules('profileName', '', 'trim|required');
        // validate profileNameEN
        $this->form_validation->set_rules('profileWorktype', '', 'trim');
        // validate profileTel
        $this->form_validation->set_rules('profileTel', '', 'trim');
        // validate profileEmail
        $this->form_validation->set_rules('profileEmail', '', 'trim|valid_email');

        // On validation errors
        if (!$this->form_validation->run()) {
            $response = ['status' => false, 'errorMessage' => 'Validatation Error !'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // post profile variable with xss clean
        $id = $this->session->userdata('crudSessionData')['crudId'];
        $name = $this->input->post('profileName', true);
        $Worktype = $this->input->post('profileWorktype', true) ? $this->input->post('profileWorktype', true) : null;
        $tel = $this->input->post('profileTel', true) ? $this->input->post('profileTel', true) : null;
        $email = $this->input->post('profileEmail', true) ? $this->input->post('profileEmail', true) : null;

        $newProfileData = [
            'workplace_name' => $name,
            'workplace_work_type' => $Worktype,
            'workplace_tel' => $tel,
            'workplace_email' => $email,
        ];

        if (!empty($_FILES['profileImage']['name'])) {
            // Load the string helper
            $this->load->helper('string');

            if (!in_array(explode(".", $_FILES["profileImage"]["name"])[count(explode(".", $_FILES["profileImage"]["name"])) - 1], ['gif'])) {
                $this->load->library('image_lib');
                // Set the configuration for image manipulation
                $imgConfig['image_library'] = 'gd2';
                $imgConfig['source_image'] = $_FILES["profileImage"]["tmp_name"];
                $imgConfig['create_thumb'] = FALSE;
                $imgConfig['maintain_ratio'] = FALSE;
                $imgConfig['width'] = 500; // Set the desired width
                $imgConfig['height'] = 500; // Set the desired height

                // Initialize the image manipulation library with the configuration
                $this->image_lib->initialize($imgConfig);

                // Resize the image
                if (!$this->image_lib->resize()) {
                    // Handle the error
                    $response = ['status' => false, 'errorMessage' => 'Image Resize Error! : ' . $this->image_lib->display_errors()];
                    header('Content-Type: application/json');
                    echo json_encode($response);
                    exit;
                }

                // Clear the configuration for the next use
                $this->image_lib->clear();
            }

            // query to check if there is an exist profile image
            $queryExistProfileImage = $this->db->get_where('cwie_profile_image', array('auth_id' => $this->session->userdata('crudSessionData')['crudAuthId']));
            if ($queryExistProfileImage->num_rows() > 0) {
                if (file_exists('./assets/images/profile/' . $queryExistProfileImage->row()->profile_image_name . $queryExistProfileImage->row()->profile_image_type)) {
                    // delete exist image
                    if (!unlink('./assets/images/profile/' . $queryExistProfileImage->row()->profile_image_name . $queryExistProfileImage->row()->profile_image_type)) {
                        $response = ['status' => false, 'errorMessage' => 'Failed to unlink video file : ' . error_get_last()['message']];
                        header('Content-Type: application/json');
                        echo json_encode($response);
                        return;
                    }
                }

                // delete old data
                if (!$this->db->delete('cwie_profile_image', array('auth_id' => $this->session->userdata('crudSessionData')['crudAuthId']))) {
                    $response = ['status' => false, 'errorMessage' => 'DB ERROR! : ' . $this->db->error()['message']];
                    header('Content-Type: application/json');
                    echo json_encode($response);
                    return;
                }
            }

            $newFileName = random_string('alnum', 30);
            $fileExtention = explode(".", $_FILES["profileImage"]["name"]);
            $config['upload_path'] = './assets/images/profile';
            $config['file_name'] = $newFileName . "." . $fileExtention[count($fileExtention) - 1];
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size'] = '2048';
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('profileImage')) {
                $response = ['status' => false, 'errorMessage' => 'Image Upload Error! : ' . $this->upload->display_errors()];
                header('Content-Type: application/json');
                echo json_encode($response);
                return;
            }

            // profile image data
            $profileImageData = [
                'profile_image_name' =>  $newFileName,
                'profile_image_type' => '.' . $fileExtention[count($fileExtention) - 1],
                'auth_id' => $this->session->userdata('crudSessionData')['crudAuthId']
            ];

            // insert profileImageData
            if (!$this->db->insert('cwie_profile_image', $profileImageData)) {
                $response = ['status' => false, 'errorMessage' => 'DB ERROR! : ' . $this->db->error()['message']];
                header('Content-Type: application/json');
                echo json_encode($response);
                return;
            }

            $profileImage = base_url('assets/images/profile/') . $newFileName . '.' . $fileExtention[count($fileExtention) - 1];
        }

        if (!$this->db->update('cwie_workplace', $newProfileData, array('workplace_id' => $id))) {
            $response = ['status' => false, 'errorMessage' => 'DB ERROR! : ' . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        $crudSessionData = $this->session->userdata('crudSessionData');

        $crudSessionData['crudName'] = $name;
        $crudSessionData['crudWorkType'] = $Worktype;
        $crudSessionData['crudTel'] = $tel;
        $crudSessionData['crudEmail'] = $email;
        $crudSessionData['crudProfileImage'] = isset($profileImage) ? $profileImage : $crudSessionData['crudProfileImage'];

        $this->session->set_userdata('crudSessionData', $crudSessionData);

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => true]);
    }

    public function onEditAddressWorkplace()
    {
        if (!$this->checkPermission(['workplace'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

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
        // validate workplaceAddress
        $this->form_validation->set_rules('workplaceAddress', '', 'trim');
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

        // post profile variable with xss clean
        $id = $this->session->userdata('crudSessionData')['crudId'];
        $workplaceZipCode = $this->input->post('workplaceZipCode', true) ? $this->input->post('workplaceZipCode', true) : null;
        $workplaceSubDistrict = $this->input->post('workplaceSubDistrict', true) ? $this->input->post('workplaceSubDistrict', true) : null;
        $workplaceDistrict = $this->input->post('workplaceDistrict', true) ? $this->input->post('workplaceDistrict', true) : null;
        $workplaceProvince = $this->input->post('workplaceProvince', true) ? $this->input->post('workplaceProvince', true) : null;
        $workplaceCountry = $this->input->post('workplaceCountry', true) ? $this->input->post('workplaceCountry', true) : null;
        $workplaceAddress = $this->input->post('workplaceAddress', true) ? $this->input->post('workplaceAddress', true) : null;
        $workplaceLat = $this->input->post('workplaceLat', true) ? $this->input->post('workplaceLat', true) : null;
        $workplaceLong = $this->input->post('workplaceLong', true) ? $this->input->post('workplaceLong', true) : null;

        $workplaceAddressData = [
            'workplace_zipcode' => $workplaceZipCode,
            'workplace_sub_district' => $workplaceSubDistrict,
            'workplace_district' => $workplaceDistrict,
            'workplace_province' => $workplaceProvince,
            'workplace_country' => $workplaceCountry,
            'workplace_address' => $workplaceAddress,
            'workplace_lat' => $workplaceLat,
            'workplace_long' => $workplaceLong,
        ];

        if (!$this->db->update('cwie_workplace', $workplaceAddressData, array('workplace_id' => $id))) {
            $response = ['status' => false, 'errorMessage' => 'DB ERROR! : ' . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        $crudSessionData = $this->session->userdata('crudSessionData');

        $crudSessionData['crudZipcode'] = $workplaceZipCode;
        $crudSessionData['crudSubDistrict'] = $workplaceSubDistrict;
        $crudSessionData['crudDistrict'] = $workplaceDistrict;
        $crudSessionData['crudProvince'] = $workplaceProvince;
        $crudSessionData['crudCountry'] = $workplaceCountry;
        $crudSessionData['crudAddrress'] = $workplaceAddress;
        $crudSessionData['crudLat'] = $workplaceLat;
        $crudSessionData['crudLong'] = $workplaceLong;

        $this->session->set_userdata('crudSessionData', $crudSessionData);

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => true]);
    }

    public function onEditWorkplacePassword()
    {
        if (!$this->checkPermission(['workplace'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // validate major old password
        $this->form_validation->set_rules('oldPassword', '', 'trim|required');
        // validate major new password
        $this->form_validation->set_rules('newPassword', '', 'trim|required');
        // validate major con password
        $this->form_validation->set_rules('newConPassword', '', 'trim|required|matches[newPassword]');

        // On validation errors
        if (!$this->form_validation->run()) {
            $response = ['status' => false, 'errorMessage' => 'Validatation Error!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        $crudAuthId = $this->session->userdata('crudSessionData')['crudAuthId'];

        // check old password
        $queryAuthenticationData = $this->db->get_where('cwie_authentication', array('auth_id' => $crudAuthId));

        if ($queryAuthenticationData->num_rows() <= 0) {
            $response = ['status' => false, 'errorMessage' => 'Authentication Not Found!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        $oldPassword = $this->input->post('oldPassword', true);
        $newConPassword = $this->input->post('newConPassword', true);

        if (!password_verify($oldPassword, $queryAuthenticationData->row()->auth_password)) {
            $response = ['status' => false, 'errorMessage' => 'รหัสผ่านเดิมไม่ถูกต้อง'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        if (!$this->db->update('cwie_authentication', array('auth_password' => password_hash($newConPassword, PASSWORD_DEFAULT)), array('auth_id' => $crudAuthId))) {
            $response = ['status' => false, 'errorMessage' => 'DB ERROR! : ' . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => true]);
    }
}
