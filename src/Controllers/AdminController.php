<?php
declare(strict_types=1);
namespace App\Controllers;

use App\Form\AddPostForm;
use App\Models\CommentRepository;
use App\Models\Post;
use App\Models\PostRepository;
use App\Services\Flash;
use App\Services\Session;
use JetBrains\PhpStorm\NoReturn;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class AdminController extends Controller
{
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
        if (Session::get('user', 'roles') !== 'admin') {
            Flash::set('error', 'Access denied');
            $this->redirect('/');
        }
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
        if (Session::get('user', 'roles') !== 'admin') {
            Flash::set('error', 'Access denied');
            $this->redirect('/');
        }
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
     */
    public function modify(int $postId): void
    {
        if (!Session::get('user') || Session::get('user', 'roles') !== 'admin') {
            Flash::set('error', 'Access denied');
            $this->redirect('/post');
        }
        $addPostForm = new AddPostForm();
        $postRepository = new PostRepository();
        $post = (array)$postRepository->getPost($postId);
        $addPostForm->setData($post);
        if ($addPostForm->isSubmitted()) {
            if ($addPostForm->isValid()) {
                $data = $addPostForm->getData();
                $post = new Post($data);
                if (!isset($data['csrfToken']) || $data['csrfToken'] !== Session::get('user', 'csrfToken')) {
                    Flash::set('error', 'Something went wrong please try again');
                    $this->redirect('/post');
                }

                $postRepository->update($post, $postId);
                Flash::set('success', 'Post modified successfully');
                $this->redirect('/admin/posts');
            }
        }

        $this->twig->display('post/modify.html.twig', [
            'addPostForm' => $addPostForm->createForm()
        ]);
    }

    /**
     * Delete a post
     *
     * @param int $postId The post id to delete
     * @return void Redirect to the admin posts list
     */
    #[NoReturn] public function deletePost(int $postId): void
    {
        if (Session::get('user', 'roles') !== 'admin') {
            Flash::set('error', 'Access denied');
            $this->redirect('/');
        }
        (new PostRepository())->deletePost($postId);
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
        if (Session::get('user', 'roles') !== 'admin') {
            Flash::set('error', 'Access denied');
            $this->redirect('/');
        }
        $comments = (new CommentRepository())->getAdminComments();
        $this->twig->display('admin/comments.html.twig', compact('comments'));
    }

    /**
     * Validate a comment
     *
     * @param int $commentId The comment id to validate
     * @return void Redirect to the admin comments list
     */
    #[NoReturn] public function validateComment(int $commentId): void
    {
        if (Session::get('user', 'roles') !== 'admin') {
            Flash::set('error', 'Access denied');
            $this->redirect('/');
        }
        (new CommentRepository())->validateComment($commentId);
        Flash::set('success', 'Comment validated and published');
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
        if (Session::get('user', 'roles') !== 'admin') {
            Flash::set('error', 'Access denied');
            $this->redirect('/');
        }
        (new CommentRepository())->delete($commentId);
        Flash::set('success', 'Comment deleted');
        $this->redirect('/admin/comments');
    }
}
