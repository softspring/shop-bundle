<?php

namespace Softspring\ShopBundle\Doctrine\Filter;

use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Filter\SQLFilter;
use Softspring\ShopBundle\Model\Filters\MultiStoreFilterInterface;
use Softspring\ShopBundle\Model\Filters\StoreFilterInterface;

class StoreFilter extends SQLFilter
{
    /**
     * @param ClassMetadata $targetEntity
     * @param string        $targetTableAlias
     *
     * @return string
     * @throws \Doctrine\ORM\Mapping\MappingException
     */
    public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias)
    {
        $storeParamName = $this->getParameter('storeParamName');

        if ($targetEntity->reflClass->implementsInterface(StoreFilterInterface::class)) {
            return $targetTableAlias.'.store_id = ' . $this->getParameter($storeParamName);
        }

        if ($targetEntity->reflClass->implementsInterface(MultiStoreFilterInterface::class)) {
            $associationMapping = $targetEntity->getAssociationMapping('stores');
            $joinTable = $associationMapping['joinTable'];
            $joinTableName = $joinTable['name'];
            $joinTableFieldName = $joinTable['joinColumns'][0]['name'];
            $joinTableStoreFieldName = $joinTable['inverseJoinColumns'][0]['name'];
            $filterStore = $this->getParameter($storeParamName);
            return "$targetTableAlias.id IN (SELECT $joinTableFieldName FROM $joinTableName WHERE $joinTableStoreFieldName = $filterStore )";
        }

        return '';
    }
}