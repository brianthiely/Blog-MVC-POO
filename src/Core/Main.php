<?php
declare(strict_types=1);

namespace App\Core;

use App\Controllers\MainController;
use App\Globals\GlobalsFactory;
use App\Services\Session;
use PHPMailer\PHPMailer\Exception;

class Main
{
    /**
     * Start the application and run the controller and action specified in the URL
     *
     * @return string|void The response from the controller
     * @throws \Exception If the controller or action is not found
     */
    public function start()
    {
        Session::start();
        $global = GlobalsFactory::getInstance()->createGlobals();

        $get = $global->getGet();
        $uri = $global->getUri();

        // If the URI is not empty and ends with a slash, redirect to the same URI without the slash.
        if (!empty($uri) && $uri != '/' && $uri[-1] == '/') {
            $uri = substr($uri, 0, -1);
            http_response_code(301);
            header('Location: ' . $uri);
        }

        // If the "p" parameter is set in the URL, run the specified controller and action.
        if(!empty($get['p'])) {
            // Split the "p" parameter value into an array of parameters.
            $params = explode('/', $get['p']);

            // If the first parameter is not empty, run the specified controller and action.
            if($params[0] !== "") {
                // Create the name of the controller class based on the first parameter.
                $controller = "\\App\\Controllers\\" . ucfirst(array_shift($params)) . "Controller";

                $controller = new $controller();

                // Set the action to the second parameter, or "index" if no second parameter is specified.
                $action = (isset($params[0])) ? array_shift($params) : 'index';

                // If the action method exists in the controller class, run it.
                if(method_exists($controller, $action)) {
                    // If there are additional parameters, call the action method with them as arguments.
                    // Otherwise, just call the action method without any arguments.
                    (isset($params[0])) ? call_user_func_array(
                        [$controller, $action],
                        $params
                    ) : $controller->$action();
                }
                // If the action method doesn't exist, return a "404" error.
                http_response_code(404);
                return "This page doesn't exist";
            }
        }
        // If no controller and action are specified in the URL, run the "index" action of the "MainController".
        $controller = new MainController;
        try {
            $controller->index();
        } catch (\Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
