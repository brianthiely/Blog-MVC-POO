<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Form\AddPostForm;
use App\Models\CommentRepository;
use App\Models\Post;
use App\Models\PostRepository;
use Exception;

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
        $this->twig->display('post/index.html.twig', compact('posts'));
    }

    /**
     * @throws Exception
     */
    public function read(int $id)
    {
        $post = (new PostRepository())->getPost($id);
        $comments =(new CommentRepository())->getComments($id);
        $commentForm = (new CommentController())->addComment($id);

        $this->twig->display('post/read.html.twig', compact('post','comments')
            + ['addCommentForm' => $commentForm]);
    }

    /**
     * @throws Exception
     */
    public function add(): void
    {
        $addPostForm = new AddPostForm();

        if ($addPostForm->isSubmitted()) {
            if ($addPostForm->isValid()) {
                $data = $addPostForm->getData();
                $post = new Post($data);
                $postRepository = new PostRepository;
                $postRepository->save($post);
                $this->global->setSession('message', 'Your post has been added');
                $this->redirect('/post');
            }
        }
        $this->twig->display('post/add.html.twig', [
            'addPostForm' => $addPostForm->getForm()
        ]);
    }
}
