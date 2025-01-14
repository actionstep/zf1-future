<?php
/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   Zend
 * @package    Zend_Cache
 * @subpackage UnitTests
 * @copyright  Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id$
 */

/**
 * Zend_Cache
 */
require_once 'Zend/Cache.php';
require_once 'Zend/Cache/Backend/Memcached.php';

/**
 * Common tests for backends
 */
require_once 'CommonExtendedBackendTest.php';

/**
 * @category   Zend
 * @package    Zend_Cache
 * @subpackage UnitTests
 * @copyright  Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @group      Zend_Cache
 */
class Zend_Cache_MemcachedBackendTest extends Zend_Cache_CommonExtendedBackendTest
{
    protected $_instance;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct('Zend_Cache_Backend_Memcached', $data, $dataName);
    }

    public function setUp($notag = true): void
    {
        if (!class_exists('Memcached')) {
            $this->markTestSkipped('Memcached is not installed, skipping test');
            return;
        }

        $serverValid = [
            'host' => TESTS_ZEND_CACHE_MEMCACHED_HOST,
            'port' => TESTS_ZEND_CACHE_MEMCACHED_PORT,
            'persistent' => TESTS_ZEND_CACHE_MEMCACHED_PERSISTENT
        ];
        $serverFail = [
            'host' => 'not.exist',
            'port' => TESTS_ZEND_CACHE_MEMCACHED_PORT,
            'persistent' => TESTS_ZEND_CACHE_MEMCACHED_PERSISTENT
        ];
        $options = [
            'servers' => [$serverValid, $serverFail]
        ];
        $this->_instance = new Zend_Cache_Backend_Memcached($options);
        parent::setUp($notag);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->_instance);
        // We have to wait after a memcache flush
        sleep(1);
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testConstructorCorrectCall()
    {
        $test = new Zend_Cache_Backend_Memcached();
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testCleanModeOld()
    {
        $this->_instance->setDirectives(['logging' => false]);
        $this->_instance->clean('old');
        // do nothing, just to see if an error occured
        $this->_instance->setDirectives(['logging' => true]);
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testCleanModeMatchingTags()
    {
        $this->_instance->setDirectives(['logging' => false]);
        $this->_instance->clean('matchingTag', ['tag1']);
        // do nothing, just to see if an error occured
        $this->_instance->setDirectives(['logging' => true]);
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testCleanModeNotMatchingTags()
    {
        $this->_instance->setDirectives(['logging' => false]);
        $this->_instance->clean('notMatchingTag', ['tag1']);
        // do nothing, just to see if an error occured
        $this->_instance->setDirectives(['logging' => true]);
    }

    public function testGetWithCompression()
    {
        $this->_instance->setOption('compression', true);
        $this->testGetWithAnExistingCacheIdAndUTFCharacters();
    }

    public function testConstructorWithAnAlternativeSyntax()
    {
        $server = [
            'host' => TESTS_ZEND_CACHE_MEMCACHED_HOST,
            'port' => TESTS_ZEND_CACHE_MEMCACHED_PORT,
            'persistent' => TESTS_ZEND_CACHE_MEMCACHED_PERSISTENT
        ];
        $options = [
            'servers' => $server
        ];
        $this->_instance = new Zend_Cache_Backend_Memcached($options);
        $this->testGetWithAnExistingCacheIdAndUTFCharacters();
    }

    // Because of limitations of this backend...
    /**
     * @doesNotPerformAssertions
     */
    public function testGetWithAnExpiredCacheId()
    {
    }
    /**
     * @doesNotPerformAssertions
     */
    public function testCleanModeMatchingTags2()
    {
    }
    /**
     * @doesNotPerformAssertions
     */
    public function testCleanModeNotMatchingTags2()
    {
    }
    /**
     * @doesNotPerformAssertions
     */
    public function testCleanModeNotMatchingTags3()
    {
    }
    /**
     * @doesNotPerformAssertions
     */
    public function testSaveCorrectCall()
    {
        $this->_instance->setDirectives(['logging' => false]);
        parent::testSaveCorrectCall();
        $this->_instance->setDirectives(['logging' => true]);
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testSaveWithNullLifeTime()
    {
        $this->_instance->setDirectives(['logging' => false]);
        parent::testSaveWithNullLifeTime();
        $this->_instance->setDirectives(['logging' => true]);
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testSaveWithSpecificLifeTime()
    {
        $this->_instance->setDirectives(['logging' => false]);
        parent::testSaveWithSpecificLifeTime();
        $this->_instance->setDirectives(['logging' => true]);
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testGetMetadatas($notag = false)
    {
        parent::testGetMetadatas(true);
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testGetFillingPercentage()
    {
        $this->_instance->setDirectives(['logging' => false]);
        parent::testGetFillingPercentage();
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testGetFillingPercentageOnEmptyBackend()
    {
        $this->_instance->setDirectives(['logging' => false]);
        parent::testGetFillingPercentageOnEmptyBackend();
    }
}
