<?php
declare(strict_types=1);

namespace App\Form;

use App\Core\Form;
use App\Globals\GlobalsFactory;

class SignUpForm extends Form
{
    private array $errors = [];

    /**
     * Create a new form instance.
     *
     * @return string The form HTML.
     */
    public function createForm(): string
    {
        $global = GlobalsFactory::getInstance()->createGlobals();

        $this->startForm()
            ->addLabelFor('firstname', 'Firstname :')
            ->addInput('firstname', 'firstname', [
                'id' => 'firstname',
                'value' => $this->getData()['firstname'] ?? '',
                'class' => (isset($this->errors['firstname']) ? 'form-control is-invalid' : 'form-control'),
            ])
            ->addSpan($this->errors['firstname'] ?? '', ['class' => 'invalid-feedback'])

            ->addLabelFor('lastname', 'Lastname :')
            ->addInput('lastname', 'lastname', [
                'id' => 'lastname',
                'value' => $this->getData()['lastname'] ?? '',
                'class' => (isset($this->errors['lastname'])) ? 'form-control is-invalid' : 'form-control',
            ])
            ->addSpan($this->errors['lastname'] ?? '', ['class' => 'invalid-feedback'])

            ->addLabelFor('username', 'Username')
            ->addInput('username', 'username', [
                'id' => 'username',
                'value' => $this->getData()['username'] ?? '',
                'class' => (isset($this->errors['username'])) ? 'form-control is-invalid' : 'form-control',
            ])
            ->addSpan($this->errors['username'] ?? '', ['class' => 'invalid-feedback'])

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

            ->addLabelFor('password_confirmation', 'Password confirmation :')
            ->addInput('password', 'password_confirmation', [
                'id' => 'password_confirmation',
                'value' => $global->getPost('password_confirmation') ?? '',
                'class' => (isset($this->errors['password_confirmation'])) ? 'form-control is-invalid' : 'form-control',
            ])
            ->addSpan($this->errors['password_confirmation'] ?? '', ['class' => 'invalid-feedback'])

            ->addButton('Submit', [
                'class' => 'btn btn-primary mt-3 w-100',
            ])
            ->endForm();

        return $this->create();
    }

    /**
     * Validate the form.
     *
     * @return bool True if the form is valid, false otherwise.
     */
    public function isValid(): bool
    {
        if (empty($this->getData()['firstname'])) {
            $this->errors['firstname'] = 'The firstname is required';
        }
        if (empty($this->getData()['lastname'])) {
            $this->errors['lastname'] = 'The lastname is required';
        }
        if (empty($this->getData()['username'])) {
            $this->errors['username'] = 'The username is required';
        }
        if (empty($this->getData()['email'])) {
            $this->errors['email'] = 'Email is required';
        }
        if (!$this->isEmailValid()) {
            $this->errors['email'] = 'The Email is not valid';
        }
        if (empty($this->getData()['password'])) {
            $this->errors['password'] = 'Password is required';
        }
        if (!$this->isPasswordValid()) {
            $this->errors['password'] = "The password must contain at least 8 characters, a lowercase letter, an uppercase letter, a number and a special character.";
        }
        if (!$this->isPasswordConfirmValid()) {
            $this->errors['password_confirmation'] = "The password doesn't match";
        }
        return empty($this->errors);
    }

    /**
     * Check if password confirmation is valid.
     *
     * @return bool True if the password confirmation is valid, false otherwise.
     */
    private function isPasswordConfirmValid(): bool
    {
        $global = GlobalsFactory::getInstance()->createGlobals();
        return $this->getData()['password'] === $global->getPost('password_confirmation');
    }

    /**
     * Check if the password is valid.
     *
     * @return bool True if the password is valid, false otherwise.
     */
    private function isPasswordValid(): bool
    {
        if(empty($this->getData()['password'])) {
            return true;
        }
        $regex = '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,}$/';
        if (!preg_match($regex, $this->getData()['password'])) {
            return false;
        }
        return true;
    }

    /**
     * Get the data from the form.
     *
     * @return array The data from the form.
     */
    public function getData(): array
    {
        $global = GlobalsFactory::getInstance()->createGlobals();
        return [
            'firstname' => strip_tags($global->getPost('firstname')),
            'lastname' => strip_tags($global->getPost('lastname')),
            'username' => strip_tags($global->getPost('username')),
            'email' => strip_tags($global->getPost('email')),
            'password' => strip_tags($global->getPost('password')),
        ];
    }

    /**
     * Check if the email is valid.
     *
     * @return bool True if the email is valid, false otherwise.
     */
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
