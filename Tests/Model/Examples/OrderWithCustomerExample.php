<?php

namespace Softspring\ShopBundle\Tests\Model\Examples;

use Softspring\ShopBundle\Model\Order;
use Softspring\ShopBundle\Model\OrderHasCustomerInterface;
use Softspring\ShopBundle\Model\OrderHasCustomerTrait;

class OrderWithCustomerExample extends Order implements OrderHasCustomerInterface
{
    use OrderHasCustomerTrait;
}