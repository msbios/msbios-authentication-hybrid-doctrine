<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Authentication\Hybrid\Doctrine\Factory;

use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use MSBios\Authentication\Hybrid\Doctrine\Resolver\EmailResolver;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class EmailResolverFactory
 * @package MSBios\Authentication\Hybrid\Doctrine\Factory
 */
class EmailResolverFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return EmailResolver
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new EmailResolver(
            $container->get(EntityManager::class)
        );
    }
}
