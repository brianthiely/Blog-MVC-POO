<?php
declare(strict_types=1);


namespace App\Mailer;

use App\Globals\Globals;

class MailerFactory
{
    private Globals $global;
    private static MailerFactory $instance;

    private function __construct()
    {
        $this->global = new Globals();
    }

    public static function getInstance(): MailerFactory
    {
        if (!isset(self::$instance)) {
            self::$instance = new MailerFactory();
        }
        return self::$instance;
    }

    public function createMailer(): Mailer
    {
        return new Mailer(
            $this->global->getEnv('MAILER_HOST'),
            $this->global->getEnv('MAILER_USERNAME'),
            $this->global->getEnv('MAILER_PASSWORD'),
            $this->global->getEnv('MAILER_PORT')
        );
    }
}
