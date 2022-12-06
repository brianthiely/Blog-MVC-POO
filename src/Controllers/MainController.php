<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Mailer\Mailer;
use Exception;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
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
        if (!$contactForm->isSubmitted()) {
            if ($contactForm->isValid()) {
                $data = $contactForm->getData();
                $mailer = new Mailer($this->global->getEnv('MAILER_HOST'), $this->global->getEnv('MAILER_USERNAME'),
                    $this->global->getEnv('MAILER_PASSWORD'), $this->global->getEnv('MAILER_PORT'));
                $mailer->send($data);
                $this->global->setSession('message', 'Your message has been sent');
                $this->redirect('/');
            }
            $this->global->setSession('errors', $contactForm->getErrors());
        }


        try {
            $this->twig->display('main/index.html.twig', [
                'contactForm' => $contactForm->getForm()
            ]);
        } catch (LoaderError|RuntimeError|SyntaxError $e) {
            throw new Exception($e->getMessage());
        }
    }
}
