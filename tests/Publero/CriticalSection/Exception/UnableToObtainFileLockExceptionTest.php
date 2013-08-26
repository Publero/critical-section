<?php
namespace tests\Publero\CriticalSection\Exception;

use Publero\CriticalSection\Exception\UnableToObtainFileLockException;

class UnableToObtainFileLockExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testGetLockFile()
    {
        $lockCode = 'test_code';
        $lockFile = '/tmp/lock_file';
        $exception = new UnableToObtainFileLockException($lockCode, $lockFile);

        $this->assertEquals($exception->getLockCode(), $lockCode);
        $this->assertEquals($exception->getLockFile(), $lockFile);
        $this->assertEquals($exception->getMessage(), 'Unable to obtain lock "test_code", file "/tmp/lock_file" couldn\'t be locked');
    }
}
