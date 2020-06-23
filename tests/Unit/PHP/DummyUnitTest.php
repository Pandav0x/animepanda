<?php

namespace App\Tests\Unit\PHP;

use PHPUnit\Framework\TestCase;

class DummyUnitTest extends TestCase
{
    public function testOneEqualsOne(): void
    {
        $this->assertSame(1, 1);
    }
}