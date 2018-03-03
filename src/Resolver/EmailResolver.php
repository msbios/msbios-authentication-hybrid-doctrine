<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Authentication\Hybrid\Doctrine\Resolver;

use Doctrine\Common\Persistence\ObjectManager;
use MSBios\Authentication\Hybrid\Resolver\EmailResolver as DefaultEmailResolver;
use MSBios\Doctrine\ObjectManagerAwareTrait;
use MSBios\Guard\Resource\Doctrine\UserInterface;

/**
 * Class EmailResolver
 * @package MSBios\Authentication\Hybrid\Doctrine\Resolver
 */
class EmailResolver extends DefaultEmailResolver
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
     * @return null|object
     */
    public function find(\Hybrid_User_Profile $profile)
    {
        return $this->getObjectManager()
            ->getRepository(UserInterface::class)
            ->findOneBy([
                'email' => $profile->emailVerified
            ]);
    }
}
