<?php
namespace tests\Publero\CriticalSection\Exception;

use Publero\CriticalSection\Exception\UnableToObtainLockException;

class UnableToObtainLockExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testGetLockCode()
    {
        $lockCode = 'test_code';
        $message = 'Unable to get lock test_code';
        $exception = new UnableToObtainLockException($lockCode, $message);

        $this->assertEquals($exception->getLockCode(), $lockCode);
        $this->assertEquals($exception->getMessage(), $message);
    }
}
