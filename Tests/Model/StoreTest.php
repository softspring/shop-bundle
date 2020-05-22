<?php

namespace Softspring\ShopBundle\Tests\Model;

use Softspring\ShopBundle\Model\StoreInterface;
use Softspring\ShopBundle\Tests\Model\Examples\StoreSimpleExample;
use Softspring\ShopBundle\Tests\Model\Examples\StoreWithCountriesExample;
use PHPUnit\Framework\TestCase;
use Softspring\ShopBundle\Tests\Model\Examples\StoreWithLanguagesExample;

class StoreTest extends TestCase
{
    public function testSimpleInterface()
    {
        $store = new StoreSimpleExample();

        $this->assertInstanceOf(StoreInterface::class, $store);

        $this->assertFalse($store->isEnabled());

        $store->setEnabled(true);
        $this->assertTrue($store->isEnabled());

        $store->setEnabled(false);
        $this->assertFalse($store->isEnabled());

        $store->setCurrency('EUR');
        $this->assertEquals('EUR', $store->getCurrency());
    }

    public function testWithCountries()
    {
        $store = new StoreWithCountriesExample();

        $this->assertInstanceOf(StoreInterface::class, $store);
        $this->assertInstanceOf(StoreWithCountriesExample::class, $store);

        $this->assertEmpty($store->getCountries());

        $countries = ['ES'];
        $store->setCountries($countries);
        $this->assertEquals($countries, $store->getCountries());
    }

    public function testWithLanguages()
    {
        $store = new StoreWithLanguagesExample();

        $this->assertInstanceOf(StoreInterface::class, $store);
        $this->assertInstanceOf(StoreWithLanguagesExample::class, $store);

        $this->assertEmpty($store->getLanguages());

        $langs = ['es', 'en'];
        $store->setLanguages($langs);
        $this->assertEquals($langs, $store->getLanguages());
    }


}
