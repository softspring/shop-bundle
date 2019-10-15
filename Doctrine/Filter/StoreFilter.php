<?php

namespace Softspring\ShopBundle\Doctrine\Filter;

use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Filter\SQLFilter;
use Softspring\ShopBundle\Model\StoreFilterInterface;

class StoreFilter extends SQLFilter
{
    public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias)
    {
        if (!$targetEntity->reflClass->implementsInterface(StoreFilterInterface::class)) {
            return '';
        }

        return $targetTableAlias.'.store_id = ' . $this->getParameter('_store');
    }
}