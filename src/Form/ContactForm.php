<?php
declare(strict_types=1);

namespace App\Form;

use App\Core\Form;

class ContactForm extends Form
{
    private array $errors = [
        'name' => '',
        'mail' => '',
        'phone' => '',
        'message' => '',
    ];
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
            ->addLabelFor('name', 'Name')
            ->addInput('text', 'name', [
                'id' => 'name',
                'value' => $this->getData()['name'] ?? '',
                'class' => $this->errors['name'] ? 'form-control is-invalid' : 'form-control',
            ])
            ->addSpan($this->errors['name'] ?? '', ['class' => 'invalid-feedback'])

            ->addLabelFor('mail', 'E-mail :')
            ->addInput('text', 'mail', [
                'id' => 'mail',
                'value' => $this->getData()['mail'] ?? '',
                'class' => $this->errors['mail'] ? 'form-control is-invalid' : 'form-control',
            ])
            ->addSpan($this->errors['mail'] ?? '', ['class' => 'invalid-feedback'])

            ->addLabelFor('phone', 'Phone numbers :')
            ->addInput('text', 'phone', [
                'id' => 'phone',
                'value' => $this->getData()['phone'] ?? '',
                'class' => $this->errors['phone'] ? 'form-control is-invalid' : 'form-control',
            ])
            ->addSpan($this->errors['phone'] ?? '', ['class' => 'invalid-feedback'])

            ->addLabelFor('message', 'Message :')
            ->addTextArea('message', $this->getData()['message'] ?? '',[
                'id' => 'content',
                'class' => $this->errors['message'] ? 'form-control is-invalid' : 'form-control',
            ])
            ->addSpan($this->errors['message'] ?? '', ['class' => 'invalid-feedback'])

            ->addButton('Submit', [
                'class' => 'btn btn-primary mt-3 w-100',
            ])
            ->endForm();

        return $this->create();
    }


public function isValid(): bool
{
    $data = $this->getData();

    if (empty($data['name'])) {
        $this->errors['name'] = 'The name is required';
    }

    if (empty($data['mail'])) {
        $this->errors['mail'] = 'The mail is required';
    }

    if (!$this->isEmailValid()) {
        $this->errors['mail'] = 'The mail is not valid';
    }

    if (empty($data['phone'])) {
        $this->errors['phone'] = 'The phone is required';
    }

    if (!$this->isPhoneValid()) {
        $this->errors['phone'] = 'The phone is not valid';
    }

    if (empty($data['message'])) {
        $this->errors['message'] = 'The message is required';
    }
    return empty($this->errors['name']) && empty($this->errors['mail']) && empty($this->errors['phone']) && empty($this->errors['message']);
}

    /**
     * @return bool
     */
    public function isEmailValid(): bool
    {
        if (!filter_var($this->getData()['mail'], FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        return true;
    }

    /**
     * @return bool
     */
    public function isPhoneValid(): bool
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
        return true;
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

}
