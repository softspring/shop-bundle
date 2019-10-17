<?php

namespace Softspring\ShopBundle\Controller;

use Softspring\ExtraBundle\Controller\AbstractController;
use Softspring\ShopBundle\Manager\CartManagerInterface;
use Softspring\ShopBundle\Model\OrderInterface;
use Softspring\ShopBundle\Model\SalableItemInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CartController extends AbstractController
{
    /**
     * @var CartManagerInterface
     */
    protected $cartManager;

    /**
     * CartController constructor.
     *
     * @param CartManagerInterface $cartManager
     */
    public function __construct(CartManagerInterface $cartManager)
    {
        $this->cartManager = $cartManager;
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

        return $this->render('@SfsShop/cart/view.html.twig', $viewData->getArrayCopy());
    }

    public function addItem(SalableItemInterface $item, Request $request): Response
    {
        $this->cartManager->addItem($request, $item);
        $this->cartManager->saveEntity($this->cartManager->getCart($request));

        return $this->redirect($request->headers->get('Referer'));
    }

    public function removeItem(SalableItemInterface $item, Request $request): Response
    {
        throw new \Exception('Not yet implemented');
    }

    public function transition(string $transition, Request $request): Response
    {
        $cart = $this->cartManager->getCart($request);
        $transitionMetadata = $this->cartManager->getCartTransitionMetadata($transition, $request);

        if (!empty($transitionMetadata['is_granted'])) {
            $this->denyAccessUnlessGranted($transitionMetadata['is_granted'], $cart);
        }

        if (empty($transitionMetadata['form'])) {
            $this->cartManager->transition($transition, $request);

            if (!empty($transitionMetadata['redirect_on_terminate'])) {
                return $this->redirectToRoute($transitionMetadata['redirect_on_terminate']);
            }

            return new Response('');
        }

        $form = $this->createForm($transitionMetadata['form'], $cart)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->cartManager->transition($transition, $request);
        }

        $viewData = new \ArrayObject([
            'cart' => $cart,
            'form' => $form->createView(),
        ]);

        return $this->render('@SfsShop/cart/'.$transition.'.html.twig', $viewData->getArrayCopy());
    }


    public function finished(OrderInterface $order, Request $request): Response
    {
        $viewData = new \ArrayObject([
            'order' => $order,
        ]);

        return $this->render('@SfsShop/cart/finished.html.twig', $viewData->getArrayCopy());
    }
}