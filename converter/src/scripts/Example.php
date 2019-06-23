<?php

namespace App\scripts;

use App\ScriptBase;

class Example extends ScriptBase
{

    public function setUp()
    {

    }

    public function execute()
    {
        $query = $this->database->getInstance()->query("select * from information_schema.tables");
        $result = $query->fetchAll();
        dump($result);
    }


    public function cleanUp()
    {
    }
}
