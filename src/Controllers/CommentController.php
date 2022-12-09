<?php

namespace App\Controllers;

use App\Form\AddCommentForm;
use App\Models\Comment;
use App\Models\CommentRepository;
use Exception;

class CommentController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param int $id
     * @return string
     * @throws Exception
     */
    public function addComment(int $id): string
    {

        $commentForm = new AddCommentForm();

        if ($commentForm->isSubmitted()) {
            if ($commentForm->isValid()) {
                $data = $commentForm->getData();
                $comment = new Comment($data, $id);
                var_dump($data);
                $commentRepository = new CommentRepository();
                $commentRepository->save($comment);
                $this->global->setSession('message', 'Your comment has been sent');
                $this->redirect('/post/read/' . $id);
            }
        }
        return $commentForm->getForm();
    }
}
