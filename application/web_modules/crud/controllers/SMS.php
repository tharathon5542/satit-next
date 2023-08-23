<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SMS extends CI_Controller
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
        if (!$this->checkPermission(['admin'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        $response = $this->mainVariable();
        $response['page'] = 'SMS';

        $this->load->view('z_template/header', $response);
        $this->load->view('sms/smsPage', $response);
        $this->load->view('z_template/footer');
    }

    /*
    | --------------------------------------------------------------------------------
    | Functions Section
    | --------------------------------------------------------------------------------
    */

    public function onCheckCredit($provider = null)
    {
        if (!$this->checkPermission(['admin'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        if ($provider == null) {
            $response = ['status' => false, 'errorMessage' => 'Parameter Not Found!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        switch ($provider) {
            case 0:
                $credit = 0;
                break;
            case 1:
                $response = $this->mainVariable();
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://thsms.com/api/me',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                    CURLOPT_HTTPHEADER => array(
                        'Authorization: Bearer ' . $response['apiKey'],
                        'Content-Type: application/json'
                    ),
                ));
                $response = json_decode(curl_exec($curl));
                curl_close($curl);
                $credit = $response->data->wallet->credit;
                break;
        }
        echo json_encode(['status' => true, 'data' => round($credit, 0)]);
    }

    public function onSendSMS($provider = null)
    {
        if (!$this->checkPermission(['admin', 'faculty'])) {
            $response = ['status' => false, 'errorMessage' => 'Permission Denied!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        if ($provider == null) {
            $response = ['status' => false, 'errorMessage' => 'Parameter Not Found!'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        // validate tel
        $this->form_validation->set_rules('tels', '', 'trim|required');
        // validate message
        $this->form_validation->set_rules('message', '', 'trim|required');

        // post workPlaceType variable with xss clean
        $tels = explode(',', $this->input->post('tels', true));
        $formattedTels = "";
        foreach ($tels as $tel) {
            $formattedTels .= '"' . $tel . '",';
        }
        $message = $this->input->post('message', true);

        switch ($provider) {
            case 0:
                $response = ['status' => false, 'errorMessage' => 'Out of Credit!'];
                header('Content-Type: application/json');
                echo json_encode($response);
                return;
            case 1:
                $response = $this->mainVariable();
                $messageChunks = str_split($message, 160);
                $curl = curl_init();
                $setting = [
                    CURLOPT_URL => 'https://thsms.com/api/send-sms',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_HTTPHEADER => array(
                        'Authorization: Bearer ' . $response['apiKey'],
                        'Content-Type: application/json'
                    ),
                ];
                foreach ($messageChunks as $chunk) {
                    $setting[CURLOPT_POSTFIELDS] = '
                    {
                        "sender" : "CRRU.CLLI",
                        "msisdn" : [' . substr($formattedTels, 0, -1) . '],
                        "message" : "' . $chunk . '"
                    }';
                    curl_setopt_array($curl, $setting);
                    $response = json_decode(curl_exec($curl));
                    if (!$response->success) {
                        $response = ['status' => false, 'errorMessage' => $response->message];
                        header('Content-Type: application/json');
                        echo json_encode($response);
                        return;
                    }
                    continue;
                }
                curl_close($curl);
                break;
        }

        header('Content-Type: application/json');
        echo json_encode(['status' => true, 'creditUsage' => $response->data->credit_usage, 'creditRemain' => $response->data->remaining_credit]);
    }
}
