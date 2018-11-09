<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Authentication\Hybrid\Doctrine\Factory;

use Interop\Container\ContainerInterface;
use MSBios\Authentication\Hybrid\Controller\HybridController as DefaultHybridController;
use MSBios\Authentication\Hybrid\Doctrine\Controller\HybridController;
use MSBios\Authentication\Hybrid\Factory\HybridControllerFactory as DefaultHybridControllerFactory;
use Zend\Mvc\Controller\AbstractController;

/**
 * Class HybridControllerFactory
 * @package MSBios\Authentication\Hybrid\Doctrine\Factory
 */
class HybridControllerFactory extends DefaultHybridControllerFactory
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return DefaultHybridController|HybridController
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var AbstractController|DefaultHybridController $defaultController */
        $defaultController = parent::__invoke($container, $requestedName, $options);

        return new HybridController(
            $defaultController->getAuthenticationService(),
            $defaultController->getHybridauthManager(),
            $defaultController->getProviderManager(),
            $defaultController->getIdentityResolver()
        );
    }
}
