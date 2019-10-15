<?php

namespace Softspring\ShopBundle\EventListener;

use Doctrine\ORM\EntityManagerInterface;
use Softspring\ShopBundle\Model\StoreInterface;
use Softspring\ShopBundle\Twig\AppVariable;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\RouterInterface;

class StoreRequestListener implements EventSubscriberInterface
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
     * @var RouterInterface
     */
    protected $router;

    /**
     * @var AppVariable
     */
    protected $twigAppVariable;

    /**
     * @var string
     */
    protected $findParamName;

    /**
     * StoreRequestListener constructor.
     * @param EntityManagerInterface $em
     * @param string $storeRouteParamName
     * @param RouterInterface $router
     * @param AppVariable $twigAppVariable
     * @param string $findParamName
     */
    public function __construct(EntityManagerInterface $em, string $storeRouteParamName, RouterInterface $router, AppVariable $twigAppVariable, string $findParamName)
    {
        $this->em = $em;
        $this->storeRouteParamName = $storeRouteParamName;
        $this->router = $router;
        $this->twigAppVariable = $twigAppVariable;
        $this->findParamName = $findParamName;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => [
                ['onRequestGetStore', 30], // router listener has 32
            ],
        ];
    }

    /**
     * @param GetResponseEvent $event
     * @throws UnauthorizedHttpException
     */
    public function onRequestGetStore(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        if ($request->attributes->has($this->storeRouteParamName)) {
            $store = $request->attributes->get($this->storeRouteParamName);

            if (!$store) {
                // hide not found with an unauthorized response
                throw new UnauthorizedHttpException('', 'Empty _store');
            }

            $store = $this->em->getRepository(StoreInterface::class)->findOneBy([$this->findParamName => $store]);

            if (!$store) {
                // hide not found with an unauthorized response
                throw new UnauthorizedHttpException('', 'Store not found');
            }

            $request->attributes->set($this->storeRouteParamName, $store);

            $context = $this->router->getContext();
            $context->setParameter('_store', $store);

            $this->twigAppVariable->setStore($store);
        }
    }
}