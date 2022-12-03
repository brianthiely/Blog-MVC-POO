<?php
declare(strict_types=1);

namespace App\Mailer;

use App\Globals\Globals;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require_once ROOT . '/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require_once ROOT . '/vendor/phpmailer/phpmailer/src/SMTP.php';
require_once ROOT . '/vendor/phpmailer/phpmailer/src/Exception.php';

class Mailer
{
    private PHPMailer $mailer;

    public function __construct()
    {
        $globals = new Globals();
        $MAILER_HOST = $globals->getEnv('MAILER_HOST');
        $MAILER_PORT = $globals->getEnv('MAILER_PORT');
        $MAILER_USERNAME = $globals->getEnv('MAILER_USERNAME');
        $MAILER_PASSWORD = $globals->getEnv('MAILER_PASSWORD');

        $this->mailer = new \PHPMailer\PHPMailer\PHPMailer();
        $this->mailer->SMTPDebug = SMTP::DEBUG_SERVER; // Enable verbose debug output
        $this->mailer->isSMTP();
        $this->mailer->Host = $MAILER_HOST;
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = $MAILER_USERNAME;
        $this->mailer->Password = $MAILER_PASSWORD;
        $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $this->mailer->Port = $MAILER_PORT;
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
        $globals = new Globals();
        $MAILER_FROM = $globals->getEnv('MAILER_USERNAME');
        $MAILER_FROM_NAME = $globals->getEnv('MAILER_USERNAME');

        try {
            //Recipients
            $this->mailer->setFrom($MAILER_FROM);
            $this->mailer->addAddress($MAILER_FROM_NAME);     // Add a recipient

            // Content
            $this->mailer->Subject = $subject;
            $this->mailer->Body = $body;

            return $this->mailer->send();

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}