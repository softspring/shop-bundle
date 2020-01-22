<?php

namespace Softspring\ShopBundle\Model;

use Softspring\UserBundle\Model\UserInterface;

interface OrderTransitionUserInterface
{
    /**
     * @return UserInterface|null
     */
    public function getUser();

    /**
     * @param UserInterface|null $user
     */
    public function setUser($user): void;
}