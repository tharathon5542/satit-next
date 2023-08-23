<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Isced extends CI_Controller
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
        $response['page'] = 'ISCED';

        $this->load->view('z_template/header', $response);
        $this->load->view('isced/iscedPage', $response);
        $this->load->view('z_template/footer');
    }

    public function editModal($iscedID = null)
    {
        if (!$this->checkPermission(['admin'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        if ($iscedID == null) {
            $response = ['status' => false, 'errorMessage' =>  "Parameter Not Found!"];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        $response = [
            'status' => true,
            'queryData' => $this->getIsced($iscedID),
            'data' =>  $this->load->view('isced/iscedEditPage', null, true)
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

        $response = ['status' => true, 'data' =>  $this->load->view('isced/iscedAddPage', null, true)];
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    /*
    | --------------------------------------------------------------------------------
    | Functions Section
    | --------------------------------------------------------------------------------
    */

    public function getIsced($iscedID = null)
    {
        if (!$this->checkPermission(['admin'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // query category by id
        if ($iscedID != null) {
            $queryIsced = $this->db->get_where('cwie_isced', array('isced_id' => $iscedID));

            if ($queryIsced->num_rows() <= 0) {
                header('Content-Type: application/json');
                echo json_encode($response = ['status' => 'false', 'errorMessage' => 'ISCED Not Found!']);
                return;
            }

            $response = [
                'iscedID' => $queryIsced->row()->isced_id,
                'iscedName' => $queryIsced->row()->isced_name,
            ];
            return $response;
        }

        // query ISCED
        $queryIsced = $this->db->select('cwie_isced.isced_id, isced_name, count(course_id) as iscedCount')
            ->join('cwie_course', 'cwie_isced.isced_id = cwie_course.isced_id', 'left')
            ->group_by('cwie_isced.isced_id')
            ->order_by('isced_id', 'DESC')
            ->get('cwie_isced');

        foreach ($queryIsced->result() as $isced) {
            $queryData[] = [
                'iscedID' => $isced->isced_id,
                'iscedName' => $isced->isced_name,
                'iscedCount' => $isced->iscedCount,
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => 'true', 'data' => isset($queryData) ? $queryData : []]);
    }

    public function onAddIsced()
    {
        if (!$this->checkPermission(['admin'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // validate iscedName
        $this->form_validation->set_rules('iscedName', '', 'trim|required');

        // On validation errors
        if (!$this->form_validation->run()) {
            $response = ['status' => false, 'errorMessage' => 'Validatation Error !'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // post year variable with xss clean
        $iscedName = $this->input->post('iscedName', true);

        if (!$this->db->insert('cwie_isced', ['isced_name' =>  $iscedName])) {
            $response = ['status' => false, 'errorMessage' => 'DB ERROR! : ' . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => true]);
    }

    public function onEditIsced()
    {
        if (!$this->checkPermission(['admin'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // validate iscedID
        $this->form_validation->set_rules('iscedID', '', 'trim|required');
        // validate iscedName
        $this->form_validation->set_rules('iscedName', '', 'trim|required');

        // On validation errors
        if (!$this->form_validation->run()) {
            $response = ['status' => false, 'errorMessage' => 'Validatation Error !'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // post isced variable with xss clean
        $iscedID = $this->input->post('iscedID', true);
        $iscedName = $this->input->post('iscedName', true);

        if (!$this->db->update('cwie_isced', ['isced_name' => $iscedName], array('isced_id' => $iscedID))) {
            $response = ['status' => false, 'errorMessage' => 'DB ERROR! : ' . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => true]);
    }

    public function onDeleteIsced($iscedID = null)
    {
        if (!$this->checkPermission(['admin'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // if isced id not set
        if ($iscedID == null) {
            $response = ['status' => false, 'errorMessage' => "Parameter Not Found!"];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // query isced
        $queryIsced = $this->db->get_where('cwie_isced', array('isced_id' => $iscedID));

        // if not found category by id
        if ($queryIsced->num_rows() <= 0) {
            $response = ['status' => false, 'errorMessage' => "ISCED Not Found!"];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // if delete isced error
        if (!$this->db->delete('cwie_isced', array('isced_id' => $queryIsced->row()->isced_id))) {
            $response = ['status' => false, 'errorMessage' => "DB Error! " . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => true]);
    }
}
