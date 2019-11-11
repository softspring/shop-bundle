<?php

namespace Softspring\ShopBundle\Controller\Customer;

use Softspring\CoreBundle\Controller\AbstractController;
use Softspring\CoreBundle\Event\ViewEvent;
use Softspring\ShopBundle\Event\GetResponseCustomerEvent;
use Softspring\ShopBundle\Manager\OrderManagerInterface;
use Softspring\ShopBundle\Model\CustomerInterface;
use Softspring\ShopBundle\Model\OrderHasCustomerInterface;
use Softspring\ShopBundle\Model\OrderInterface;
use Softspring\ShopBundle\SfsShopEvents;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class OrdersController extends AbstractController
{
    /**
     * @var OrderManagerInterface
     */
    protected $orderManager;

    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * OrderController constructor.
     *
     * @param OrderManagerInterface    $orderManager
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(OrderManagerInterface $orderManager, EventDispatcherInterface $eventDispatcher)
    {
        $this->orderManager = $orderManager;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function list(Request $request): Response
    {
        $customer = $this->getCustomer($request);

        if ($response = $this->dispatchGetResponse(SfsShopEvents::CUSTOMER_ORDER_LIST_INITIALIZE, new GetResponseCustomerEvent($customer, $request))) {
            return $response;
        }

        $orders = $this->orderManager->getRepository()->findBy(['customer' => $customer]);

        $viewData = new \ArrayObject([
            'orders' => $orders,
        ]);

        $this->eventDispatcher->dispatch(new ViewEvent($viewData), SfsShopEvents::CUSTOMER_ORDER_LIST_VIEW);

        return $this->render('@SfsShop/customer/order/list.html.twig', $viewData->getArrayCopy());
    }

    /**
     * @param OrderInterface|OrderHasCustomerInterface $order
     * @param Request                                  $request
     *
     * @return Response
     * @throws \Exception
     */
    public function details(OrderInterface $order, Request $request): Response
    {
        $customer = $this->getCustomer($request);

        if ($order->getCustomer() != $customer) {
            throw $this->createAccessDeniedException('You can not access this order');
        }

        $viewData = new \ArrayObject([
            'order' => $order,
        ]);

        // $this->eventDispatcher->dispatch(new ViewEvent($viewData), SfsShopEvents::CUSTOMER_ORDER_LIST_VIEW);

        return $this->render('@SfsShop/customer/order/details.html.twig', $viewData->getArrayCopy());
    }

    /**
     * @param Request $request
     *
     * @return CustomerInterface|null
     */
    protected function getCustomer(Request $request): ?CustomerInterface
    {
        $user = $this->getUser();

        if ($user instanceof CustomerInterface) {
            return $user;
        }

        // TODO SEARCH ALTERNATIVES
        throw new \Exception('Not yet implemented');
    }
}