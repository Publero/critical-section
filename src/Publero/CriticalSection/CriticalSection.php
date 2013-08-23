<?php
namespace Publero\CriticalSection;

interface CriticalSection
{
    /**
     * @param string $code
     * @param int|null $timeoutSeconds
     * @return bool
     * @throws \Publero\CriticalSection\Exception\UnableToObtainLockException
     */
    public function enter($code, $timeoutSeconds = null);

    /**
     * @param string $code
     */
    public function leave($code);

    /**
     * @param string $code
     * @return boolean
     */
    public function canEnter($code);
}
