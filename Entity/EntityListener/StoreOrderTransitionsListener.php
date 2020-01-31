<?php

namespace Softspring\ShopBundle\Entity\EntityListener;

use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Softspring\ShopBundle\EventListener\TransitionStoreListener;
use Softspring\ShopBundle\Manager\OrderTransitionManagerInterface;
use Softspring\ShopBundle\Model\Order;
use Softspring\ShopBundle\Model\OrderInterface;
use Softspring\ShopBundle\Model\OrderTransitionInterface;
use Softspring\ShopBundle\Model\OrderTransitionUserInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class StoreOrderTransitionsListener
{
    /**
     * @var OrderTransitionManagerInterface
     */
    protected $transtionManager;

    /**
     * @var TransitionStoreListener
     */
    protected $transitionStoreListener;

    /**
     * @var TokenStorageInterface
     */
    protected $tokenStorage;

    /**
     * StoreOrderTransitionsListener constructor.
     *
     * @param OrderTransitionManagerInterface $transtionManager
     * @param TransitionStoreListener         $transitionStoreListener
     * @param TokenStorageInterface           $tokenStorage
     */
    public function __construct(OrderTransitionManagerInterface $transtionManager, TransitionStoreListener $transitionStoreListener, TokenStorageInterface $tokenStorage)
    {
        $this->transtionManager = $transtionManager;
        $this->transitionStoreListener = $transitionStoreListener;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @param Order              $order
     * @param PreUpdateEventArgs $eventArgs
     *
     * @throws \Exception
     */
    public function preUpdate(Order $order, PreUpdateEventArgs $eventArgs)
    {
        if (!$eventArgs->hasChangedField('status')) {
            return;
        }

        $this->createTransition($order, $eventArgs->getNewValue('status'));
    }

    /**
     * @param Order              $order
     * @param LifecycleEventArgs $eventArgs
     *
     * @throws \Exception
     */
    public function prePersist(Order $order, LifecycleEventArgs $eventArgs)
    {
        $this->createTransition($order, $order->getStatus());
    }

    /**
     * @param OrderInterface $order
     * @param                $status
     *
     * @throws \Exception
     */
    private function createTransition(OrderInterface $order, $status)
    {
        /** @var OrderTransitionInterface $transition */
        $transition = $this->transtionManager->createEntity();
        $transition->setStatus($status);
        $transition->setDate(new \DateTime('now'));
        if ($transition instanceof OrderTransitionUserInterface) {
            $token = $this->tokenStorage->getToken();
            if ($token && $user = $token->getUser()) {
                if ($user !== 'anon.') {
                    $transition->setUser($user);
                }
            }
        }
        $order->addTransition($transition);
        $this->transitionStoreListener->addTransition($transition);
    }
}