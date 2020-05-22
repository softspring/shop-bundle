<?php

namespace Softspring\ShopBundle\Tests\Model;

use Doctrine\Common\Collections\Collection;
use PHPUnit\Framework\TestCase;
use Softspring\ShopBundle\Model\ShopCustomerInterface;
use Softspring\ShopBundle\Tests\Model\Examples\ShopCustomerSimpleExample;
use Softspring\ShopBundle\Tests\Model\Examples\OrderSimpleExample;
use Softspring\ShopBundle\Tests\Model\Examples\OrderWithCustomerExample;

class ShopCustomerTest extends TestCase
{
    public function testSimpleInterface()
    {
        $customer = new ShopCustomerSimpleExample();
        $this->assertInstanceOf(ShopCustomerInterface::class, $customer);

        // default values
        $this->assertInstanceOf(Collection::class, $customer->getOrders());

        // test entries
        $order1 = new OrderSimpleExample();
        $order2 = new OrderSimpleExample();
        $order3 = new OrderWithCustomerExample();
        $this->assertCount(0, $customer->getOrders());
        $customer->addOrder($order1);
        $this->assertCount(1, $customer->getOrders());
        $customer->addOrder($order2);
        $this->assertCount(2, $customer->getOrders());
        $customer->removeOrder($order2);
        $this->assertCount(1, $customer->getOrders());
        $customer->removeOrder($order2);
        $this->assertCount(1, $customer->getOrders());

        $customer->addOrder($order3);
        $this->assertEquals($customer, $order3->getCustomer());
    }
}
