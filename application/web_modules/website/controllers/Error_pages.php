<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Error_pages extends CI_Controller
{
    /*
    | --------------------------------------------------------------------------------
    | Load View Section
    | --------------------------------------------------------------------------------
    */

    public function index()
    {

        if (strpos(str_replace('/index.php', '', current_url()), 'crud')) {
            $this->load->view('error_404_crud');
            return;
        }

        $this->load->view('error_404');
    }
}
