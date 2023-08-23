<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Index extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    private function mainVariable()
    {
        $reponse['title'] = 'CRRU-CWIE | สหกิจศึกษาและการศึกษาเชิงบูรณาการกับการทำงาน';
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

        $response['page'] = 'index';

        // fetch banner data
        $response['bannerData'] = $this->getBanner();
        $response['newsData'] = $this->getNews();
        $response['facultyData'] = $this->getFaculty();
        $response['imagesGalleryData'] = $this->getImages();
        $response['videoData'] = $this->getVideo();

        $this->load->view('z_template/header', $response);
        $this->load->view('index', $response);
        $this->load->view('z_template/footer');
    }

    /*
    | --------------------------------------------------------------------------------
    | Functions Section
    | --------------------------------------------------------------------------------
    */

    private function getBanner()
    {
        // query banner
        $queryBanner = $this->db->order_by('banner_image_order ASC')->get_where('cwie_banner_image', array('banner_image_display' => true));
        foreach ($queryBanner->result() as $banner) {
            $queryData[] = [
                'bannerPath' => base_url('assets/images/bannerSlider/') . $banner->banner_image_name . $banner->banner_image_type,
            ];
        }
        return isset($queryData) ? $queryData : [];
    }

    private function getNews()
    {
        // query News
        setlocale(LC_TIME, 'th_TH.utf8');
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

    private function getFaculty()
    {
        $queryFaculty = $this->db->join('cwie_profile_image', 'cwie_faculty.auth_id = cwie_profile_image.auth_id', 'left')
            ->get('cwie_faculty');
        foreach ($queryFaculty->result() as $faculty) {
            $queryData[] = [
                'facultyID' => $faculty->faculty_id,
                'facultyNameTH' => $faculty->faculty_name_th,
                'facultyWebsite' => $faculty->faculty_website,
                'facultyImage' => $faculty->profile_image_name . $faculty->profile_image_type,
            ];
        }
        return isset($queryData) ? $queryData : [];
    }

    private function getImages()
    {

        setlocale(LC_TIME, 'th_TH.utf8');

        $queryNews = $this->db->order_by('rand()')->get('cwie_news');
        foreach ($queryNews->result() as $news) {
            $newsImagesData = [];
            $queryNewsImages = $this->db->order_by('news_image_datetime DESC')->get_where('cwie_news_image', array('news_id' => $news->news_id));
            foreach ($queryNewsImages->result() as $newsImages) {
                $newsImagesData[] = [
                    'imageName' => $newsImages->news_image_name,
                    'imageType' => $newsImages->news_image_type,
                ];
            }
            $queryData[] = [
                'newsTitle' => $news->news_title,
                'newsURL' => $news->news_url,
                'newsDateTH' => strftime('%d %B %Y', strtotime(date('Y-m-d', strtotime($news->news_datetime)))),
                'newsImages' => $newsImagesData
            ];
        }
        return isset($queryData) ? $queryData : [];
    }

    private function getVideo()
    {
        setlocale(LC_TIME, 'th_TH.utf8');

        $queryVideo = $this->db->order_by('rand()')
            ->join('cwie_video_thumbnail', 'cwie_video.video_id = cwie_video_thumbnail.video_id', 'left')
            ->get('cwie_video');
        foreach ($queryVideo->result() as $video) {
            $queryData[] = [
                'videoID' => $video->video_id,
                'videoTitle' => $video->video_title,
                'videoName' => $video->video_name,
                'videoType' => $video->video_type,
                'videoThumbnailName' => $video->video_thumbnail_name,
                'videoThumbnailType' => $video->video_thumbnail_type,
                'videoDateTH' => strftime('%d %B %Y', strtotime(date('Y-m-d', strtotime($video->video_datetime)))),
                'videoTime' =>  date('H:i', strtotime($video->video_datetime)),
                'videoAuthor' =>  $video->video_author
            ];
        }
        return isset($queryData) ? $queryData : [];
    }
}
