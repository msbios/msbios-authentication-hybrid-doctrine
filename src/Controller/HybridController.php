<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Authentication\Hybrid\Doctrine\Controller;

use MSBios\Authentication\Hybrid\Controller\HybridController as DefaultHybridController;
use MSBios\Hybridauth\HybridauthManagerInterface;

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
        parent::providerAction();

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

        r($adapter->getAccessToken()); die();
    }

    /**
     * @return \Zend\Http\Response
     */
    public function clearAction()
    {
        return parent::clearAction(); // TODO: Change the autogenerated stub
    }
}