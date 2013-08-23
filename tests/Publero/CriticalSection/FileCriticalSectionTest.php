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
        $this->assertFalse($this->criticalSection->canEnter('example_enter'));
        $this->criticalSection->enter('example_enter');
        $this->assertTrue($this->criticalSection->canEnter('example_enter'));
        $this->criticalSection->leave('example_enter');
        $this->assertFalse($this->criticalSection->canEnter('example_enter'));
    }

    public function testMultiplEenters()
    {
        $this->criticalSection->enter('example1');
        $this->criticalSection->enter('example2');

        $this->assertTrue($this->criticalSection->canEnter('example1'));
        $this->assertTrue($this->criticalSection->canEnter('example2'));

        $this->criticalSection->leave('example1');
        $this->criticalSection->leave('example2');

        $this->assertFalse($this->criticalSection->canEnter('example1'));
        $this->assertFalse($this->criticalSection->canEnter('example2'));
    }

    public function testMoreLeavesWontDoAnything()
    {
        $this->assertFalse($this->criticalSection->canEnter('example_enter'));
        $this->criticalSection->leave('example_enter');
        $this->assertFalse($this->criticalSection->canEnter('example_enter'));
        $this->criticalSection->leave('example_enter');
        $this->assertFalse($this->criticalSection->canEnter('example_enter'));
    }
}
