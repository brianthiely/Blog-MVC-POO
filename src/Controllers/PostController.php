<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Form\AddPostForm;
use App\Models\Post;
use App\Models\PostRepository;
use Exception;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;


class PostController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @throws Exception
     */
    public function index()
    {
        $posts = (new PostRepository())->getPosts();
        try {
            $this->twig->display('post/index.html.twig', compact('posts'));
        } catch (LoaderError|RuntimeError|SyntaxError $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function add(): void
    {
        $addPostForm = new AddPostForm();

        if (!$addPostForm->isSubmitted()) {
            if ($addPostForm->isValid()) {
                $data = $addPostForm->getData();
                $post = new Post($data);
                $postRepository = new PostRepository;
                $postRepository->save($post);
                $this->redirect('/post');
            }
            $this->session->setSession('errors', $addPostForm->getErrors());
        }
        try {
            $this->twig->display('post/add.html.twig', [
                'addPostForm' => $addPostForm->getForm()
            ]);
        } catch (LoaderError|RuntimeError|SyntaxError $e) {
            throw new Exception($e->getMessage());
        }
    }
}