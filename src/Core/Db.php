<?php
declare(strict_types=1);

namespace App\Core;

use App\Globals\GlobalsFactory;
use PDO;
use PDOException;

class Db extends PDO
{
    // Declare a private static property named $instance which is initially set to null.
    // This property will be used to store the single instance of the Db class that we create.
    private static ?Db $instance = null;

    private function __construct()
    {
        // Get the database configuration from the .env file.
        $dbConfig = (new GlobalsFactory())::getInstance()->createGlobals();

        try {
            parent::__construct(
                'mysql:host=' . $dbConfig->getEnv('DB_HOST') . ';dbname=' . $dbConfig->getEnv('DB_NAME'),
                $dbConfig->getEnv('DB_USER'),
                $dbConfig->getEnv('DB_PASSWORD'),
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]
            );
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }

    /**
     * Get the single instance of the Db class.
     * If the instance doesn't exist, create it.
     *
     * @return static
     */
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}
