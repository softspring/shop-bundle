<?php

namespace Softspring\ShopBundle\Event;

use Softspring\CoreBundle\Event\GetResponseEventInterface;
use Softspring\CoreBundle\Event\GetResponseTrait;

class GetResponseCartEvent extends CartEvent implements GetResponseEventInterface
{
    use GetResponseTrait;
}