<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PsType extends CI_Controller
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
        $response['page'] = 'CWIE Personnel Type';

        $this->load->view('z_template/header', $response);
        $this->load->view('cwiePersonnelType/cwiePersonnelTypePage', $response);
        $this->load->view('z_template/footer');
    }

    public function editModal($psTypeID = null)
    {
        if (!$this->checkPermission(['admin'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        if ($psTypeID == null) {
            $response = ['status' => false, 'errorMessage' =>  "Parameter Not Found!"];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        $response = [
            'status' => true,
            'queryData' => $this->getPsType($psTypeID),
            'data' =>  $this->load->view('cwiePersonnelType/cwiePersonnelTypeEditPage', null, true)
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

        $response = ['status' => true, 'data' =>  $this->load->view('cwiePersonnelType/cwiePersonnelTypeAddPage', null, true)];
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    /*
    | --------------------------------------------------------------------------------
    | Functions Section
    | --------------------------------------------------------------------------------
    */

    public function getPsType($psTypeID = null)
    {
        if (!$this->checkPermission(['admin'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // query psType by id
        if ($psTypeID != null) {
            $queryPsType = $this->db->get_where('cwie_personnel_type', array('personnel_type_id' => $psTypeID));

            if ($queryPsType->num_rows() <= 0) {
                header('Content-Type: application/json');
                echo json_encode($response = ['status' => 'false', 'errorMessage' => 'Coordinator Not Found!']);
                return;
            }

            $response = [
                'psTypeID' => $queryPsType->row()->personnel_type_id,
                'psTypeName' => $queryPsType->row()->personnel_type_title,
            ];
            return $response;
        }

        // query personnel tpye
        $queryPsType = $this->db->select('cwie_personnel_type.personnel_type_id, personnel_type_title, COUNT(personnel_id) AS personnel_count')
            ->join('cwie_personnel', 'cwie_personnel_type.personnel_type_id = cwie_personnel.personnel_type_id', 'left')
            ->group_by('cwie_personnel_type.personnel_type_id')
            ->order_by('personnel_type_id', 'DESC')
            ->get('cwie_personnel_type');
        foreach ($queryPsType->result() as $psType) {
            $queryData[] = [
                'psTypeID' => $psType->personnel_type_id,
                'psTypeName' => $psType->personnel_type_title,
                'psCount' => $psType->personnel_count
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => 'true', 'data' => isset($queryData) ? $queryData : []]);
    }

    public function onAddPsType()
    {
        if (!$this->checkPermission(['admin'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // validate personnelType
        $this->form_validation->set_rules('personnelType', '', 'trim|required');

        // On validation errors
        if (!$this->form_validation->run()) {
            $response = ['status' => false, 'errorMessage' => 'Validatation Error !'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // post personnelType variable with xss clean
        $personnelType = $this->input->post('personnelType', true);

        // personnelType insert data
        $psTypeInsertData = [
            'personnel_type_title' => $personnelType,
        ];

        if (!$this->db->insert('cwie_personnel_type', $psTypeInsertData)) {
            $response = ['status' => false, 'errorMessage' => 'DB ERROR! : ' . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => true]);
    }

    public function onEditPsType()
    {
        if (!$this->checkPermission(['admin'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // validate personnelTypeID
        $this->form_validation->set_rules('personnelTypeID', '', 'trim|required');
        // validate personnelType
        $this->form_validation->set_rules('personnelType', '', 'trim|required');

        // On validation errors
        if (!$this->form_validation->run()) {
            $response = ['status' => false, 'errorMessage' => 'Validatation Error !'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // post personnelType variable with xss clean
        $personnelTypeID = $this->input->post('personnelTypeID', true);
        $personnelType = $this->input->post('personnelType', true);

        // personnelType update data
        $psTypeUpdateData = [
            'personnel_type_title' => $personnelType,
        ];

        if (!$this->db->update('cwie_personnel_type', $psTypeUpdateData, array('personnel_type_id' => $personnelTypeID))) {
            $response = ['status' => false, 'errorMessage' => 'DB ERROR! : ' . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => true]);
    }

    public function onDeletePsType($psTypeID = null)
    {
        if (!$this->checkPermission(['admin'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // if Personnel Type id not set
        if ($psTypeID == null) {
            $response = ['status' => false, 'errorMessage' => "Parameter Not Found!"];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // if Personnel Type error
        if (!$queryPersonnelType = $this->db->select('personnel_type_id')->get_where('cwie_personnel_type', array('personnel_type_id' => $psTypeID))) {
            $response = ['status' => false, 'errorMessage' => "DB Error! " . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // if not found Personnel Type by id
        if ($queryPersonnelType->num_rows() <= 0) {
            $response = ['status' => false, 'errorMessage' => "Personnel Type Not Found!"];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // if delete Personnel Type error
        if (!$this->db->delete('cwie_personnel_type', array('personnel_type_id' => $queryPersonnelType->row()->personnel_type_id))) {
            $response = ['status' => false, 'errorMessage' => "DB Error! " . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => true]);
    }
}
