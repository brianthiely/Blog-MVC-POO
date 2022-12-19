<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Form\AddCommentForm;
use App\Models\Comment;
use App\Models\CommentRepository;
use App\Services\Flash;
use App\Services\Session;
use Exception;

class CommentController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param int $postId
     * @return string
     * @throws Exception
     */
    public function addComment(int $postId): string
    {
        $form = new AddCommentForm();

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $data = $form->getData();
                $data['post_id'] = $postId;
                $comment = new Comment($data);
                (new CommentRepository())->save($comment);
                if (Session::get('user', 'roles') === 'admin') {
                    Flash::set('success', 'Your comment has been added successfully');
                } elseif (Session::get('user', 'roles') === 'user') {
                    Flash::set('message', 'Your comment has been added successfully and will be visible after validation by an administrator');
                }
                $this->redirect('/post/read/' . $postId);
            }
        }
        return $form->createForm();
    }
}
