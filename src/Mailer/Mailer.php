<?php
declare(strict_types=1);

namespace App\Mailer;

use App\Globals\_ENV;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require_once ROOT . '/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require_once ROOT . '/vendor/phpmailer/phpmailer/src/SMTP.php';
require_once ROOT . '/vendor/phpmailer/phpmailer/src/Exception.php';

class Mailer
{
    private PHPMailer $mailer;
    private _ENV $env;

    public function __construct()
    {
        $this->env = new _ENV();
        $this->mailer = new \PHPMailer\PHPMailer\PHPMailer();
        $this->mailer->SMTPDebug = SMTP::DEBUG_SERVER; // Enable verbose debug output
        $this->mailer->isSMTP();
        $this->mailer->Host = $this->env->getEnv('MAILER_HOST');
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = $this->env->getEnv('ADMIN_EMAIL');
        $this->mailer->Password = $this->env->getEnv('MAIL_PASSWORD');
        $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $this->mailer->Port = $this->env->getEnv('MAILER_PORT');
        $this->mailer->setLanguage('fr', 'vendor\phpmailer\phpmailer\language\phpmailer.lang-fr.php');
        $this->mailer->CharSet = 'UTF-8';
        $this->mailer->isHTML(true);
    }
    /**
     * @param string $subject
     * @param string $body
     * @return bool
     * @throws Exception
     */
    public function send(string $subject, string $body): bool
    {
        try {
            //Recipients
            $this->mailer->setFrom($this->env->getEnv('ADMIN_EMAIL'));
            $this->mailer->addAddress($this->env->getEnv('ADMIN_EMAIL'));

            // Content
            $this->mailer->Subject = $subject;
            $this->mailer->Body = $body;

            return $this->mailer->send();

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}