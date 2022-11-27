<?php
declare(strict_types=1);

namespace App\Controllers;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

abstract class Controller
{
   private FilesystemLoader $loader;
   protected Environment $twig;

   public function __construct()
   {
        $this->loader = New FilesystemLoader(ROOT . '/src/Views');
        $this->twig = new Environment($this->loader);
   }
}