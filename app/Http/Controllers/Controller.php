<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Log;
use PHPMailer\PHPMailer;
use \Illuminate\Filesystem\Filesystem;
use File;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    function simpleLogger($class, $method, $message = [], $line = null) {
        if (is_object($class)) {
          $name = get_class($class);
        } else if (is_string($class)) {
          $name = $class;
        } else {
          $name = "PROVIDE A NAME PLEASE";
        }
        $msg = is_string($message) ? $message: json_encode($message);
        \Log::debug("Namespace => [" . $name . "] \n\t Function => " . $method . " \n\t Title/Line => " . $line . "\n\t Message/DTO/Request => " . $msg);
    }

    function sendEmail($recipients,$subject,$text,$file_name=null)
    {
        $mail             = new PHPMailer\PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPDebug  = 2;
        $mail->SMTPAuth   = true;
        $mail->SMTPSecure = env('MAIL_ENCRYPTION');
        $mail->Host       = env('MAIL_HOST');
        $mail->Port       = env('MAIL_PORT');
        $mail->Username   = env('MAIL_USERNAME');
        $mail->Password   = env('MAIL_PASSWORD');
        $mail->SetFrom("pascalprahardhika@gmail.com", env('APP_NAME'));
        $mail->Subject    = $subject;

        $filepath = storage_path('excel/exports/').$file_name;
        if(File::exists($filepath))
        {
            $mail->addAttachment($filepath,$file_name);    
        } 
        
        $mail->IsHTML(true);

        foreach($recipients as $email => $name)
        {
           $mail->AddCC($email, $name);
        }

        $bodyContent = 'Email from '.env('APP_NAME');
        $bodyContent .= '<br><br>'.$text;
        $bodyContent .= '<br><br>Address: Jl. Solo-Jogja KM 15 <br><br>Date: '.date('d-m-Y').'<br>Contact Person: 08956535353535';

        $mail->Body       = $bodyContent;
        
        if(!$mail->send()) {
            $this->simpleLogger($this, __FUNCTION__, $mail, __LINE__);
            return "Terjadi error: ".$mail->ErrorInfo;
        } else {
            return "Email berhasil dikirim";
        }
    }
}
