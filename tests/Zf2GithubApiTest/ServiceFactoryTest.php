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

use GithubApi\Client;
use Github\HttpClient\HttpClientInterface;
use Zf2GithubApi\ServiceFactory;
use Zend\ServiceManager\ServiceManager;

/**
 * Tests for service factory.
 *
 * @author Gordon Schmidt <schmidt.gordon@web.de>
 */
class ServiceFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Instance of service factory
     * @var ServiceFactory
     */
    private $factory;

    /**
     * Instance of service locator
     * @var ServiceManager
     */
    private $serviceLocator;

    /**
     * Initialize service factory and service locator
     */
    public function setUp()
    {
        $this->factory = new ServiceFactory();
        $this->serviceLocator = new ServiceManager();
    }

    /**
     * Test the successful createService method of the service factory with empty config
     */
    public function testCreateServiceSuccessEmptyConfig()
    {
        $options = (object)array();
        $this->serviceLocator->setService('zf2_github_api.options', $options);
        $http = $this->getMock('\Github\HttpClient\HttpClientInterface');
        $this->serviceLocator->setService('zf2_github_api.http', $http);
        $service = $this->factory->createService($this->serviceLocator);
        $this->assertInstanceOf('\Github\Client', $service);
    }

    /**
     * Test the successful createService method of the service factory with authorization
     */
    public function testCreateServiceSuccessWithAuth()
    {
        $options = (object)array('auth' => (object)array('enabled' => true));
        $this->serviceLocator->setService('zf2_github_api.options', $options);
        $http = $this->getMock('\Github\HttpClient\HttpClientInterface');
        $this->serviceLocator->setService('zf2_github_api.http', $http);
        $service = $this->factory->createService($this->serviceLocator);
        $this->assertInstanceOf('\Github\Client', $service);
    }
}
