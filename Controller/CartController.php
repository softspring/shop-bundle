<?php

namespace Softspring\ShopBundle\Controller;

use Softspring\ExtraBundle\Controller\AbstractController;
use Softspring\ShopBundle\Model\SalableInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CartController extends AbstractController
{
    public function view(Request $request): Response
    {
        // show view
        $viewData = new \ArrayObject([
        ]);

        return $this->render('@SfsShop/cart/view.html.twig', $viewData->getArrayCopy());
    }

    public function addItem(SalableInterface $item, Request $request): Response
    {
        throw new \Exception('Not yet implemented');
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