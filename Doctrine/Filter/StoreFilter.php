<?php

namespace Softspring\ShopBundle\Doctrine\Filter;

use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Filter\SQLFilter;
use Softspring\ShopBundle\Model\MultiStoreFilterInterface;
use Softspring\ShopBundle\Model\StoreFilterInterface;

class StoreFilter extends SQLFilter
{
    public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias)
    {
        if ($targetEntity->reflClass->implementsInterface(StoreFilterInterface::class)) {
            return $targetTableAlias.'.store_id = ' . $this->getParameter('_store');
        }

        if ($targetEntity->reflClass->implementsInterface(MultiStoreFilterInterface::class)) {
            $associationMapping = $targetEntity->getAssociationMapping('stores');
            $joinTable = $associationMapping['joinTable'];
            $joinTableName = $joinTable['name'];
            $joinTableFieldName = $joinTable['joinColumns'][0]['name'];
            $joinTableStoreFieldName = $joinTable['inverseJoinColumns'][0]['name'];
            $filterStore = $this->getParameter('_store');
            return "$targetTableAlias.id IN (SELECT $joinTableFieldName FROM $joinTableName WHERE $joinTableStoreFieldName = $filterStore )";
        }

        return '';
    }
}