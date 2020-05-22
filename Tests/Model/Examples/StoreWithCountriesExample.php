<?php

namespace Softspring\ShopBundle\Tests\Model\Examples;

use Softspring\ShopBundle\Model\Store;
use Softspring\ShopBundle\Model\StoreSimpleCountriesInterface;
use Softspring\ShopBundle\Model\StoreSimpleCountriesTrait;

class StoreWithCountriesExample extends Store implements StoreSimpleCountriesInterface
{
    use StoreSimpleCountriesTrait;
}