<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Authentication\Hybrid\Doctrine\Factory;

use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use MSBios\Authentication\Hybrid\Doctrine\Resolver\EmailResolver;
use MSBios\Authentication\Hybrid\Doctrine\Resolver\PhoneResolver;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class PhoneResolverFactory
 * @package MSBios\Authentication\Hybrid\Doctrine\Factory
 */
class PhoneResolverFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return PhoneResolver
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new PhoneResolver(
            $container->get(EntityManager::class)
        );
    }
}
