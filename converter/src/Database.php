<?php

namespace App;

class Database
{
    /**
     * @var \PDO
     */
    private $instance;


    public function __construct()
    {
        $this->setConnexions();
    }

    private function setConnexions(): void
    {
        $this->instance = $instance ?? new \PDO(
                'mysql:host=' . DATABASE_HOST . ';dbname=' . DATABASE_NAME, DATABASE_USER, DATABASE_PASSWORD
            );
    }

    public function getInstance(): \PDO
    {
        return $this->instance;
    }

}
