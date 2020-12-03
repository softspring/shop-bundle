<?php

namespace Softspring\ShopBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use Softspring\CrudlBundle\Manager\CrudlEntityManagerTrait;
use Softspring\PaymentBundle\Manager\DiscountRuleManagerInterface;
use Softspring\ShopBundle\Event\CartEvent;
use Softspring\ShopBundle\Model\OrderEntryHasDiscountsInterface;
use Softspring\ShopBundle\Model\OrderInterface;
use Softspring\ShopBundle\Model\SalableItemInterface;
use Softspring\ShopBundle\Model\StoreAwareInterface;
use Softspring\ShopBundle\SfsShopEvents;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Workflow\Registry;

class CartManager implements CartManagerInterface
{
    use CrudlEntityManagerTrait;

    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * @var Registry
     */
    protected $workflows;

    /**
     * @var OrderEntryManagerInterface
     */
    protected $orderEntryManager;

    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * @var DiscountRuleManagerInterface|null
     */
    protected $discountRuleManager;

    /**
     * CartManager constructor.
     *
     * @param EntityManagerInterface            $em
     * @param Registry                          $workflows
     * @param OrderEntryManagerInterface        $orderEntryManager
     * @param EventDispatcherInterface          $eventDispatcher
     * @param DiscountRuleManagerInterface|null $discountRuleManager
     */
    public function __construct(EntityManagerInterface $em, Registry $workflows, OrderEntryManagerInterface $orderEntryManager, EventDispatcherInterface $eventDispatcher, ?DiscountRuleManagerInterface $discountRuleManager)
    {
        $this->em = $em;
        $this->workflows = $workflows;
        $this->orderEntryManager = $orderEntryManager;
        $this->eventDispatcher = $eventDispatcher;
        $this->discountRuleManager = $discountRuleManager;
    }

    public function getTargetClass(): string
    {
        return OrderInterface::class;
    }

    public function getCart(Request $request, bool $createIfNotExists = true): ?OrderInterface
    {
        $session = $this->getSession($request);

        /** @var OrderInterface $cart */
        $cart = $session->get('cart');
        $cart = $cart ? $this->getRepository()->findOneById($cart) : null;

        if (!$cart instanceof OrderInterface) {
            if (!$createIfNotExists) {
                return null;
            }

            $cart = $this->createEntity();

            $workflow = $this->workflows->get($cart, 'checkout');
            $cart->setStatus($workflow->getDefinition()->getInitialPlaces()[0]);

            $this->eventDispatcher->dispatch(new CartEvent($cart, null), SfsShopEvents::CART_CREATING);
        }

        $this->saveEntity($cart);
        $session->set('cart', $cart->getId());

        return $cart;
    }

    public function getCartTransitionMetadata(string $transition, Request $request): array
    {
        $cart = $this->getCart($request);
        $workflow = $this->workflows->get($cart, 'checkout');

        if (!$workflow->can($cart, $transition)) {
            throw new \Exception('Transition is not enabled');
        }

        foreach ($workflow->getEnabledTransitions($cart) as $transitionItem) {
            if ($transitionItem->getName() == $transition) {
                break;
            }
        }

        return $workflow->getMetadataStore()->getTransitionMetadata($transitionItem);
    }

    /**
     * @param string  $transition
     * @param Request $request
     *
     * @return bool
     * @throws \Exception
     */
    public function transition(string $transition, Request $request): bool
    {
        $cart = $this->getCart($request);
        $workflow = $this->workflows->get($cart, 'checkout');
        $transitionMetadata = $this->getCartTransitionMetadata($transition, $request);

        if (!$workflow->can($cart, $transition)) {
            return false;
        }

        $workflow->apply($cart, $transition);
        $this->saveEntity($cart);

        if ($transitionMetadata['close_cart']??false == true) {
            $this->close($request);
        }

        if ($transitionMetadata['reset_cart']??false == true) {
            $this->reset($request);
        }

        return true;
    }

    /**
     * @param Request $request
     *
     * @return OrderInterface|null
     */
    public function reset(Request $request): ?OrderInterface
    {
        $session = $this->getSession($request);

        $session->set('cart', null);

        return $this->getCart($request);
    }

    /**
     * @param Request $request
     */
    public function close(Request $request): void
    {
        $session = $this->getSession($request);

        $session->set('cart', null);
    }

    /**
     * @param Request              $request
     * @param SalableItemInterface $item
     * @param int                  $quantity
     */
    public function addItem(Request $request, SalableItemInterface $item, int $quantity = 1): void
    {
        $cart = $this->getCart($request);

        $entry = $cart->getEntryByItem($item);
        if (!$entry) {
            $entry = $this->orderEntryManager->createEntity();
            $entry->setSalableItem($item);
        }
        $entry->setPrice($item->getPrice($cart instanceof StoreAwareInterface ? $cart->getStore() : null));
        $entry->setQuantity($quantity + (int)$entry->getQuantity());

        $cart->addEntry($entry);

        if ($entry instanceof OrderEntryHasDiscountsInterface) {
            if (!$this->discountRuleManager instanceof DiscountRuleManagerInterface) {
                throw new \Exception('Discount rule manager is not registered');
            }

            $this->discountRuleManager->applyDiscountsToOrderEntry($entry);
        }

        $this->saveEntity($cart);
    }

    /**
     * @param Request              $request
     * @param SalableItemInterface $item
     */
    public function removeItem(Request $request, SalableItemInterface $item): void
    {
        $cart = $this->getCart($request);

        $entry = $cart->getEntryByItem($item);
        if ($entry) {
            $cart->removeEntry($entry);
        }

        $this->saveEntity($cart);
    }

    /**
     * @param Request $request
     *
     * @return Session
     * @throws \RuntimeException
     */
    protected function getSession(Request $request): Session
    {
        $session = $request->getSession();

        if (!$session instanceof Session) {
            throw new \RuntimeException('User session is not started');
        }

        return $session;
    }
}