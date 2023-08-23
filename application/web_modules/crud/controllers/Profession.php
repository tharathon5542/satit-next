<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profession extends CI_Controller
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
        $response['page'] = 'Profession';

        $this->load->view('z_template/header', $response);
        $this->load->view('profession/professionPage', $response);
        $this->load->view('z_template/footer');
    }

    public function editModal($professionID = null)
    {
        if (!$this->checkPermission(['admin'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        if ($professionID == null) {
            $response = ['status' => false, 'errorMessage' =>  "Parameter Not Found!"];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        $response = [
            'status' => true,
            'queryData' => $this->getProfession($professionID),
            'data' =>  $this->load->view('profession/professionEditPage', null, true)
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

        $response = ['status' => true, 'data' =>  $this->load->view('profession/professionAddPage', null, true)];
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    /*
    | --------------------------------------------------------------------------------
    | Functions Section
    | --------------------------------------------------------------------------------
    */

    public function getProfession($professionID = null)
    {
        if (!$this->checkPermission(['admin'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // query profession by id
        if ($professionID != null) {
            $queryProfession = $this->db->get_where('cwie_profession', array('profession_id' => $professionID));

            if ($queryProfession->num_rows() <= 0) {
                header('Content-Type: application/json');
                echo json_encode($response = ['status' => 'false', 'errorMessage' => 'Profession Not Found!']);
                return;
            }

            $response = [
                'professionID' => $queryProfession->row()->profession_id,
                'professionName' => $queryProfession->row()->profession_name,
            ];
            return $response;
        }

        // query profession
        $queryProfession = $this->db->select('cwie_profession.profession_id, profession_name, count(course_id) as professionCount')
            ->join('cwie_course', 'cwie_profession.profession_id = cwie_course.profession_id', 'left')
            ->group_by('cwie_profession.profession_id')
            ->order_by('profession_id', 'DESC')
            ->get('cwie_profession');

        foreach ($queryProfession->result() as $profession) {
            $queryData[] = [
                'professionID' => $profession->profession_id,
                'professionName' => $profession->profession_name,
                'professionCount' => $profession->professionCount,
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => 'true', 'data' => isset($queryData) ? $queryData : []]);
    }

    public function onAddProfession()
    {
        if (!$this->checkPermission(['admin'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // validate professionName
        $this->form_validation->set_rules('professionName', '', 'trim|required');

        // On validation errors
        if (!$this->form_validation->run()) {
            $response = ['status' => false, 'errorMessage' => 'Validatation Error !'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // post profession variable with xss clean
        $professionName = $this->input->post('professionName', true);

        if (!$this->db->insert('cwie_profession', ['profession_name' =>  $professionName])) {
            $response = ['status' => false, 'errorMessage' => 'DB ERROR! : ' . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => true]);
    }

    public function onEditProfession()
    {
        if (!$this->checkPermission(['admin'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // validate professionID
        $this->form_validation->set_rules('professionID', '', 'trim|required');
        // validate professionName
        $this->form_validation->set_rules('professionName', '', 'trim|required');

        // On validation errors
        if (!$this->form_validation->run()) {
            $response = ['status' => false, 'errorMessage' => 'Validatation Error !'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // post profession variable with xss clean
        $professionID = $this->input->post('professionID', true);
        $professionName = $this->input->post('professionName', true);

        if (!$this->db->update('cwie_profession', ['profession_name' => $professionName], array('profession_id' => $professionID))) {
            $response = ['status' => false, 'errorMessage' => 'DB ERROR! : ' . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => true]);
    }

    public function onDeleteProfession($professionID = null)
    {
        if (!$this->checkPermission(['admin'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // if professionID id not set
        if ($professionID == null) {
            $response = ['status' => false, 'errorMessage' => "Parameter Not Found!"];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // query profession 
        $queryProfession = $this->db->get_where('cwie_profession', array('profession_id' => $professionID));

        // if not found category by id
        if ($queryProfession->num_rows() <= 0) {
            $response = ['status' => false, 'errorMessage' => "Profession Not Found!"];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // if delete profession error
        if (!$this->db->delete('cwie_profession', array('profession_id' => $queryProfession->row()->profession_id))) {
            $response = ['status' => false, 'errorMessage' => "DB Error! " . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => true]);
    }
}
