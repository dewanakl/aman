<?php

use Kamu\Aman;
use PHPUnit\Framework\TestCase;

class Test extends TestCase
{
    /**
     * @var Aman
     */
    private $aman;

    protected function setUp(): void
    {
        $this->aman = Aman::factory();
    }

    public function testCheck(): void
    {
        $this->assertTrue($this->aman->check('This is a test with b@jIng4n word'));

        $this->assertFalse($this->aman->check('This is a clean test'));
    }

    public function testMasking(): void
    {
        $maskedString = $this->aman->masking('This is a test with b@jIng4n word');
        $this->assertSame('This is a test with ******** word', $maskedString);

        $maskedStringWithHash = $this->aman->masking('This is a test with b@jIng4n word', '#');
        $this->assertSame('This is a test with ######## word', $maskedStringWithHash);
    }

    public function testFilter(): void
    {
        $filteredString = $this->aman->filter('This is a test with b@jIng4n word');
        $this->assertSame('This is a test with  word', $filteredString);
    }

    public function testWords(): void
    {
        $filteredWords = $this->aman->words('This is a test with b@jIng4n word');
        $this->assertSame(['b@jIng4n'], $filteredWords);

        $filteredWords = $this->aman->words('This is a test with b@jIng4n and k3p4rat word');
        $this->assertSame(['b@jIng4n', 'k3p4rat'], $filteredWords);

        $cleanWords = $this->aman->words('This is a clean test');
        $this->assertSame([], $cleanWords);
    }
}
