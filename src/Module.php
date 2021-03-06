<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Authentication\Hybrid\Doctrine;

use MSBios\AutoloaderAwareInterface;
use MSBios\AutoloaderAwareTrait;
use MSBios\ModuleAwareInterface;
use MSBios\ModuleAwareTrait;
use MSBios\ModuleInterface;
use Zend\Authentication\AuthenticationService;
use Zend\EventManager\EventInterface;
use Zend\Loader\AutoloaderFactory;
use Zend\Loader\StandardAutoloader;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;

/**
 * Class Module
 * @package MSBios\Authentication\Hybrid\Doctrine
 */
class Module implements
    ModuleInterface,
    ModuleAwareInterface,
    AutoloaderAwareInterface,
    BootstrapListenerInterface
{
    /** @const VERSION */
    const VERSION = '1.0.3';

    /**
     * Returns configuration to merge with application configuration
     *
     * @return array|\Traversable
     */
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    /**
     * Return an array for passing to Zend\Loader\AutoloaderFactory.
     *
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return [
            AutoloaderFactory::STANDARD_AUTOLOADER => [
                StandardAutoloader::LOAD_NS => [
                    __NAMESPACE__ => __DIR__,
                ],
            ],
        ];
    }

    /**
     * Listen to the bootstrap event
     *
     * @param EventInterface $e
     * @return array
     */
    public function onBootstrap(EventInterface $e)
    {
        // var_dump($e->getTarget()->getServiceManager()->get(AuthenticationService::class)->hasIdentity()); die();
    }
}
