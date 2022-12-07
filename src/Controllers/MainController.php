<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Mailer\Mailer;
use Exception;
use App\Form\ContactForm;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

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


        try {
            $this->twig->display('main/index.html.twig', [
                'contactForm' => $contactForm->getForm(),
            ]);
        } catch (LoaderError|RuntimeError|SyntaxError $e) {
            throw new Exception($e->getMessage());
        }
    }


    /**
     * @throws \PHPMailer\PHPMailer\Exception
     */
    private function sendMail($data): void
    {
        $mailer = new Mailer($this->global->getEnv('MAILER_HOST'), $this->global->getEnv('MAILER_USERNAME'),
            $this->global->getEnv('MAILER_PASSWORD'), $this->global->getEnv('MAILER_PORT'));
        $mailer->send($data);
    }
}
