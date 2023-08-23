<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Chat extends CI_Controller
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
        $response['title'] = 'CRRU-CWIE | MIS';
        $response['description'] = 'CWIE';
        $response['author'] = 'CLLI Devs';
        $response['apiKey'] = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC90aHNtcy5jb21cL2xvZ2luIiwiaWF0IjoxNjYwMTE1NDUxLCJuYmYiOjE2NjAxMTU0NTEsImp0aSI6IkRGbUFMekNpQ1hLcDVhOEgiLCJzdWIiOjEwNjc5MywicHJ2IjoiMjNiZDVjODk0OWY2MDBhZGIzOWU3MDFjNDAwODcyZGI3YTU5NzZmNyJ9.r7sqSP0wKBh8i8b7YHgL1aGeL8kUNz_XDA_KgOONVqg';
        return $response;
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
        $response = $this->mainVariable();
        $response['page'] = 'Chat';

        $this->load->view('z_template/header', $response);
        $this->load->view('chat/chatPage', $response);
        $this->load->view('z_template/footer');
    }

    /*
    | --------------------------------------------------------------------------------
    | Functions Section
    | --------------------------------------------------------------------------------
    */

    private function configPusher()
    {
        $options = array(
            'cluster' => 'ap1',
            'useTLS' => true
        );

        $pusher = new Pusher\Pusher(
            '7226a07b4e54ff05b233',
            '440511deae3491b6ff0a',
            '1656625',
            $options
        );

        return $pusher;
    }

    public function getMessage()
    {

        $pusher = $this->configPusher();

        $queryChatData = $this->db->select('chat_id AS chatID, cwie_chat.auth_id, auth_type, chat_message, chat_timestamp')
            ->join('cwie_authentication', 'cwie_authentication.auth_id  = cwie_chat.auth_id')
            ->get('cwie_chat');

        foreach ($queryChatData->result() as $chatData) {
            switch ($chatData->auth_type) {
                case 0:
                    $queryUserData = $this->db->select('admin_name, admin_surname, profile_image_name, profile_image_type')
                        ->join('cwie_profile_image', 'cwie_admin.auth_id = cwie_profile_image.auth_id', 'left')
                        ->get_where('cwie_admin', ['cwie_admin.auth_id' => $chatData->auth_id]);
                    $userData = [
                        'userNameSurname' => $queryUserData->row()->admin_name . ' ' . $queryUserData->row()->admin_surname,
                        'userImage' => $queryUserData->row()->profile_image_name ? base_url('assets/images/profile/') . $queryUserData->row()->profile_image_name .  $queryUserData->row()->profile_image_type : 'https://robohash.org/' . $chatData->auth_id . '.png'
                    ];
                    break;
                case 1:
                    $queryUserData = $this->db->select('faculty_name_th, profile_image_name, profile_image_type')
                        ->join('cwie_profile_image', 'cwie_faculty.auth_id = cwie_profile_image.auth_id', 'left')
                        ->get_where('cwie_faculty', ['cwie_faculty.auth_id' => $chatData->auth_id]);
                    $userData = [
                        'userNameSurname' => $queryUserData->row()->faculty_name_th,
                        'userImage' => $queryUserData->row()->profile_image_name ? base_url('assets/images/profile/') . $queryUserData->row()->profile_image_name .  $queryUserData->row()->profile_image_type : 'https://robohash.org/' . $chatData->auth_id . '.png'
                    ];
                    break;
                case 2:
                    $queryUserData = $this->db->select('major_name_th, profile_image_name, profile_image_type')
                        ->join('cwie_profile_image', 'cwie_major.auth_id = cwie_profile_image.auth_id', 'left')
                        ->get_where('cwie_major', ['cwie_major.auth_id' => $chatData->auth_id]);
                    $userData = [
                        'userNameSurname' => $queryUserData->row()->major_name_th,
                        'userImage' => $queryUserData->row()->profile_image_name ? base_url('assets/images/profile/') . $queryUserData->row()->profile_image_name .  $queryUserData->row()->profile_image_type : 'https://robohash.org/' . $chatData->auth_id . '.png'
                    ];
                    break;
            };

            $userData['chatID'] = $chatData->chatID;
            $userData['userMessage'] = $chatData->chat_message;
            $userData['timeStamp'] = (new DateTime($chatData->chat_timestamp))->format('d/m/Y H:i');
            $userData['authID'] = $chatData->auth_id;

            $pusher->trigger('chat-channel-local', 'new-message', $userData);

            echo $queryChatData;
        }
    }

    public function send()
    {
        $message = $this->input->post('message');

        // save message to database
        $chatID = $this->saveMessage($message);

        // push message real-time
        $this->sendPusherMessage($message, $chatID);
    }

    private function sendPusherMessage($message, $chatID)
    {
        $pusher = $this->configPusher();

        switch ($this->session->userdata('crudSessionData')['crudPermission']) {
            case 'admin':
                $queryUserData = $this->db->select('admin_name, admin_surname, profile_image_name, profile_image_type')
                    ->join('cwie_profile_image', 'cwie_admin.auth_id = cwie_profile_image.auth_id', 'left')
                    ->get_where('cwie_admin', ['cwie_admin.auth_id' => $this->session->userdata('crudSessionData')['crudAuthId']]);
                $userData = [
                    'userNameSurname' => $queryUserData->row()->admin_name . ' ' . $queryUserData->row()->admin_surname,
                    'userImage' => $queryUserData->row()->profile_image_name ? base_url('assets/images/profile/') . $queryUserData->row()->profile_image_name .  $queryUserData->row()->profile_image_type : 'https://robohash.org/' . $this->session->userdata('crudSessionData')['crudAuthId'] . '.png'
                ];
                break;
            case 'faculty':
                $queryUserData = $this->db->select('faculty_name_th, profile_image_name, profile_image_type')
                    ->join('cwie_profile_image', 'cwie_faculty.auth_id = cwie_profile_image.auth_id', 'left')
                    ->get_where('cwie_faculty', ['cwie_faculty.auth_id' => $this->session->userdata('crudSessionData')['crudAuthId']]);
                $userData = [
                    'userNameSurname' => $queryUserData->row()->faculty_name_th,
                    'userImage' => $queryUserData->row()->profile_image_name ? base_url('assets/images/profile/') . $queryUserData->row()->profile_image_name .  $queryUserData->row()->profile_image_type : 'https://robohash.org/' . $this->session->userdata('crudSessionData')['crudAuthId'] . '.png'
                ];
                break;
            case 'major':
                $queryUserData = $this->db->select('major_name_th, profile_image_name, profile_image_type')
                    ->join('cwie_profile_image', 'cwie_major.auth_id = cwie_profile_image.auth_id', 'left')
                    ->get_where('cwie_major', ['cwie_major.auth_id' => $this->session->userdata('crudSessionData')['crudAuthId']]);
                $userData = [
                    'userNameSurname' => $queryUserData->row()->major_name_th,
                    'userImage' => $queryUserData->row()->profile_image_name ? base_url('assets/images/profile/') . $queryUserData->row()->profile_image_name .  $queryUserData->row()->profile_image_type : 'https://robohash.org/' . $this->session->userdata('crudSessionData')['crudAuthId'] . '.png'
                ];
                break;
        };

        $userData['chatID'] = $chatID;
        $userData['userMessage'] = $message;
        $userData['timeStamp'] = (new DateTime(date('Y-m-d H:i:s')))->format('d/m/Y H:i');
        $userData['authID'] = $this->session->userdata('crudSessionData')['crudAuthId'];

        $pusher->trigger('chat-channel-local', 'new-message', $userData);
    }

    private function saveMessage($message)
    {
        // save message to database
        $messageData = [
            'auth_id' => $this->session->userdata('crudSessionData')['crudAuthId'],
            'chat_message' => $message,
        ];

        if (!$this->db->insert('cwie_chat', $messageData)) {
            $response = ['status' => false, 'errorMessage' => $this->db->error()['message']];
            return $response;
        }

        return $this->db->insert_id();
    }
}
