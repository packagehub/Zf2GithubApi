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

use Zf2GithubApi\Module;

/**
 * Tests for the Zf2GithubApi module class.
 *
 * @author Gordon Schmidt <schmidt.gordon@web.de>
 */
class ModuleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Instance of module
     * @var Module
     */
    private $module;

    /**
     * Initialize cache factory and service locator
     */
    public function setUp()
    {
        $this->module = new Module();
    }

    /**
     * Test the autoloader config, if provided
     */
    public function testGetAutoloaderConfig()
    {
        if (method_exists($this->module, 'getAutoloaderConfig')) {
            $config = $this->module->getAutoloaderConfig();
            $this->assertNotEmpty($config);
        }
    }

    /**
     * Test the module config, if provided
     */
    public function testGetConfig()
    {
        if (method_exists($this->module, 'getConfig')) {
            $config = $this->module->getConfig();
            $this->assertNotEmpty($config);
        }
    }

    /**
     * Test the service config, if provided
     */
    public function testGetServiceConfig()
    {
        if (method_exists($this->module, 'getServiceConfig')) {
            $config = $this->module->getServiceConfig();
            $this->assertNotEmpty($config);
        }
    }
}
