<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Authentication\Hybrid\Doctrine\Resolver;


use Doctrine\Common\Persistence\ObjectManager;
use MSBios\Authentication\Hybrid\Resolver\EmailResolver as DefaultEmailResolver;
use MSBios\Doctrine\ObjectManagerAwareTrait;

/**
 * Class PhoneResolver
 * @package MSBios\Authentication\Hybrid\Doctrine\Resolver
 */
class PhoneResolver extends DefaultEmailResolver
{
    use ObjectManagerAwareTrait;

    /**
     * EmailResolver constructor.
     * @param ObjectManager $objectManager
     */
    public function __construct(ObjectManager $objectManager)
    {
        $this->setObjectManager($objectManager);
    }

    /**
     * @param \Hybrid_User_Profile $profile
     */
    public function find(\Hybrid_User_Profile $profile)
    {
        exit('Find by phone');
    }

}