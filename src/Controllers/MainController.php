<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Form\ContactForm;
use App\Mailer\MailerFactory;
use App\Services\Flash;
use Exception;


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
                Flash::set('success', 'Your message has been sent');
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
