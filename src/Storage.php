<?php
/**
 * This file is part of Vegas package
 *
 * @author Radosław Fąfara <radek@archdevil.pl>
 * @copyright Amsterdam Standard Sp. Z o.o.
 * @homepage https://bitbucket.org/amsdard/vegas-phalcon
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Vegas\Profiler;

use Vegas\Profiler\Exception\InvalidRequestException;

/**
 * Class Storage
 * Handles process of storing and retrieving storage identifier.
 * The identifier points to a file which consists data collected by profiler.
 * The data lives between requests and we don't want it to be kept in the session.
 * 
 * @package Vegas\Profiler
 */
class Storage
{
    /**
     * @var string
     */
    private $requestId;
    
    /**
     * Storage directory for output files
     * @var string
     */
    private $dir;
    
    public function __construct()
    {
        $this->dir = sys_get_temp_dir();
        $this->requestId = preg_replace("/[^A-Za-z0-9 ]/", '', strrev(uniqid()) . uniqid());
    }
    
    /**
     * Saves profiled data into temporary file to be used in the next request.
     * @param mixed $data
     */
    public function store($data)
    {
        file_put_contents($this->getFilepath(), json_encode($data));
    }

    /**
     * Retrieves data for requestId stored in the temporary directory.
     * @return array json decoded data
     * @throws InvalidRequestException when a file for request doesn't exist
     */
    public function read()
    {
        if (!file_exists($this->getFilepath())) {
            throw new InvalidRequestException;
        }
        $data = file_get_contents($this->getFilepath());
        if ($data === false) {
            throw new InvalidRequestException;
        }
        return json_decode($data, true);
    }
    
    public function delete()
    {
        if (is_file($this->getFilepath())) {
            unlink($this->getFilepath());
        }
        
        return $this;
    }
    
    public function setRequestId($requestId)
    {
        $this->requestId = $requestId;
    }
    
    public function getRequestId()
    {
        return $this->requestId;
    }
    
    private function getFilepath()
    {
        return implode(DIRECTORY_SEPARATOR, [$this->dir, $this->requestId]);
    }
}
