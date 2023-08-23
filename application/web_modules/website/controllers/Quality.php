<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Quality extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    private function mainVariable()
    {
        $reponse['title'] = 'CRRU-CWIE | คณะกรรมการขับเคลื่อนสหกิจศึกษาและการศึกษาเชิงบูรณาการกับการทำงาน';
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

        $response['page'] = 'Quality';

        $response['Breadcrumb'] = [
            'title' => 'ประกันคุณภาพ',
            'main' => 'ประกันคุณภาพ',
        ];

        $this->load->view('z_template/header', $response);
        $this->load->view('quality/qualityPage', $response);
        $this->load->view('z_template/footer');
    }

    /*
    | --------------------------------------------------------------------------------
    | Functions Section
    | --------------------------------------------------------------------------------
    */
}
