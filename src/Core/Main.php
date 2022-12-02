<?php
declare(strict_types=1);

namespace App\Core;

use App\Controllers\MainController;
use App\Globals\_GET;
use App\Globals\_SERVER;
use PHPMailer\PHPMailer\Exception;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class Main
{
    private _SERVER $server;
    private _GET $get;

    public function __construct()
    {
        $this->server = new _SERVER();
        $this->get = new _GET();
    }

    /**
     * Main router
     * @return void
     * @throws Exception
     */
    public function start(): void
    {
        session_start();

        $uri = $this->server->getUri();

        // We clean the url to avoid duplicate content
        if (!empty($uri) && $uri != '/' && $uri[-1] == '/') {
            $uri = substr($uri, 0, -1);
            http_response_code(301);
            header('Location: ' .$uri);
        }

        // We manage the url parameters
        // p=controller/method/params
        $params = [];
        if($this->get->_GET('p') !== null) {
            $params = explode('/', $this->get->_GET('p'));

        if($params[0] !== "") {
            // We retrieve the controller to instantiate
            $controller = "\\App\\Controllers\\" . ucfirst(array_shift($params)) . "Controller";

            // We instantiate the controller
            $controller = new $controller();

            // We retrieve the second parameter of the url
            $action = (isset($params[0])) ? array_shift($params) : 'index';

            if(method_exists($controller, $action)) {
                (isset($params[0])) ? call_user_func_array(
                    [$controller, $action],
                    $params
                ) : $controller->$action();
            }
                http_response_code(404);
                echo "This page doesn't exist";

        }
            // No parameter we return the default controller
            $controller = new MainController;
            try {
                $controller->index();
            } catch (LoaderError|RuntimeError|SyntaxError $e) {
                throw new Exception($e->getMessage());
            }
        }
    }
}