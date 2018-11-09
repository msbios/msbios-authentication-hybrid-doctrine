<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Authentication\Hybrid\Doctrine;

use MSBios\Authentication\IdentityInterface;
use Zend\Authentication\Result as DefaultResult;

/**
 * Class Result
 * @package MSBios\Authentication\Hybrid\Doctrine
 */
class Result extends DefaultResult
{
    /** @var \Hybrid_User_Profile */
    protected $userProfile;

    /**
     * Result constructor.
     * @param int $code
     * @param IdentityInterface $identity
     * @param array $messages
     * @param \Hybrid_User_Profile|null $userProfile
     */
    public function __construct(int $code, IdentityInterface $identity, array $messages = [], \Hybrid_User_Profile $userProfile = null)
    {
        parent::__construct($code, $identity, $messages);
        $this->userProfile = $userProfile;
    }

    /**
     * @return \Hybrid_User_Profile|null
     */
    public function getUserProfile()
    {
        return $this->userProfile;
    }

    /**
     * @param \Hybrid_User_Profile $userProfile
     * @return $this
     */
    public function setUserProfile(\Hybrid_User_Profile $userProfile)
    {
        $this->userProfile = $userProfile;
        return $this;
    }
}
