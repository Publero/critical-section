<?php
namespace Publero\CriticalSection\Exception;

class UnableToObtainFileLockException extends UnableToObtainLockException
{
    /**
     * @var string
     */
    private $lockFile;

    public function __construct($lockCode, $lockFile, $exceptionCode = 0, Exception $previous = null)
    {
        $this->lockFile = $lockFile;
        $message = "Unable to obtain lock \"$lockCode\", file \"$lockFile\" couldn't be locked";

        parent::__construct($lockCode, $message, $exceptionCode, $previous);
    }

    /**
     * @return string
     */
    public function getLockFile()
    {
        return $this->lockFile;
    }
}
