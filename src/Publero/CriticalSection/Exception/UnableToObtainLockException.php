<?php
namespace Publero\CriticalSection\Exception;

class UnableToObtainLockException extends \RuntimeException
{
    public function __construct($lockCode, $exceptionCode = 0)
    {
        $message = "Unable to obtain lock $lockCode, lock code is already locked or it couldn't be created";

        parent::__construct($message, $exceptionCode);
    }
}
