<?php

namespace Softspring\ShopBundle\Twig\Extension;

use Softspring\ShopBundle\Manager\CartManagerInterface;
use Softspring\ShopBundle\Model\OrderInterface;
use Symfony\Component\HttpFoundation\Request;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class CartExtension extends AbstractExtension
{
    /**
     * @var CartManagerInterface
     */
    protected $cartManager;

    /**
     * CartExtension constructor.
     *
     * @param CartManagerInterface $cartManager
     */
    public function __construct(CartManagerInterface $cartManager)
    {
        $this->cartManager = $cartManager;
    }

    /**
     * @return array|TwigFunction[]
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('cart', [$this, 'getCart']),
        ];
    }

    /**
     * @param Request $request
     * @param bool    $createIfNotExists
     *
     * @return OrderInterface|null
     */
    public function getCart(Request $request, bool $createIfNotExists = true): ?OrderInterface
    {
        return $this->cartManager->getCart($request, $createIfNotExists);
    }
}