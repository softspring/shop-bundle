<?php

namespace Softspring\ShopBundle\Event;

use Softspring\CoreBundle\Event\GetResponseEventInterface;
use Softspring\CoreBundle\Event\GetResponseTrait;

class GetResponseOrderEvent extends OrderEvent implements GetResponseEventInterface
{
    use GetResponseTrait;
}