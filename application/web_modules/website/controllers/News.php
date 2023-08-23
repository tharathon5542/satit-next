<?php
defined('BASEPATH') or exit('No direct script access allowed');

class News extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    private function mainVariable()
    {
        $reponse['title'] = 'CRRU-CWIE | ข่าวประชาสัมพันธ์';
        $reponse['keywords'] = [
            'CRRU', 'CWIE', 'สหกิจศึกษาและการศึกษาเชิงบูรณาการกับการทำงาน', 'Cooperative',
            'Work', 'Education', 'Integrated', 'Chiang Rai', 'Chiang Rai', 'เชียงราย',
            'การศึกษา', 'ความร่วมมือ', 'ราชภัฏ', 'ราชภัฏเชียงราย', 'มหาวิทยาลัย', 'มหาวิทยาลัยราชภัฏเชียงราย'
        ];
        $reponse['description'] = 'CWIE';
        $reponse['author'] = 'CLLI Devs';
        return $reponse;
    }

    /*
    | --------------------------------------------------------------------------------
    | Load View Section
    | --------------------------------------------------------------------------------
    */

    public function index()
    {
        $response = $this->mainVariable();

        $response['page'] = 'news';

        $response['Breadcrumb'] = [
            'title' => 'ข่าวประชาสัมพันธ์',
            'main' => 'ข่าวประชาสัมพันธ์',
            'mainURL' => 'news'
        ];

        $response['newsData'] = $this->getNews();

        $this->load->view('z_template/header', $response);
        $this->load->view('news/newsPage', $response);
        $this->load->view('z_template/footer');
    }

    public function detail($newsURL = null)
    {
        $response = $this->mainVariable();

        $response['page'] = 'news';

        if ($newsURL == null) {
            redirect(base_url('news'));
            return;
        }

        $newsData = $this->getNews(null, $newsURL);

        $response['newsData'] = $newsData;

        $response['Breadcrumb'] = [
            'title' => 'ข่าวประชาสัมพันธ์',
            'main' => 'ข่าวประชาสัมพันธ์',
            'mainURL' => 'news',
            'sub' => $newsData['newsTitle']
        ];

        $this->load->view('z_template/header', $response);
        $this->load->view('news/newsDetailPage', $response);
        $this->load->view('z_template/footer');
    }

    /*
    | --------------------------------------------------------------------------------
    | Functions Section
    | --------------------------------------------------------------------------------
    */
    public function getNews($newsID = null, $newsURL = null)
    {
        setlocale(LC_TIME, 'th_TH.utf8');

        if ($newsID != null) {
            // query News
            $queryNews = $this->db->get_where('cwie_news', array('news_id' => $newsID));

            if ($queryNews->num_rows() <= 0) {
                $response = ['status' => false, 'errorMessage' => "News Not Found!"];
                echo json_encode($response);
                return;
            }

            // query news images
            $queryNewsImage = $this->db->get_where('cwie_news_image', array('news_id' => $queryNews->row()->news_id));
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

            $queryData = [
                'newsID' => $queryNews->row()->news_id,
                'newsImages' => $newsImageData,
                'newsTitle' => $queryNews->row()->news_title,
                'newsURL' => $queryNews->row()->news_url,
                'newsDetail' => $queryNews->row()->news_detail,
                'newsDateTH' => strftime('%d %B %Y', strtotime(date('Y-m-d', strtotime($queryNews->row()->news_datetime)))),
                'newsTime' =>  date('H:i', strtotime($queryNews->row()->news_datetime)),
                'newsAuthor' =>  $queryNews->row()->news_author
            ];

            return isset($queryData) ? $queryData : [];
        }

        if ($newsURL != null) {
            // query News
            $queryNews = $this->db->get_where('cwie_news', array('news_url' => urldecode($newsURL)));

            if ($queryNews->num_rows() <= 0) {
                $response = ['status' => false, 'errorMessage' => "News Not Found!"];
                echo json_encode($response);
                return;
            }

            // query news images
            $queryNewsImage = $this->db->get_where('cwie_news_image', array('news_id' => $queryNews->row()->news_id));
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

            $queryData = [
                'newsID' => $queryNews->row()->news_id,
                'newsImages' => $newsImageData,
                'newsTitle' => $queryNews->row()->news_title,
                'newsURL' => $queryNews->row()->news_url,
                'newsDetail' => $queryNews->row()->news_detail,
                'newsDateTH' => strftime('%d %B %Y', strtotime(date('Y-m-d', strtotime($queryNews->row()->news_datetime)))),
                'newsTime' =>  date('H:i', strtotime($queryNews->row()->news_datetime)),
                'newsAuthor' =>  $queryNews->row()->news_author
            ];

            return isset($queryData) ? $queryData : [];
        }

        // query News
        $queryNews = $this->db->order_by('news_datetime DESC')->get('cwie_news');
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
                'newsAuthor' =>  $news->news_author
            ];
        }

        return isset($queryData) ? $queryData : [];
    }
}
