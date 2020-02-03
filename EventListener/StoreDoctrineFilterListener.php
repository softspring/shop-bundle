<?php

namespace Softspring\ShopBundle\EventListener;

use Doctrine\ORM\EntityManagerInterface;
use Softspring\ShopBundle\Doctrine\Filter\StoreFilter;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class StoreDoctrineFilterListener implements EventSubscriberInterface
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * @var string
     */
    protected $storeRouteParamName;

    /**
     * StoreRequestListener constructor.
     * @param EntityManagerInterface $em
     * @param string $storeRouteParamName
     */
    public function __construct(EntityManagerInterface $em, string $storeRouteParamName)
    {
        $this->em = $em;
        $this->storeRouteParamName = $storeRouteParamName;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => [
                ['onRequestEnableDoctrineStoreFilter', -200],
            ],
        ];
    }

    public function onRequestEnableDoctrineStoreFilter(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        if ($request->attributes->has($this->storeRouteParamName)) {
            $this->em->getConfiguration()->addFilter('store', StoreFilter::class);
            /** @var StoreFilter $filter */
            $filter = $this->em->getFilters()->enable('store');
            $filter->setParameter('storeParamName', $this->storeRouteParamName);
            $filter->setParameter($this->storeRouteParamName, $request->attributes->get($this->storeRouteParamName));
        }
    }
}