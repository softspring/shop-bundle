<?php

namespace Softspring\ShopBundle\Doctrine\Filter;

use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Filter\SQLFilter;
use Softspring\ShopBundle\Model\OrderInterface;

class OrderCheckoutFilter extends SQLFilter
{
    public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias)
    {
        if ($targetEntity->reflClass->implementsInterface(OrderInterface::class)) {
            return $targetTableAlias.'.checkout_at IS NOT NULL';
        }

        return '';
    }
}