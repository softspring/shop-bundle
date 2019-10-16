<?php

namespace Softspring\ShopBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Softspring\ShopBundle\Model\OrderInterface;
use Softspring\ShopBundle\Model\OrderItemInterface;
use Softspring\ShopBundle\Model\SalableInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Workflow\Registry;

class CartManager implements CartManagerInterface
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * @var Registry
     */
    protected $workflows;

    /**
     * @var OrderItemManagerInterface
     */
    protected $orderItemManager;

    /**
     * CartManager constructor.
     *
     * @param EntityManagerInterface    $em
     * @param Registry                  $workflows
     * @param OrderItemManagerInterface $orderItemManager
     */
    public function __construct(EntityManagerInterface $em, Registry $workflows, OrderItemManagerInterface $orderItemManager)
    {
        $this->em = $em;
        $this->workflows = $workflows;
        $this->orderItemManager = $orderItemManager;
    }

    public function getClass(): string
    {
        return OrderInterface::class;
    }

    public function getRepository(): EntityRepository
    {
        return $this->em->getRepository($this->getClass());
    }

    /**
     * @return OrderInterface
     */
    public function createEntity()
    {
        $metadata = $this->em->getClassMetadata($this->getClass());
        $class = $metadata->getReflectionClass()->name;
        return new $class;
    }

    public function saveEntity($entity): void
    {
        if (!$entity instanceof OrderInterface) {
            throw new \InvalidArgumentException(sprintf('$entity must be an instance of %s', OrderInterface::class));
        }

        $this->em->persist($entity);
        $this->em->flush();
    }

    public function getCart(Request $request): ?OrderInterface
    {
        $session = $request->getSession();

        if (!$session instanceof Session) {
            throw new \RuntimeException('User session is not started');
        }

        $cart = $session->get('cart');
        $cart = $cart ? $this->getRepository()->findOneById($cart) : null;

        if (!$cart instanceof OrderInterface) {
            $cart = $this->createEntity();

            $workflow = $this->workflows->get($cart, 'checkout_state_machine');
            $cart->setStatus($workflow->getDefinition()->getInitialPlaces()[0]);
        }

        $this->saveEntity($cart);
        $session->set('cart', $cart->getId());

        return $cart;
    }

    public function reset(Request $request): ?OrderInterface
    {
        $session = $request->getSession();

        if (!$session instanceof Session) {
            throw new \RuntimeException('User session is not started');
        }

        $session->set('cart', null);

        return $this->getCart($request);
    }

    public function addItem(OrderInterface $cart, SalableInterface $salable): void
    {
        $item = $cart->getSalableItem($salable);
        if (!$item) {
            /** @var OrderItemInterface $item */
            $item = $this->orderItemManager->createEntity();
            $item->setItem($salable);
        }
        $item->setQuantity(1 + (int)$item->getQuantity());
        $cart->addItem($item);

        $this->em->persist($item); // TODO REMOVE WHEN CASCADE PERSIST WORKS
    }
}