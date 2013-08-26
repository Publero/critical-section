<?php
namespace Publero\CriticalSection;

use Publero\CriticalSection\Exception\UnableToObtainFileLockException;

class FileCriticalSection implements CriticalSection
{
    /**
     * @var string
     */
    private $lockPrefix;

    /**
     * @var string
     */
    private $lockDirectory;

    /**
     * @var \SplFileObject[]
     */
    private $locks = [];

    public function __construct($lockDirectory = null, $lockPrefix = 'php_lock_file_')
    {
        $this->lockPrefix = $lockPrefix;
        $this->lockDirectory = $lockDirectory ?: rtrim(sys_get_temp_dir(), '/\\');
    }

    /**
     * @param string $code
     * @param int|null $timeoutSeconds
     * @return bool
     * @throws UnableToObtainFileLockException
     */
    public function enter($code, $timeoutSeconds = null)
    {
        if (empty($this->locks[$code])) {
            $this->locks[$code] = $this->getFile($code);
        }
        $file = &$this->locks[$code];

        if ($timeoutSeconds === null) {
            if ($file->flock(LOCK_EX)) {
                return;
            }

            throw new UnableToObtainFileLockException($code, $this->getLockFileName($code));
        }

        $endTime = time() + $timeoutSeconds;
        while (!($lock = $file->flock(LOCK_EX | LOCK_NB)) && time() < $endTime) {
            sleep(1);
        }

        return $lock;
    }

    /**
     * @param string $code
     */
    public function leave($code)
    {
        if (isset($this->locks[$code])) {
            $file = $this->locks[$code];
        } else {
            $file = $this->getFile($code);
        }

        if ($file->flock(LOCK_UN) && isset($this->locks[$code])) {
            unset($this->locks[$code]);
        }
    }

    /**
     * @param string $code
     * @return boolean
     */
    public function canEnter($code)
    {
        if ($this->getFile($code)->flock(LOCK_EX | LOCK_NB)) {
            return true;
        }

        return false;
    }

    /**
     * @param string $code
     * @return \SplFileObject
     */
    private function getFile($code)
    {
        return new \SplFileObject($this->getLockFileName($code), 'w');
    }

    /**
     * @param string $code
     * @return string
     */
    private function getLockFileName($code)
    {
        $tmpFile = $this->lockPrefix . sha1(__FILE__ . $code);

        return "{$this->lockDirectory}/$tmpFile";
    }
}