<?php
declare(strict_types=1);
namespace App\Mailer;

use App\Globals\GlobalsFactory;

class MailerFactory
{
    private static MailerFactory $instance;

    public static function getInstance(): MailerFactory
    {
        if (!isset(self::$instance)) {
            self::$instance = new MailerFactory();
        }
        return self::$instance;
    }

    public function createMailer(): Mailer
    {
        $global = GlobalsFactory::getInstance()->createGlobals();
        return new Mailer(
            $global->getEnv('MAILER_HOST'),
            $global->getEnv('MAILER_USERNAME'),
            $global->getEnv('MAILER_PASSWORD'),
            $global->getEnv('MAILER_PORT')
        );
    }
}
