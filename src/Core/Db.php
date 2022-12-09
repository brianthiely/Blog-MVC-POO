<?php
declare(strict_types=1);

namespace App\Core;

use PDO;
use PDOException;

class Db extends PDO
{
    private static ?Db $instance = null;

    private const HOST = 'localhost';
    private const USER = 'root';
    private const PASS = '';
    private const DBNAME = 'blog-php';


    private function __construct()
    {
        $dsn = 'mysql:host=' . self::HOST . ';dbname=' . self::DBNAME;

        // We call the parent constructor
        try {
            parent::__construct($dsn, self::USER, self::PASS);

            $this->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');
            $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage());
        }
    }

    /**
     * @return static
     */
    public static function getInstance():self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}

