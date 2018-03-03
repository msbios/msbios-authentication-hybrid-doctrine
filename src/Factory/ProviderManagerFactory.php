<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Authentication\Hybrid\Doctrine\Factory;

use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use MSBios\Authentication\Hybrid\Doctrine\ProviderManager;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class ProviderManagerFactory
 * @package MSBios\Authentication\Hybrid\Doctrine\Factory
 */
class ProviderManagerFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return ProviderManager
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new ProviderManager(
            $container->get(EntityManager::class)
        );
    }
}
