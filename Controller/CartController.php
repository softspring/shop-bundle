<?php

namespace Softspring\ShopBundle\Controller;

use Softspring\CoreBundle\Event\GetResponseFormEvent;
use Softspring\CoreBundle\Event\ViewEvent;
use Softspring\ExtraBundle\Controller\AbstractController;
use Softspring\ShopBundle\Event\GetResponseCartTransitionEvent;
use Softspring\ShopBundle\Manager\CartManagerInterface;
use Softspring\ShopBundle\Model\OrderInterface;
use Softspring\ShopBundle\Model\SalableItemInterface;
use Softspring\ShopBundle\SfsShopEvents;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CartController extends AbstractController
{
    /**
     * @var CartManagerInterface
     */
    protected $cartManager;

    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * CartController constructor.
     *
     * @param CartManagerInterface     $cartManager
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(CartManagerInterface $cartManager, EventDispatcherInterface $eventDispatcher)
    {
        $this->cartManager = $cartManager;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function view(Request $request): Response
    {
        $cart = $this->cartManager->getCart($request);

        $viewData = new \ArrayObject([
            'cart' => $cart,
        ]);

        $this->eventDispatcher->dispatch(new ViewEvent($viewData), SfsShopEvents::CART_VIEW_VIEW);

        return $this->render('@SfsShop/cart/view.html.twig', $viewData->getArrayCopy());
    }

    /**
     * @param SalableItemInterface $item
     * @param Request              $request
     *
     * @return Response
     */
    public function addItem(SalableItemInterface $item, Request $request): Response
    {
        $this->cartManager->addItem($request, $item);

        return $this->redirect($request->headers->get('Referer'));
    }

    /**
     * @param SalableItemInterface $item
     * @param Request              $request
     *
     * @return Response
     * @throws \Exception
     */
    public function removeItem(SalableItemInterface $item, Request $request): Response
    {
        throw new \Exception('Not yet implemented');
    }

    /**
     * @param string  $transition
     * @param Request $request
     *
     * @return Response
     */
    public function transition(string $transition, Request $request): Response
    {
        $cart = $this->cartManager->getCart($request);
        $transitionMetadata = $this->cartManager->getCartTransitionMetadata($transition, $request);

        if ($response = $this->dispatchGetResponse("sfs_shop.cart.transition.{$transition}.initialize", new GetResponseCartTransitionEvent($transition, $transitionMetadata, $cart, $request))) {
            return $response;
        }

        // if configured, check user role before running the transition
        if (!empty($transitionMetadata['is_granted'])) {
            $this->denyAccessUnlessGranted($transitionMetadata['is_granted'], $cart);
        }

        $viewData = new \ArrayObject(['cart' => $cart]);

        if (!empty($transitionMetadata['form'])) {
            $form = $this->createForm($transitionMetadata['form'], $cart)->handleRequest($request);

            if ($form->isSubmitted()) {
                if ($form->isValid()) {
                    if ($response = $this->dispatchGetResponse("sfs_shop.cart.transition.{$transition}.form_valid", new GetResponseFormEvent($form, $request))) {
                        return $response;
                    }

                    if ($response = $this->applyTransition($transition, $transitionMetadata, $cart, $request)) {
                        return $response;
                    }
                } else {
                    if ($response = $this->dispatchGetResponse("sfs_shop.cart.transition.{$transition}.form_invalid", new GetResponseFormEvent($form, $request))) {
                        return $response;
                    }
                }
            }

            $viewData['form'] = $form->createView();
        } else {
            if ($response = $this->applyTransition($transition, $transitionMetadata, $cart, $request)) {
                return $response;
            }
        }

        $this->eventDispatcher->dispatch(new ViewEvent($viewData), "sfs_shop.cart.transition.{$transition}.view");

        return $this->render('@SfsShop/cart/'.$transition.'.html.twig', $viewData->getArrayCopy());
    }

    /**
     * @param string         $transition
     * @param array          $transitionMetadata
     * @param OrderInterface $cart
     * @param Request        $request
     *
     * @return Response|null
     */
    private function applyTransition(string $transition, array $transitionMetadata, OrderInterface $cart, Request $request): ?Response
    {
        if ($response = $this->dispatchGetResponse("sfs_shop.cart.transition.{$transition}.before", new GetResponseCartTransitionEvent($transition, $transitionMetadata, $cart, $request))) {
            return $response;
        }

        // if no form is required, apply transition directly
        if (!$this->cartManager->transition($transition, $request)) {
            // error
        }

        if ($response = $this->dispatchGetResponse("sfs_shop.cart.transition.{$transition}.after", new GetResponseCartTransitionEvent($transition, $transitionMetadata, $cart, $request))) {
            return $response;
        }

        if (!empty($transitionMetadata['on_terminate_goto_transition'])) {
            return $this->redirectToRoute('sfs_shop_cart_transition', [
                'transition' => $transitionMetadata['on_terminate_goto_transition'],
            ]);
        }

        if (!empty($transitionMetadata['on_terminate_redirect'])) {
            if (!empty($transitionMetadata['on_terminate_redirect_params'])) {
                foreach ($transitionMetadata['on_terminate_redirect_params'] as $param => $value) {
                    switch ($value) {
                        case '__cart_object__':
                            $transitionMetadata['on_terminate_redirect_params'][$param] = $cart;
                            break;
                    }
                }
            }

            return $this->redirectToRoute($transitionMetadata['on_terminate_redirect'], $transitionMetadata['on_terminate_redirect_params'] ?? []);
        }

        return null;
    }

    /**
     * @param OrderInterface $order
     * @param Request        $request
     *
     * @return Response
     */
    public function finished(OrderInterface $order, Request $request): Response
    {
        $viewData = new \ArrayObject([
            'order' => $order,
        ]);

        $this->eventDispatcher->dispatch(new ViewEvent($viewData), SfsShopEvents::CART_FINISHED_VIEW);

        return $this->render('@SfsShop/cart/finished.html.twig', $viewData->getArrayCopy());
    }
}