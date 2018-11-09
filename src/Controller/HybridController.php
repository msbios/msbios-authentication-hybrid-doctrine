<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Authentication\Hybrid\Doctrine\Controller;

use MSBios\Authentication\Hybrid\Controller\HybridController as DefaultHybridController;
use MSBios\Authentication\Hybrid\Doctrine\Adapter;
use MSBios\Authentication\Hybrid\Doctrine\Result;
use MSBios\Guard\GuardInterface;
use Zend\Authentication\Adapter\AdapterInterface;

/**
 * Class HybridController
 * @package MSBios\Authentication\Hybrid\Doctrine\Controller
 */
class HybridController extends DefaultHybridController implements GuardInterface
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
}
