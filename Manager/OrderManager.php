<?php

namespace Softspring\ShopBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use Softspring\CrudlBundle\Manager\CrudlEntityManagerTrait;
use Softspring\ShopBundle\Exception\OrderTransitionNotValid;
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
     * @inheritDoc
     */
    public function getOrderTransitionMetadata(string $transition, OrderInterface $order, string $workflowName = 'order'): array
    {
        $workflow = $this->workflows->get($order, $workflowName);

        if (!$workflow->can($order, $transition)) {
            throw new OrderTransitionNotValid($order, $transition);
        }

        foreach ($workflow->getEnabledTransitions($order) as $transitionItem) {
            if ($transitionItem->getName() == $transition) {
                break;
            }
        }

        return $workflow->getMetadataStore()->getTransitionMetadata($transitionItem);
    }

    /**
     * @inheritDoc
     */
    public function transition(string $transition, OrderInterface $order, string $workflowName = 'order'): bool
    {
        $workflow = $this->workflows->get($order, $workflowName);

        if (!$workflow->can($order, $transition)) {
            return false;
        }

        $workflow->apply($order, $transition);
        $this->saveEntity($order);

        return true;
    }

    /**
     * @inheritDoc
     */
    public function getStatuses(string $workflowName = 'order'): array
    {
        $workflow = $this->workflows->get($this->createEntity(), $workflowName);
        $definition = $workflow->getDefinition();
        return $definition->getPlaces();
    }
}