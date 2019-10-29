<?php

namespace Softspring\ShopBundle\Model;

interface StoreSimpleCountriesInterface
{
    /**
     * @return array
     */
    public function getCountries(): array;

    /**
     * @param array $countries
     */
    public function setCountries(array $countries): void;
}