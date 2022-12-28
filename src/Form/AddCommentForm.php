<?php
declare(strict_types=1);

namespace App\Form;

use App\Core\Form;
use App\Globals\GlobalsFactory;
use App\Services\Session;

class AddCommentForm extends Form
{
    private array $errors = [];


    /**
     * @return string
     */
    public function createForm(): string
    {
        $this->startForm()
            ->addLabelFor('content', 'Comment :')
            ->addTextArea('content', $this->getData()['content'] ?? '', [
                'id' => 'content',
                'class' => (isset($this->errors['content'])) ? 'form-control is-invalid' : 'form-control',
            ])
            ->addSpan($this->errors['content'] ?? '', ['class' => 'invalid-feedback'])
            ->addButton('Submit', [
                'class' => 'btn btn-primary mt-3 w-100',
            ])
            ->addInput('hidden', 'csrf_token', [
                'value' => Session::get('user', 'csrfToken') ?? '',
            ])
            ->endForm();

        return $this->create();
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        $globals = GlobalsFactory::getInstance()->createGlobals();
        return [
            'content' => $globals->getPost('content'),
            'author' => Session::get('user', 'username'),
            'user_id' => Session::get('user', 'id'),
            'visibility' => (Session::get('user', 'roles') === 'admin') ? 1 : 0,
            'csrfToken' => $globals->getPost('csrf_token'),
        ];
    }

    public function isValid(): bool
    {
        if (empty($this->getData()['content'])) {
            $this->errors['content'] = 'Please enter a comment';
        }
        return empty($this->errors);
    }



}
