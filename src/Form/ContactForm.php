<?php
declare(strict_types=1);

namespace App\Form;

use App\Core\Form;
use App\Mailer\Mailer;
use PHPMailer\PHPMailer\Exception;
use App\Globals\_POST;

class ContactForm extends Form
{
    private string $errors;
    private _POST  $post;

    public function __construct(_POST $post)
    {
        $this->post = $post;
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
            ->addTextArea('phone', $this->post->_POST('phone') , [
                'id' => 'chapo',
                'class' => 'form-control',
            ])
            ->addLabelFor('message', 'Message :')
            ->addTextArea('message', $this->post->_POST('message') , [
                'id' => 'content',
                'class' => 'form-control',
            ])
            ->addButton('Envoyer', [
                'class' => 'btn btn-primary w-100 mt-3'
            ])
            ->endForm();
        return $this->create();
    }

    /**
     * @return bool
     */
    public function isComplete(): bool
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
    public function isValidEmail(): bool
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
        if (!preg_match('/^[0-9]{10}$/', $this->post->_POST('phone'))) {
            $this->errors = 'The phone number is not valid';
        }
        return empty($this->errors);
    }

    /**
     * @throws Exception
     */
    public function sendForm(): void
    {
        $mailer = new Mailer();
        $mailer->send(
            'Nouveau message de ' . $this->post->_POST('name'),
            'Nom : ' . $this->post->_POST('name') . '<br>' . 'Email : ' . $this->post->_POST('mail') . '<br>' . 'Telephone : ' .
            $this->post->_POST('phone') . '<br>' .
            'Message : ' . $this->post->_POST('mail'),
        );
    }

    /**
     * @return string
     */
    public function getErrors(): string
    {
        return $this->errors ?? '';
    }

}