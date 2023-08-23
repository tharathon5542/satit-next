<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CategoryCourse extends CI_Controller
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
        $response['page'] = 'Course Category';

        $this->load->view('z_template/header', $response);
        $this->load->view('categoryCourse/categoryPage', $response);
        $this->load->view('z_template/footer');
    }

    public function editModal($categoryID = null)
    {
        if (!$this->checkPermission(['admin'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        if ($categoryID == null) {
            $response = ['status' => false, 'errorMessage' =>  "Parameter Not Found!"];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        $response = [
            'status' => true,
            'queryData' => $this->getCategory($categoryID),
            'data' =>  $this->load->view('categoryCourse/categoryEditPage', null, true)
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

        $response = ['status' => true, 'data' =>  $this->load->view('categoryCourse/categoryAddPage', null, true)];
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    /*
    | --------------------------------------------------------------------------------
    | Functions Section
    | --------------------------------------------------------------------------------
    */

    public function getCategory($categoryID = null)
    {
        if (!$this->checkPermission(['admin'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // query category by id
        if ($categoryID != null) {
            $queryCategory = $this->db->get_where('cwie_course_category', array('course_category_id' => $categoryID));

            if ($queryCategory->num_rows() <= 0) {
                header('Content-Type: application/json');
                echo json_encode($response = ['status' => 'false', 'errorMessage' => 'Category Not Found!']);
                return;
            }

            $response = [
                'categoryID' => $queryCategory->row()->course_category_id,
                'categoryName' => $queryCategory->row()->course_category_name,
            ];
            return $response;
        }

        // query category
        $queryCategory = $this->db->select('cwie_course_category.course_category_id, course_category_name, count(course_id) as categoryCount')
            ->join('cwie_course', 'cwie_course_category.course_category_id = cwie_course.course_category_id', 'left')
            ->group_by('cwie_course_category.course_category_id')
            ->order_by('course_category_id', 'DESC')
            ->get('cwie_course_category');

        foreach ($queryCategory->result() as $category) {
            $queryData[] = [
                'categoryID' => $category->course_category_id,
                'categoryName' => $category->course_category_name,
                'categoryCount' => $category->categoryCount,
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => 'true', 'data' => isset($queryData) ? $queryData : []]);
    }

    public function onAddCategory()
    {
        if (!$this->checkPermission(['admin'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // validate categoryName
        $this->form_validation->set_rules('categoryName', '', 'trim|required');

        // On validation errors
        if (!$this->form_validation->run()) {
            $response = ['status' => false, 'errorMessage' => 'Validatation Error !'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // post year variable with xss clean
        $categoryName = $this->input->post('categoryName', true);

        if (!$this->db->insert('cwie_course_category', ['course_category_name' =>  $categoryName])) {
            $response = ['status' => false, 'errorMessage' => 'DB ERROR! : ' . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => true]);
    }

    public function onEditCategory()
    {
        if (!$this->checkPermission(['admin'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // validate categoryID
        $this->form_validation->set_rules('categoryID', '', 'trim|required');
        // validate categoryName
        $this->form_validation->set_rules('categoryName', '', 'trim|required');

        // On validation errors
        if (!$this->form_validation->run()) {
            $response = ['status' => false, 'errorMessage' => 'Validatation Error !'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // post category variable with xss clean
        $categoryID = $this->input->post('categoryID', true);
        $categoryName = $this->input->post('categoryName', true);

        if (!$this->db->update('cwie_course_category', ['course_category_name' => $categoryName], array('course_category_id' => $categoryID))) {
            $response = ['status' => false, 'errorMessage' => 'DB ERROR! : ' . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => true]);
    }

    public function onDeleteCategory($categoryID = null)
    {
        if (!$this->checkPermission(['admin'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // if category id not set
        if ($categoryID == null) {
            $response = ['status' => false, 'errorMessage' => "Parameter Not Found!"];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        //  query category
        $queryCategory = $this->db->get_where('cwie_course_category', array('course_category_id' => $categoryID));

        // if not found category by id
        if ($queryCategory->num_rows() <= 0) {
            $response = ['status' => false, 'errorMessage' => "Category Not Found!"];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // if delete category error
        if (!$this->db->delete('cwie_course_category', array('course_category_id' => $queryCategory->row()->course_category_id))) {
            $response = ['status' => false, 'errorMessage' => "DB Error! " . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => true]);
    }
}
