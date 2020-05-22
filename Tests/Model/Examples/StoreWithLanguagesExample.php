<?php

namespace Softspring\ShopBundle\Tests\Model\Examples;

use Softspring\ShopBundle\Model\Store;
use Softspring\ShopBundle\Model\StoreLanguagesInterface;
use Softspring\ShopBundle\Model\StoreLanguagesTrait;

class StoreWithLanguagesExample extends Store implements StoreLanguagesInterface
{
    use StoreLanguagesTrait;
}