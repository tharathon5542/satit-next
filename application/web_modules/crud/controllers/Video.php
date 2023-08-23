<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Video extends CI_Controller
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
        $response['page'] = 'Video';

        $this->load->view('z_template/header', $response);
        $this->load->view('video/VideoPage', $response);
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

        $response = ['status' => true, 'data' =>  $this->load->view('crud/video/videoAddPage', null, true)];
        header('Content-Type: application/json');
        echo json_encode($response);
    }


    public function editModal($videoID = null)
    {
        if (!$this->checkPermission(['admin', 'faculty'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        if ($videoID == null) {
            $response = ['status' => false, 'errorMessage' =>  "Parameter Not Found!"];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        $videoResponse = $this->getVideo($videoID);

        $response = [
            'status' => true,
            'videoResponse' => $videoResponse,
            'data' =>  $this->load->view('video/videoEditPage', null, true)
        ];

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    /*
    | --------------------------------------------------------------------------------
    | Functions Section
    | --------------------------------------------------------------------------------
    */

    public function getVideo($videoID = null)
    {
        if (!$this->checkPermission(['admin', 'faculty'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        setlocale(LC_TIME, 'th_TH.utf8');

        // query video by id
        if ($videoID != null) {
            $queryVideo = $this->db->join('cwie_video_thumbnail', 'cwie_video.video_id = cwie_video_thumbnail.video_id')->get_where('cwie_video', array('cwie_video.video_id' => $videoID));

            if ($queryVideo->num_rows() <= 0) {
                header('Content-Type: application/json');
                echo json_encode($response = ['status' => 'false', 'errorMessage' => 'Video Not Found!']);
                return;
            }

            $response = [
                'videoID' => $queryVideo->row()->video_id,
                'videoTitle' => $queryVideo->row()->video_title,
                'videoName' => $queryVideo->row()->video_name,
                'videoType' => $queryVideo->row()->video_type,
                'videoAuthor' => $queryVideo->row()->video_author,
                'videoThumbnailName' => $queryVideo->row()->video_thumbnail_name,
                'videoThumbnailType' => $queryVideo->row()->video_thumbnail_type,
                'videoDateTH' => strftime('%d %B %Y', strtotime(date('Y-m-d', strtotime($queryVideo->row()->video_datetime)))),
                'videoTime' =>  date('H:i', strtotime($queryVideo->row()->video_datetime)),
                'isWelcomeVideo' => $this->db->get_where('cwie_faculty', array('auth_id' => $this->session->userdata('crudSessionData')['crudAuthId'], 'video_id' => $queryVideo->row()->video_id))->num_rows() > 0 ? true : false
            ];

            return  $response;
        }

        // query faculty video
        if ($this->session->userdata('crudSessionData')['crudPermission'] == 'faculty') {
            // query video
            $querVideo = $this->db->join('cwie_video_thumbnail', 'cwie_video.video_id = cwie_video_thumbnail.video_id', 'left')->order_by('video_datetime', 'DESC')->get_where('cwie_video', ['auth_id' => $this->session->userdata('crudSessionData')['crudAuthId']]);
            foreach ($querVideo->result() as $video) {
                $queryData[] = [
                    'videoID' => $video->video_id,
                    'videoTitle' => $video->video_title,
                    'videoName' => $video->video_name,
                    'videoType' => $video->video_type,
                    'videoAuthor' => $video->video_author,
                    'videoThumbnailName' => $video->video_thumbnail_name,
                    'videoThumbnailType' => $video->video_thumbnail_type,
                    'videoDateTH' => strftime('%d %B %Y', strtotime(date('Y-m-d', strtotime($video->video_datetime)))),
                    'videoTime' =>  date('H:i', strtotime($video->video_datetime)),
                ];
            }
            header('Content-Type: application/json');
            echo json_encode($response = ['status' => 'true', 'data' => isset($queryData) ? $queryData : []]);
            return;
        }

        // query video
        $querVideo = $this->db->join('cwie_video_thumbnail', 'cwie_video.video_id = cwie_video_thumbnail.video_id', 'left')->order_by('video_datetime', 'DESC')->get('cwie_video');
        foreach ($querVideo->result() as $video) {
            $queryData[] = [
                'videoID' => $video->video_id,
                'videoTitle' => $video->video_title,
                'videoName' => $video->video_name,
                'videoType' => $video->video_type,
                'videoAuthor' => $video->video_author,
                'videoThumbnailName' => $video->video_thumbnail_name,
                'videoThumbnailType' => $video->video_thumbnail_type,
                'videoDateTH' => strftime('%d %B %Y', strtotime(date('Y-m-d', strtotime($video->video_datetime)))),
                'videoTime' =>  date('H:i', strtotime($video->video_datetime)),
            ];
        }
        header('Content-Type: application/json');
        echo json_encode($response = ['status' => 'true', 'data' => isset($queryData) ? $queryData : []]);
    }

    public function onAddVideo()
    {
        if (!$this->checkPermission(['admin', 'faculty'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // validate videoTitle
        $this->form_validation->set_rules('videoTitle', '', 'trim|required');

        // On validation errors
        if (!$this->form_validation->run()) {
            $response = ['status' => false, 'errorMessage' => 'Validatation Error !'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        if (empty($_FILES['videoFile']['name'])) {
            $response = ['status' => false, 'errorMessage' => 'File is required!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // post news variable with xss clean
        $videoTitle = $this->input->post('videoTitle', true);

        // Load the string helper
        $this->load->helper('string');

        $newFileName = random_string('alnum', 30);

        $fileExtention = explode(".", $_FILES["videoFile"]["name"]);
        $config['upload_path'] = './assets/videos/';
        $config['file_name'] = $newFileName . "." . $fileExtention[count($fileExtention) - 1];
        $config['allowed_types'] = '*';
        $config['max_size'] = '102400';
        $this->upload->initialize($config);

        if (!$this->upload->do_upload('videoFile')) {
            $response = ['status' => false, 'errorMessage' => 'Video Upload Error! : ' . $this->upload->display_errors()];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        $videoName = $newFileName;
        $videoType = "." . $fileExtention[count($fileExtention) - 1];
        $videoAuthor = $this->session->userdata('crudSessionData')['crudPermission'] == 'admin' ? 'สถาบันการเรียนรู้ตลอดชีวิต' : $this->session->userdata('crudSessionData')['crudName'] . ' ' . (isset($this->session->userdata('crudSessionData')['crudSurname']) ? $this->session->userdata('crudSessionData')['crudSurname'] : '');

        $videoData = [
            'video_title' => $videoTitle,
            'video_name' => $videoName,
            'video_type' => $videoType,
            'video_author' =>  $videoAuthor,
            'auth_id' => $this->session->userdata('crudSessionData')['crudAuthId']
        ];

        // insert video data
        if (!$this->db->insert('cwie_video', $videoData)) {
            $response = ['status' => false, 'errorMessage' => 'DB ERROR! : ' . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // video thumbnail if uploaded
        if (!empty($_FILES['videoThumbnail']['name'])) {
            $newFileName = random_string('alnum', 30);
            $fileExtention = explode(".", $_FILES["videoThumbnail"]["name"]);
            $config['upload_path'] = './assets/images/videoThumbnail';
            $config['file_name'] = $newFileName . "." . $fileExtention[count($fileExtention) - 1];
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = '2048';
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('videoThumbnail')) {
                $response = ['status' => false, 'errorMessage' => 'Video Upload Error! : ' . $this->upload->display_errors()];
                header('Content-Type: application/json');
                echo json_encode($response);
                return;
            }

            $videoThumbnail = $newFileName;
            $videoThumbnailType = "." . $fileExtention[count($fileExtention) - 1];
        } else {
            // generate video thumbnail from video with specific wanted frame of video 
            $videoThumbnail = random_string('alnum', 30);
            $videoThumbnailType = ".jpg";

            // Set the video file path
            $videoFilePath = 'assets/videos/' . $newFileName . "." . $fileExtention[count($fileExtention) - 1];

            // Check if the video file exists
            if (!file_exists($videoFilePath)) {
                $response = ['status' => false, 'errorMessage' => 'Generate Thumbnail Error no video file found!'];
                header('Content-Type: application/json');
                echo json_encode($response);
                return;
            }
            // Attempt to generate video thumbnail
            $ffmpeg = FFMpeg\FFMpeg::create([
                'ffmpeg.binaries'  => 'C:/FFmpeg/bin/ffmpeg.exe',
                'ffprobe.binaries' => 'C:/FFmpeg/bin/ffprobe.exe'
            ]);

            // Open the video file
            $video = $ffmpeg->open($videoFilePath);
            // Get the duration of the video
            $duration =  $video->getStreams()->videos()->first()->get('duration');
            // Generate a random timecode within the video duration
            $timecode = FFMpeg\Coordinate\TimeCode::fromSeconds(rand(1, ($duration * 0.05)));
            // Get the frame at the selected timecode
            $frame = $video->frame($timecode);
            // Save the frame as a thumbnail image
            $thumbnailPath = './assets/images/videoThumbnail/' . $videoThumbnail . $videoThumbnailType;
            $frame->save($thumbnailPath);
        }

        $videoThumbnailData = [
            'video_thumbnail_name' => $videoThumbnail,
            'video_thumbnail_type' =>  $videoThumbnailType,
            'video_id' => $this->db->insert_id(),
        ];

        // insert video thumbnail
        if (!$this->db->insert('cwie_video_thumbnail', $videoThumbnailData)) {
            $response = ['status' => false, 'errorMessage' => 'DB ERROR! : ' . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => true]);
    }

    public function onAddVideoURL()
    {
        if (!$this->checkPermission(['admin', 'faculty'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // validate videoTitle
        $this->form_validation->set_rules('videoTitle', '', 'trim|required');
        // validate videoURL
        $this->form_validation->set_rules('videoURL', '', 'trim|required');

        // On validation errors
        if (!$this->form_validation->run()) {
            $response = ['status' => false, 'errorMessage' => 'Validatation Error !'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // post news variable with xss clean
        $videoTitle = $this->input->post('videoTitle', true);
        $videoName = $this->cleanYouTubeUrl($this->input->post('videoURL', true));
        $videoType = 'youtube';
        $videoThumbnail = $this->youTubeThumbnailUrl($this->input->post('videoURL', true));
        $videoThumbnailType = 'youtube';
        $videoAuthor = $this->session->userdata('crudSessionData')['crudPermission'] == 'admin' ? 'สถาบันการเรียนรู้ตลอดชีวิต' : $this->session->userdata('crudSessionData')['crudName'] . ' ' . (isset($this->session->userdata('crudSessionData')['crudSurname']) ? $this->session->userdata('crudSessionData')['crudSurname'] : '');

        $videoData = [
            'video_title' => $videoTitle,
            'video_name' => $videoName,
            'video_type' => $videoType,
            'video_author' =>  $videoAuthor,
            'auth_id' => $this->session->userdata('crudSessionData')['crudAuthId']
        ];

        // insert video data
        if (!$this->db->insert('cwie_video', $videoData)) {
            $response = ['status' => false, 'errorMessage' => 'DB ERROR! : ' . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        $insertVideoID = $this->db->insert_id();

        $videoThumbnailData = [
            'video_thumbnail_name' => $videoThumbnail,
            'video_thumbnail_type' =>  $videoThumbnailType,
            'video_id' => $insertVideoID,
        ];

        // insert video thumbnail
        if (!$this->db->insert('cwie_video_thumbnail', $videoThumbnailData)) {
            $response = ['status' => false, 'errorMessage' => 'DB ERROR! : ' . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // set welcome video
        if ($this->input->post('welcomeVideo')) {
            $welcomeVideoData = [
                'video_id' => $insertVideoID,
            ];
            // update faculty welcome video 
            if (!$this->db->update('cwie_faculty', $welcomeVideoData, array('auth_id' => $this->session->userdata('crudSessionData')['crudAuthId']))) {
                $response = ['status' => false, 'errorMessage' => 'DB ERROR! : ' . $this->db->error()['message']];
                header('Content-Type: application/json');
                echo json_encode($response);
                return;
            }
        }

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => true]);
    }

    public function onEditVideo()
    {
        if (!$this->checkPermission(['admin', 'faculty'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // validate videoTitle
        $this->form_validation->set_rules('videoTitle', '', 'trim|required');

        // On validation errors
        if (!$this->form_validation->run()) {
            $response = ['status' => false, 'errorMessage' => 'Validatation Error !'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // post news variable with xss clean
        $videoID = $this->input->post('videoID', true);
        $videoTitle = $this->input->post('videoTitle', true);

        // query video data
        $queryVideo = $this->db->join('cwie_video_thumbnail', 'cwie_video.video_id = cwie_video_thumbnail.video_id')->get_where('cwie_video', array('cwie_video.video_id' => $videoID));

        if ($queryVideo->num_rows() <= 0) {
            $response = ['status' => false, 'errorMessage' => 'Video Not Found!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // Load the string helper
        $this->load->helper('string');

        if (!empty($_FILES['videoFile']['name'])) {
            $newFileName = random_string('alnum', 30);
            $fileExtention = explode(".", $_FILES["videoFile"]["name"]);
            $config['upload_path'] = './assets/videos';
            $config['file_name'] = $newFileName . "." . $fileExtention[count($fileExtention) - 1];
            $config['allowed_types'] = '*';
            $config['max_size'] = '102400';
            $this->upload->initialize($config);

            // upload video
            if (!$this->upload->do_upload('videoFile')) {
                $response = ['status' => false, 'errorMessage' => 'Video Upload Error! : ' . $this->upload->display_errors()];
                header('Content-Type: application/json');
                echo json_encode($response);
                return;
            }

            if (file_exists('./assets/videos/' . $queryVideo->row()->video_name . $queryVideo->row()->video_type)) {
                // Attempt to delete video file
                if (!unlink('./assets/videos/' . $queryVideo->row()->video_name . $queryVideo->row()->video_type)) {
                    $response = ['status' => false, 'errorMessage' => 'Failed to unlink video file : ' . error_get_last()['message']];
                    header('Content-Type: application/json');
                    echo json_encode($response);
                    return;
                }
            }

            $videoUpdateData = [
                'video_name' => $newFileName,
                'video_type' => "." . $fileExtention[count($fileExtention) - 1],
            ];

            if ($this->input->post('generateThumbnail')) {
                // generate video thumbnail from video with specific wanted frame of video 
                $videoThumbnail = random_string('alnum', 30);
                $videoThumbnailType = ".jpg";

                // Set the video file path
                $videoFilePath = 'assets/videos/' . $newFileName . "." . $fileExtention[count($fileExtention) - 1];

                // Check if the video file exists
                if (!file_exists($videoFilePath)) {
                    $response = ['status' => false, 'errorMessage' => 'Generate Thumbnail Error no video file found!'];
                    header('Content-Type: application/json');
                    echo json_encode($response);
                    return;
                }
                // Attempt to generate video thumbnail
                $ffmpeg = FFMpeg\FFMpeg::create([
                    'ffmpeg.binaries'  => 'C:/FFmpeg/bin/ffmpeg.exe',
                    'ffprobe.binaries' => 'C:/FFmpeg/bin/ffprobe.exe'
                ]);

                // Open the video file
                $video = $ffmpeg->open($videoFilePath);
                // Get the duration of the video
                $duration =  $video->getStreams()->videos()->first()->get('duration');
                // Generate a random timecode within the video duration
                $timecode = FFMpeg\Coordinate\TimeCode::fromSeconds(rand(1, ($duration * 0.05)));
                // Get the frame at the selected timecode
                $frame = $video->frame($timecode);
                // Save the frame as a thumbnail image
                $thumbnailPath = './assets/images/videoThumbnail/' . $videoThumbnail . $videoThumbnailType;
                $frame->save($thumbnailPath);

                if (file_exists('./assets/images/videoThumbnail/' . $queryVideo->row()->video_thumbnail_name . $queryVideo->row()->video_thumbnail_type)) {
                    // Attempt to delete thumbnail file
                    if (!unlink('./assets/images/videoThumbnail/' . $queryVideo->row()->video_thumbnail_name . $queryVideo->row()->video_thumbnail_type)) {
                        $response = ['status' => false, 'errorMessage' => 'Failed to unlink thumbnail file : ' . error_get_last()['message']];
                        header('Content-Type: application/json');
                        echo json_encode($response);
                        return;
                    }
                }


                $videoThumbnailUpdateData = [
                    'video_thumbnail_name' => $videoThumbnail,
                    'video_thumbnail_type' =>  $videoThumbnailType,
                ];

                if (!$this->db->update('cwie_video_thumbnail', $videoThumbnailUpdateData, array('video_id' => $videoID))) {
                    $response = ['status' => false, 'errorMessage' => 'DB ERROR! : ' . $this->db->error()['message']];
                    header('Content-Type: application/json');
                    echo json_encode($response);
                    return;
                }
            }
        }

        $videoUpdateData['video_title'] =  $videoTitle;

        // update video data
        if (!$this->db->update('cwie_video', $videoUpdateData, array('video_id' => $videoID))) {
            $response = ['status' => false, 'errorMessage' => 'DB ERROR! : ' . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        if (!empty($_FILES['videoThumbnail']['name']) && !$this->input->post('generateThumbnail')) {
            $newFileName = random_string('alnum', 30);
            $fileExtention = explode(".", $_FILES["videoThumbnail"]["name"]);
            $config['upload_path'] = './assets/images/videoThumbnail';
            $config['file_name'] = $newFileName . "." . $fileExtention[count($fileExtention) - 1];
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = '2048';
            $this->upload->initialize($config);

            // upload video thumbnail
            if (!$this->upload->do_upload('videoThumbnail')) {
                $response = ['status' => false, 'errorMessage' => 'Video Upload Error! : ' . $this->upload->display_errors()];
                header('Content-Type: application/json');
                echo json_encode($response);
                return;
            }

            if (file_exists('./assets/images/videoThumbnail/' . $queryVideo->row()->video_thumbnail_name . $queryVideo->row()->video_thumbnail_type)) {
                // Attempt to delete thumbnail file
                if (!unlink('./assets/images/videoThumbnail/' . $queryVideo->row()->video_thumbnail_name . $queryVideo->row()->video_thumbnail_type)) {
                    $response = ['status' => false, 'errorMessage' => 'Failed to unlink thumbnail file : ' . error_get_last()['message']];
                    header('Content-Type: application/json');
                    echo json_encode($response);
                    return;
                }
            }

            $videoThumbnailUpdateData = [
                'video_thumbnail_name' => $newFileName,
                'video_thumbnail_type' =>  "." . $fileExtention[count($fileExtention) - 1],
            ];
        }

        if ($this->input->post('generateThumbnail') && empty($_FILES['videoFile']['name'])) {
            // generate video thumbnail from video with specific wanted frame of video 
            $videoThumbnail = random_string('alnum', 30);
            $videoThumbnailType = ".jpg";

            // Set the video file path
            $videoFilePath = 'assets/videos/' . $queryVideo->row()->video_name . $queryVideo->row()->video_type;

            // Check if the video file exists
            if (!file_exists($videoFilePath)) {
                $response = ['status' => false, 'errorMessage' => 'Generate Thumbnail Error no video file found!'];
                header('Content-Type: application/json');
                echo json_encode($response);
                return;
            }

            // Attempt to generate video thumbnail
            $ffmpeg = FFMpeg\FFMpeg::create([
                'ffmpeg.binaries'  => 'C:/FFmpeg/bin/ffmpeg.exe',
                'ffprobe.binaries' => 'C:/FFmpeg/bin/ffprobe.exe'
            ]);

            // Open the video file
            $video = $ffmpeg->open($videoFilePath);
            // Get the duration of the video
            $duration =  $video->getStreams()->videos()->first()->get('duration');
            // Generate a random timecode within the video duration
            $timecode = FFMpeg\Coordinate\TimeCode::fromSeconds(rand(1, ($duration * 0.05)));
            // Get the frame at the selected timecode
            $frame = $video->frame($timecode);
            // Save the frame as a thumbnail image
            $thumbnailPath = './assets/images/videoThumbnail/' . $videoThumbnail . $videoThumbnailType;
            $frame->save($thumbnailPath);

            if (file_exists('./assets/images/videoThumbnail/' . $queryVideo->row()->video_thumbnail_name . $queryVideo->row()->video_thumbnail_type)) {
                // Attempt to delete thumbnail file
                if (!unlink('./assets/images/videoThumbnail/' . $queryVideo->row()->video_thumbnail_name . $queryVideo->row()->video_thumbnail_type)) {
                    $response = ['status' => false, 'errorMessage' => 'Failed to unlink thumbnail file : ' . error_get_last()['message']];
                    header('Content-Type: application/json');
                    echo json_encode($response);
                    return;
                }
            }

            $videoThumbnailUpdateData = [
                'video_thumbnail_name' => $videoThumbnail,
                'video_thumbnail_type' =>  $videoThumbnailType,
            ];
        }

        // update video thumbnail
        if (isset($videoThumbnailUpdateData)) {
            if (!$this->db->update('cwie_video_thumbnail', $videoThumbnailUpdateData, array('video_id' => $videoID))) {
                $response = ['status' => false, 'errorMessage' => 'DB ERROR! : ' . $this->db->error()['message']];
                header('Content-Type: application/json');
                echo json_encode($response);
                return;
            }
        }

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => true]);
    }

    public function onEditVideoURL()
    {
        if (!$this->checkPermission(['admin', 'faculty'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // validate videoTitle
        $this->form_validation->set_rules('videoTitle', '', 'trim|required');
        // validate videoURL
        $this->form_validation->set_rules('videoURL', '', 'trim|required');

        // On validation errors
        if (!$this->form_validation->run()) {
            $response = ['status' => false, 'errorMessage' => 'Validatation Error !'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // post news variable with xss clean
        $videoID = $this->input->post('videoID', true);
        $videoTitle = $this->input->post('videoTitle', true);
        $videoName = $this->cleanYouTubeUrl($this->input->post('videoURL', true));
        $videoThumbnail = $this->youTubeThumbnailUrl($this->input->post('videoURL', true));

        $videoUpdateData = [
            'video_title' => $videoTitle,
            'video_name' => $videoName,
        ];

        $videoThumbnailData = [
            'video_thumbnail_name' => $videoThumbnail,
        ];

        // update video data
        if (!$this->db->update('cwie_video', $videoUpdateData, array('video_id' => $videoID))) {
            $response = ['status' => false, 'errorMessage' => 'DB ERROR! : ' . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // update video thumbnail
        if (!$this->db->update('cwie_video_thumbnail', $videoThumbnailData, array('video_id' => $videoID))) {
            $response = ['status' => false, 'errorMessage' => 'DB ERROR! : ' . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        if ($this->session->userdata('crudSessionData')['crudPermission'] != 'admin') {
            // set welcome video
            if ($this->input->post('welcomeVideo')) {
                $welcomeVideoData = [
                    'video_id' => $videoID,
                ];
                // update faculty welcome video 
                if (!$this->db->update('cwie_faculty', $welcomeVideoData, array('auth_id' => $this->session->userdata('crudSessionData')['crudAuthId']))) {
                    $response = ['status' => false, 'errorMessage' => 'DB ERROR! : ' . $this->db->error()['message']];
                    header('Content-Type: application/json');
                    echo json_encode($response);
                    return;
                }
            } else {
                // check current welcome video
                $queryCurrentWelcomeVideo = $this->db->select('video_id')->get_where('cwie_faculty', array('auth_id' => $this->session->userdata('crudSessionData')['crudAuthId']));
                if ($videoID == $queryCurrentWelcomeVideo->row()->video_id) {
                    $welcomeVideoData = [
                        'video_id' => null,
                    ];
                    // update faculty welcome video 
                    if (!$this->db->update('cwie_faculty', $welcomeVideoData, array('auth_id' => $this->session->userdata('crudSessionData')['crudAuthId']))) {
                        $response = ['status' => false, 'errorMessage' => 'DB ERROR! : ' . $this->db->error()['message']];
                        header('Content-Type: application/json');
                        echo json_encode($response);
                        return;
                    }
                }
            }
        }

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => true]);
    }

    public function onDeleteVideo($videoID = null)
    {
        if (!$this->checkPermission(['admin', 'faculty'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        if ($videoID == null) {
            $response = ['status' => false, 'errorMessage' =>  "Parameter Not Found!"];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // query video data
        $queryVideo = $this->db->join('cwie_video_thumbnail', 'cwie_video.video_id = cwie_video_thumbnail.video_id')->get_where('cwie_video', array('cwie_video.video_id' => $videoID));

        // if not found video by id
        if ($queryVideo->num_rows() <= 0) {
            $response = ['status' => false, 'errorMessage' => "Video Not Found!"];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // unlink image if not youtube video
        if ($queryVideo->row()->video_type != 'youtube') {

            if (file_exists('./assets/videos/' . $queryVideo->row()->video_name . $queryVideo->row()->video_type)) {
                // Attempt to delete video file
                if (!unlink('./assets/videos/' . $queryVideo->row()->video_name . $queryVideo->row()->video_type)) {
                    $response = ['status' => false, 'errorMessage' => 'Failed to unlink video file : ' . error_get_last()['message']];
                    header('Content-Type: application/json');
                    echo json_encode($response);
                    return;
                }
            }

            if (file_exists('./assets/images/videoThumbnail/' . $queryVideo->row()->video_thumbnail_name . $queryVideo->row()->video_thumbnail_type)) {
                // Attempt to delete thumbnail file
                if (!unlink('./assets/images/videoThumbnail/' . $queryVideo->row()->video_thumbnail_name . $queryVideo->row()->video_thumbnail_type)) {
                    $response = ['status' => false, 'errorMessage' => 'Failed to unlink thumbnail file : ' . error_get_last()['message']];
                    header('Content-Type: application/json');
                    echo json_encode($response);
                    return;
                }
            }
        }

        // if delete video error
        if (!$this->db->delete('cwie_video', array('video_id' => $videoID))) {
            $response = ['status' => false, 'errorMessage' => "DB Error! " . $this->db->error()['message']];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        header('Content-Type: application/json');
        echo json_encode($response = ['status' => true]);
    }

    private function cleanYouTubeUrl($url)
    {
        // Extract the video ID from the URL
        $videoId = '';
        parse_str(parse_url($url, PHP_URL_QUERY), $params);
        if (isset($params['v'])) {
            $videoId = $params['v'];
        }
        // Construct the thumbnail URL
        $cleanURL = 'https://www.youtube.com/watch?v=' . $videoId;
        return $cleanURL;
    }

    private function youTubeThumbnailUrl($url)
    {
        // Extract the video ID from the URL
        $videoId = '';
        parse_str(parse_url($url, PHP_URL_QUERY), $params);
        if (isset($params['v'])) {
            $videoId = $params['v'];
        }

        // Construct the thumbnail URL
        $thumbnailUrl = 'https://img.youtube.com/vi/' . $videoId . '/mqdefault.jpg';
        return $thumbnailUrl;
    }
}
