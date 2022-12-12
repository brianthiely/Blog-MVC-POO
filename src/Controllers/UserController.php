<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\Session;
use JetBrains\PhpStorm\NoReturn;

class UserController extends Controller
{
    protected Session $session;

    #[NoReturn] public function logout()
    {
        $this->session->destroy();
        $this->redirect('/login');
    }


    public function login()
    {

    }

    public function register()
    {
    }


}
