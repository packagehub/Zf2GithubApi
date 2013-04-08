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

use Zf2GithubApi\OptionsFactory;
use Zend\ServiceManager\ServiceManager;

/**
 * Tests for options factory.
 *
 * @author Gordon Schmidt <schmidt.gordon@web.de>
 */
class OptionsFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Instance of options factory
     * @var OptionsFactory
     */
    private $factory;

    /**
     * Instance of service locator
     * @var ServiceManager
     */
    private $serviceLocator;

    /**
     * Initialize options factory and service locator
     */
    public function setUp()
    {
        $this->factory = new OptionsFactory();
        $this->serviceLocator = new ServiceManager();
    }

    /**
     * Test the createService method of the options factory
     *
     * @dataProvider configProvider
     * @param array $configArray
     * @param object $configObject
     */
    public function testCreateService($configArray, $configObject)
    {
        $this->serviceLocator->setService('Config', $configArray);
        $options = $this->factory->createService($this->serviceLocator);
        $this->assertEquals($configObject, $options);
    }

    /**
     * Provide data to the method testCreateService
     *
     * @return array
     */
    public static function configProvider()
    {
        return array(
            array(array('zf2_github_api' => 100), 100),
            array(array('zf2_github_api' => array()), (object)array()),
            array(array('zf2_github_api' => array(100)), (object)array()),
            array(array('zf2_github_api' => array('foo' => 100)), (object)array('foo' => 100)),
            array(array('zf2_github_api' => array('foo_bar' => 100)), (object)array('fooBar' => 100)),
            array(array('zf2_github_api' => array('foo' => array('bar' => 100))), (object)array('foo' => (object)array('bar' => 100))),
            array(array('zf2_github_api' => array('foo.bar' => 100)), (object)array('foo' => (object)array('bar' => 100))),
            array(array('zf2_github_api' => array('foo.bar' => 100, 'foo.narf' => true)), (object)array('foo' => (object)array('bar' => 100, 'narf' => true))),
        );
    }
}
