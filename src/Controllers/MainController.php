<?php
declare(strict_types=1);

namespace App\Controllers;

use PHPMailer\PHPMailer\Exception;
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

        // is the form submitted ?
        if (!$contactForm->isSubmitted()) {
            // is the form valid ?
            if ($contactForm->isValid()) {
                // check if email is valid
                if ($contactForm->isEmailValid()){
                    // Check if phone number is valid
                    if ($contactForm->isPhoneValid()) {
                        $contactForm->sendForm();
                        $this->session->setSession('message', 'Your message has been sent');
                        $this->redirect('/');
                    }
                    $this->session->setSession('errors', $contactForm->getErrors());
                }
                $this->session->setSession('errors', $contactForm->getErrors());
            }
            $this->session->setSession('errors', $contactForm->getErrors());
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