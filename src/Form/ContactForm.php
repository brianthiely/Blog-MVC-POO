<?php
declare(strict_types=1);

namespace App\Form;

use App\Core\Form;
use App\Mailer\Mailer;
use PHPMailer\PHPMailer\Exception;

class ContactForm extends Form
{
    private string $errors;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return string
     */
    public function getForm(): string
    {
        $this->startForm()
            ->addLabelFor('name', 'Nom')
            ->addInput('text', 'name', [
                'id' => 'name',
                'class' => 'form-control',
                'value' => $this->post->_POST('name')
            ])
            ->addLabelFor('mail', 'E-mail :')
            ->addInput('text', 'mail', [
                'id' => 'mail',
                'class' => 'form-control',
                'value' => $this->post->_POST('mail')
                ])
            ->addLabelFor('phone', 'Telephone :')
            ->addInput('text', 'phone', [
                'id' => 'phone',
                'class' => 'form-control',
                'value' => $this->post->_POST('phone')
            ])
            ->addLabelFor('message', 'Message :')
            ->addTextArea('message', $this->post->_POST('message') , [
                'id' => 'content',
                'class' => 'form-control',
            ])
            ->addButton('Submit', [
                'class' => 'btn btn-primary mt-3 w-100'
            ])
            ->endForm();

        return $this->create();
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        if (!Form::validate($_POST, ['name', 'mail', 'phone', 'message'])) {
            $this->errors = 'The form is not complete';
            return false;
        }
        return true;
    }

    /**
     * @return bool
     */
    public function isEmailValid(): bool
    {
        if (!filter_var($this->post->_POST('mail'), FILTER_VALIDATE_EMAIL)) {
            $this->errors = 'The email is not valid';
        }
        return empty($this->errors);
    }


    /**
     * @return bool|int
     */
    public function isPhoneValid(): bool|int
    {
        // allow +, - and . and () in phone number
        $filtered_phone_number = filter_var($this->post->_POST('phone'), FILTER_SANITIZE_NUMBER_INT);
        // Remove "-" from number
        $phone_to_check = str_replace("-", "", $filtered_phone_number);
        // Check the length of number
        // This can be customized if you want phone number from a specific country
        if (strlen($phone_to_check) < 10 || strlen($phone_to_check) > 14) {
            $this->errors = 'The phone number is not valid';
        }
        return empty($this->errors);
    }


    /**
     * @return void
     * @throws Exception
     */
    public function sendForm(): void
    {
        try {
            $mailer = new Mailer();
            $mailer->send(
                'Nouveau message de ' . $this->post->_POST('name'),
                'Nom : ' . $this->post->_POST('name') . '<br>' . 'Email : ' . $this->post->_POST('mail') . '<br>' . 'Telephone : ' .
                $this->post->_POST('phone') . '<br>' .
                'Message : ' . $this->post->_POST('mail'));
            } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @return string
     */
    public function getErrors(): string
    {
        return $this->errors ?? '';
    }
}