<?php
declare(strict_types=1);

namespace App\Form;

use App\Core\Form;
use App\Mailer\Mailer;
use PHPMailer\PHPMailer\Exception;

class ContactForm extends Form
{
    private ?string $errors = null;

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
                'value' => $this->global->getPost('name')
            ])
            ->addLabelFor('mail', 'E-mail :')
            ->addInput('text', 'mail', [
                'id' => 'mail',
                'class' => 'form-control',
                'value' => $this->global->getPost('mail')
                ])
            ->addLabelFor('phone', 'Telephone :')
            ->addInput('text', 'phone', [
                'id' => 'phone',
                'class' => 'form-control',
                'value' => $this->global->getPost('phone')
            ])
            ->addLabelFor('message', 'Message :')
            ->addTextArea('message', $this->global->getPost('message') , [
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
        if (empty($this->global->getPost('name'))) {
            $this->errors .= 'Name is required';
        }
        if (empty($this->global->getPost('mail'))) {
            $this->errors .= 'Mail is required';
        }
        if (empty($this->global->getPost('phone'))) {
            $this->errors .= 'Phone is required';
        }
        if (empty($this->global->getPost('message'))) {
            $this->errors .= 'Message is required';
        }
        return empty($this->errors);
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function isEmailValid(): bool
    {
        if (!filter_var($this->global->getPost('mail'), FILTER_VALIDATE_EMAIL)) {
            throw new Exception('The email is not valid');
        }
        return empty($this->errors);
    }

    /**
     * @return bool|int
     * @throws Exception
     */
    public function isPhoneValid(): bool|int
    {
        // allow +, - and . and () in phone number
        $filtered_phone = filter_var($this->global->getPost('phone'), FILTER_SANITIZE_NUMBER_INT);
        // Remove "-" from number
        $phone_to_check = str_replace("-", "", $filtered_phone);
        // Check the length of number
        // This can be customized if you want phone number from a specific country
        if (strlen($phone_to_check) < 10 || strlen($phone_to_check) > 14) {
            throw new Exception('The phone is not valid');
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
                'Nouveau message de ' . $this->global->getPost('name'),
                'Nom : ' . $this->global->getPost('name') . '<br>' . 'Email : ' . $this->global->getPost('mail') . '<br>' .
                'Telephone : ' .
                $this->global->getPost('phone') . '<br>' .
                'Message : ' . $this->global->getPost('message'));
            } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @return string
     */
    public function getErrors(): string
    {
        return $this->errors;
    }
}
