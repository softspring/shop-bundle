<?php

namespace Softspring\ShopBundle\Event;

use Softspring\CoreBundle\Event\GetResponseEventInterface;
use Softspring\CoreBundle\Event\GetResponseTrait;

class GetCartItemEvent extends CartItemEvent implements GetResponseEventInterface
{
    use GetResponseTrait;
}