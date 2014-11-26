<?php
/**
 * This file is part of Vegas package
 *
 * @author Radosław Fąfara <radek@archdevil.pl>
 * @copyright Amsterdam Standard Sp. Z o.o.
 * @homepage http://vegas-cmf.github.io/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Vegas\Tests\Profiler;

use Vegas\Profiler\Storage;

class StorageTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Storage
     */
    public static $storage;

    public static function setUpBeforeClass()
    {
        self::$storage = new Storage;
    }

    public function testStorageGetsUniqueSafeIdentifier()
    {
        $storage1 = new Storage;
        $storage2 = new Storage;

        $this->assertNotEquals($storage1->getRequestId(), $storage2->getRequestId());

        $this->assertGreaterThan(10, strlen($storage1->getRequestId()));
        $this->assertGreaterThan(10, strlen($storage2->getRequestId()));

        $this->assertRegExp('/[a-zA-Z0-9]+/', $storage1->getRequestId());
        $this->assertRegExp('/[a-zA-Z0-9]+/', $storage2->getRequestId());
    }

    public function testStoragePersistsContentInFilesystem()
    {
        $storage = self::$storage;

        $this->assertFileNotExists($storage->getFilepath());

        $storage->store(['success' => true]);

        $this->assertFileExists($storage->getFilepath());
    }

    /**
     * @depends testStoragePersistsContentInFilesystem
     */
    public function testStorageWillReadStoredContent()
    {
        $storage = self::$storage;

        $this->assertFileExists($storage->getFilepath());

        $this->assertSame(['success' => true], $storage->read());
    }

    /**
     * @depends testStorageWillReadStoredContent
     */
    public function testStorageWillDeleteFile()
    {
        $storage = self::$storage;

        $this->assertFileExists($storage->getFilepath());

        $storage->delete();

        $this->assertFileNotExists($storage->getFilepath());
    }

    public function testStorageFailsToReadNonExistingContent()
    {
        $storage = new Storage;

        try {
            $storage->read();
            $this->fail();
        } catch (\Exception $e) {
            $this->assertInstanceOf('\Vegas\Profiler\Exception\InvalidRequestException', $e);
        }
    }
}