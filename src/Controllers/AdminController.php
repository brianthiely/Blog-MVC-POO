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
use JetBrains\PhpStorm\NoReturn;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class AdminController extends Controller
{
    /**
     * Check if the user is an admin
     *
     * @return void
     */
    private function checkAdminAccess(): void
    {
        $user = Session::get('user');
        if (!$user || $user->getRoles() !== 'admin') {
            Flash::set('error', 'You must be logged in as admin to access this page');
            $this->redirect('/');
        }
    }
    /**
     * Display the admin dashboard
     *
     * @return void Render the view
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function index(): void
    {
        $this->checkAdminAccess();
        $this->twig->display('admin/index.html.twig');
    }

    /**
     * Display the admin posts list
     *
     * @return void Render the view
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     */
    public function posts(): void
    {
        $this->checkAdminAccess();

        $posts = (new PostRepository())->getPosts();
        $this->twig->display('admin/posts.html.twig', compact('posts'));
    }

    /**
     * Display modify post form
     *
     * @param int $postId The post id to modify
     * @return void Render the view
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws Exception
     */
    public function modify(int $postId): void
    {
        $this->checkAdminAccess();

        $postRepository = new PostRepository();
        $post = (array)$postRepository->getPost($postId);

        $addPostForm = new AddPostForm();
        $addPostForm->setData($post);

        if ($addPostForm->isSubmitted()) {
            if ($addPostForm->isValid()) {
                $data = $addPostForm->getData();
                if ($data['csrfToken'] !== Session::get('user', 'csrfToken')) {
                    Flash::set('error', 'Something went wrong, please try again');
                    $this->redirect('/admin/posts');
                }

                $post = new Post($data);
                $postRepository->update($post, $postId);
                Flash::set('success', 'Post modified successfully');
                $this->redirect('/admin/posts');
            }
        }
        $this->twig->display('post/modify.html.twig', [
            'addPostForm' => $addPostForm->createForm()
        ]);
    }

    #[NoReturn] public function deletePost(int $postId): void
    {

        $this->checkAdminAccess();

        $csrfToken = filter_input(INPUT_POST, '_token');

        if (!isset($csrfToken) || $csrfToken !== Session::get('user', 'csrfToken')) {
            Flash::set('error', 'Something went wrong, please try again');
            $this->redirect('/admin/posts');
        }

        (new PostRepository())->delete($postId);
        Flash::set('success', 'Post deleted');
        $this->redirect('/admin/posts');
    }

    /**
     * Display all comments for validation
     *
     * @return void Render the view
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     */
    public function comments(): void
    {
        $this->checkAdminAccess();
        $comments = (new CommentRepository())->getAdminComments();

        $this->twig->display('admin/comments.html.twig', compact('comments'));
    }

    /**
     * Validate a comment
     *
     * @param int $commentId The comment id to validate
     * @return void
     */
    #[NoReturn] public function validateComment(int $commentId): void
    {
        $this->checkAdminAccess();

        $csrfToken = filter_input(INPUT_POST, '_token');

        if (!isset($csrfToken) || $csrfToken !== Session::get('user', 'csrfToken')) {
            Flash::set('error', 'Something went wrong, please try again');
            $this->redirect('/admin/comments');
        }

        (new CommentRepository())->validateComment($commentId);

        Flash::set('success', 'Comment validated');
        $this->redirect('/admin/comments');
    }

    /**
     * Delete a comment
     *
     * @param int $commentId
     * @return void Redirect to the admin comments list
     */
    #[NoReturn] public function deleteComment(int $commentId): void
    {
        $this->checkAdminAccess();

        $csrfToken = filter_input(INPUT_POST, '_token', FILTER_DEFAULT);

        if (!isset($csrfToken) || $csrfToken !== Session::get('user', 'csrfToken')) {
            Flash::set('error', 'Something went wrong, please try again');
            $this->redirect('/admin/comments');
        }

        (new CommentRepository())->delete($commentId);
        Flash::set('success', 'Comment deleted');
        $this->redirect('/admin/comments');
    }
}
