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

use Github\Client;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Service factory.
 *
 * @author Gordon Schmidt <schmidt.gordon@web.de>
 */
class ServiceFactory implements FactoryInterface
{
    /**
     * Create github client service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return Client
     * @throws InvalidArgumentException
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        // create client service
        $options = $serviceLocator->get('zf2_github_api.options');
        $client = new \Github\Client();

        // create http client
        $httpClient = $serviceLocator->get('zf2_github_api.http');
        $client->setHttpClient($httpClient);

        // set authorization
        $useAuth = (isset($options->auth->enabled) && true == $options->auth->enabled);
        if ($useAuth) {
            $tokenOrLogin = isset($options->auth->tokenOrLogin) ? $options->auth->tokenOrLogin : '';
            $password = isset($options->auth->tokenOrLogin) ? $options->auth->tokenOrLogin : '';
            $authMethod = isset($options->auth->tokenOrLogin) ? $options->auth->tokenOrLogin : '';
            $client->authenticate($tokenOrLogin, $password, $authMethod)
        }
        return $client;
    }
}
