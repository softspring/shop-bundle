<?php

namespace Softspring\ShopBundle\Controller;

use Softspring\CoreBundle\Controller\AbstractController;
use Softspring\CoreBundle\Event\GetResponseFormEvent;
use Softspring\CoreBundle\Event\ViewEvent;
use Softspring\ShopBundle\Event\GetCartItemEvent;
use Softspring\ShopBundle\Event\GetResponseCartEvent;
use Softspring\ShopBundle\Event\GetResponseCartTransitionEvent;
use Softspring\ShopBundle\Form\CartUpdateFormInterface;
use Softspring\ShopBundle\Manager\CartManagerInterface;
use Softspring\ShopBundle\Model\OrderInterface;
use Softspring\ShopBundle\Model\SalableItemInterface;
use Softspring\ShopBundle\SfsShopEvents;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormInterface;
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
     * @var CartUpdateFormInterface
     */
    protected $cartUpdateForm;

    public function __construct(CartManagerInterface $cartManager, EventDispatcherInterface $eventDispatcher, CartUpdateFormInterface $cartUpdateForm)
    {
        $this->cartManager = $cartManager;
        $this->eventDispatcher = $eventDispatcher;
        $this->cartUpdateForm = $cartUpdateForm;
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function view(Request $request): Response
    {
        $form = $this->getCartForm($request);

        $cart = $this->cartManager->getCart($request);
        if ($response = $this->dispatchGetResponse(SfsShopEvents::CART_VIEW_INIT, new GetResponseCartEvent($cart, $request))) {
            return $response;
        }

        $viewData = new \ArrayObject([
            'cart' => $form->getData(),
            'form' => $form->createView(),
        ]);

        $this->eventDispatcher->dispatch(new ViewEvent($viewData), SfsShopEvents::CART_VIEW_VIEW);

        return $this->render('@SfsShop/cart/view.html.twig', $viewData->getArrayCopy());
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function update(Request $request): Response
    {
        $form = $this->getCartForm($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var OrderInterface $cart */
            $cart = $form->getData();

            foreach ($cart->getEntries() as $entry) {
                if ($entry->getQuantity() <= 0) {
                    $cart->removeEntry($entry);
                }
            }

            $this->cartManager->saveEntity($cart);
            // $this->eventDispatcher->dispatch(new ViewEvent($viewData), SfsShopEvents::CART_UPDATE_SUCCESS;
        }

        return $this->redirectToRoute('sfs_shop_cart_view');
    }

    /**
     * @param Request $request
     *
     * @return FormInterface
     */
    protected function getCartForm(Request $request): FormInterface
    {
        $cart = $this->cartManager->getCart($request);

        $form = $this->createForm(get_class($this->cartUpdateForm), $cart, [
            'action' => $this->generateUrl('sfs_shop_cart_update'),
            'method' => 'POST',
        ]);

        $form->handleRequest($request);

        return $form;
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function addItem(Request $request): Response
    {
        $item = $this->getRepository(SalableItemInterface::class)->findOneById($request->get('item'));
        $cart = $this->cartManager->getCart($request);

        if ($response = $this->dispatchGetResponse(SfsShopEvents::CART_ADD_ITEM_INIT, new GetCartItemEvent($cart, $item, $request))) {
            return $response;
        }

        $quantity = (int)$request->get('quantity', 1);
        $this->cartManager->addItem($request, $item, $quantity);

        if ($response = $this->dispatchGetResponse(SfsShopEvents::CART_ADD_ITEM_SUCCESS, new GetCartItemEvent($cart, $item, $request, ['quantity' => $quantity]))) {
            return $response;
        }

        return $this->redirect($request->headers->get('Referer'));
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function removeItem(Request $request): Response
    {
        $item = $this->getRepository(SalableItemInterface::class)->findOneById($request->get('item'));
        $cart = $this->cartManager->getCart($request);

        if ($response = $this->dispatchGetResponse(SfsShopEvents::CART_REMOVE_ITEM_INIT, new GetCartItemEvent($cart, $item, $request))) {
            return $response;
        }

        $this->cartManager->removeItem($request, $item);

        if ($response = $this->dispatchGetResponse(SfsShopEvents::CART_REMOVE_ITEM_SUCCESS, new GetCartItemEvent($cart, $item, $request))) {
            return $response;
        }

        return $this->redirect($request->headers->get('Referer'));
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