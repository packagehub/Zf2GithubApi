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

namespace Zf2GithubApi;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;

/**
 * Zf2GithubApi module.
 *
 * @author Gordon Schmidt <schmidt.gordon@web.de>
 */
class Module implements AutoloaderProviderInterface, ServiceProviderInterface
{
    /**
     * Provide classmap and standard autoloading
     *
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(__DIR__ . '/../../autoload_classmap.php'),
            'Zend\Loader\StandardAutoloader' => array('namespaces' => array(__NAMESPACE__ => __DIR__)),
        );
    }

    /**
     * Provide factory of github client service
     *
     * @return array
     */
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'zf2_github_api.cache' => 'Zf2GithubApi\CacheFactory',
                'zf2_github_api.http' => 'Zf2GithubApi\HttpFactory',
                'zf2_github_api.options' => 'Zf2GithubApi\OptionsFactory',
                'zf2_github_api.service' => 'Zf2GithubApi\ServiceFactory',
            ),
        );
    }
}
