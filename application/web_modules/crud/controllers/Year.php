<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Year extends CI_Controller
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
        $response['page'] = 'Year';

        $this->load->view('z_template/header', $response);
        $this->load->view('year/yearPage', $response);
        $this->load->view('z_template/footer');
    }

    public function editModal($yearID = null)
    {
        if (!$this->checkPermission(['admin'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        if ($yearID == null) {
            $response = ['status' => false, 'errorMessage' =>  "Parameter Not Found!"];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        $response = [
            'status' => true,
            'queryData' => $this->getYear($yearID),
            'data' =>  $this->load->view('year/yearEditPage', null, true)
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

        $response = ['status' => true, 'data' =>  $this->load->view('year/yearAddPage', null, true)];
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    /*
    | --------------------------------------------------------------------------------
    | Functions Section
    | --------------------------------------------------------------------------------
    */

    public function getYear($yearID = null)
    {
        if (!$this->checkPermission(['admin'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // query year by id
        if ($yearID != null) {
            $queryYear = $this->db->get_where('cwie_year', array('year_id' => $yearID));

            if ($queryYear->num_rows() <= 0) {
                header('Content-Type: application/json');
                echo json_encode($response = ['status' => 'false', 'errorMessage' => 'Year Not Found!']);
                return;
            }

            $response = [
                'yearID' => $queryYear->row()->year_id,
                'yearTitle' => $queryYear->row()->year_title,
            ];
            return $response;
        }

        // query year
        $queryYear = $this->db->select('cwie_year.year_id, year_title, count(course_id) as yearCount')
            ->join('cwie_course', 'cwie_year.year_id = cwie_course.year_id', 'left')
            ->group_by('cwie_year.year_id')
            ->order_by('year_id', 'DESC')
            ->get('cwie_year');
        foreach ($queryYear->result() as $year) {
            $queryData[] = [
                'yearID' => $year->year_id,
                'yearTitle' => $year->year_title,
                'yearCount' => $year->yearCount,
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => 'true', 'data' => isset($queryData) ? $queryData : []]);
    }

    public function onAddYear()
    {
        if (!$this->checkPermission(['admin'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // validate yearTitle
        $this->form_validation->set_rules('yearTitle', '', 'trim|required');

        // On validation errors
        if (!$this->form_validation->run()) {
            $response = ['status' => false, 'errorMessage' => 'Validatation Error !'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // post year variable with xss clean
        $yearTitle = $this->input->post('yearTitle', true);

        if (!$this->db->insert('cwie_year', ['year_title' =>  $yearTitle])) {
            $response = ['status' => false, 'errorMessage' => 'DB ERROR! : ' . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => true]);
    }

    public function onEditYear()
    {
        if (!$this->checkPermission(['admin'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // validate yearID
        $this->form_validation->set_rules('yearID', '', 'trim|required');
        // validate yearTitle
        $this->form_validation->set_rules('yearTitle', '', 'trim|required');

        // On validation errors
        if (!$this->form_validation->run()) {
            $response = ['status' => false, 'errorMessage' => 'Validatation Error !'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // post year variable with xss clean
        $yearID = $this->input->post('yearID', true);
        $yearTitle = $this->input->post('yearTitle', true);

        if (!$this->db->update('cwie_year', ['year_title' => $yearTitle], array('year_id' => $yearID))) {
            $response = ['status' => false, 'errorMessage' => 'DB ERROR! : ' . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => true]);
    }

    public function onDeleteYear($yearID = null)
    {
        if (!$this->checkPermission(['admin'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // if year id not set
        if ($yearID == null) {
            $response = ['status' => false, 'errorMessage' => "Parameter Not Found!"];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        //  query year
        $queryYear = $this->db->get_where('cwie_year', array('year_id' => $yearID));

        // if not found year by id
        if ($queryYear->num_rows() <= 0) {
            $response = ['status' => false, 'errorMessage' => "Year Not Found!"];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // if delete year error
        if (!$this->db->delete('cwie_year', array('year_id' => $queryYear->row()->year_id))) {
            $response = ['status' => false, 'errorMessage' => "DB Error! " . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => true]);
    }
}
