<?php
declare(strict_types=1);

namespace App\Form;

use App\Core\Form;

class AddPostForm extends Form
{
    private string $errors;

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
                'value' => $this->post->_POST('title')

            ])
            ->addLabelFor('author', 'Auteur :')
            ->addInput('text', 'author', [
                'id' => 'author',
                'class' => 'form-control', 'value' => $this->post->_POST('author') ?? $this->session->setSession('user', 'username')
            ])
            ->addLabelFor('chapo', 'Chap :')
            ->addTextArea('chapo', $this->post->_POST('chapo'), [
                'id' => 'chapo',
                'class' => 'form-control',
            ])
            ->addLabelFor('content', 'Content :')
            ->addTextArea('content', $this->post->_POST('content'), [
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
        if (empty($this->post->_POST('title'))) {
            $this->errors .= 'Title is required';
        }
        if (empty($this->post->_POST('author'))) {
            $this->errors .= 'Author is required';
        }
        if (empty($this->post->_POST('chapo'))) {
            $this->errors .= 'Chapo is required';
        }
        if (empty($this->post->_POST('content'))) {
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
            'title' => $this->post->_POST('title'),
            'author' => $this->post->_POST('author'),
            'chapo' => $this->post->_POST('chapo'),
            'content' => $this->post->_POST('content'),
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