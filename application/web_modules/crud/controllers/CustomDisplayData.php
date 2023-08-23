<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CustomDisplayData extends CI_Controller
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
        if (!$this->checkPermission(['faculty', 'admin'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        $response = $this->mainVariable();
        $response['page'] = 'Custom Display Data';

        $this->load->view('z_template/header', $response);
        $this->load->view('customDisplayData/customDisplayDataPage', $response);
        $this->load->view('z_template/footer');
    }

    public function addModal()
    {
        if (!$this->checkPermission(['admin', 'faculty'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        $response = ['status' => true, 'data' =>  $this->load->view('customDisplayData/customDisplayDataAddPage', null, true)];
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function editModal($customDisplayDataID = null)
    {
        if (!$this->checkPermission(['admin', 'faculty'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        if ($customDisplayDataID == null) {
            $response = ['status' => false, 'errorMessage' =>  "Parameter Not Found!"];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        $response = [
            'status' => true,
            'queryData' => $this->getCustomDisplayData($customDisplayDataID),
            'data' =>  $this->load->view('customDisplayData/customDisplayDataEditPage', null, true)
        ];
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function iconList()
    {
        $response = $this->mainVariable();
        $response['page'] = 'Custom Display Data';

        $this->load->view('customDisplayData/iconListPage', $response);
    }
    /*
    | --------------------------------------------------------------------------------
    | Functions Section
    | --------------------------------------------------------------------------------
    */

    public function getCustomDisplayData($customDisplayDataID = null)
    {

        if (!$this->checkPermission(['faculty', 'admin'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // query custom display data by id
        if ($customDisplayDataID != null) {
            $querycustomDisplayData = $this->db->get_where('cwie_custom_display_data', array('custom_display_data_id' => $customDisplayDataID));

            if ($querycustomDisplayData->num_rows() <= 0) {
                $response = ['status' => false, 'errorMessage' => 'Data Not Found!'];
                header('Content-Type: application/json');
                echo json_encode($response);
                return;
            }

            $queryData = [
                'customDisplayDataID' => $querycustomDisplayData->row()->custom_display_data_id,
                'customDisplayDataTitle' => $querycustomDisplayData->row()->custom_display_data_title,
                'customDisplayData' => $querycustomDisplayData->row()->custom_display_data,
                'customDisplayDataUnit' => $querycustomDisplayData->row()->custom_display_data_unit,
                'customDisplayDataIcon' => $querycustomDisplayData->row()->custom_display_data_icon,
                'customDisplayDataColor' => $querycustomDisplayData->row()->custom_display_data_color,
                'facultyID' => $querycustomDisplayData->row()->faculty_id,
            ];

            return $queryData;
        }

        // query Custom Display Data by faculty
        if ($this->session->userdata('crudSessionData')['crudPermission'] == 'faculty') {
            $querycustomDisplayData = $this->db->get_where('cwie_custom_display_data', array('faculty_id' => $this->session->userdata('crudSessionData')['crudId']));

            foreach ($querycustomDisplayData->result() as $customDisplayData) {
                $queryData[] = [
                    'customDisplayDataID' => $customDisplayData->custom_display_data_id,
                    'customDisplayDataTitle' => $customDisplayData->custom_display_data_title,
                    'customDisplayData' => $customDisplayData->custom_display_data,
                    'customDisplayDataUnit' => $customDisplayData->custom_display_data_unit,
                    'customDisplayDataIcon' => $customDisplayData->custom_display_data_icon,
                    'customDisplayDataColor' => $customDisplayData->custom_display_data_color,
                ];
            }

            header('Content-Type: application/json');
            echo json_encode($response = ['status' => 'true', 'data' => isset($queryData) ? $queryData : []]);
            return;
        }

        // query Custom Display Data
        $querycustomDisplayData = $this->db->get('cwie_custom_display_data');
        foreach ($querycustomDisplayData->result() as $customDisplayData) {
            $queryData[] = [
                'customDisplayDataID' => $customDisplayData->custom_display_data_id,
                'customDisplayDataTitle' => $customDisplayData->custom_display_data_title,
                'customDisplayData' => $customDisplayData->custom_display_data,
                'customDisplayDataUnit' => $customDisplayData->custom_display_data_unit,
                'customDisplayDataIcon' => $customDisplayData->custom_display_data_icon,
                'customDisplayDataColor' => $customDisplayData->custom_display_data_color,
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => 'true', 'data' => isset($queryData) ? $queryData : []]);
    }

    public function onAddCustomDisplayData()
    {
        // validate dataTitle
        $this->form_validation->set_rules('dataTitle', '', 'trim|required');
        // validate data
        $this->form_validation->set_rules('data', '', 'trim|required');
        // validate unit
        $this->form_validation->set_rules('unit', '', 'trim|required');
        // validate icon
        $this->form_validation->set_rules('icon', '', 'trim|required');
        // validate color
        $this->form_validation->set_rules('color', '', 'trim|required');

        // On validation errors
        if (!$this->form_validation->run()) {
            $response = ['status' => false, 'errorMessage' => 'Validatation Error !'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // post variable with xss clean
        if ($this->input->post('facultyID', true)) {
            $facultyID = $this->input->post('facultyID', true);
        }
        $dataTitle = $this->input->post('dataTitle', true);
        $data = $this->input->post('data', true);
        $unit = $this->input->post('unit', true);
        $icon = $this->input->post('icon', true);
        $color = $this->input->post('color', true);

        $insertData = [
            'custom_display_data_title' => $dataTitle,
            'custom_display_data' => $data,
            'custom_display_data_unit' => $unit,
            'custom_display_data_icon' => $icon,
            'custom_display_data_color' => $color,
            'faculty_id' => isset($facultyID) ? $facultyID : $this->session->userdata('crudSessionData')['crudId'],
        ];

        if (!$this->db->insert('cwie_custom_display_data', $insertData)) {
            $response = ['status' => false, 'errorMessage' => 'DB ERROR! : ' . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => true]);
    }

    public function onEditCustomDisplayData()
    {
        if (!$this->checkPermission(['admin', 'faculty'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // validate customDisplayDataID
        $this->form_validation->set_rules('customDisplayDataID', '', 'trim|required');
        // validate dataTitle
        $this->form_validation->set_rules('dataTitle', '', 'trim|required');
        // validate data
        $this->form_validation->set_rules('data', '', 'trim|required');
        // validate unit
        $this->form_validation->set_rules('unit', '', 'trim|required');
        // validate icon
        $this->form_validation->set_rules('icon', '', 'trim|required');
        // validate color
        $this->form_validation->set_rules('color', '', 'trim|required');

        // On validation errors
        if (!$this->form_validation->run()) {
            $response = ['status' => false, 'errorMessage' => 'Validatation Error !'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // post variable with xss clean
        if ($this->input->post('facultyID', true)) {
            $facultyID = $this->input->post('facultyID', true);
        }
        $customDisplayDataID = $this->input->post('customDisplayDataID', true);
        $dataTitle = $this->input->post('dataTitle', true);
        $data = $this->input->post('data', true);
        $unit = $this->input->post('unit', true);
        $icon = $this->input->post('icon', true);
        $color = $this->input->post('color', true);

        // update data
        $UpdateData = [
            'custom_display_data_title' => $dataTitle,
            'custom_display_data' => $data,
            'custom_display_data_unit' => $unit,
            'custom_display_data_icon' => $icon,
            'custom_display_data_color' => $color,
            'faculty_id' => isset($facultyID) ? $facultyID : $this->session->userdata('crudSessionData')['crudId'],
        ];

        if (!$this->db->update('cwie_custom_display_data', $UpdateData, array('custom_display_data_id' => $customDisplayDataID))) {
            $response = ['status' => false, 'errorMessage' => 'DB ERROR! : ' . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => true]);
    }

    public function onDeleteCustomDisplayData($customDisplayDataID = null)
    {
        if (!$this->checkPermission(['faculty', 'admin'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // if customDisplayDataID id not set
        if ($customDisplayDataID == null) {
            $response = ['status' => false, 'errorMessage' => "Parameter Not Found!"];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // query customDisplayData
        $querycustomDisplayData = $this->db->get_where('cwie_custom_display_data', array('custom_display_data_id' => $customDisplayDataID));

        // if not found customDisplayData by id
        if ($querycustomDisplayData->num_rows() <= 0) {
            $response = ['status' => false, 'errorMessage' => "Custom Display Data Not Found!"];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // if delete customDisplayData error
        if (!$this->db->delete('cwie_custom_display_data', array('custom_display_data_id' => $querycustomDisplayData->row()->custom_display_data_id))) {
            $response = ['status' => false, 'errorMessage' => "DB Error! " . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => true]);
    }
}
