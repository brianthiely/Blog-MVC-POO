<?php
declare(strict_types=1);

namespace App\Form;

use App\Core\Form;

class AddPostForm extends Form
{
    private array $errors = [
        'title' => '',
        'author' => '',
        'chapo' => '',
        'content' => '',
    ];

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
            ->addLabelFor('title', 'Article title:')
            ->addInput('text', 'title', [
                'id' => 'title',
                'value' => $this->getData()['title'] ?? '',
                'class' => $this->errors['title'] ? 'form-control is-invalid' : 'form-control',
            ])
            ->addSpan($this->errors['title'] ?? '', ['class' => 'invalid-feedback'])

            ->addLabelFor('author', 'Author :')
            ->addInput('text', 'author', [
                'id' => 'author',
                'value' => $this->getData()['author'] ?? '',
                'class' => $this->errors['author'] ? 'form-control is-invalid' : 'form-control',
            ])
            ->addSpan($this->errors['author'] ?? '', ['class' => 'invalid-feedback'])

            ->addLabelFor('chapo', 'Chap :')
            ->addTextArea('chapo', $this->getData()['chapo'], [
                'id' => 'chapo',
                'class' => $this->errors['chapo'] ? 'form-control is-invalid' : 'form-control',
            ])
            ->addSpan($this->errors['chapo'] ?? '', ['class' => 'invalid-feedback'])

            ->addLabelFor('content', 'Content :')
            ->addTextArea('content', $this->getData()['content'], [
                'id' => 'content',
                'class' => $this->errors['content'] ? 'form-control is-invalid' : 'form-control',
            ])
            ->addSpan($this->errors['content'] ?? '', ['class' => 'invalid-feedback'])

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
        $data = $this->getData();

        if (empty($data['title'])) {
            $this->errors['title'] = 'Title is required';
        }
        if (empty($data['author'])) {
            $this->errors['author'] = 'Author is required';
        }
        if (empty($data['chapo'])) {
            $this->errors['chapo'] = 'Chapo is required';
        }
        if (empty($data['content'])) {
            $this->errors['content'] = 'Content is required';
        }
        return empty($this->errors['title']) && empty($this->errors['author']) && empty($this->errors['chapo']) && empty($this->errors['content']);
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        $contentClean = htmlentities($this->global->getPost('content'));
        return [
            'title' => strip_tags($this->global->getPost('title')),
            'author' => strip_tags($this->global->getPost('author')),
            'chapo' => strip_tags($this->global->getPost('chapo')),
            'content' => html_entity_decode($contentClean),
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
