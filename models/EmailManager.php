<?php
/**
 * Created by PhpStorm.
 * User: artur
 * Date: 20.12.16
 * Time: 12:55
 */
namespace app\models;

use PHPMailer;
use yii\helpers\Url;

class EmailManager
{
    private $email;
    private $mailer;

    public function __construct($email)
    {
        $this->email = $email;
        $this->mailer = $this->getMailer();
    }

    public function resetPassword()
    {
        $password = $this->generateRandomString();
        $this->mailer->MsgHTML('Your new password: ' . $password);
        $this->mailer->Subject    = sprintf("Password reset");

        if(!$this->mailer->Send()) {
            return false;
        } else {
            return $password;
        }
    }

    public function confirmEmail(){
        $user = User::findByUsername($this->email);

        if($user){
            $this->mailer->MsgHTML('Go to: ' . Url::to(['site/confirm'], true) . '&id=' . $user->getId());
            $this->mailer->Subject    = sprintf("Email confirmation");

            if($this->mailer->Send()) {
                return true;
            }
        }

        return false;
    }

    private function getMailer()
    {
        $mail = new PHPMailer();

        $mail->IsSMTP();
        $mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
        $mail->SMTPAuth   = true;                  // enable SMTP authentication
        $mail->SMTPSecure = "tls";                 // sets the prefix to the servier
        $mail->Host       = "ssl://smtp.gmail.com";      // sets GMAIL as the SMTP server
        $mail->Port       = 465;                   // set the SMTP port for the GMAIL server
        $mail->Username   = "projektcs11@gmail.com";  // GMAIL username
        $mail->Password   = "projektcs11CS";            // GMAIL password

        $mail->SetFrom('projektcs11@gmail.com', 'Manager');

        $mail->Subject    = sprintf("Site manager");

        $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

        $mail->AddAddress($this->email, "John");

        $password = $this->generateRandomString();
        $mail->MsgHTML('Your new password: ' . $password);

        return $mail;
    }

    private function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }
}