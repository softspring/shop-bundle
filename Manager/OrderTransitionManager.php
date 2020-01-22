<?php

namespace Softspring\ShopBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use Softspring\AdminBundle\Manager\AdminEntityManagerTrait;
use Softspring\ShopBundle\Model\OrderTransitionInterface;

class OrderTransitionManager implements OrderTransitionManagerInterface
{
    use AdminEntityManagerTrait;

    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * OrderTransitionManager constructor.
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getTargetClass(): string
    {
        return OrderTransitionInterface::class;
    }
}