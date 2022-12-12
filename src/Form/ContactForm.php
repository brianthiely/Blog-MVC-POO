<?php
declare(strict_types=1);

namespace App\Form;

use App\Core\Form;
use App\Globals\GlobalsFactory;

class ContactForm extends Form
{
    private array $errors = [];

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
                'class' => (isset($this->errors['name']) ? 'form-control is-invalid' : 'form-control'),
            ])
            ->addSpan($this->errors['name'] ?? '', ['class' => 'invalid-feedback'])

            ->addLabelFor('mail', 'E-mail :')
            ->addInput('text', 'mail', [
                'id' => 'mail',
                'value' => $this->getData()['mail'] ?? '',
                'class' => (isset($this->errors['mail'])) ? 'form-control is-invalid' : 'form-control',
            ])
            ->addSpan($this->errors['mail'] ?? '', ['class' => 'invalid-feedback'])

            ->addLabelFor('phone', 'Phone numbers :')
            ->addInput('text', 'phone', [
                'id' => 'phone',
                'value' => $this->getData()['phone'] ?? '',
                'class' => (isset($this->errors['phone'])) ? 'form-control is-invalid' : 'form-control',
            ])
            ->addSpan($this->errors['phone'] ?? '', ['class' => 'invalid-feedback'])

            ->addLabelFor('message', 'Message :')
            ->addTextArea('message', $this->getData()['message'] ?? '',[
                'id' => 'content',
                'class' => (isset($this->errors['message'])) ? 'form-control is-invalid' : 'form-control',
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
    return empty($this->errors);
}

    /**
     * @return bool
     */
    public function isEmailValid(): bool
    {
        if(empty($this->getData()['mail'])) {
            return true;
        }
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
        if(empty($this->getData()['phone'])) {
            return true;
        }
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
        $global = GlobalsFactory::getInstance()->createGlobals();
        return [
            'name' => strip_tags($global->getPost('name')),
            'mail' => strip_tags($global->getPost('mail')),
            'phone' => strip_tags($global->getPost('phone')),
            'message' => strip_tags($global->getPost('message')),
        ];
    }
}
