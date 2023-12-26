<?php

use Kamu\Aman;
use PHPUnit\Framework\TestCase;

class Test extends TestCase
{
    public function testCheckTrue()
    {
        $check = Aman::factory()->check('k0nt0L');
        $this->assertTrue($check);
    }

    public function testCheckFalse()
    {
        $check = Aman::factory()->check('kantor');
        $this->assertFalse($check);
    }

    public function testCheckMixedTrue()
    {
        $check = Aman::factory()->check('k0nt0L dan m3m3k');
        $this->assertTrue($check);
    }

    public function testMaskEquals()
    {
        $check = Aman::factory()->masking('k0nt0L');
        $this->assertStringContainsString($check, '******');
    }

    public function testMaskEqualsEmpty()
    {
        $check = Aman::factory()->masking('kantor');
        $this->assertStringContainsString($check, 'kantor');
    }

    public function testMaskEqualsEmptyMixed()
    {
        $check = Aman::factory()->masking('kantor dan kontol');
        $this->assertStringContainsString($check, 'kantor dan ******');
    }
}
