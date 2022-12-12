<?php
declare(strict_types=1);

namespace App\Form;

use App\Core\Form;
use App\Globals\GlobalsFactory;

class AddCommentForm extends Form
{
    private array $errors = [];

    /**
     * @return string
     */
    public function getForm(): string
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
            ->endForm();

        return $this->create();
    }

    public function isValid(): bool
    {
        if (empty($this->getData()['content'])) {
            $this->errors['content'] = 'You cannot send an empty comment';
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
            'content' => strip_tags($global->getPost('content') ?? ''),
            'user_id' => $global->getSession('user')['id'] ?? '',
            'author' => 'Anonymous',
        ];
    }
}
