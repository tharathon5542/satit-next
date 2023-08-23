<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Banner extends CI_Controller
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
        $response['page'] = 'Banner';

        $this->load->view('z_template/header', $response);
        $this->load->view('banner/bannerPage', $response);
        $this->load->view('z_template/footer');
    }

    public function addModal()
    {
        if (!$this->checkPermission(['admin'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        $response = ['status' => true, 'data' =>  $this->load->view('banner/bannerAddPage', null, true)];
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function editModal($bannerID = null)
    {
        if (!$this->checkPermission(['admin'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        if ($bannerID == null) {
            $response = ['status' => false, 'errorMessage' =>  "Parameter Not Found!"];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        $bannerResponse = $this->getBanner($bannerID);

        $response = [
            'status' => true,
            'bannerResponse' => $bannerResponse,
            'data' =>  $this->load->view('banner/bannerEditPage', null, true)
        ];

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    /*
    | --------------------------------------------------------------------------------
    | Functions Section
    | --------------------------------------------------------------------------------
    */

    public function getBanner($bannerID = null)
    {

        if (!$this->checkPermission(['admin'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // query banner by id
        if ($bannerID != null) {
            $queryBanner = $this->db->get_where('cwie_banner_image', array('banner_id' => $bannerID));

            if ($queryBanner->num_rows() <= 0) {
                echo json_encode($response = ['status' => 'false', 'errorMessage' => 'Banner Not Found!']);
                return;
            }

            $response = [
                'bannerID' => $queryBanner->row()->banner_id,
                'bannerImageName' =>  $queryBanner->row()->banner_image_name,
                'bannerImageType' => $queryBanner->row()->banner_image_type,
                'bannerImageOrder' => $queryBanner->row()->banner_image_order,
                'bannerImageDisplay' => $queryBanner->row()->banner_image_display,
            ];

            return $response;
        }

        // query banner
        $queryBanner = $this->db->get('cwie_banner_image');
        foreach ($queryBanner->result() as $banner) {
            $queryData[] = [
                'bannerID' => $banner->banner_id,
                'bannerPath' => base_url('assets/images/bannerSlider/') . $banner->banner_image_name . $banner->banner_image_type,
                'bannerType' => $banner->banner_image_type,
                'bannerOrder' => $banner->banner_image_order,
                'bannerDisplay' => $banner->banner_image_display,
            ];
        }
        header('Content-Type: application/json');
        echo json_encode($response = ['status' => 'true', 'data' => isset($queryData) ? $queryData : []]);
    }

    public function onAddBanner()
    {
        if (!$this->checkPermission(['admin'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // validate bannerOrder
        $this->form_validation->set_rules('bannerOrder', '', 'trim|required');
        // validate bannerDisplay
        $this->form_validation->set_rules('bannerDisplay', '', 'trim');

        // On validation errors
        if (!$this->form_validation->run()) {
            $response = ['status' => false, 'errorMessage' => 'Validatation Error !'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        if (empty($_FILES['bannerFile']['name'])) {
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
        $imgConfig['source_image'] = $_FILES["bannerFile"]["tmp_name"];
        $imgConfig['create_thumb'] = FALSE;
        $imgConfig['maintain_ratio'] = FALSE;
        $imgConfig['width'] = 1920; // Set the desired width
        $imgConfig['height'] = 1000; // Set the desired height

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
        $fileExtention = explode(".", $_FILES["bannerFile"]["name"]);
        $config['upload_path'] = './assets/images/bannerSlider';
        $config['file_name'] = $newFileName . "." . $fileExtention[count($fileExtention) - 1];
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size'] = '2048';
        $this->upload->initialize($config);

        if (!$this->upload->do_upload('bannerFile')) {
            $response = ['status' => false, 'errorMessage' => 'Image Upload Error! : ' . $this->upload->display_errors()];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // post banner variable with xss clean
        $bannerOrder = $this->input->post('bannerOrder', true);
        $bannerDisplay = $this->input->post('bannerDisplay', true);

        $newBannerData = [
            'banner_image_name' => $newFileName,
            'banner_image_type' => '.' . $fileExtention[count($fileExtention) - 1],
            'banner_image_order' => $bannerOrder,
            'banner_image_display' => $bannerDisplay ? 1 : 0,
        ];

        // insert bannerData
        if (!$this->db->insert('cwie_banner_image', $newBannerData)) {
            $response = ['status' => false, 'errorMessage' => 'DB ERROR! : ' . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => true]);
    }

    public function onEditBanner()
    {
        if (!$this->checkPermission(['admin'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // validate bannerID
        $this->form_validation->set_rules('bannerID', '', 'trim|required');
        // validate bannerOrder
        $this->form_validation->set_rules('bannerOrder', '', 'trim|required');
        // validate bannerDisplay
        $this->form_validation->set_rules('bannerDisplay', '', 'trim');

        // On validation errors
        if (!$this->form_validation->run()) {
            $response = ['status' => false, 'errorMessage' => 'Validatation Error !'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // post banner variable with xss clean
        $bannerID = $this->input->post('bannerID', true);
        $bannerOrder = $this->input->post('bannerOrder', true);
        $bannerDisplay = $this->input->post('bannerDisplay', true);

        $updateBannerData = [
            'banner_image_order' => $bannerOrder,
            'banner_image_display' => $bannerDisplay ? 1 : 0,
        ];

        // if there is an new banner image file
        if (!empty($_FILES['bannerFile']['name'])) {
            // Load the string helper
            $this->load->helper('string');

            // query banner data
            $queryBanner = $this->db->get_where('cwie_banner_image', array('banner_id' => $bannerID));

            // if not found banner by id
            if ($queryBanner->num_rows() <= 0) {
                $response = ['status' => false, 'errorMessage' => "Banner Not Found!"];
                header('Content-Type: application/json');
                echo json_encode($response);
                return;
            }

            $newFileName = random_string('alnum', 30);
            $fileExtention = explode(".", $_FILES["bannerFile"]["name"]);
            $config['upload_path'] = './assets/images/bannerSlider';
            $config['file_name'] = $newFileName . "." . $fileExtention[count($fileExtention) - 1];
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = '2048';
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('bannerFile')) {
                $response = ['status' => false, 'errorMessage' => 'Image Upload Error! : ' . $this->upload->display_errors()];
                header('Content-Type: application/json');
                echo json_encode($response);
                return;
            }

            if (file_exists('./assets/images/bannerSlider/' . $queryBanner->row()->banner_image_name . $queryBanner->row()->banner_image_type)) {
                // unlink image
                if (!unlink('./assets/images/bannerSlider/' . $queryBanner->row()->banner_image_name . $queryBanner->row()->banner_image_type)) {
                    $response = ['status' => false, 'errorMessage' => 'Failed to unlink file : ' . error_get_last()['message']];
                    header('Content-Type: application/json');
                    echo json_encode($response);
                    return;
                }
            }

            $updateBannerData['banner_image_name'] = $newFileName;
            $updateBannerData['banner_image_type'] = '.' . $fileExtention[count($fileExtention) - 1];
        }

        // update bannerData
        if (!$this->db->update('cwie_banner_image', $updateBannerData, array('banner_id' => $bannerID))) {
            $response = ['status' => false, 'errorMessage' => 'DB ERROR! : ' . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => true]);
    }

    public function onDeleteBanner($bannerID = null)
    {
        if (!$this->checkPermission(['admin'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        if ($bannerID == null) {
            $response = ['status' => false, 'errorMessage' => 'Parameter not found!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // query banner data
        $queryBanner = $this->db->get_where('cwie_banner_image', array('banner_id' => $bannerID));

        // if not found banner by id
        if ($queryBanner->num_rows() <= 0) {
            $response = ['status' => false, 'errorMessage' => "Banner Not Found!"];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // if delete banner error
        if (!$this->db->delete('cwie_banner_image', array('banner_id' => $bannerID))) {
            $response = ['status' => false, 'errorMessage' => "DB Error! " . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        if (file_exists('./assets/images/bannerSlider/' . $queryBanner->row()->banner_image_name . $queryBanner->row()->banner_image_type)) {
            // unlink image
            if (!unlink('./assets/images/bannerSlider/' . $queryBanner->row()->banner_image_name . $queryBanner->row()->banner_image_type)) {
                $response = ['status' => false, 'errorMessage' => 'Failed to unlink file : ' . error_get_last()['message']];
                header('Content-Type: application/json');
                echo json_encode($response);
                return;
            }
        }

        header('Content-Type: application/json');
        echo json_encode($response = [
            'status' => true,
        ]);
    }
}
