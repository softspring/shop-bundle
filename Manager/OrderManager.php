<?php

namespace Softspring\ShopBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use Softspring\CrudlBundle\Manager\CrudlEntityManagerTrait;
use Softspring\ShopBundle\Model\OrderInterface;
use Symfony\Component\Workflow\Registry;

class OrderManager implements OrderManagerInterface
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

    public function getTargetClass(): string
    {
        return OrderInterface::class;
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