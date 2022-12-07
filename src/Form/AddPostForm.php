<?php
declare(strict_types=1);

namespace App\Form;

use App\Core\Form;

class AddPostForm extends Form
{
    private array $errors = [];

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
            ->addLabelFor('title', 'Titre de l\'article :')
            ->addInput('text', 'title', [
                'id' => 'title',
                'class' => 'form-control',
                'value' => $this->global->getPost('title')

            ])
            ->addLabelFor('author', 'Auteur :')
            ->addInput('text', 'author', [
                'id' => 'author',
                'class' => 'form-control', 'value' => $this->global->getPost('author') ?? $this->global->setSession
                    ('user', 'username')
            ])
            ->addLabelFor('chapo', 'Chap :')
            ->addTextArea('chapo', $this->global->getPost('chapo'), [
                'id' => 'chapo',
                'class' => 'form-control',
            ])
            ->addLabelFor('content', 'Content :')
            ->addTextArea('content', $this->global->getPost('content'), [
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
        if (empty($this->global->getPost('title'))) {
            $this->errors .= 'The title is required';
        }
        if (empty($this->global->getPost('author'))) {
            $this->errors .= 'Author is required';
        }
        if (empty($this->global->getPost('chapo'))) {
            $this->errors .= 'Chapo is required';
        }
        if (empty($this->global->getPost('content'))) {
            $this->errors .= 'Content is required';
        }
        return empty($this->errors);
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return [
            'title' => strip_tags($this->global->getPost('title')),
            'author' => strip_tags($this->global->getPost('author')),
            'chapo' => strip_tags($this->global->getPost('chapo')),
            'content' => strip_tags($this->global->getPost('content')),
        ];
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
