<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Authentication\Hybrid\Doctrine\Controller;

use MSBios\Authentication\Hybrid\Controller\IndexController as DefaultIndexController;
use MSBios\Guard\GuardInterface;
use Zend\Permissions\Acl\Resource\ResourceInterface;

/**
 * Class IndexController
 * @package MSBios\Authentication\Hybrid\Doctrine\Controller
 */
class IndexController extends DefaultIndexController implements
    GuardInterface,
    ResourceInterface
{

    /**
     * @inheritdoc
     *
     * @return string
     */
    public function getResourceId()
    {
        return self::class;
    }
}
