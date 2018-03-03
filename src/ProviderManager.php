<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Authentication\Hybrid\Doctrine;

use Doctrine\Common\Persistence\ObjectManager;
use MSBios\Authentication\Hybrid\ProviderManagerInterface;
use MSBios\Authentication\Hybrid\Resource\Doctrine\Entity\Provider;
use MSBios\Authentication\IdentityInterface;
use MSBios\Doctrine\ObjectManagerAwareTrait;
use MSBios\Resource\Doctrine\EntityInterface;

/**
 * Class ProviderManager
 * @package MSBios\Authentication\Hybrid\Doctrine
 */
class ProviderManager implements ProviderManagerInterface
{
    use ObjectManagerAwareTrait;

    /**
     * ProviderManager constructor.
     * @param ObjectManager $objectManager
     */
    public function __construct(ObjectManager $objectManager)
    {
        $this->setObjectManager($objectManager);
    }

    /**
     * @param \Hybrid_User_Profile $profile
     * @param $identifier
     * @param IdentityInterface|null $identity
     * @return null|object
     */
    public function find(\Hybrid_User_Profile $profile, $identifier, IdentityInterface $identity = null)
    {
        /** @var array $criteria */
        $criteria = [
            'identifier' => $profile->identifier,
            'name' => $identifier
        ];

        if (! is_null($identity)) {
            $criteria['user'] = $identity;
        }

        return $this->getObjectManager()
            ->getRepository(Provider::class)
            ->findOneBy($criteria);
    }

    /**
     * @param IdentityInterface $identity
     * @param \Hybrid_User_Profile $profile
     * @param $identifier
     */
    public function write(IdentityInterface $identity, \Hybrid_User_Profile $profile, $identifier)
    {
        if (! $this->find($profile, $identifier, $identity)) {

            /** @var EntityInterface $entity */
            $entity = (new Provider)
                ->setUser($identity)
                ->setIdentifier($profile->identifier)
                ->setName($identifier)
                ->setCreatedAt(new \DateTime('now'))
                ->setModifiedAt(new \DateTime('now'));

            /** @var ObjectManager $dem */
            $dem = $this->getObjectManager();
            $dem->persist($entity);
            $dem->flush();
        }
    }
}
