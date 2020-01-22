<?php

namespace Softspring\ShopBundle\Entity;

use Softspring\UserBundle\Model\UserInterface;

trait OrderTransitionHasUserTrait
{
    /**
     * @var UserInterface|null
     * @ORM\ManyToOne(targetEntity="Softspring\UserBundle\Model\UserInterface")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="SET NULL")
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