<?php

namespace Softspring\ShopBundle\Event;

use Softspring\CoreBundle\Event\GetResponseEventInterface;
use Softspring\CoreBundle\Event\GetResponseTrait;

class GetResponseOrderTransitionEvent extends OrderTransitionEvent implements GetResponseEventInterface
{
    use GetResponseTrait;
}