<?php

namespace Softspring\ShopBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Softspring\ShopBundle\Model\OrderInterface;
use Symfony\Component\Workflow\Registry;

class OrderManager implements OrderManagerInterface
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
     * OrderManager constructor.
     *
     * @param EntityManagerInterface $em
     * @param Registry               $workflows
     */
    public function __construct(EntityManagerInterface $em,  Registry $workflows)
    {
        $this->em = $em;
        $this->workflows = $workflows;
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

    /**
     * @param string         $transition
     * @param OrderInterface $order
     *
     * @return array
     * @throws \Exception
     */
    public function getOrderTransitionMetadata(string $transition, OrderInterface $order): array
    {
        $workflow = $this->workflows->get($order, 'order');

        if (!$workflow->can($order, $transition)) {
            throw new \Exception('Transition is not enabled');
        }

        foreach ($workflow->getEnabledTransitions($order) as $transitionItem) {
            if ($transitionItem->getName() == $transition) {
                break;
            }
        }

        return $workflow->getMetadataStore()->getTransitionMetadata($transitionItem);
    }

    /**
     * @param string         $transition
     * @param OrderInterface $order
     *
     * @return bool
     * @throws \Exception
     */
    public function transition(string $transition, OrderInterface $order): bool
    {
        $workflow = $this->workflows->get($order, 'order');

        if (!$workflow->can($order, $transition)) {
            return false;
        }

        $workflow->apply($order, $transition);
        $this->saveEntity($order);

        return true;
    }
}