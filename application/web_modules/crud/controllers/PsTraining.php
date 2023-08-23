<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PsTraining extends CI_Controller
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
        $response['page'] = 'CWIE Personnel Training';

        $this->load->view('z_template/header', $response);
        $this->load->view('cwiePersonnelTraining/cwiePersonnelTrainingPage', $response);
        $this->load->view('z_template/footer');
    }

    public function editModal($psTrainingID = null)
    {
        if (!$this->checkPermission(['admin'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        if ($psTrainingID == null) {
            $response = ['status' => false, 'errorMessage' =>  "Parameter Not Found!"];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        $response = [
            'status' => true,
            'queryData' => $this->getPsTraining($psTrainingID),
            'data' =>  $this->load->view('cwiePersonnelTraining/cwiePersonnelTrainingEditPage', null, true)
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

        $response = ['status' => true, 'data' =>  $this->load->view('cwiePersonnelTraining/cwiePersonnelTrainingAddPage', null, true)];
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    /*
    | --------------------------------------------------------------------------------
    | Functions Section
    | --------------------------------------------------------------------------------
    */

    public function getPsTraining($psTrainingID = null)
    {
        if (!$this->checkPermission(['admin'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // query psType by id
        if ($psTrainingID != null) {
            $queryPsTraining = $this->db->get_where('cwie_personnel_training', array('personnel_training_id' => $psTrainingID));

            if ($queryPsTraining->num_rows() <= 0) {
                header('Content-Type: application/json');
                echo json_encode($response = ['status' => 'false', 'errorMessage' => 'Personnel training Not Found!']);
                return;
            }

            $response = [
                'psTrainingID' => $queryPsTraining->row()->personnel_training_id,
                'psTrainingName' => $queryPsTraining->row()->personnel_training_name,
                'psTrainingDate' => $queryPsTraining->row()->personnel_training_date,
                'psTrainingAgency' => $queryPsTraining->row()->personnel_training_agency,
                'psTrainingPlace' => $queryPsTraining->row()->personnel_training_place,
            ];
            return $response;
        }

        // query personnel training
        $queryPsTraining = $this->db->order_by('personnel_training_id', 'DESC')
            ->get('cwie_personnel_training');
        foreach ($queryPsTraining->result() as $psTraining) {
            $queryData[] = [
                'psTrainingID' => $psTraining->personnel_training_id,
                'psTrainingName' => $psTraining->personnel_training_name,
                'psTrainingAgency' => $psTraining->personnel_training_agency,
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => 'true', 'data' => isset($queryData) ? $queryData : []]);
    }

    public function onAddPsTraining()
    {
        if (!$this->checkPermission(['admin'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // validate personnelTrainingName
        $this->form_validation->set_rules('personnelTrainingName', '', 'trim|required');
        // validate personnelTrainingDate
        $this->form_validation->set_rules('personnelTrainingDate', '', 'trim|required');
        // validate personnelTrainingAgency
        $this->form_validation->set_rules('personnelTrainingAgency', '', 'trim|required');
        // validate personnelTrainingPlace
        $this->form_validation->set_rules('personnelTrainingPlace', '', 'trim|required');

        // On validation errors
        if (!$this->form_validation->run()) {
            $response = ['status' => false, 'errorMessage' => 'Validatation Error !'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // post personnelType variable with xss clean
        $personnelTrainingName = $this->input->post('personnelTrainingName', true);
        $personnelTrainingDate = $this->input->post('personnelTrainingDate', true);
        $personnelTrainingAgency = $this->input->post('personnelTrainingAgency', true);
        $personnelTrainingPlace = $this->input->post('personnelTrainingPlace', true);

        // personnel training insert data
        $psTrainingInsertData = [
            'personnel_training_name' => $personnelTrainingName,
            'personnel_training_date' => $personnelTrainingDate,
            'personnel_training_agency' => $personnelTrainingAgency,
            'personnel_training_place' => $personnelTrainingPlace,
        ];

        if (!$this->db->insert('cwie_personnel_training', $psTrainingInsertData)) {
            $response = ['status' => false, 'errorMessage' => 'DB ERROR! : ' . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => true]);
    }

    public function onEditPsTraining()
    {
        if (!$this->checkPermission(['admin'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // validate personnelTrainingName
        $this->form_validation->set_rules('personnelTrainingName', '', 'trim|required');
        // validate personnelTrainingDate
        $this->form_validation->set_rules('personnelTrainingDate', '', 'trim|required');
        // validate personnelTrainingAgency
        $this->form_validation->set_rules('personnelTrainingAgency', '', 'trim|required');
        // validate personnelTrainingPlace
        $this->form_validation->set_rules('personnelTrainingPlace', '', 'trim|required');

        // On validation errors
        if (!$this->form_validation->run()) {
            $response = ['status' => false, 'errorMessage' => 'Validatation Error !'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // post personnelType variable with xss clean
        $personnelTrainingID = $this->input->post('personnelTrainingID', true);
        $personnelTrainingName = $this->input->post('personnelTrainingName', true);
        $personnelTrainingDate = $this->input->post('personnelTrainingDate', true);
        $personnelTrainingAgency = $this->input->post('personnelTrainingAgency', true);
        $personnelTrainingPlace = $this->input->post('personnelTrainingPlace', true);

        // personnel training update data
        $psTrainingUpdateData = [
            'personnel_training_name' => $personnelTrainingName,
            'personnel_training_date' => $personnelTrainingDate,
            'personnel_training_agency' => $personnelTrainingAgency,
            'personnel_training_place' => $personnelTrainingPlace,
        ];

        if (!$this->db->update('cwie_personnel_training', $psTrainingUpdateData, array('personnel_training_id' => $personnelTrainingID))) {
            $response = ['status' => false, 'errorMessage' => 'DB ERROR! : ' . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => true]);
    }

    public function onDeletePsTraining($psTrainingID = null)
    {
        if (!$this->checkPermission(['admin'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // if Personnel Training id not set
        if ($psTrainingID == null) {
            $response = ['status' => false, 'errorMessage' => "Parameter Not Found!"];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // if Personnel Training error
        if (!$queryPersonnelTraining = $this->db->select('personnel_training_id')->get_where('cwie_personnel_training', array('personnel_training_id' => $psTrainingID))) {
            $response = ['status' => false, 'errorMessage' => "DB Error! " . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // if not found Personnel Training by id
        if ($queryPersonnelTraining->num_rows() <= 0) {
            $response = ['status' => false, 'errorMessage' => "Personnel Training Not Found!"];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // if delete Personnel Training error
        if (!$this->db->delete('cwie_personnel_training', array('personnel_training_id' => $queryPersonnelTraining->row()->personnel_training_id))) {
            $response = ['status' => false, 'errorMessage' => "DB Error! " . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => true]);
    }
}
