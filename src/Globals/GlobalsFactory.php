<?php
declare(strict_types=1);

namespace App\Globals;

class GlobalsFactory
{
    private static GlobalsFactory $instance;

    public static function getInstance(): GlobalsFactory
    {
        if (!isset(self::$instance)) {
            self::$instance = new GlobalsFactory();
        }
        return self::$instance;
    }

    public function createGlobals(): Globals
    {
        return new Globals();
    }
}
