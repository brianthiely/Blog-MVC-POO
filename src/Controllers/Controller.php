<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Globals\Globals;
use App\Globals\GlobalsFactory;
use JetBrains\PhpStorm\NoReturn;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

abstract class Controller
{
   private FilesystemLoader $loader;
   protected Environment $twig;
   protected Globals $global;

    public function __construct()
   {
        $this->loader = New FilesystemLoader(ROOT . '/src/Views');
        $this->twig = new Environment($this->loader);
        $this->global = GlobalsFactory::getInstance()->createGlobals();
   }

    /**
     * @param string $page
     * @return void
     */
    #[NoReturn] protected function redirect(string $page): void
    {
        header('Location: ' . $page);
    }
}
