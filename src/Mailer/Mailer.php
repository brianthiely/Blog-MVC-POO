<?php
declare(strict_types=1);
namespace App\Mailer;

use App\Globals\Globals;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

class Mailer
{
    private PHPMailer $mailer;

    public function __construct(string $MAILER_HOST, string $MAILER_USERNAME, string $MAILER_PASSWORD, string $MAILER_PORT)
    {
        $this->mailer = new PHPMailer();
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
     * Send an email
     *
     * @param array $data The data to send
     * @return void
     * @throws Exception
     */
    public function send(array $data): void
    {
        $from = (new Globals())->getEnv('MAILER_USERNAME');
        $this->mailer->setFrom($from, 'Mailer');
        $this->mailer->Subject = 'Contact ' . $data['name'];
        foreach ($data as $key => $value) {
            $this->mailer->Body .= '<p><strong>' . $key . ':</strong> ' . $value . '</p> </br>';
        }
        $this->mailer->addAddress($from);
        $this->mailer->send();
    }
}
