<?php
declare(strict_types=1);

namespace App\Form;

use App\Core\Form;

class ContactForm extends Form
{
    private ?string $errors = '';

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
            ])
            ->addLabelFor('mail', 'E-mail :')
            ->addInput('text', 'mail', [
                'id' => 'mail',
                'class' => 'form-control',
                ])
            ->addLabelFor('phone', 'Telephone :')
            ->addInput('text', 'phone', [
                'id' => 'phone',
                'class' => 'form-control',
            ])
            ->addLabelFor('message', 'Message :')
            ->addTextArea('message', '',[
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
        if (empty($this->getData()['name'])) {
            $this->errors .= 'Name is required';
        }
        if (empty($this->getData()['mail'])) {
            $this->errors .= 'Mail is required';
        }
        if (!$this->isEmailValid()) {
            $this->errors .= 'Mail is not valid';
        }
        if (empty($this->getData()['phone'])) {
            $this->errors .= 'Phone is required';
        }
        if (!$this->isPhoneValid()) {
            $this->errors .= 'Phone is not valid';
        }
        if (empty($this->getData()['message'])) {
            $this->errors .= 'Message is required';
        }
        return empty($this->errors);
    }

    /**
     * @return bool
     */
    public function isEmailValid(): bool
    {
        if (!filter_var($this->getData()['mail'], FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        return empty($this->errors);
    }

    /**
     * @return bool|int
     */
    public function isPhoneValid(): bool|int
    {
        // allow +, - and . and () in phone number
        $filtered_phone = filter_var($this->getData()['phone'], FILTER_SANITIZE_NUMBER_INT);
        // Remove "-" from number
        $phone_to_check = str_replace("-", "", $filtered_phone);
        // Check the length of number
        // This can be customized if you want phone number from a specific country
        if (strlen($phone_to_check) < 10 || strlen($phone_to_check) > 14) {
            return false;
        }
        return empty($this->errors);
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return [
            'name' => strip_tags($this->global->getPost('name')),
            'mail' => strip_tags($this->global->getPost('mail')),
            'phone' => strip_tags($this->global->getPost('phone')),
            'message' => strip_tags($this->global->getPost('message')),
        ];
    }

    /**
     * @return string
     */
    public function getErrors(): string
    {
        return $this->errors;
    }
}
