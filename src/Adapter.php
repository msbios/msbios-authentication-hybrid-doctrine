<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Authentication\Hybrid\Doctrine;

use Doctrine\Common\Persistence\ObjectManager;
use MSBios\Authentication\Hybrid\IdentityResolver;
use MSBios\Authentication\Hybrid\IdentityResolverAwareInterface;
use MSBios\Authentication\Hybrid\IdentityResolverAwareTrait;
use MSBios\Authentication\Hybrid\ProviderManagerAwareInterface;
use MSBios\Authentication\Hybrid\ProviderManagerAwareTrait;
use MSBios\Authentication\Hybrid\ProviderManagerInterface;
use MSBios\Authentication\IdentityInterface;
use MSBios\Guard\Resource\Doctrine\UserInterface;
use MSBios\Hybridauth\HybridauthManagerAwareInterface;
use MSBios\Hybridauth\HybridauthManagerAwareTrait;
use MSBios\Hybridauth\HybridauthManagerInterface;
use Zend\Authentication\Adapter\AdapterInterface;

/**
 * Class Adapter
 * @package MSBios\Authentication\Hybrid\Doctrine
 */
class Adapter implements
    AdapterInterface,
    HybridauthManagerAwareInterface,
    ProviderManagerAwareInterface,
    IdentityResolverAwareInterface
{
    use HybridauthManagerAwareTrait;
    use ProviderManagerAwareTrait;
    use IdentityResolverAwareTrait;

    protected $identifier = null;

    /**
     * Adapter constructor.
     * @param HybridauthManagerInterface $hybridauthManager
     * @param ProviderManagerInterface $providerManager
     * @param IdentityResolver $identityResolver
     * @param null $identifier
     */
    public function __construct(
        HybridauthManagerInterface $hybridauthManager,
        ProviderManagerInterface $providerManager,
        IdentityResolver $identityResolver,
        $identifier = null
    ) {
        $this->setHybridauthManager($hybridauthManager);
        $this->setProviderManager($providerManager);
        $this->setIdentityResolver($identityResolver);
        $this->identifier = $identifier;
    }

    /**
     * @param $identifier
     * @return $this
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
        return $this;
    }

    /**
     * @param null $identifier
     * @return void|\Zend\Authentication\Result
     */
    public function authenticate($identifier = null)
    {
        /** @var string $identifier */
        $identifier = $identifier
            ?: $this->identifier;

        /** @var \Hybrid_Provider_Adapter $hybridauthResult */
        $hybridauthResult = $this->hybridauthManager
            ->authenticate($identifier);

        /** @var \Hybrid_User_Profile $userProfile */
        $userProfile = $hybridauthResult->getUserProfile();

        /** @var IdentityInterface $identity */
        $identity = $this->find($userProfile, $identifier);

        return new Result(Result::SUCCESS, $identity, ['Authentication successful.'], $userProfile);
    }

    /**
     * @param $userProfile
     * @param $identifier
     */
    protected function find($userProfile, $identifier)
    {
        /** @var ProviderManagerInterface $providerManager */
        $providerManager = $this->getProviderManager();

        if ($provider = $providerManager->find($userProfile, $identifier)) {
            return $provider->getUser();
        }

        $identity = $this->getIdentityResolver()
            ->find($userProfile);

        if ($identity) {
            return $identity;
        }

        /** @var ObjectManager $dem */
        $dem = $providerManager->getObjectManager();

        /** @var IdentityInterface $identity */
        $identity = $dem->getMetadataFactory()
            ->getMetadataFor(ltrim(UserInterface::class, '\\'))
            ->newInstance();

        $identity->setUsername($identifier . $userProfile->identifier)
            ->setFirstname($userProfile->firstName)
            ->setLastname($userProfile->lastName)
            ->setEmail($userProfile->emailVerified)
            ->setCreatedAt(new \DateTime('now'))
            ->setModifiedAt(new \DateTime('now'));

        /** @var ObjectManager $dem */
        $dem = $providerManager->getObjectManager();
        $dem->persist($identity);
        $dem->flush();

        return $identity;
    }
}
