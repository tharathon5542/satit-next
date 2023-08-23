<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Module extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    private function mainVariable()
    {
        $reponse['title'] = 'CRRU-CWIE | เว็บไซต์หน่วยงานการศึกษา';
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
    public function siteLoad($siteName = null)
    {
        $response = $this->mainVariable();

        $response['facultyData'] = $this->getFacultyData(urldecode($siteName));
        $response['newsData'] = $this->getNews(urldecode($siteName));
        $response['imagesGalleryData'] = $this->getImages(urldecode($siteName));
        $response['videoData'] = $this->getVideo(urldecode($siteName));

        $this->load->view('z_template/header', $response);
        $this->load->view('index', $response);
        $this->load->view('z_template/footer');
    }

    public function courseDetailModal($facultyID = null)
    {
        if ($facultyID == null) {
            $response = ['status' => false, 'errorMessage' =>  "Parameter Not Found!"];
            echo json_encode($response);
            return;
        }

        $response = [
            'status' => true,
            'data' =>  $this->load->view('detailModal/courseDetailModal', null, true),
            'courseData' => $this->getCoursesData($facultyID)
        ];
        echo json_encode($response);
    }

    public function cwiePersonalModal($facultyID = null)
    {
        if ($facultyID == null) {
            $response = ['status' => false, 'errorMessage' =>  "Parameter Not Found!"];
            echo json_encode($response);
            return;
        }

        $response = [
            'status' => true,
            'data' =>  $this->load->view('detailModal/personalDetailModal', null, true),
            'personnelData' => $this->getPersonnelData($facultyID)
        ];
        echo json_encode($response);
    }

    public function cwiePersonalStudents($facultyID = null)
    {
        if ($facultyID == null) {
            $response = ['status' => false, 'errorMessage' =>  "Parameter Not Found!"];
            echo json_encode($response);
            return;
        }

        $response = [
            'status' => true,
            'data' =>  $this->load->view('detailModal/studentDetailModal', null, true),
            'studentData' => $this->getStudentData($facultyID)
        ];
        echo json_encode($response);
    }

    public function cwieWorkplace($facultyID = null)
    {
        if ($facultyID == null) {
            $response = ['status' => false, 'errorMessage' =>  "Parameter Not Found!"];
            echo json_encode($response);
            return;
        }

        $response = [
            'status' => true,
            'data' =>  $this->load->view('detailModal/workplaceDetailModal', null, true),
            'workplaceData' => $this->getWorkplace($facultyID)
        ];

        echo json_encode($response);
    }

    public function cwieWorkplaceMou($facultyID = null)
    {
        if ($facultyID == null) {
            $response = ['status' => false, 'errorMessage' =>  "Parameter Not Found!"];
            echo json_encode($response);
            return;
        }

        $response = [
            'status' => true,
            'data' =>  $this->load->view('detailModal/workplaceMouDetailModal', null, true),
            'workplaceMouData' => $this->getWorkplaceMou($facultyID)
        ];

        echo json_encode($response);
    }

    /*
    | --------------------------------------------------------------------------------
    | Functions Section
    | --------------------------------------------------------------------------------
    */

    private function getCoursesData($facultyID = null)
    {
        // post variable
        $yearID = $this->input->post('yearID');

        if ($yearID == '0') {
            // query courses
            $queryCoursesData = $this->db->select('course_name, course_grade, course_category_name, major_name_th')
                ->join('cwie_course_category', 'cwie_course.course_category_id = cwie_course_category.course_category_id', 'left')
                ->join('cwie_major', 'cwie_course.major_id = cwie_major.major_id')
                ->get_where('cwie_course', array('cwie_major.faculty_id' => $facultyID));
        } else {
            // query courses
            $queryCoursesData = $this->db->select('course_name, course_grade, course_category_name, major_name_th')
                ->join('cwie_course_category', 'cwie_course.course_category_id = cwie_course_category.course_category_id', 'left')
                ->join('cwie_major', 'cwie_course.major_id = cwie_major.major_id')
                ->get_where('cwie_course', array('year_id' => $yearID, 'cwie_major.faculty_id' => $facultyID));
        }

        foreach ($queryCoursesData->result() as $courses) {

            switch ($courses->course_grade) {
                case 0:
                    $grade = 'ปริญญาตรี';
                    break;
                case 1:
                    $grade = 'ปริญญาโท';
                    break;
                case 2:
                    $grade = 'ปริญญาเอก';
                    break;
            }

            $queryData[] = [
                'courseName' => $courses->course_name,
                'courseGrade' => $grade,
                'courseCategory' => $courses->course_category_name,
                'courseMajor' => $courses->major_name_th,
            ];
        }

        return isset($queryData) ? $queryData : [];
    }

    private function getPersonnelData($facultyID = null)
    {
        // post variable
        $yearID = $this->input->post('yearID');

        if ($yearID == '0') {
            // query cwie personnel all year
            $queryPersonnelData = $this->db->select('personnel_name, personnel_surname, personnel_type_title, personnel_postion, major_name_th')
                ->join('cwie_personnel_type', 'cwie_personnel.personnel_type_id = cwie_personnel_type.personnel_type_id')
                ->join('cwie_major', 'cwie_personnel.major_id = cwie_major.major_id')
                ->get_where('cwie_personnel', array('cwie_major.faculty_id' => $facultyID));
        } else {
            // query cwie personnel by year
            $queryPersonnelData = $this->db->select('personnel_name, personnel_surname, personnel_type_title, personnel_postion, major_name_th')
                ->join('cwie_personnel_type', 'cwie_personnel.personnel_type_id = cwie_personnel_type.personnel_type_id')
                ->join('cwie_major', 'cwie_personnel.major_id = cwie_major.major_id')
                ->join('cwie_personnel_course', 'cwie_personnel.personnel_id = cwie_personnel_course.personnel_id')
                ->join('cwie_course', 'cwie_personnel_course.course_id = cwie_course.course_id')
                ->get_where('cwie_personnel', array('cwie_major.faculty_id' => $facultyID, 'cwie_course.year_id' => $yearID));
        }

        foreach ($queryPersonnelData->result() as $personnel) {
            $queryData[] = [
                'personnelNameSurname' => $personnel->personnel_name . ' ' .  $personnel->personnel_surname,
                'personnelType' => $personnel->personnel_type_title,
                'personnelPosition' => $personnel->personnel_postion != null ? $personnel->personnel_postion : '-',
                'personnelMajor' => $personnel->major_name_th,
            ];
        }

        return isset($queryData) ? $queryData : [];
    }

    private function getStudentData($facultyID = null)
    {
        // post variable
        $yearID = $this->input->post('yearID');

        if ($yearID == '0') {
            // query cwie student all year
            $queryStudentData = $this->db->join('cwie_course', 'cwie_students.course_id = cwie_course.course_id')
                ->join('cwie_major', 'cwie_course.major_id = cwie_major.major_id')
                ->get_where('cwie_students', array('cwie_major.faculty_id' => $facultyID));
        } else {
            // query cwie student by id
            $queryStudentData = $this->db->join('cwie_course', 'cwie_students.course_id = cwie_course.course_id')
                ->join('cwie_major', 'cwie_course.major_id = cwie_major.major_id')
                ->get_where('cwie_students', array('cwie_major.faculty_id' => $facultyID, 'cwie_course.year_id' => $yearID));
        }

        foreach ($queryStudentData->result() as $student) {

            $url = 'https://orasis.crru.ac.th/orasis_crru/mis_export/clli_student_link/get_student';
            $myvars = 'citizen_id=' . $student->student_code . '&token=' . 'CLLI@CRRU#ACCESS2022@DATALINKCHECKING!!';

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $myvars);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            $apiStudentData = json_decode(curl_exec($ch));

            $queryData[] = [
                'studentCode' => $apiStudentData->studentData[0]->std_id,
                'studentNameSurname' => $apiStudentData->studentData[0]->pname . $apiStudentData->studentData[0]->fname . ' ' . $apiStudentData->studentData[0]->lname,
                'studentMajor' => $apiStudentData->studentData[0]->major_name,
                'studentFaculty' => $apiStudentData->studentData[0]->faculty,
            ];
        }

        return isset($queryData) ? $queryData : [];
    }

    private function getWorkplace($facultyID = null)
    {
        // post variable
        $yearID = $this->input->post('yearID');

        if ($yearID == '0') {
            // query cwie workplace all year
            $queryWorkplaceData = $this->db->join('cwie_workplace_type', 'cwie_workplace.workplace_type_id = cwie_workplace_type.workplace_type_id')
                ->join('cwie_major', 'cwie_workplace.major_id = cwie_major.major_id')
                ->get_where('cwie_workplace', array('cwie_major.faculty_id' => $facultyID, 'status' => '1'));
        } else {
            // query cwie workplace by id
            $queryWorkplaceData = $this->db->join('cwie_workplace_course', 'cwie_workplace.workplace_id = cwie_workplace_course.workplace_id', 'left')
                ->join('cwie_course', 'cwie_workplace_course.course_id = cwie_course.course_id', 'left')
                ->join('cwie_workplace_type', 'cwie_workplace.workplace_type_id = cwie_workplace_type.workplace_type_id', 'left')
                ->join('cwie_major', 'cwie_workplace.major_id = cwie_major.major_id')
                ->get_where('cwie_workplace', array('cwie_major.faculty_id' => $facultyID, 'cwie_course.year_id' => $yearID, 'status' => '1'));
        }

        foreach ($queryWorkplaceData->result() as $workplace) {
            $queryData[] = [
                'workplaceName' => $workplace->workplace_name,
                'workplaceType' => $workplace->workplace_type,
            ];
        }

        return isset($queryData) ? $queryData : [];
    }

    private function getWorkplaceMou($facultyID = null)
    {
        // post variable
        $yearID = $this->input->post('yearID');

        if ($yearID == '0') {
            // query cwie workplace mou all year
            $queryWorkplaceMouData = $this->db->join('cwie_workplace', 'cwie_workplace_mou_file.workplace_id = cwie_workplace.workplace_id')
                ->join('cwie_major', 'cwie_workplace.major_id = cwie_major.major_id')
                ->get_where('cwie_workplace_mou_file', array('cwie_major.faculty_id' => $facultyID, 'status' => '1'));
        } else {
            // query cwie workplace mou by year id
            $queryWorkplaceMouData = $this->db->join('cwie_workplace', 'cwie_workplace_mou_file.workplace_id = cwie_workplace.workplace_id')
                ->join('cwie_workplace_course', 'cwie_workplace.workplace_id = cwie_workplace_course.workplace_id', 'left')
                ->join('cwie_course', 'cwie_workplace_course.course_id = cwie_course.course_id', 'left')
                ->join('cwie_major', 'cwie_workplace.major_id = cwie_major.major_id')
                ->get_where('cwie_workplace_mou_file', array('cwie_major.faculty_id' => $facultyID, 'cwie_course.year_id' => $yearID, 'status' => '1'));
        }

        foreach ($queryWorkplaceMouData->result() as $workplaceMou) {
            $queryData[] = [
                'workplaceName' => $workplaceMou->workplace_name,
                'workplaceDetail' => $workplaceMou->workplace_mou_detail,
                'workplaceFile' => $workplaceMou->workplace_mou_file . $workplaceMou->workplace_mou_file_type,
            ];
        }

        return isset($queryData) ? $queryData : [];
    }

    private function getFacultyData($siteName)
    {
        $queryFaculty = $this->db->join('cwie_profile_image', 'cwie_faculty.auth_id = cwie_profile_image.auth_id', 'left')
            ->join('cwie_video', 'cwie_faculty.video_id = cwie_video.video_id', 'left')
            ->join('cwie_cover_image', 'cwie_faculty.faculty_id = cwie_cover_image.faculty_id', 'left')
            ->get_where('cwie_faculty', ['faculty_website' => $siteName]);

        if ($queryFaculty->num_rows() <= 0) {
            redirect(base_url());
            return;
        }

        $queryMajor = $this->db->get_where('cwie_major', array('faculty_id' => $queryFaculty->row()->faculty_id));
        foreach ($queryMajor->result() as $major) {
            $majorData[] = [
                'majorName' => $major->major_name_th,
                'majorTel' => $major->major_tel != null ? $major->major_tel : '-'
            ];
        }

        $queryData = [
            'facultyID' => $queryFaculty->row()->faculty_id,
            'facultyNameTH' => $queryFaculty->row()->faculty_name_th,
            'facultyNameEN' => $queryFaculty->row()->faculty_name_en,
            'facultyWebsite' => $queryFaculty->row()->faculty_website,
            'facultyCwiePolicy' => $queryFaculty->row()->faculty_cwie_policy,
            'facultyTel' => $queryFaculty->row()->faculty_tel,
            'facultyEmail' => $queryFaculty->row()->faculty_email,
            'facultyCoverImageName' => $queryFaculty->row()->cover_image_name,
            'facultyCoverImageType' => $queryFaculty->row()->cover_image_type,
            'facultyWelcomeVideoName' => $queryFaculty->row()->video_name,
            'facultyWelcomeVideoType' => $queryFaculty->row()->video_type,
            'facultyImage' => $queryFaculty->row()->profile_image_name . $queryFaculty->row()->profile_image_type,
            'facultyAuthID' => $queryFaculty->row()->auth_id,
            'majorData' => isset($majorData) ? $majorData : [['majorName' => '-', 'majorTel' => '-']]
        ];

        return isset($queryData) ? $queryData : [];
    }

    private function getNews($siteName)
    {
        // query faculty
        $queryFaculty = $this->db->get_where('cwie_faculty', ['faculty_website' => $siteName]);

        if ($queryFaculty->num_rows() <= 0) {
            redirect(base_url());
            return;
        }

        // query News
        setlocale(LC_TIME, 'th_TH.utf8');
        $queryNews = $this->db->order_by('news_datetime DESC')->get_where('cwie_news', array('auth_id' => $queryFaculty->row()->auth_id));
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

    private function getImages($siteName)
    {
        // query faculty
        $queryFaculty = $this->db->get_where('cwie_faculty', ['faculty_website' => $siteName]);

        if ($queryFaculty->num_rows() <= 0) {
            redirect(base_url());
            return;
        }

        setlocale(LC_TIME, 'th_TH.utf8');
        $queryNews = $this->db->order_by('news_datetime DESC')->get_where('cwie_news', array('auth_id' => $queryFaculty->row()->auth_id));
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

    private function getVideo($siteName)
    {
        setlocale(LC_TIME, 'th_TH.utf8');

        // query faculty
        $queryFaculty = $this->db->get_where('cwie_faculty', ['faculty_website' => $siteName]);

        if ($queryFaculty->num_rows() <= 0) {
            redirect(base_url());
            return;
        }

        $queryVideo = $this->db->join('cwie_video_thumbnail', 'cwie_video.video_id = cwie_video_thumbnail.video_id', 'left')
            ->get_where('cwie_video', array('auth_id' => $queryFaculty->row()->auth_id));
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

    public function setYearSession($yearID = null)
    {
        if ($yearID == null) {
            $response = ['status' => false, 'errorMessage' => 'Parameter Not Found!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        if ($this->db->get_where('cwie_year', array('year_id' => $yearID))->num_rows() <= 0 && $yearID != 0) {
            $response = ['status' => false, 'errorMessage' => 'Year Not Found!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        $this->session->set_userdata('moduleYearID', $yearID);

        header('Content-Type: application/json');
        echo json_encode(['status' => true]);
        return;
    }
}
