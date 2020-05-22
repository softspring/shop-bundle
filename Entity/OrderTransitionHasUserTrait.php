<?php

namespace Softspring\ShopBundle\Entity;

use Softspring\UserBundle\Model\UserInterface;
use Softspring\ShopBundle\Model\OrderTransitionHasUserTrait as OrderTransitionHasUserTraitModel;

trait OrderTransitionHasUserTrait
{
    use OrderTransitionHasUserTraitModel;

    /**
     * @var UserInterface|null
     * @ORM\ManyToOne(targetEntity="Softspring\UserBundle\Model\UserInterface")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $user;
}