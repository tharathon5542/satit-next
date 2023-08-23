<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cover extends CI_Controller
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
        if (!$this->checkPermission(['faculty'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        $response = $this->mainVariable();
        $response['page'] = 'Cover';

        $this->load->view('z_template/header', $response);
        $this->load->view('cover/coverPage', $response);
        $this->load->view('z_template/footer');
    }
    /*
    | --------------------------------------------------------------------------------
    | Functions Section
    | --------------------------------------------------------------------------------
    */

    public function getCoverImage()
    {

        if (!$this->checkPermission(['faculty'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // query cover image
        $queryCoverImage = $this->db->get_where('cwie_cover_image', array('faculty_id' => $this->session->userdata('crudSessionData')['crudId']));

        if ($queryCoverImage->num_rows() > 0) {
            $queryData = [
                'coverImageID' => $queryCoverImage->row()->cover_image_id,
                'coverImageName' => $queryCoverImage->row()->cover_image_name,
                'coverImageType' => $queryCoverImage->row()->cover_image_type,
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => 'true', 'data' => isset($queryData) ? $queryData : false]);
    }

    public function onChangeCoverImage()
    {
        if (!$this->checkPermission(['faculty'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        if (empty($_FILES['coverImage']['name'])) {
            $response = ['status' => false, 'errorMessage' => 'File is required!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // Load the string helper
        $this->load->helper('string');
        $this->load->library('image_lib');

        // Set the configuration for image manipulation
        $imgConfig['image_library'] = 'gd2';
        $imgConfig['source_image'] = $_FILES["coverImage"]["tmp_name"];
        $imgConfig['create_thumb'] = FALSE;
        $imgConfig['maintain_ratio'] = TRUE;
        $imgConfig['width'] = 2000; // Set the desired width
        $imgConfig['height'] = 1335; // Set the desired height

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

        $newFileName = random_string('alnum', 30);
        $fileExtention = explode(".", $_FILES["coverImage"]["name"]);
        $config['upload_path'] = './assets/images/cover';
        $config['file_name'] = $newFileName . "." . $fileExtention[count($fileExtention) - 1];
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size'] = '2048';
        $this->upload->initialize($config);

        if (!$this->upload->do_upload('coverImage')) {
            $response = ['status' => false, 'errorMessage' => 'Image Upload Error! : ' . $this->upload->display_errors()];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // query cover image data
        $queryCoverImage = $this->db->get_where('cwie_cover_image', array('faculty_id' => $this->session->userdata('crudSessionData')['crudId']));

        if ($queryCoverImage->num_rows() > 0) {
            if (file_exists('./assets/images/cover/' . $queryCoverImage->row()->cover_image_name . $queryCoverImage->row()->cover_image_type)) {
                // delete exist image
                if (!unlink('./assets/images/cover/' . $queryCoverImage->row()->cover_image_name . $queryCoverImage->row()->cover_image_type)) {
                    $response = ['status' => false, 'errorMessage' => 'Failed to unlink video file : ' . error_get_last()['message']];
                    header('Content-Type: application/json');
                    echo json_encode($response);
                    return;
                }
            }

            $CoverImageData = [
                'cover_image_name' => $newFileName,
                'cover_image_type' => '.' . $fileExtention[count($fileExtention) - 1],
                'faculty_id' => $this->session->userdata('crudSessionData')['crudId'],
            ];

            // update cover Data
            if (!$this->db->update('cwie_cover_image', $CoverImageData, array('faculty_id' => $this->session->userdata('crudSessionData')['crudId']))) {
                $response = ['status' => false, 'errorMessage' => 'DB ERROR! : ' . $this->db->error()['message']];
                header('Content-Type: application/json');
                echo json_encode($response);
                return;
            }
        } else {
            $CoverImageData = [
                'cover_image_name' => $newFileName,
                'cover_image_type' => '.' . $fileExtention[count($fileExtention) - 1],
                'faculty_id' => $this->session->userdata('crudSessionData')['crudId'],
            ];

            // insert cover Data
            if (!$this->db->insert('cwie_cover_image', $CoverImageData)) {
                $response = ['status' => false, 'errorMessage' => 'DB ERROR! : ' . $this->db->error()['message']];
                header('Content-Type: application/json');
                echo json_encode($response);
                return;
            }
        }

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => true]);
    }
}
