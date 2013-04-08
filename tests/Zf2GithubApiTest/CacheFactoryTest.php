<?php
/**
 * This file is part of Zf2GithubApi.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Copyright (c) 2013 Gordon Schmidt
 * @license   MIT
 */

namespace Zf2GithubApiTest;

use GithubApi\HttpClient\Cache\CacheInterface;
use Zf2GithubApi\CacheFactory;
use Zend\ServiceManager\ServiceManager;

/**
 * Tests for cache factory.
 *
 * @author Gordon Schmidt <schmidt.gordon@web.de>
 */
class CacheFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Instance of cache factory
     * @var CacheFactory
     */
    private $factory;

    /**
     * Instance of service locator
     * @var ServiceManager
     */
    private $serviceLocator;

    /**
     * Initialize cache factory and service locator
     */
    public function setUp()
    {
        $this->factory = new CacheFactory();
        $this->serviceLocator = new ServiceManager();
    }

    /**
     * Test the successful createService method of the cache factory
     */
    public function testCreateServiceSuccess()
    {
        $options = (object)array('cache' => (object)array('params' => (object)array('path' => '/tmp')));
        $this->serviceLocator->setService('zf2_github_api.options', $options);
        $cache = $this->factory->createService($this->serviceLocator);
        $this->assertInstanceOf('\Github\HttpClient\Cache\CacheInterface', $cache);
    }

    /**
     * Test the createService method of the cache factory with wrong cache class
     *
     * @expectedException \Zf2GithubApi\Exception\InvalidArgumentException
     */
    public function testCreateServicWrongCacheClass()
    {
        $options = (object)array('cache' => (object)array('class' => '\stdClass'));
        $this->serviceLocator->setService('zf2_github_api.options', $options);
        $this->factory->createService($this->serviceLocator);
    }
}
