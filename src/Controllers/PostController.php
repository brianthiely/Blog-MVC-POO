<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Form;
use App\Models\Post;
use App\Models\PostRepository;
use Exception;

class PostController extends Controller
{
    /**
     * @throws Exception
     */
    public function add(): void
    {
        $form = new Form;

        $form->startForm()
            ->addLabelFor('title', 'Titre de l\'article :')
            ->addInput('text', 'title', [
                'id' => 'title',
                'class' => 'form-control',
                'value' => strip_tags($_POST['title'] ?? ''),

            ])
            ->addLabelFor('author', 'Auteur :')
            ->addInput('text', 'author', [
                'id' => 'author',
                'class' => 'form-control',
                'value' => strip_tags($_POST['author'] ?? $_SESSION['user']['username'] ?? ''),

            ])
            ->addLabelFor('chapo', 'Chapô :')
            ->addTextArea('chapo', strip_tags($_POST['chapo'] ?? ''), [
                'id' => 'chapo',
                'class' => 'form-control',
            ])
            ->addLabelFor('content', 'Contenu :')
            ->addTextArea('content', strip_tags($_POST['content'] ?? ''), [
                'id' => 'content',
                'class' => 'form-control',
            ])
            ->addButton('Ajouter', [
                'class' => 'btn btn-primary mt-3 mb-3'
            ])
            ->endForm();

        // We check if form is complete
        if (Form::validate($_POST, ['title', 'author', 'chapo', 'content'])) {

            // We put data to send in an array
            $data = [
                'title' => strip_tags($_POST['title']),
                'author' => strip_tags($_POST['author']),
                'chapo' => strip_tags($_POST['chapo']),
                'content' => strip_tags($_POST['content']),
                'users_id' => $_SESSION['user']['id'],
            ];

            // We create a new post with data
            $post = new Post($data);
            $postRepository = new PostRepository;
            $postRepository->save($post);

            // Redirect to articles list
            $_SESSION['message'] = "The post has been added";
            header('Location: /post');
            exit;

        } else {
            $_SESSION['error'] = !empty($_POST) ? "The form isn't complete" : '';
        }
        $this->twig->display('post/add.html.twig', ['addPost' => $form->create()]);
    }
}