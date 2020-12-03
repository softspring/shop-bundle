<?php

namespace Softspring\ShopBundle\Tests\Model;

use Doctrine\Common\Collections\Collection;
use PHPUnit\Framework\TestCase;
use Softspring\ShopBundle\Model\OrderInterface;
use Softspring\ShopBundle\Tests\Model\Examples\OrderEntrySimpleExample;
use Softspring\ShopBundle\Tests\Model\Examples\OrderSimpleExample;
use Softspring\ShopBundle\Tests\Model\Examples\PriceSimpleExample;
use Softspring\ShopBundle\Tests\Model\Examples\SalableItemSimpleExample;

class OrderTest extends TestCase
{
    public function testSimpleInterface()
    {
        $order = new OrderSimpleExample();
        $this->assertInstanceOf(OrderInterface::class, $order);

        // default values
        $this->assertNull($order->getNumber());
        $this->assertNull($order->getStatus());
        $this->assertNull($order->getCheckoutAt());
        $this->assertNull($order->getCurrency());
        $this->assertEquals(0, $order->getTotal());
        $this->assertInstanceOf(Collection::class, $order->getEntries());

        $order->setStatus('new');
        $this->assertEquals('new', $order->getStatus());

        $order->setNumber('P123456');
        $this->assertEquals('P123456', $order->getNumber());

        $order->setCheckoutAt(new \DateTime('2000-01-01 00:00:01'));
        $this->assertEquals('2000-01-01 00:00:01', $order->getCheckoutAt()->format('Y-m-d H:i:s'));

        $order->setCurrency('EUR');
        $this->assertEquals('EUR', $order->getCurrency());

        // test entries
        $entry1 = new OrderEntrySimpleExample();
        $entry2 = new OrderEntrySimpleExample();
        $this->assertCount(0, $order->getEntries());
        $order->addEntry($entry1);
        $this->assertCount(1, $order->getEntries());
        $order->addEntry($entry2);
        $this->assertCount(2, $order->getEntries());
        $order->removeEntry($entry2);
        $this->assertCount(1, $order->getEntries());
        $order->removeEntry($entry2);
        $this->assertCount(1, $order->getEntries());

        $this->assertEquals(0, $order->getTotal());

        $item = new SalableItemSimpleExample();
//        $price = new PriceSimpleExample();
//        $price->setPrice(3);
//        $item->addPrice($price);
        $entry1->getSalableItem($item);

//        $this->assertEquals(0, $order->getTotal());
//        $entry1->setQuantity(1);
//        $this->assertEquals(3, $order->getTotal());

        $order->addEntry($entry2);

        $this->assertEquals($entry1, $order->getEntryByItem($item));
    }
}
