<?php

namespace Softspring\ShopBundle\Tests\Model;

use Doctrine\Common\Collections\Collection;
use PHPUnit\Framework\TestCase;
use Softspring\ShopBundle\Tests\Model\Examples\MultiStoreObject;
use Softspring\ShopBundle\Tests\Model\Examples\StoreSimpleExample;

class MultiStoreTraitTest extends TestCase
{
    public function testTrait()
    {
        $trait = new MultiStoreObject();

        // default values
        $this->assertInstanceOf(Collection::class, $trait->getStores());

        // test stores
        $store1 = new StoreSimpleExample();
        $store2 = new StoreSimpleExample();
        $this->assertCount(0, $trait->getStores());
        $trait->addStore($store1);
        $this->assertCount(1, $trait->getStores());
        $trait->addStore($store2);
        $this->assertCount(2, $trait->getStores());
        $trait->removeStore($store2);
        $this->assertCount(1, $trait->getStores());
        $trait->removeStore($store2);
        $this->assertCount(1, $trait->getStores());
    }
}