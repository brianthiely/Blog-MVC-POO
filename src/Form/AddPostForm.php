<?php
declare(strict_types=1);

namespace App\Form;

use App\Core\Form;
use App\Globals\GlobalsFactory;

class AddPostForm extends Form
{
    private array $errors = [];

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
                'class' => (isset($this->errors['title'])) ? 'form-control is-invalid' : 'form-control',
            ])
            ->addSpan($this->errors['title'] ?? '', ['class' => 'invalid-feedback'])

            ->addLabelFor('author', 'Author :')
            ->addInput('text', 'author', [
                'id' => 'author',
                'value' => $this->getData()['author'] ?? '',
                'class' => (isset($this->errors['author'])) ? 'form-control is-invalid' : 'form-control',
            ])
            ->addSpan($this->errors['author'] ?? '', ['class' => 'invalid-feedback'])

            ->addLabelFor('chapo', 'Chap :')
            ->addTextArea('chapo', $this->getData()['chapo'], [
                'id' => 'chapo',
                'class' => (isset($this->errors['chapo'])) ? 'form-control is-invalid' : 'form-control',
            ])
            ->addSpan($this->errors['chapo'] ?? '', ['class' => 'invalid-feedback'])

            ->addLabelFor('content', 'Content :')
            ->addTextArea('content', $this->getData()['content'], [
                'id' => 'content',
                'class' => (isset($this->errors['content'])) ? 'form-control is-invalid' : 'form-control',
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
        return empty($this->errors);
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        $global = GlobalsFactory::getInstance()->createGlobals();
        $contentClean = htmlentities($global->getPost('content'));
        return [
            'title' => strip_tags($global->getPost('title')),
            'author' => strip_tags($global->getPost('author')),
            'chapo' => strip_tags($global->getPost('chapo')),
            'content' => html_entity_decode($contentClean),
        ];
    }

}
