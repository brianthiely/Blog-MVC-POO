<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Mailer\MailerFactory;
use Exception;
use App\Form\ContactForm;


class MainController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return void
     * @throws Exception
     */
    public function index(): void
    {
        $contactForm = new ContactForm();

        if ($contactForm->isSubmitted()) {
            if ($contactForm->isValid()) {
                $data = $contactForm->getData();
                $this->sendMail($data);
                $this->global->setSession('message', 'Your message has been sent');
                $this->redirect('/');
            }
        }

        $this->twig->display('main/index.html.twig', [
            'contactForm' => $contactForm->getForm(),
        ]);
    }


    /**
     * @throws \PHPMailer\PHPMailer\Exception
     */
    private function sendMail($data): void
    {
        $mailer = MailerFactory::getInstance()->createMailer();
        $mailer->send($data);
    }
}
