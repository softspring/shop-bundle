<?php

namespace Softspring\ShopBundle\Controller;

use Softspring\ExtraBundle\Controller\AbstractController;
use Softspring\ShopBundle\Manager\CartManagerInterface;
use Softspring\ShopBundle\Model\SalableInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function reset(Request $request): Response
    {
        $this->cartManager->reset($request);

        return $this->redirectToRoute('sfs_shop_cart_view');
    }

    public function addItem(SalableInterface $item, Request $request): Response
    {
        $cart = $this->cartManager->getCart($request);
        $this->cartManager->addItem($cart, $item);
        $this->cartManager->saveEntity($cart);

        return $this->redirect($request->headers->get('Referer'));
    }

    public function removeItem(SalableInterface $item, Request $request): Response
    {
        throw new \Exception('Not yet implemented');
    }

    public function purchase()
    {

    }

    public function shippingAddress()
    {

    }

    public function paymentMethod()
    {

    }

    public function confirm()
    {

    }
}