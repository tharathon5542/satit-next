<?php
defined('BASEPATH') or exit('No direct script access allowed');

class WPType extends CI_Controller
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
        $response['page'] = 'Work Place Type';

        $this->load->view('z_template/header', $response);
        $this->load->view('workplaceType/workPlaceTypePage', $response);
        $this->load->view('z_template/footer');
    }

    public function editModal($workPlaceTypeID = null)
    {
        if (!$this->checkPermission(['admin'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        if ($workPlaceTypeID == null) {
            $response = ['status' => false, 'errorMessage' =>  "Parameter Not Found!"];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        $response = [
            'status' => true,
            'queryData' => $this->getWorkPlaceType($workPlaceTypeID),
            'data' =>  $this->load->view('workplacetype/workplaceTypeEditPage', null, true)
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

        $response = ['status' => true, 'data' =>  $this->load->view('workplaceType/workplaceTypeAddPage', null, true)];
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    /*
    | --------------------------------------------------------------------------------
    | Functions Section
    | --------------------------------------------------------------------------------
    */

    public function getWorkPlaceType($workPlaceTypeID = null)
    {
        if (!$this->checkPermission(['admin'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // query Work Place Type by id
        if ($workPlaceTypeID != null) {
            $queryWorkplaceType = $this->db->get_where('cwie_workplace_type', array('workplace_type_id' => $workPlaceTypeID));

            if ($queryWorkplaceType->num_rows() <= 0) {
                header('Content-Type: application/json');
                echo json_encode($response = ['status' => 'false', 'errorMessage' => 'Work Place Type Not Found!']);
                return;
            }

            $response = [
                'workplaceTypeID' => $queryWorkplaceType->row()->workplace_type_id,
                'workplaceType' => $queryWorkplaceType->row()->workplace_type,
            ];

            return $response;
        }

        // query work place
        $queryWorkplaceType = $this->db->select('cwie_workplace_type.workplace_type_id, workplace_type, count(workplace_id) as workplace_work_type')
            ->join('cwie_workplace', 'cwie_workplace_type.workplace_type_id = cwie_workplace.workplace_type_id', 'left')
            ->group_by('cwie_workplace_type.workplace_type_id')
            ->order_by('workplace_type_id', 'DESC')
            ->get('cwie_workplace_type');

        foreach ($queryWorkplaceType->result() as $workplaceType) {
            $queryData[] = [
                'workPlaceTypeID' => $workplaceType->workplace_type_id,
                'workPlaceType' => $workplaceType->workplace_type,
                'workPlaceTypeCount' => $workplaceType->workplace_work_type,
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => 'true', 'data' => isset($queryData) ? $queryData : []]);
    }

    public function onAddWorkplaceType()
    {
        if (!$this->checkPermission(['admin'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // validate work place type
        $this->form_validation->set_rules('workplaceType', '', 'trim|required');

        // On validation errors
        if (!$this->form_validation->run()) {
            $response = ['status' => false, 'errorMessage' => 'Validatation Error !'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // post faculty variable with xss clean
        $workplaceType = $this->input->post('workplaceType', true);

        // faculty insert data
        $workPlaceTypeInsertData = [
            'workplace_type' => $workplaceType,
        ];

        if (!$this->db->insert('cwie_workplace_type', $workPlaceTypeInsertData)) {
            $response = ['status' => false, 'errorMessage' => 'DB ERROR! : ' . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => true]);
    }

    public function onEditWorkplaceType()
    {
        if (!$this->checkPermission(['admin'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // validate workPlaceTypeID
        $this->form_validation->set_rules('workPlaceTypeID', '', 'trim|required');
        // validate workplaceType
        $this->form_validation->set_rules('workplaceType', '', 'trim|required');

        // On validation errors
        if (!$this->form_validation->run()) {
            $response = ['status' => false, 'errorMessage' => 'Validatation Error !'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // post workPlaceType variable with xss clean
        $workPlaceTypeID = $this->input->post('workPlaceTypeID', true);
        $workplaceType = $this->input->post('workplaceType', true);

        // workPlaceType update data
        $workPlaceTypeUpdateData = [
            'workplace_type' => $workplaceType,
        ];


        if (!$this->db->update('cwie_workplace_type', $workPlaceTypeUpdateData, array('workplace_type_id' => $workPlaceTypeID))) {
            $response = ['status' => false, 'errorMessage' => 'DB ERROR! : ' . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => true]);
    }

    public function onDeleteWorkplaceType($workPlaceTypeID = null)
    {
        if (!$this->checkPermission(['admin'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // if workPlaceTypeID id not set
        if ($workPlaceTypeID == null) {
            $response = ['status' => false, 'errorMessage' => "Parameter Not Found!"];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        //  query WorkPlaceType
        $queryWorkPlaceType = $this->db->select('workplace_type_id')->get_where('cwie_workplace_type', array('workplace_type_id' => $workPlaceTypeID));

        // if not found major by id
        if ($queryWorkPlaceType->num_rows() <= 0) {
            $response = ['status' => false, 'errorMessage' => "Work place Type Not Found!"];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // if delete WorkPlaceType error
        if (!$this->db->delete('cwie_workplace_type', array('workplace_type_id' => $queryWorkPlaceType->row()->workplace_type_id))) {
            $response = ['status' => false, 'errorMessage' => "DB Error! " . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => true]);
    }
}
