<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Globals\_SESSION;
use PHPMailer\PHPMailer\Exception;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use App\Form\ContactForm;

class MainController extends Controller
{
    /**
     * @return void
     * @throws Exception
     */
    public function index(): void
    {
        $contactForm = new ContactForm();

        // is the form submitted ?
        if ($contactForm->isSubmitted()) {
            // is the form valid ?
            if ($contactForm->isComplete()) {
                // check if email is valid
                if ($contactForm->isValidEmail()){
                    // Check if phone number is valid
                    if ($contactForm->isPhoneValid()) {
                        $contactForm->sendForm();
                        $this->redirect('/');
                    }
                        _SESSION::setSession('errors', $contactForm->getErrors());

                }
                    _SESSION::setSession('errors', $contactForm->getErrors());

            }
                _SESSION::setSession('errors', $contactForm->getErrors());
        }
        try {
            $this->twig->display('main/index.html.twig', [
                'contactForm' => $contactForm->getForm()
            ]);
        } catch (LoaderError|RuntimeError|SyntaxError $e) {
        }
    }

}