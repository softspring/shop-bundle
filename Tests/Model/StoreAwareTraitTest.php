<?php

namespace Softspring\ShopBundle\Tests\Model;

use PHPUnit\Framework\TestCase;
use Softspring\ShopBundle\Model\StoreAwareTrait;
use Softspring\ShopBundle\Tests\Model\Examples\StoreSimpleExample;

class StoreAwareTraitTest extends TestCase
{
    public function testTrait()
    {
        $trait = $this->getObjectForTrait(StoreAwareTrait::class);

        $this->assertNull($trait->getStore());

        $store = new StoreSimpleExample();
        $trait->setStore($store);
        $this->assertEquals($store, $trait->getStore());
    }
}