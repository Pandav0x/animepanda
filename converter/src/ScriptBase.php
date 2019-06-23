<?php


namespace App;


abstract class ScriptBase implements ScriptInterface
{
    protected $database;

    public function __construct()
    {
        $this->database = new Database();
    }

}