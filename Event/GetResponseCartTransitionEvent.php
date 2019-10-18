<?php

namespace Softspring\ShopBundle\Event;

use Softspring\CoreBundle\Event\GetResponseEventInterface;
use Softspring\CoreBundle\Event\GetResponseTrait;

class GetResponseCartTransitionEvent extends CartTransitionEvent implements GetResponseEventInterface
{
    use GetResponseTrait;
}