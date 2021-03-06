<?php

namespace Softspring\ShopBundle\Event;

use Softspring\CoreBundle\Event\GetResponseEventInterface;
use Softspring\CoreBundle\Event\GetResponseTrait;

class GetResponseCustomerEvent extends CustomerEvent implements GetResponseEventInterface
{
    use GetResponseTrait;
}