<?php

namespace Softspring\ShopBundle\EventListener;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Softspring\ShopBundle\Model\OrderTransitionInterface;

class TransitionStoreListener implements EventSubscriber
{
    /**
     * @var Collection
     */
    protected $transitions;

    public function __construct()
    {
        $this->transitions = new ArrayCollection();
    }

    public function getSubscribedEvents()
    {
        return [
            'postFlush',
        ];
    }

    public function postFlush(PostFlushEventArgs $eventArgs)
    {
        if (!$this->transitions->count()) {
            return;
        }

        $em = $eventArgs->getEntityManager();
        $uok = $em->getUnitOfWork();

        /** @var OrderTransitionInterface $transition */
        foreach ($this->transitions as $transition) {
            $order = $transition->getOrder();
            $uok->recomputeSingleEntityChangeSet($em->getClassMetadata(get_class($order)), $order);
            $em->persist($transition);

            $this->transitions->removeElement($transition);
        }

        $em->flush();
    }

    public function addTransition(OrderTransitionInterface $transition)
    {
        if (!$this->transitions->contains($transition)) {
            $this->transitions->add($transition);
        }
    }
}