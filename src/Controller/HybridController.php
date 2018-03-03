<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Authentication\Hybrid\Doctrine\Controller;

use Doctrine\Common\Persistence\ObjectManager;
use MSBios\Authentication\Hybrid\Adapter;
use MSBios\Authentication\Hybrid\Controller\HybridController as DefaultHybridController;
use MSBios\Authentication\Hybrid\ProviderManagerInterface;
use MSBios\Authentication\IdentityInterface;
use MSBios\Guard\Resource\Doctrine\Entity\User;
use MSBios\Hybridauth\HybridauthManagerInterface;
use Zend\Authentication\AuthenticationServiceInterface;
use Zend\Authentication\Result;

/**
 * Class HybridController
 * @package MSBios\Authentication\Hybrid\Doctrine\Controller
 */
class HybridController extends DefaultHybridController
{
    /**
     *
     */
    public function providerAction()
    {
        /** @var string $identifier */
        $identifier = $this->params()->fromRoute('identifier');

        /** @var \Hybrid_Auth|HybridauthManagerInterface $hybridauthManager */
        $hybridauthManager = $this->getHybridauthManager();

        /** @var \Hybrid_Provider_Adapter $adapter */
        $adapter = $hybridauthManager->authenticate($identifier, [
            'hauth_return_to' => $this->url()->fromRoute('hybridauth/provider/authenticate', [
                'identifier' => $identifier
            ]),
        ]);

        r($adapter->getAccessToken());
        die();
    }

    /**
     *
     */
    public function authenticateAction()
    {
        /** @var string $identifier */
        $identifier = $this->params()->fromRoute('identifier');

        /** @var \Hybrid_Auth|HybridauthManagerInterface $hybridauthManager */
        $hybridauthManager = $this->getHybridauthManager();

        /** @var \Hybrid_Provider_Adapter $hybridauthResult */
        $hybridauthResult = $hybridauthManager->authenticate($identifier);

        /** @var ProviderManagerInterface $providerManager */
        $providerManager = $this->getProviderManager();

        /** @var \Hybrid_User_Profile $userProfile */
        $userProfile = $hybridauthResult->getUserProfile();

        $identity = null;

        if ($provider = $providerManager->find($userProfile, $identifier)) {
            $identity = $provider->getUser();
        } else if ($identity = $this->getIdentityResolver()->find($userProfile)) {
            // ... some
        } else {
            /** @var IdentityInterface $identity */
            $identity = (new User)
                ->setUsername($identifier . $userProfile->identifier)
                ->setFirstname($userProfile->firstName)
                ->setLastname($userProfile->lastName)
                ->setEmail($userProfile->emailVerified)
                ->setCreatedAt(new \DateTime('now'))
                ->setModifiedAt(new \DateTime('now'))
            ;

            /** @var ObjectManager $dem */
            $dem = $this->getProviderManager()->getObjectManager();
            $dem->persist($identity);
            $dem->flush();
        }

        /** @var Result $authenticationResult */
        $authenticationResult = $this->getAuthenticationService()->authenticate(
            new Adapter($identity)
        );

        if ($authenticationResult->isValid()) {
            return $this->redirect()->toRoute('home');
        }

        exit('... need find user or registered empty user');

    }

    /**
     * @return \Zend\Http\Response
     */
    public function addAction()
    {
        /** @var AuthenticationServiceInterface $authenticationService */
        $authenticationService = $this->getAuthenticationService();

        if (!$authenticationService->hasIdentity()) {
            return $this->redirect()->toRoute('home');
        }

        /** @var string $identifier */
        $identifier = $this->params()->fromRoute('identifier');

        /** @var \Hybrid_User_Profile $userProfile */
        $userProfile = $this->getHybridauthManager()
            ->authenticate($identifier)
            ->getUserProfile();

        $this->getProviderManager()->write(
            $authenticationService->getIdentity(),
            $userProfile,
            $identifier
        );

        return $this->redirect()->toRoute('home');
    }
}
