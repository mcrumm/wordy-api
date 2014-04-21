<?php

namespace Wordy\Seed;

class IO
{
    private $seedFile;

    /**
     * @param string $seedFile
     * @param string $locale
     */
    public function __construct($seedFile, $locale = 'en_US')
    {
        $this->seedFile = $seedFile;
        $this->sorter   = new Sorter($locale);
    }

    /**
     * @param array $data
     * @return array
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     */
    public function write(array $data = array())
    {
        if ($this->fileExists() && !is_writable($this->seedFile)) {
            throw new \InvalidArgumentException('The seed file path "%s" is not writable.', $this->seedFile);
        }

        $this->sorter->execute($data);

        if (false === file_put_contents($this->seedFile, $this->encode($data))) {
            throw new \RuntimeException('Failed to write %d bytes to seed file.', strlen($data));
        }

        return $data;
    }

    /**
     * @param array $data
     * @return array
     */
    public function append(array $data = array())
    {
        if ($this->fileExists()) {
            $contents = $this->read();
            if (false !== $contents) {
                $data = array_merge($contents, $data);
            }
        }

        return $this->write($data);
    }

    /**
     * @return array
     * @throws \InvalidArgumentException
     */
    public function read()
    {
        if (!$this->fileExists()) {
            throw new \InvalidArgumentException('Seed file does not exist.');
        }

        return $this->decode(file_get_contents($this->seedFile));
    }

    /**
     * @return bool
     */
    public function fileExists()
    {
        return file_exists($this->seedFile);
    }

    /**
     * @param string $encoded
     * @return array
     */
    protected function decode($encoded)
    {
        $decoded = explode(PHP_EOL, $encoded);

        return false !== $decoded ? array_filter($decoded) : array();
    }

    /**
     * @param array $data
     * @return string
     */
    protected function encode(array $data = array())
    {
        return implode(PHP_EOL, $data);
    }

}
