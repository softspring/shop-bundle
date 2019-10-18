<?php

namespace Softspring\ShopBundle\Controller;

use Softspring\CoreBundle\Event\ViewEvent;
use Softspring\ExtraBundle\Controller\AbstractController;
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

        // if configured, check user role before running the transition
        if (!empty($transitionMetadata['is_granted'])) {
            $this->denyAccessUnlessGranted($transitionMetadata['is_granted'], $cart);
        }

        $viewData = new \ArrayObject([
            'cart' => $cart,
        ]);

        if (!empty($transitionMetadata['form'])) {
            $form = $this->createForm($transitionMetadata['form'], $cart)->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->cartManager->transition($transition, $request);

                if (!empty($transitionMetadata['redirect_on_terminate'])) {
                    return $this->redirectToRoute($transitionMetadata['redirect_on_terminate']);
                }
            }

            $viewData['form'] = $form->createView();
        } else {
            // if no form is required, apply transition directly
            $this->cartManager->transition($transition, $request);

            if (!empty($transitionMetadata['redirect_on_terminate'])) {
                return $this->redirectToRoute($transitionMetadata['redirect_on_terminate']);
            }
        }

        return $this->render('@SfsShop/cart/'.$transition.'.html.twig', $viewData->getArrayCopy());
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