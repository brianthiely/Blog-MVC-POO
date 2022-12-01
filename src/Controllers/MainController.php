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
                        // Redirect to the home page
                         header('Location: /');
                    } else {
                        // display the errors
                        $_SESSION['error'] = "The number isn't valid";
                    }
                } else {
                    $_SESSION['error'] = "The email isn't valid";
                }
            } else {
                $_SESSION['error'] = "The form isn't complete";
            }
        }
        try {
            $this->twig->display('main/index.html.twig', [
                'contactForm' => $contactForm->getForm()
            ]);
        } catch (LoaderError|RuntimeError|SyntaxError $e) {
        }
    }
}