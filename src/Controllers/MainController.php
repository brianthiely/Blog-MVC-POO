<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Form;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class MainController extends Controller
{
    /**
     * @return void
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function index(): void
    {
        $form = new Form;

        $form->startForm()
            ->openDiv([
                'class' => 'w-75 m-auto'
            ])
            ->addLabelFor('name', 'Nom')
            ->addInput('text', 'name', [
                'id' => 'name',
                'class' => 'form-control',
                'value' => strip_tags($_POST['name'] ?? '')

            ])
            ->addLabelFor('mail', 'E-mail :')
            ->addInput('text', 'mail', [
                'id' => 'mail',
                'class' => 'form-control',
                'value' => strip_tags($_POST['mail'] ?? '')

            ])
            ->addLabelFor('phone', 'Téléphone :')
            ->addTextArea('phone', strip_tags($_POST['phone'] ?? ''), [
                'id' => 'chapo',
                'class' => 'form-control',
            ])
            ->addLabelFor('message', 'Message :')
            ->addTextArea('message', strip_tags($_POST['message'] ?? ''), [
                'id' => 'content',
                'class' => 'form-control',
            ])
            ->addButton('Envoyer', [
                'class' => 'btn btn-primary w-100 mt-3'
            ])
            ->closeDiv()
            ->endForm();

        if (Form::validate($_POST, ['name', 'mail', 'phone', 'message'])) {
            if (filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
            } else {
                $_SESSION['message'] = "Email is not valid";
                header('Location: /');
                exit;
            }
            if (preg_match('/^0[1-9]([-. ]?[0-9]{2}){4}$/', $_POST['phone'])) {
            } else {
                // Le téléphone n'est pas valide
                $_SESSION['message'] = "The phone number is not valid";
                header('Location: /');
                exit;
            }

            $name = strip_tags($_POST['name']);
            $email = strip_tags($_POST['mail']);
            $phone = strip_tags($_POST['phone']);
            $message = strip_tags($_POST['message']);

            $mail = new PHPMailer(true);

            try {
                //Configuration
                $mail->SMTPDebug = SMTP::DEBUG_SERVER; // Enable verbose debug output

                // We use SMTP
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = $_ENV['ADMIN_EMAIL'];
                $mail->Password = $_ENV['MAIL_PASSWORD'];
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port = '465';

                $mail->setFrom($_ENV['ADMIN_EMAIL']); // Sender
                $mail->addAddress($_ENV['ADMIN_EMAIL']); // Recipient
                $mail->Subject = 'Nouveau message de votre site';
                $mail->Body = "Nom : $name \nE-mail : $email \nTelephone : $phone \nMessage : $message";
                $mail->setLanguage('fr', 'vendor\phpmailer\phpmailer\language\phpmailer.lang-fr.php');

                $mail->send();
                $_SESSION['message'] = "Your message has been sent successfully";
                header('Location: /');
                exit;
            } catch (Exception) {
                echo "Message not sent. error: $mail->ErrorInfo";
            }
        } else {
            $_SESSION['error'] = !empty($_POST) ? "The form isn't complete" : '';
        }
        $this->twig->display('main/index.html.twig', [
            'contactForm' => $form->create()
        ]);
    }
}