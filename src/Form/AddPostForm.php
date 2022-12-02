<?php
declare(strict_types=1);

namespace App\Form;

use App\Core\Form;
use App\Globals\_POST;
use App\Globals\_SESSION;

class AddPostForm extends Form
{
    private string $errors;

    /**
     * @return string
     */
    public function getForm(): string
    {
        $this->startForm()
            ->addLabelFor('title', 'Titre de l\'article :')
            ->addInput('text', 'title', [
                'id' => 'title',
                'class' => 'form-control',
                'value' => _POST::_POST('title') ?? ''

            ])
            ->addLabelFor('author', 'Auteur :')
            ->addInput('text', 'author', [
                'id' => 'author',
                'class' => 'form-control',
                'value' => _POST::_POST('author') ?? _SESSION::getSession('username'),
            ])
            ->addLabelFor('chapo', 'Chap :')
            ->addTextArea('chapo', _POST::_POST('chapo'), [
                'id' => 'chapo',
                'class' => 'form-control',
            ])
            ->addLabelFor('content', 'Content :')
            ->addTextArea('content', _POST::_POST('content'), [
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
    public function isComplete(): bool
    {
        if (!Form::validate($_POST, ['title', 'author', 'chapo', 'content'])) {
            $this->errors = 'The form is not complete';
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
            'title' => _POST::_POST('title'),
            'author' => _POST::_POST('author'),
            'chapo' => _POST::_POST('chapo'),
            'content' => _POST::_POST('content'),
        ];
    }

    /**
     * @return string
     */
    public function getErrors(): string
    {
        return $this->errors ?? '';
    }
}