<?php
defined('BASEPATH') or exit('No direct script access allowed');

class News extends CI_Controller
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
        if (!$this->checkPermission(['admin', 'faculty'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        $response = $this->mainVariable();
        $response['page'] = 'News';

        $this->load->view('z_template/header', $response);
        $this->load->view('news/newspage', $response);
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

        $response = ['status' => true, 'data' =>  $this->load->view('crud/news/newsAddPage', null, true)];
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function addImageModal($newsID = null)
    {
        if (!$this->checkPermission(['admin', 'faculty'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        if ($newsID == null) {
            $response = ['status' => false, 'errorMessage' =>  "Parameter Not Found!"];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // query News data
        $queryNews = $this->db->get_where('cwie_news', array('news_id' => $newsID));

        // if not found News by id
        if ($queryNews->num_rows() <= 0) {
            $response = ['status' => false, 'errorMessage' => "News Not Found!"];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        $response = ['status' => true, 'newsID' => $newsID, 'data' =>  $this->load->view('crud/news/newsAddImagePage', null, true)];
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function editModal($newID = null)
    {
        if (!$this->checkPermission(['admin', 'faculty'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        if ($newID == null) {
            $response = ['status' => false, 'errorMessage' =>  "Parameter Not Found!"];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        $response = [
            'status' => true,
            'newsResponse' => $this->getNews($newID),
            'data' =>  $this->load->view('news/newsEditPage', null, true)
        ];

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    /*
    | --------------------------------------------------------------------------------
    | Functions Section
    | --------------------------------------------------------------------------------
    */

    public function getNews($newsID = null)
    {
        if (!$this->checkPermission(['admin', 'faculty'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        setlocale(LC_TIME, 'th_TH.utf8');

        if ($this->input->post('searchKeyword')) {
            // search keyword
            $searchKeyword = $this->input->post('searchKeyword', true);

            // query news
            $queryNews = $this->db->order_by('news_datetime', 'DESC')
                ->like('news_title', $searchKeyword)
                ->or_like('news_detail', $searchKeyword)
                ->get('cwie_news');
            foreach ($queryNews->result() as $news) {
                // query news images
                $queryNewsImage = $this->db->get_where('cwie_news_image', array('news_id' => $news->news_id));
                // check is news images exist
                $newsImageData = [];
                if ($queryNewsImage->num_rows() > 0) {
                    foreach ($queryNewsImage->result() as $newsImage) {
                        $newsImageData[] = [
                            'newsImageID' => $newsImage->news_image_id,
                            'newsImageName' => $newsImage->news_image_name,
                            'newsImageType' => $newsImage->news_image_type,
                        ];
                    }
                }

                $queryData[] = [
                    'newsID' => $news->news_id,
                    'newsImages' => $newsImageData,
                    'newsTitle' => $news->news_title,
                    'newsURL' => $news->news_url,
                    'newsDetail' => $news->news_detail,
                    'newsDateTH' => strftime('%d %B %Y', strtotime(date('Y-m-d', strtotime($news->news_datetime)))),
                    'newsTime' =>  date('H:i', strtotime($news->news_datetime)),
                    'newsAuthor' =>  $news->news_author,
                ];
            }

            header('Content-Type: application/json');
            echo json_encode($response = ['status' => 'true', 'data' => isset($queryData) ? $queryData : []]);
            return;
        }

        // query news by id
        if ($newsID != null) {
            $queryNews = $this->db->get_where('cwie_news', array('news_id' => $newsID));

            if ($queryNews->num_rows() <= 0) {
                header('Content-Type: application/json');
                echo json_encode($response = ['status' => 'false', 'errorMessage' => 'News Not Found!']);
                return;
            }

            $response = [
                'status' => 'true',
                'newsID' => $queryNews->row()->news_id,
                'newsTitle' => $queryNews->row()->news_title,
                'newsURL' => $queryNews->row()->news_url,
                'newsDetail' => $queryNews->row()->news_detail,
            ];

            return  $response;
        }

        // query faculty news
        if ($this->session->userdata('crudSessionData')['crudPermission'] == 'faculty') {
            // query news
            $queryNews = $this->db->order_by('news_datetime', 'DESC')->get_where('cwie_news', ['auth_id' => $this->session->userdata('crudSessionData')['crudAuthId']]);
            foreach ($queryNews->result() as $news) {
                // query news images
                $queryNewsImage = $this->db->get_where('cwie_news_image', array('news_id' => $news->news_id));
                // check is news images exist
                $newsImageData = [];
                if ($queryNewsImage->num_rows() > 0) {
                    foreach ($queryNewsImage->result() as $newsImage) {
                        $newsImageData[] = [
                            'newsImageID' => $newsImage->news_image_id,
                            'newsImageName' => $newsImage->news_image_name,
                            'newsImageType' => $newsImage->news_image_type,
                        ];
                    }
                }

                $queryData[] = [
                    'newsID' => $news->news_id,
                    'newsImages' => $newsImageData,
                    'newsTitle' => $news->news_title,
                    'newsURL' => $news->news_url,
                    'newsDetail' => $news->news_detail,
                    'newsDateTH' => strftime('%d %B %Y', strtotime(date('Y-m-d', strtotime($news->news_datetime)))),
                    'newsTime' =>  date('H:i', strtotime($news->news_datetime)),
                    'newsAuthor' =>  $news->news_author,
                ];
            }
            header('Content-Type: application/json');
            echo json_encode($response = ['status' => 'true', 'data' => isset($queryData) ? $queryData : []]);
            return;
        }

        // query news
        $queryNews = $this->db->order_by('news_datetime', 'DESC')->get('cwie_news');
        foreach ($queryNews->result() as $news) {
            // query news images
            $queryNewsImage = $this->db->get_where('cwie_news_image', array('news_id' => $news->news_id));
            // check is news images exist
            $newsImageData = [];
            if ($queryNewsImage->num_rows() > 0) {
                foreach ($queryNewsImage->result() as $newsImage) {
                    $newsImageData[] = [
                        'newsImageID' => $newsImage->news_image_id,
                        'newsImageName' => $newsImage->news_image_name,
                        'newsImageType' => $newsImage->news_image_type,
                    ];
                }
            }

            $queryData[] = [
                'newsID' => $news->news_id,
                'newsImages' => $newsImageData,
                'newsTitle' => $news->news_title,
                'newsURL' => $news->news_url,
                'newsDetail' => $news->news_detail,
                'newsDateTH' => strftime('%d %B %Y', strtotime(date('Y-m-d', strtotime($news->news_datetime)))),
                'newsTime' =>  date('H:i', strtotime($news->news_datetime)),
                'newsAuthor' =>  $news->news_author,
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => 'true', 'data' => isset($queryData) ? $queryData : []]);
    }

    public function onAddNews()
    {
        if (!$this->checkPermission(['admin', 'faculty'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // validate newsTitle
        $this->form_validation->set_rules('newsTitle', '', 'trim|required');
        // validate newsDetail
        $this->form_validation->set_rules('newsDetail', '', 'trim');
        // validate newsUrl
        $this->form_validation->set_rules('newsUrl', '', 'trim');

        // On validation errors
        if (!$this->form_validation->run()) {
            $response = ['status' => false, 'errorMessage' => 'Validatation Error !'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // post news variable with xss clean
        $newsTitle = $this->input->post('newsTitle', true);
        $newsDetail = $this->input->post('newsDetail');
        $newsUrl = $this->input->post('newsUrl') ? preg_replace("/[^a-zA-Z0-9_\x{0E00}-\x{0E7F}]/u", '-', $this->input->post('newsUrl')) : preg_replace("/[^a-zA-Z0-9_\x{0E00}-\x{0E7F}]/u", '-', $this->input->post('newsTitle'));
        $newsAuthor = $this->session->userdata('crudSessionData')['crudPermission'] == 'admin' ? 'สถาบันการเรียนรู้ตลอดชีวิต' : $this->session->userdata('crudSessionData')['crudName'] . ' ' . (isset($this->session->userdata('crudSessionData')['crudSurname']) ? $this->session->userdata('crudSessionData')['crudSurname'] : '');

        // check duplicate url
        if ($this->db->get_where('cwie_news', array('news_url' => $newsUrl))->num_rows() > 0) {
            $response = ['status' => false, 'errorMessage' => 'มี URL นี้อยู่ในระบบแล้ว'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        $newsData = [
            'news_title' => $newsTitle,
            'news_detail' => $newsDetail,
            'news_author' =>  $newsAuthor,
            'news_url' => $newsUrl,
            'auth_id' => $this->session->userdata('crudSessionData')['crudAuthId']
        ];

        // insert news data
        if (!$this->db->insert('cwie_news', $newsData)) {
            $response = ['status' => false, 'errorMessage' => 'DB ERROR! : ' . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // if there is images upload images
        if (!empty($_FILES['newsImage']['name'][0])) {

            $newsID = $this->db->insert_id();

            // Load the string helper
            $this->load->helper('string');
            $this->load->library('image_lib');

            $config['upload_path'] = './assets/images/newsImages';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = '2048';

            for ($i = 0; $i < count($_FILES['newsImage']['name']); $i++) {
                $newFileName = random_string('alnum', 30);
                $fileExtention = explode(".", $_FILES["newsImage"]["name"][$i]);
                $config['file_name'] = $newFileName . "." . $fileExtention[count($fileExtention) - 1];
                $this->upload->initialize($config);

                // Set the configuration for image manipulation
                $imgConfig['image_library'] = 'gd2';
                $imgConfig['source_image'] = $_FILES["newsImage"]["tmp_name"][$i];
                $imgConfig['create_thumb'] = FALSE;
                $imgConfig['maintain_ratio'] = TRUE;
                $imgConfig['width'] = 1900; // Set the desired width
                $imgConfig['height'] = 1300; // Set the desired height

                // Initialize the image manipulation library with the configuration
                $this->image_lib->initialize($imgConfig);

                // Resize the image
                if (!$this->image_lib->resize()) {
                    // Handle the error
                    $response = ['status' => false, 'errorMessage' => 'Image Resize Error! : ' . $this->image_lib->display_errors()];
                    header('Content-Type: application/json');
                    echo json_encode($response);
                    exit;
                }

                // Clear the configuration for the next use
                $this->image_lib->clear();

                $_FILES['image']['name'] = $_FILES['newsImage']['name'][$i];
                $_FILES['image']['type'] = $_FILES['newsImage']['type'][$i];
                $_FILES['image']['tmp_name'] = $_FILES['newsImage']['tmp_name'][$i];
                $_FILES['image']['error'] = $_FILES['newsImage']['error'][$i];
                $_FILES['image']['size'] = $_FILES['newsImage']['size'][$i];

                if (!$this->upload->do_upload('image')) {
                    $response = ['status' => false, 'errorMessage' => 'Image Upload Error! : ' . $this->upload->display_errors()];
                    header('Content-Type: application/json');
                    echo json_encode($response);
                    exit;
                }

                $newsImageData = [
                    'news_image_name' => $newFileName,
                    'news_image_type' => '.' . $fileExtention[count($fileExtention) - 1],
                    'news_id' => $newsID
                ];

                // insert news image data
                if (!$this->db->insert('cwie_news_image', $newsImageData)) {
                    $response = ['status' => false, 'errorMessage' => 'DB ERROR! : ' . $this->db->error()['message']];
                    header('Content-Type: application/json');
                    echo json_encode($response);
                    exit;
                }

                // max 10 images upload in 1 request
                if ($i >= 10)
                    break;
            }
        }

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => true]);
    }

    public function onAddNewsImage()
    {
        if (!$this->checkPermission(['admin', 'faculty'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        if (empty($_FILES['newsImage']['name'][0])) {
            $response = ['status' => false, 'errorMessage' => 'File is required!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // Load the string helper
        $this->load->helper('string');
        $this->load->library('image_lib');

        $config['upload_path'] = './assets/images/newsImages';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size'] = '2048';

        // post news variable with xss clean
        $newsID = $this->input->post('newsID', true);

        for ($i = 0; $i < count($_FILES['newsImage']['name']); $i++) {
            $newFileName = random_string('alnum', 30);
            $fileExtention = explode(".", $_FILES["newsImage"]["name"][$i]);
            $config['file_name'] = $newFileName . "." . $fileExtention[count($fileExtention) - 1];
            $this->upload->initialize($config);

            // Set the configuration for image manipulation
            $imgConfig['image_library'] = 'gd2';
            $imgConfig['source_image'] = $_FILES["newsImage"]["tmp_name"][$i];
            $imgConfig['create_thumb'] = FALSE;
            $imgConfig['maintain_ratio'] = TRUE;
            $imgConfig['width'] = 1900; // Set the desired width
            $imgConfig['height'] = 1300; // Set the desired height

            // Initialize the image manipulation library with the configuration
            $this->image_lib->initialize($imgConfig);

            // Resize the image
            if (!$this->image_lib->resize()) {
                // Handle the error
                $response = ['status' => false, 'errorMessage' => 'Image Resize Error! : ' . $this->image_lib->display_errors()];
                header('Content-Type: application/json');
                echo json_encode($response);
                exit;
            }

            // Clear the configuration for the next use
            $this->image_lib->clear();

            $_FILES['image']['name'] = $_FILES['newsImage']['name'][$i];
            $_FILES['image']['type'] = $_FILES['newsImage']['type'][$i];
            $_FILES['image']['tmp_name'] = $_FILES['newsImage']['tmp_name'][$i];
            $_FILES['image']['error'] = $_FILES['newsImage']['error'][$i];
            $_FILES['image']['size'] = $_FILES['newsImage']['size'][$i];

            if (!$this->upload->do_upload('image')) {
                $response = ['status' => false, 'errorMessage' => 'Image Upload Error! : ' . $this->upload->display_errors()];
                header('Content-Type: application/json');
                echo json_encode($response);
                exit;
            }

            $newsImageData = [
                'news_image_name' => $newFileName,
                'news_image_type' => '.' . $fileExtention[count($fileExtention) - 1],
                'news_id' => $newsID
            ];

            // insert news image data
            if (!$this->db->insert('cwie_news_image', $newsImageData)) {
                $response = ['status' => false, 'errorMessage' => 'DB ERROR! : ' . $this->db->error()['message']];
                header('Content-Type: application/json');
                echo json_encode($response);
                exit;
            }

            // max 10 images upload in 1 request
            if ($i >= 10)
                break;
        }

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => true]);
    }

    public function onEditNews()
    {
        if (!$this->checkPermission(['admin', 'faculty'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // validate newsTitle
        $this->form_validation->set_rules('newsTitle', '', 'trim|required');
        // validate newsDetail
        $this->form_validation->set_rules('newsDetail', '', 'trim');
        // validate newsUrl
        $this->form_validation->set_rules('newsUrl', '', 'trim');

        // On validation errors
        if (!$this->form_validation->run()) {
            $response = ['status' => false, 'errorMessage' => 'Validatation Error !'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // post news variable with xss clean
        $newsID = $this->input->post('newsID', true);
        $newsTitle = $this->input->post('newsTitle', true);
        $newsUrl = $this->input->post('newsUrl') ? preg_replace("/[^a-zA-Z0-9_\x{0E00}-\x{0E7F}]/u", '-', $this->input->post('newsUrl')) : preg_replace("/[^a-zA-Z0-9_\x{0E00}-\x{0E7F}]/u", '-', $this->input->post('newsTitle'));
        $newsDetail = $this->input->post('newsDetail');

        // check duplicate url
        if ($this->db->get_where('cwie_news', array('news_url' => $newsUrl, 'news_id !=' => $newsID))->num_rows() > 0) {
            $response = ['status' => false, 'errorMessage' => 'Duplicate URL!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        $newsUpdateData = [
            'news_title' => $newsTitle,
            'news_detail' => $newsDetail,
            'news_url' => $newsUrl,
        ];

        // insert bannerData
        if (!$this->db->update('cwie_news', $newsUpdateData, array('news_id' => $newsID))) {
            $response = ['status' => false, 'errorMessage' => 'DB ERROR! : ' . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => true]);
    }

    public function onDeleteNews($newID = null)
    {
        if (!$this->checkPermission(['admin', 'faculty'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        if ($newID == null) {
            $response = ['status' => false, 'errorMessage' =>  "Parameter Not Found!"];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // query new data
        $queryNews = $this->db->get_where('cwie_news', array('news_id' => $newID));

        // if not found new by id
        if ($queryNews->num_rows() <= 0) {
            $response = ['status' => false, 'errorMessage' => "News Not Found!"];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // query news images data 
        $qyeryNewsImages = $this->db->get_where('cwie_news_image', array('news_id' => $newID));

        foreach ($qyeryNewsImages->result() as $newsImage) {
            if (file_exists('./assets/images/newsImages/' . $newsImage->news_image_name . $newsImage->news_image_type)) {
                // unlink image
                if (!unlink('./assets/images/newsImages/' . $newsImage->news_image_name . $newsImage->news_image_type)) {
                    $response = ['status' => false, 'errorMessage' => 'Failed to unlink file : ' . error_get_last()['message']];
                    header('Content-Type: application/json');
                    echo json_encode($response);
                    return;
                }
            }
        }

        // if delete news error
        if (!$this->db->delete('cwie_news', array('news_id' => $newID))) {
            $response = ['status' => false, 'errorMessage' => "DB Error! " . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => true]);
    }

    public function onDeleteNewsImage($newImageID = null)
    {
        if (!$this->checkPermission(['admin', 'faculty'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        if ($newImageID == null) {
            $response = ['status' => false, 'errorMessage' =>  "Parameter Not Found!"];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // query news image data
        $queryNewsImage = $this->db->get_where('cwie_news_image', array('news_image_id' => $newImageID));

        // if not found news by id
        if ($queryNewsImage->num_rows() <= 0) {
            $response = ['status' => false, 'errorMessage' => "News Image Not Found!"];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        if (file_exists('./assets/images/newsImages/' . $queryNewsImage->row()->news_image_name . $queryNewsImage->row()->news_image_type)) {
            // unlink image
            if (!unlink('./assets/images/newsImages/' . $queryNewsImage->row()->news_image_name . $queryNewsImage->row()->news_image_type)) {
                $response = ['status' => false, 'errorMessage' => 'Failed to unlink video file : ' . error_get_last()['message']];
                header('Content-Type: application/json');
                echo json_encode($response);
                return;
            }
        }

        // if delete new error
        if (!$this->db->delete('cwie_news_image', array('news_image_id' => $newImageID))) {
            $response = ['status' => false, 'errorMessage' => "DB Error! " . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => true]);
    }
}
