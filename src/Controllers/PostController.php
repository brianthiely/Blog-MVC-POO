<?php
declare(strict_types=1);
namespace App\Controllers;

use App\Form\AddPostForm;
use App\Models\CommentRepository;
use App\Models\Post;
use App\Models\PostRepository;
use App\Services\Flash;
use App\Services\Session;
use Exception;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class PostController extends Controller
{
    /**
     * Display all posts in the database
     *
     * @return void Render the view
     * @throws Exception
     */
    public function index(): void
    {
        $posts = (new PostRepository())->getPosts();
        $user = Session::get('user');
        $this->twig->display('post/index.html.twig', compact('posts', 'user'));
    }

    /**
     * Display a post
     *
     * @param int $postId
     * @return void Render the view
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws Exception
     */
    public function read(int $postId): void
    {
        $user = Session::get('user');
        if (!$user) {
            Flash::set('error', 'You must be logged in to read a post');
            $this->redirect('/post');
        }
        $post = (new PostRepository())->getPost($postId);
        $comments =(new CommentRepository())->getCommentsByPost($postId);
        $commentController = new CommentController($this->loader);
        $commentForm = $commentController->addComment($postId);

        $this->twig->display('post/read.html.twig', compact('post','comments')
            + ['addCommentForm' => $commentForm]);
    }

    /**
     * Display the form to add a post
     *
     * @return void Render the view
     * @throws Exception
     */
    public function add(): void
    {
        if (!Session::get('user') || Session::get('user', 'roles') !== 'admin') {
            Flash::set('error', 'Access denied');
            $this->redirect('/post');
        }
        $addPostForm = new AddPostForm();

        if ($addPostForm->isSubmitted()) {
            if ($addPostForm->isValid()) {
                $data = $addPostForm->getData();
                $post = new Post($data);
                if (!isset($data['csrfToken']) || $data['csrfToken'] !== Session::get('user', 'csrfToken')) {
                    Flash::set('error', 'Something went wrong please try again');
                    $this->redirect('/post');
                }
                $postRepository = new PostRepository;
                $postRepository->save($post);
                Flash::set('success', 'Post added successfully');
                $this->redirect('/post');
            }
        }
        $this->twig->display('post/add.html.twig', [
            'addPostForm' => $addPostForm->createForm()
        ]);
    }

}
