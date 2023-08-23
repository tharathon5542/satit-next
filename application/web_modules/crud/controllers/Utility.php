<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Utility extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('crudSessionData')) {
            redirect(base_url('crud/auth'));
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

    /*
    | --------------------------------------------------------------------------------
    | Functions Section
    | --------------------------------------------------------------------------------
    */

    public function getPersonel($personelID = null)
    {
        if (!$this->checkPermission(['admin', 'faculty', 'major'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // query calendar events
        $personelDB = $this->load->database('personnel_crru', TRUE);

        // query personnel data by id
        if ($personelID != null) {
            $sql = "SELECT
            view_person_detail_qa.citizen_id,
            view_person_detail_qa.person_id,
            view_person_detail_qa.th_ed,
            view_person_detail_qa.fname_th, 
            view_person_detail_qa.lanme_th,
            view_person_detail_qa.mobile_no
            FROM 
            hrm.view_person_detail_qa 
            WHERE 
            view_person_detail_qa.person_id = '$personelID' ";

            $data = $personelDB->query($sql)->result();

            header('Content-Type: application/json');
            echo json_encode($data);
            return;
        }

        // search term variable with xss clean
        $searchTerm = $this->input->post('searchTerm', true);

        $sql = "SELECT
        view_person_detail_qa.person_id,
        view_person_detail_qa.th_ed,
        view_person_detail_qa.fname_th, 
        view_person_detail_qa.lanme_th
        FROM 
        hrm.view_person_detail_qa 
        WHERE 
        view_person_detail_qa.th_ed LIKE '%$searchTerm%' 
        OR
        view_person_detail_qa.fname_th LIKE '%$searchTerm%'
        OR
        view_person_detail_qa.lanme_th LIKE '%$searchTerm%'";

        $data = $personelDB->query($sql)->result();

        foreach ($data as $row) {
            $formattedData[] = [
                'id' => $row->person_id,
                'text' => $row->th_ed . $row->fname_th . ' ' . $row->lanme_th
            ];
        }

        header('Content-Type: application/json');
        echo json_encode(isset($formattedData) ? $formattedData : []);
    }

    public function getZipCode()
    {
        if (!$this->checkPermission(['admin', 'major', 'workplace'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // search term variable with xss clean
        $searchTerm = $this->input->post('searchTerm', true);

        $queryZipCode = $this->db->like('zip_code', $searchTerm)
            ->group_by('zip_code')
            ->limit(100)
            ->get('cwie_subdistrict');

        foreach ($queryZipCode->result() as $row) {
            $formattedData[] = [
                'id' => $row->zip_code,
                'text' => $row->zip_code
            ];
        }

        header('Content-Type: application/json');
        echo json_encode(isset($formattedData) ? $formattedData : []);
    }

    public function getSubDistrict()
    {
        if (!$this->checkPermission(['admin', 'major', 'workplace'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // search term variable with xss clean
        $searchTerm = $this->input->post('searchTerm', true);

        $querySubDistrict = $this->db->like('sub_district_name_th', $searchTerm)
            ->or_like('sub_district_name_en', $searchTerm)
            ->limit(100)
            ->get('cwie_subdistrict');

        foreach ($querySubDistrict->result() as $row) {
            $formattedData[] = [
                'id' => $row->sub_district_name_th,
                'text' => $row->sub_district_name_th
            ];
        }

        header('Content-Type: application/json');
        echo json_encode(isset($formattedData) ? $formattedData : []);
    }

    public function getDistrict()
    {
        if (!$this->checkPermission(['admin', 'major', 'workplace'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // search term variable with xss clean
        $searchTerm = $this->input->post('searchTerm', true);

        $queryDistrict = $this->db->like('district_name_th', $searchTerm)
            ->or_like('district_name_en', $searchTerm)
            ->limit(100)
            ->get('cwie_district');

        foreach ($queryDistrict->result() as $row) {
            $formattedData[] = [
                'id' => $row->district_name_th,
                'text' => $row->district_name_th
            ];
        }

        header('Content-Type: application/json');
        echo json_encode(isset($formattedData) ? $formattedData : []);
    }

    public function getProvince()
    {
        if (!$this->checkPermission(['admin', 'major', 'workplace'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // search term variable with xss clean
        $searchTerm = $this->input->post('searchTerm', true);

        $queryProvince = $this->db->like('province_name_th', $searchTerm)
            ->or_like('province_name_en', $searchTerm)
            ->limit(100)
            ->get('cwie_provinces');

        foreach ($queryProvince->result() as $row) {
            $formattedData[] = [
                'id' => $row->province_name_th,
                'text' => $row->province_name_th
            ];
        }

        header('Content-Type: application/json');
        echo json_encode(isset($formattedData) ? $formattedData : []);
    }

    public function getCountry()
    {
        if (!$this->checkPermission(['admin', 'major', 'workplace'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // search term variable with xss clean
        $searchTerm = $this->input->post('searchTerm', true);

        $queryCountry = $this->db->like('country_nameTH', $searchTerm)
            ->or_like('country_nameEN', $searchTerm)
            ->limit(100)
            ->get('cwie_country');

        foreach ($queryCountry->result() as $row) {
            $formattedData[] = [
                'id' => $row->country_nameTH,
                'text' => $row->country_nameTH
            ];
        }

        header('Content-Type: application/json');
        echo json_encode(isset($formattedData) ? $formattedData : []);
    }
}
