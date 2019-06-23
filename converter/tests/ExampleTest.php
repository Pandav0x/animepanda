<?php

namespace Tests;

use App\Database;
use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    public function testExecute()
    {
        $db = new Database();
        $this->assertEquals(1, 1);
    }
}