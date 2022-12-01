<?php
declare(strict_types=1);

namespace App\Form;

use App\Core\Form;
use App\Mailer\Mailer;
use PHPMailer\PHPMailer\Exception;

class ContactForm extends Form
{
    /**
     * @return string
     */
    public function getForm(): string
    {
        $this->startForm()
            ->openDiv([
                'class' => 'w-75 m-auto'
            ])
            ->addLabelFor('name', 'Nom')
            ->addInput('text', 'name', [
                'id' => 'name',
                'class' => 'form-control',
                'value' => strip_tags($_POST['name'] ?? '')
            ])
            ->addLabelFor('mail', 'E-mail :')
            ->addInput('text', 'mail', [
                'id' => 'mail',
                'class' => 'form-control',
                'value' => strip_tags($_POST['mail'] ?? '')
            ])
            ->addLabelFor('phone', 'Téléphone :')
            ->addTextArea('phone', strip_tags($_POST['phone'] ?? ''), [
                'id' => 'chapo',
                'class' => 'form-control',
            ])
            ->addLabelFor('message', 'Message :')
            ->addTextArea('message', strip_tags($_POST['message'] ?? ''), [
                'id' => 'content',
                'class' => 'form-control',
            ])
            ->addButton('Envoyer', [
                'class' => 'btn btn-primary w-100 mt-3'
            ])
            ->closeDiv()
            ->endForm();

        return $this->create();
    }

    /**
     * @return bool
     */
    public function isComplete(): bool
    {
        return $this->validate($_POST, ['name', 'mail', 'phone', 'message']);
    }

    /**
     * @return string
     */
    public function isValidEmail(): string
    {
        return filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL);
    }

    /**
     * @return bool|int
     */
    public function isPhoneValid(): bool|int
    {
        return preg_match('/^0[1-9]([-. ]?[0-9]{2}){4}$/', $_POST['phone']);
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return [
            'name' => $_POST['name'],
            'mail' => $_POST['mail'],
            'phone' => $_POST['phone'],
            'message' => $_POST['message']
        ];
    }

    /**
     * @throws Exception
     */
    public function sendForm(): void
    {
        $mailer = new Mailer();
        $data = $this->getData();
        $mailer->send(
            'Nouveau message de ' . $data['name'],
            'Nom : ' . $data['name'] . '<br>' . 'Email : ' . $data['mail'] . '<br>' . 'Telephone : ' . $data['phone'] . '<br>' . 'Message : ' . $data['message'],
        );
    }
}