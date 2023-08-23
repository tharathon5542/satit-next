<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PsTrophy extends CI_Controller
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
        $response['page'] = 'CWIE Personnel Trophy';

        $this->load->view('z_template/header', $response);
        $this->load->view('cwiePersonnelTrophy/cwiePersonnelTrophyPage', $response);
        $this->load->view('z_template/footer');
    }

    public function editModal($psTrophyID = null)
    {
        if (!$this->checkPermission(['admin'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        if ($psTrophyID == null) {
            $response = ['status' => false, 'errorMessage' =>  "Parameter Not Found!"];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        $response = [
            'status' => true,
            'queryData' => $this->getPsTrophy($psTrophyID),
            'data' =>  $this->load->view('cwiePersonnelTrophy/cwiePersonnelTrophyEditPage', null, true)
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

        $response = ['status' => true, 'data' =>  $this->load->view('cwiePersonnelTrophy/cwiePersonnelTrophyAddPage', null, true)];
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    /*
    | --------------------------------------------------------------------------------
    | Functions Section
    | --------------------------------------------------------------------------------
    */

    public function getPsTrophy($psTrophyID = null)
    {
        if (!$this->checkPermission(['admin'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // query psTrophy by id
        if ($psTrophyID != null) {
            $queryPsTrophy = $this->db->get_where('cwie_personnel_trophy', array('personnel_trophy_id' => $psTrophyID));

            if ($queryPsTrophy->num_rows() <= 0) {
                header('Content-Type: application/json');
                echo json_encode($response = ['status' => 'false', 'errorMessage' => 'Personnel trophy Not Found!']);
                return;
            }

            $response = [
                'psTrophyID' => $queryPsTrophy->row()->personnel_trophy_id,
                'psTrophyName' => $queryPsTrophy->row()->personnel_trophy_name,
                'psTrophyAgency' => $queryPsTrophy->row()->personnel_trophy_agency,
            ];
            return $response;
        }

        // query trophy training
        $queryPsTrophy = $this->db->order_by('personnel_trophy_id', 'DESC')
            ->get('cwie_personnel_trophy');
        foreach ($queryPsTrophy->result() as $psTrophy) {
            $queryData[] = [
                'psTrophyID' => $psTrophy->personnel_trophy_id,
                'psTrophyName' => $psTrophy->personnel_trophy_name,
                'psTrophyAgency' => $psTrophy->personnel_trophy_agency,
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => 'true', 'data' => isset($queryData) ? $queryData : []]);
    }

    public function onAddPsTrophy()
    {
        if (!$this->checkPermission(['admin'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // validate personnelTrophyName
        $this->form_validation->set_rules('personnelTrophyName', '', 'trim|required');
        // validate personnelTrophyAgency
        $this->form_validation->set_rules('personnelTrophyAgency', '', 'trim|required');

        // On validation errors
        if (!$this->form_validation->run()) {
            $response = ['status' => false, 'errorMessage' => 'Validatation Error !'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // post personnel trophy variable with xss clean
        $personnelTrophyName = $this->input->post('personnelTrophyName', true);
        $personnelTrophyAgency = $this->input->post('personnelTrophyAgency', true);

        // personnel training insert data
        $psTrophyInsertData = [
            'personnel_trophy_name' => $personnelTrophyName,
            'personnel_trophy_agency' => $personnelTrophyAgency,
        ];

        if (!$this->db->insert('cwie_personnel_trophy', $psTrophyInsertData)) {
            $response = ['status' => false, 'errorMessage' => 'DB ERROR! : ' . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => true]);
    }

    public function onEditPsTrophy()
    {
        if (!$this->checkPermission(['admin'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // validate personnelTrophyName
        $this->form_validation->set_rules('personnelTrophyName', '', 'trim|required');
        // validate personnelTrophyAgency
        $this->form_validation->set_rules('personnelTrophyAgency', '', 'trim|required');

        // On validation errors
        if (!$this->form_validation->run()) {
            $response = ['status' => false, 'errorMessage' => 'Validatation Error !'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // post personnelType variable with xss clean
        $personnelTrophyID = $this->input->post('personnelTrophyID', true);
        $personnelTrophyName = $this->input->post('personnelTrophyName', true);
        $personnelTrophyAgency = $this->input->post('personnelTrophyAgency', true);

        // personnel training update data
        $psTrophyUpdateData = [
            'personnel_trophy_name' => $personnelTrophyName,
            'personnel_trophy_agency' => $personnelTrophyAgency,
        ];

        if (!$this->db->update('cwie_personnel_trophy', $psTrophyUpdateData, array('personnel_trophy_id' => $personnelTrophyID))) {
            $response = ['status' => false, 'errorMessage' => 'DB ERROR! : ' . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => true]);
    }

    public function onDeletePsTrophy($psTrophyID = null)
    {
        if (!$this->checkPermission(['admin'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // if Personnel Trophy id not set
        if ($psTrophyID == null) {
            $response = ['status' => false, 'errorMessage' => "Parameter Not Found!"];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // if Personnel Trophy error
        if (!$queryPersonnelTrophy = $this->db->select('personnel_trophy_id')->get_where('cwie_personnel_trophy', array('personnel_trophy_id' => $psTrophyID))) {
            $response = ['status' => false, 'errorMessage' => "DB Error! " . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // if not found Personnel Trophy by id
        if ($queryPersonnelTrophy->num_rows() <= 0) {
            $response = ['status' => false, 'errorMessage' => "Personnel Trophy Not Found!"];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // if delete Personnel Trophy error
        if (!$this->db->delete('cwie_personnel_trophy', array('personnel_trophy_id' => $queryPersonnelTrophy->row()->personnel_trophy_id))) {
            $response = ['status' => false, 'errorMessage' => "DB Error! " . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => true]);
    }
}
