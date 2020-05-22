<?php

namespace Softspring\ShopBundle\Model;

use Softspring\UserBundle\Model\UserInterface;

trait OrderTransitionHasUserTrait
{
    /**
     * @var UserInterface|null
     */
    protected $user;

    /**
     * @return UserInterface|null
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param UserInterface|null $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }
}