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

use GithubApi\HttpClient\HttpClientInterface;
use Zf2GithubApi\HttpFactory;
use Zend\ServiceManager\ServiceManager;

/**
 * Tests for http client factory.
 *
 * @author Gordon Schmidt <schmidt.gordon@web.de>
 */
class HttpFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Instance of http factory
     * @var HttpFactory
     */
    private $factory;

    /**
     * Instance of service locator
     * @var ServiceManager
     */
    private $serviceLocator;

    /**
     * Initialize http factory and service locator
     */
    public function setUp()
    {
        $this->factory = new HttpFactory();
        $this->serviceLocator = new ServiceManager();
    }

    /**
     * Test the successful createService method of the http factory
     */
    public function testCreateServiceSuccessNoCache()
    {
        $options = (object)array();
        $this->serviceLocator->setService('zf2_github_api.options', $options);
        $httpClient = $this->factory->createService($this->serviceLocator);
        $this->assertInstanceOf('\Github\HttpClient\HttpClientInterface', $httpClient);
    }

    /**
     * Test the successful createService method of the http factory
     */
    public function testCreateServiceSuccessCache()
    {
        $options = (object)array('cache' => (object)array('enabled' => true));
        $this->serviceLocator->setService('zf2_github_api.options', $options);
        $cache = new \Github\HttpClient\Cache\FilesystemCache('/tmp');
        $this->serviceLocator->setService('zf2_github_api.cache', $cache);
        $httpClient = $this->factory->createService($this->serviceLocator);
        $this->assertInstanceOf('\Github\HttpClient\HttpClientInterface', $httpClient);
    }

    /**
     * Test the createService method of the http factory with wrong http class
     *
     * @expectedException \Zf2GithubApi\Exception\InvalidArgumentException
     */
    public function testCreateServicWrongHttpClientClass()
    {
        $options = (object)array('httpClient' => (object)array('class' => '\stdClass'));
        $this->serviceLocator->setService('zf2_github_api.options', $options);
        $this->factory->createService($this->serviceLocator);
    }
}
