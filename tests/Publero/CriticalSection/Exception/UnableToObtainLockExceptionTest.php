<?php
namespace tests\Publero\CriticalSection\Exception;

class UnableToObtainLockExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testGetMessage()
    {
        $lockCode = 'test_code';
        $exceptionCode = 3;
        $exception = new UnableToObtainLockException($lockCode, $exceptionCode);

        $this->assertEquals($exception->getMessage(), "Unable to obtain lock $lockCode, file is already locked or it couldn't be created");
        $this->assertEquals($exception->getCode(), $exceptionCode);
    }
}
