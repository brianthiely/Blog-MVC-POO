<?php
declare(strict_types=1);

namespace App\Mailer;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require_once ROOT . '/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require_once ROOT . '/vendor/phpmailer/phpmailer/src/SMTP.php';
require_once ROOT . '/vendor/phpmailer/phpmailer/src/Exception.php';

class Mailer
{
    /**
     * @param string $subject
     * @param string $body
     * @return bool
     * @throws Exception
     */
    public function send(string $subject, string $body): bool
    {
        try {
            $mailer = new \PHPMailer\PHPMailer\PHPMailer();

            //Configuration
            $mailer->SMTPDebug = SMTP::DEBUG_SERVER; // Enable verbose debug output
            $mailer->isSMTP();
            $mailer->Host = $_ENV['MAILER_HOST'];
            $mailer->SMTPAuth = true;
            $mailer->Username = $_ENV['ADMIN_EMAIL'];
            $mailer->Password = $_ENV['MAIL_PASSWORD'];
            $mailer->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mailer->Port = $_ENV['MAILER_PORT'];
            $mailer->setLanguage('fr', 'vendor\phpmailer\phpmailer\language\phpmailer.lang-fr.php');
            $mailer->CharSet = 'UTF-8';
            $mailer->isHTML(true);

            //Recipients
            $mailer->setFrom($_ENV['ADMIN_EMAIL']);
            $mailer->addAddress($_ENV['ADMIN_EMAIL']);

            // Content
            $mailer->Subject = $subject;
            $mailer->Body = $body;

            return $mailer->send();

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}