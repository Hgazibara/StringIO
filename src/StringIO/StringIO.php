<?php
namespace StringIO;

class StringIO
{
    
    const PROTOCOL = 'stringio';
    
    protected $contents;
    protected $position;
    
    private function strlen($string, $encoding = 'UTF-8') {
        return \mb_strlen($string, $encoding);
    }
    
    private function getLength() {
        return $this->strlen($this->contents);
    }
    
    public function stream_close()
    {
        $this->contents = '';
        $this->position = 0;
    }
    
    public function stream_eof()
    {
        return $this->getLength() === $this->position;
    }
    
    
    public function stream_open($path, $mode, $options, &$opened_path)
    {
        $this->contents = '';
        return true;
    }
    
    public function stream_read($count)
    {
        $count = \min($count, $this->strlen($this->contents) - $this->position);
        $data = \mb_substr($this->contents, $this->position, $count);
        $this->position += $this->strlen($data);
        return $data;
    }
    
    public function stream_seek($offset, $whence = SEEK_SET) 
    {
        switch ($whence) {
            case \SEEK_SET:
                if ($offset >= 0 && $offset < $this->getLength()) {
                    $this->position = $offset;
                    return true;
                } else {
                    return false;
                }
            case \SEEK_CUR:
                if ($offset >= 0 && $offset + $this->position < $this->getLength()) {
                    $this->position += $offset;
                    return true;
                } else {
                    return false;
                }
            case \SEEK_END:
                if ($offset + $this->getLength() >= 0) {
                    $this->position = $this->getLength() + $offset;
                    return true;
                } else {
                    return false;
                }
        }
    }
    
    public function stream_tell()
    {
        return $this->position;
    }
    
    public function stream_write($data)
    {
        $length = $this->strlen($data);
        $this->position += $length;
        $this->contents .= $data;
        return $length;
    }
    
    /**
     * @codeCoverageIgnore
     */
    public function getContents() {
        return $this->contents;
    }
    
    /**
     * @codeCoverageIgnore
     */
    public static function register()
    {
        \stream_wrapper_register(self::PROTOCOL, __CLASS__);
    }
}
