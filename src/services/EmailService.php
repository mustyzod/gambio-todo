<?php

namespace Gambio\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailService extends PHPMailer
{
    public function __construct()
    {
        parent::__construct();
        $this->SMTPDebug = 0;
        $this->isSMTP();
        $this->Host = $_ENV['SMTP_HOST'];
        $this->SMTPAuth = true;
        $this->Username = $_ENV['SMTP_USERNAME'];
        $this->Password = $_ENV['SMTP_PASSWORD'];
        $this->SMTPSecure = $_ENV['SMTP_ENCRYPTION'];
        $this->Port = $_ENV['SMTP_PORT'];
        $this->setFrom($_ENV['MAIL_DEFAULT_SENDER_EMAIL'], $_ENV['MAIL_DEFAULT_SENDER_NAME']);
        $this->addReplyTo($_ENV['MAIL_DEFAULT_REPLYTO_EMAIL'], $_ENV['MAIL_DEFAULT_REPLYTO_NAME']);
        $this->CharSet = "UTF-8";
        $this->isHTML(true);
    }
    /**
     * Send email
     * 
     * @param   string  $email,
     * @param   string  $message
     * @param   string  $subject
     * 
     * @return boolean
     */

    public function sendMail($email, $message, $subject): bool
    {
        try {
            $this->Subject = $subject;
            $this->addAddress($email);
            $this->Body = $message;
            return $this->send();
        } catch (Exception $e) {
            return $errors['mail'] = "Failed. Mailer error: {$this->ErrorInfo}";
        }
    }
    public function divideBy($num2)
    {
        if ($num2 == 0) return NAN;
        return $this->getNumberFromUserInput() / $num2;
    }
}
