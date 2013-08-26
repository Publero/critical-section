<?php
namespace Publero\CriticalSection\Exception;

class UnableToObtainLockException extends \RuntimeException
{
    /**
     * @var string
     */
    private $lockCode;

    public function __construct($lockCode, $message = "", $code = 0, Exception $previous = null)
    {
        $this->lockCode = $lockCode;

        parent::__construct($message, $code, $previous);
    }

    /**
     * @return string
     */
    public function getLockCode()
    {
        return $this->lockCode;
    }
}
