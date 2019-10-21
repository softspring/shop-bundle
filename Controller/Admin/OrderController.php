<?php

namespace Softspring\ShopBundle\Controller\Admin;

use Softspring\CoreBundle\Event\GetResponseFormEvent;
use Softspring\CoreBundle\Event\ViewEvent;
use Softspring\ExtraBundle\Controller\AbstractController;
use Softspring\ShopBundle\Event\GetResponseOrderTransitionEvent;
use Softspring\ShopBundle\Manager\OrderManagerInterface;
use Softspring\ShopBundle\Model\OrderInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends AbstractController
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
     * @param OrderInterface $order
     * @param string         $transition
     * @param Request        $request
     *
     * @return Response
     */
    public function transition(OrderInterface $order, string $transition, Request $request): Response
    {
        $transitionMetadata = $this->orderManager->getOrderTransitionMetadata($transition, $order);

        if ($response = $this->dispatchGetResponse("sfs_shop.admin.orders.transition.{$transition}.initialize", new GetResponseOrderTransitionEvent($transition, $transitionMetadata, $order, $request))) {
            return $response;
        }

        // if configured, check user role before running the transition
        if (!empty($transitionMetadata['is_granted'])) {
            $this->denyAccessUnlessGranted($transitionMetadata['is_granted'], $order);
        }

        $viewData = new \ArrayObject(['order' => $order]);

        if (!empty($transitionMetadata['form'])) {
            $form = $this->createForm($transitionMetadata['form'], $order)->handleRequest($request);

            if ($form->isSubmitted()) {
                if ($form->isValid()) {
                    if ($response = $this->dispatchGetResponse("sfs_shop.admin.orders.transition.{$transition}.form_valid", new GetResponseFormEvent($form, $request))) {
                        return $response;
                    }

                    if ($response = $this->applyTransition($transition, $transitionMetadata, $order, $request)) {
                        return $response;
                    }
                } else {
                    if ($response = $this->dispatchGetResponse("sfs_shop.admin.orders.transition.{$transition}.form_invalid", new GetResponseFormEvent($form, $request))) {
                        return $response;
                    }
                }
            }

            $viewData['form'] = $form->createView();
        } else {
            if ($response = $this->applyTransition($transition, $transitionMetadata, $order, $request)) {
                return $response;
            }
        }

        $this->eventDispatcher->dispatch(new ViewEvent($viewData), "sfs_shop.admin.orders.transition.{$transition}.view");

        return $this->render('@SfsShop/admin/orders/'.$transition.'.html.twig', $viewData->getArrayCopy());
    }

    /**
     * @param string         $transition
     * @param array          $transitionMetadata
     * @param OrderInterface $order
     * @param Request        $request
     *
     * @return Response|null
     * @throws \Exception
     */
    private function applyTransition(string $transition, array $transitionMetadata, OrderInterface $order, Request $request): ?Response
    {
        if ($response = $this->dispatchGetResponse("sfs_shop.admin.orders.transition.{$transition}.before", new GetResponseOrderTransitionEvent($transition, $transitionMetadata, $order, $request))) {
            return $response;
        }

        // if no form is required, apply transition directly
        if (!$this->orderManager->transition($transition, $order)) {
            // error
        }

        if ($response = $this->dispatchGetResponse("sfs_shop.admin.orders.transition.{$transition}.after", new GetResponseOrderTransitionEvent($transition, $transitionMetadata, $order, $request))) {
            return $response;
        }

        if (!empty($transitionMetadata['on_terminate_goto_transition'])) {
            return $this->redirectToRoute('sfs_shop_admin_orders_transition', [
                'order' => $order,
                'transition' => $transitionMetadata['on_terminate_goto_transition'],
            ]);
        }

        if (!empty($transitionMetadata['on_terminate_redirect'])) {
            if (!empty($transitionMetadata['on_terminate_redirect_params'])) {
                foreach ($transitionMetadata['on_terminate_redirect_params'] as $param => $value) {
                    switch ($value) {
                        case '__order_object__':
                            $transitionMetadata['on_terminate_redirect_params'][$param] = $order;
                            break;
                    }
                }
            }

            return $this->redirectToRoute($transitionMetadata['on_terminate_redirect'], $transitionMetadata['on_terminate_redirect_params'] ?? []);
        }

        return null;
    }
}