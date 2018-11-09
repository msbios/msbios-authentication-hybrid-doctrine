<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Authentication\Hybrid\Doctrine\Controller;

use MSBios\Authentication\Hybrid\Controller\HybridController as DefaultHybridController;
use MSBios\Authentication\Hybrid\Doctrine\Adapter;
use MSBios\Authentication\Hybrid\Doctrine\Result;
use Zend\Authentication\Adapter\AdapterInterface;

/**
 * Class HybridController
 * @package MSBios\Authentication\Hybrid\Doctrine\Controller
 */
class HybridController extends DefaultHybridController
{
    /**
     * @return \Zend\Http\Response
     */
    public function authenticateAction()
    {
        /** @var string $identifier */
        $identifier = $this->params()->fromRoute('identifier');

        /** @var AdapterInterface|Adapter $adapter */
        $adapter = new Adapter(
            $this->getHybridauthManager(),
            $this->getProviderManager(),
            $this->getIdentityResolver(),
            $this->params()->fromRoute('identifier')
        );

        /** @var Result $authenticationResult */
        $authenticationResult = $this->getAuthenticationService()
            ->authenticate($adapter);

        if ($authenticationResult->isValid()) {
            $this->writeProvider(
                $authenticationResult->getIdentity(),
                $authenticationResult->getUserProfile(),
                $identifier
            );
        }

        return $this->redirect()->toRoute('home');
    }

    ///**
    // * @return \Zend\Http\Response
    // */
    //public function addAction()
    //{
    //    /** @var AuthenticationServiceInterface $authenticationService */
    //    $authenticationService = $this->getAuthenticationService();
    //
    //    if (! $authenticationService->hasIdentity()) {
    //        return $this->redirect()->toRoute('home');
    //    }
    //
    //    /** @var string $identifier */
    //    $identifier = $this->params()->fromRoute('identifier');
    //
    //    /** @var \Hybrid_User_Profile $userProfile */
    //    $userProfile = $this->getHybridauthManager()
    //        ->authenticate($identifier)
    //        ->getUserProfile();
    //
    //    $this->writeProvider(
    //        $authenticationService->getIdentity(),
    //        $userProfile,
    //        $identifier
    //    );
    //
    //    return $this->redirect()->toRoute('home');
    //}

    ///**
    // * @param IdentityInterface $identity
    // * @param \Hybrid_User_Profile $userProfile
    // * @param $identifier
    // * @return mixed
    // */
    //protected function writeProvider(IdentityInterface $identity, \Hybrid_User_Profile $userProfile, $identifier)
    //{
    //    return $this->getProviderManager()->write(
    //        $identity,
    //        $userProfile,
    //        $identifier
    //    );
    //}
}
