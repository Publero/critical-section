<?php
namespace tests\Publero\CriticalSection;

use Publero\CriticalSection\FileCriticalSection;

class FilecriticalSectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var FileCriticalSection
     */
    private $criticalSection;

    public function setUp()
    {
        $this->criticalSection = new FileCriticalSection();
    }

    public function testEnter()
    {
        $this->assertTrue($this->criticalSection->canEnter('example_enter'));
        $this->criticalSection->enter('example_enter');
        $this->assertFalse($this->criticalSection->canEnter('example_enter'));
        $this->criticalSection->leave('example_enter');
        $this->assertTrue($this->criticalSection->canEnter('example_enter'));
    }

    public function testEnterWithTimeout()
    {
        $this->criticalSection->enter('cs_timeout');
        $this->assertFalse($this->criticalSection->canEnter('cs_timeout'));

        $timestamp = time();
        $criticalSection = new FileCriticalSection();
        $this->assertFalse($criticalSection->enter('cs_timeout', 2));
        $this->assertTrue($timestamp + 2 <= time());

        $this->criticalSection->leave('cs_timeout');
        $this->assertTrue($criticalSection->enter('cs_timeout', 2));
    }

    public function testMultipleEnters()
    {
        $this->assertTrue($this->criticalSection->canEnter('example1'));
        $this->assertTrue($this->criticalSection->canEnter('example2'));

        $this->criticalSection->enter('example1');
        $this->criticalSection->enter('example2');

        $this->assertFalse($this->criticalSection->canEnter('example1'));
        $this->assertFalse($this->criticalSection->canEnter('example2'));

        $this->criticalSection->leave('example1');
        $this->criticalSection->leave('example2');

        $this->assertTrue($this->criticalSection->canEnter('example1'));
        $this->assertTrue($this->criticalSection->canEnter('example2'));
    }

    public function testMoreLeavesWontDoAnything()
    {
        $this->assertTrue($this->criticalSection->canEnter('example_leave'));
        $this->criticalSection->leave('example_leave');
        $this->assertTrue($this->criticalSection->canEnter('example_leave'));
        $this->criticalSection->leave('example_leave');
        $this->assertTrue($this->criticalSection->canEnter('example_leave'));
    }
}
