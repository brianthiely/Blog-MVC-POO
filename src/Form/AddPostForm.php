<?php
declare(strict_types=1);

namespace App\Form;

use App\Core\Form;
use App\Globals\GlobalsFactory;
use App\Services\Session;

class AddPostForm extends Form
{
    private array $errors = [];
    private array $data = [];

    /**
     * @return string
     */
    public function createForm(): string
    {
        $this->startForm()
            ->addLabelFor('title', 'Article title:')
            ->addInput('text', 'title', [
                'id' => 'title',
                'value' => $this->data['title'] ?? '',
                'class' => (isset($this->errors['title'])) ? 'form-control is-invalid' : 'form-control',
            ])
            ->addSpan($this->errors['title'] ?? '', ['class' => 'invalid-feedback'])

            ->addLabelFor('author', 'Author :')
            ->addInput('text', 'author', [
                'id' => 'author',
                'value' => $this->data['author'] ?? '',
                'class' => (isset($this->errors['author'])) ? 'form-control is-invalid' : 'form-control',
            ])
            ->addSpan($this->errors['author'] ?? '', ['class' => 'invalid-feedback'])

            ->addLabelFor('chapo', 'Chapo :')
            ->addTextArea('chapo', $this->data['chapo'] ?? '', [
                'id' => 'chapo',
                'class' => (isset($this->errors['chapo'])) ? 'form-control is-invalid' : 'form-control',
            ])
            ->addSpan($this->errors['chapo'] ?? '', ['class' => 'invalid-feedback'])

            ->addLabelFor('content', 'Content :')
            ->addTextArea('content', $this->data['content'] ?? '', [
                'id' => 'content',
                'class' => (isset($this->errors['content'])) ? 'form-control is-invalid' : 'form-control',
            ])
            ->addSpan($this->errors['content'] ?? '', ['class' => 'invalid-feedback'])

            ->addButton('Submit', [
                'class' => 'btn btn-primary mt-3 w-100',
            ])
            ->addInput('hidden', 'csrfToken', [
                'value' => Session::get('user', 'csrfToken') ?? '',
            ])
            ->endForm();
        return $this->create();
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        if (empty($this->getData()['title'])) {
            $this->errors['title'] = 'Title is required';
        }
        if (empty($this->getData()['author'])) {
            $this->errors['author'] = 'Author is required';
        }
        if (empty($this->getData()['chapo'])) {
            $this->errors['chapo'] = 'Chapo is required';
        }
        if (empty($this->getData()['content'])) {
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
        $this->data = [
            'title' => $global->getPost('title'),
            'author' => $global->getPost('author'),
            'chapo' => $global->getPost('chapo'),
            'content' => $contentClean,
            'user_id' => Session::get('user', 'id'),
            'csrfToken' => $global->getPost('csrfToken'),
        ];
        return $this->data;
    }

    /**
     * @param array $post
     * @return void
     */
    public function setData(array $post): void
    {
        $this->data = $post;
    }
}
