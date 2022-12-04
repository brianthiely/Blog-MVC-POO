<?php
declare(strict_types=1);

namespace App\Core;

use App\Controllers\Controller;
use App\Controllers\MainController;
use PHPMailer\PHPMailer\Exception;

class Main extends Controller
{
    /**
     * @return string|void
     * @throws Exception
     */
    public function start()
    {
        session_start();


        $get = $this->global->getGet();
        $uri = $this->global->getUri();

        if (!empty($uri) && $uri != '/' && $uri[-1] == '/') {
            $uri = substr($uri, 0, -1);
            http_response_code(301);
            $this->redirect($uri);
        }

        // We manage the url parameters
        // p=controller/method/params
        if(!empty($get['p'])) {
            $params = explode('/', $get['p']);

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
                return "This page doesn't exist";
            }
        }
        // No parameter we return the default controller
        $controller = new MainController;
        try {
            $controller->index();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
