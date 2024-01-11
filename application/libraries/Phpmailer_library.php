<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Phpmailer_library {
 
    public function load()
    {
        include_once APPPATH . '/third_party/PHPMailer/PHPMailer.php';
        include_once APPPATH . '/third_party/PHPMailer/Exception.php';
        include_once APPPATH . '/third_party/PHPMailer/SMTP.php';

        $objMail = new PHPMailer\PHPMailer\PHPMailer();
        return $objMail;
    }
}
?>