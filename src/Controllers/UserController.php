<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Form\SignInForm;
use App\Form\SignUpForm;
use App\Models\User;
use App\Models\UserRepository;
use App\Services\Flash;
use App\Services\Session;
use Exception;
use JetBrains\PhpStorm\NoReturn;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class UserController extends Controller
{

    /**
     * @return void
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws Exception
     */
    public function login(): void
    {

        $signInForm = new SignInForm();

        if (Session::get('user') !== null) {
            Flash::set('message', 'You are already logged in');
            $this->redirect('/');
        }

        if ($signInForm->isSubmitted()) {
            if ($signInForm->isValid()) {
                $data = $signInForm->getData();
                $userRepository = new UserRepository();
                $userFound = $userRepository->getUserByEmail($data['email']);
                if (!isset($userFound)) {
                    Flash::set('error', 'Email or password is incorrect');
                    $this->redirect('/user/login');
                }
                if (!$userFound->checkPassword($data['password'])) {
                    Flash::set('error', 'Email or password is incorrect');
                    $this->redirect('/user/login');
                }
                Session::set('user', $userFound);
                if ($userFound->isAdmin()) {
                    Flash::set('message', 'Welcome back ' . $userFound->getFirstname() . ' you are an admin');
                    $this->redirect('/admin');
                } elseif ($userFound->isUser()) {
                    Flash::set('message', 'Welcome back ' . $userFound->getFirstname());
                    $this->redirect('/');
                } else {
                    Flash::set('error', 'You are not an user');
                    $this->redirect('/user/login');
                }
            }
        }
        $this->twig->display('user/sign-in.html.twig', [
            'signInForm' => $signInForm->createForm()
        ]);
    }


    /**
     * @return void
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws Exception
     */
    public function register(): void
    {
        $signUpForm = new SignUpForm();

        if (Session::get('user') !== null) {
            Flash::set('message', 'You are already logged in');
            $this->redirect('/');
        }

        if ($signUpForm->isSubmitted()) {
            if ($signUpForm->isValid()) {
                $data = $signUpForm->getData();
                $user = new User($data);
                $user->setPasswordWithoutHash($data['password']);
                $userRepository = new UserRepository();
                $userRepository->save($user);
                $user = $userRepository->getUserByEmail($data['email']);
                Session::set('user', $user);
                Flash::set('success', 'Your account has been created and you are logged in');
                $this->redirect('/');
            }
        }
        $this->twig->display('user/sign-up.html.twig', [
            'SignUpForm' => ($signUpForm->createForm())
        ]);
    }


    /**
     * @return void
     */
    #[NoReturn] public function logout(): void
    {
        Session::destroy();
        $this->redirect('/');
    }
}
