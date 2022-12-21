<?php
declare(strict_types=1);

namespace App\Form;

use App\Core\Form;
use App\Globals\GlobalsFactory;
use App\Services\Session;

class SignInForm extends Form
{
    private array $errors = [];

/**
     * @return string
     */
    public function createForm(): string
    {
        $this->startForm()
            ->addLabelFor('email', 'E-mail :')
            ->addInput('text', 'email', [
                'id' => 'email',
                'value' => $this->getData()['email'] ?? '',
                'class' => (isset($this->errors['email'])) ? 'form-control is-invalid' : 'form-control',
            ])
            ->addSpan($this->errors['email'] ?? '', ['class' => 'invalid-feedback'])

            ->addLabelFor('password', 'Password :')
            ->addInput('password', 'password', [
                'id' => 'password',
                'value' => $this->getData()['password'] ?? '',
                'class' => (isset($this->errors['password'])) ? 'form-control is-invalid' : 'form-control',
            ])
            ->addSpan($this->errors['password'] ?? '', ['class' => 'invalid-feedback'])

            ->addButton('Submit', [
                'class' => 'btn btn-primary mt-3 w-100',
            ])
            ->endForm();

        return $this->create();
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        $data = $this->getData();
        if (empty($data['email'])) {
            $this->errors['email'] = 'The mail is required';
        }
        if (!$this->isEmailValid()) {
            $this->errors['email'] = 'The email is not valid';
        }
        if (empty($data['password'])) {
            $this->errors['password'] = 'Password is required';
        }
        return empty($this->errors);
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        $global = GlobalsFactory::getInstance()->createGlobals();
        return [
            'email' => strip_tags($global->getPost('email')),
            'password' => strip_tags($global->getPost('password')),
        ];
    }

    private function isEmailValid(): bool
    {
        if(empty($this->getData()['email'])) {
            return true;
        }
        if (!filter_var($this->getData()['email'], FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        return true;
    }
}
