<?php

namespace Softspring\ShopBundle\Request\ParamConverter;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Softspring\ShopBundle\Manager\OrderManagerInterface;
use Softspring\ShopBundle\Model\OrderInterface;
use Symfony\Component\HttpFoundation\Request;

class OrderParamConverter implements ParamConverterInterface
{
    /**
     * @var OrderManagerInterface
     */
    protected $manager;

    /**
     * ModelParamConverter constructor.
     * @param OrderManagerInterface $manager
     */
    public function __construct(OrderManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function apply(Request $request, ParamConverter $configuration)
    {
        $query = $request->attributes->get($configuration->getName());
        $entity = $this->manager->getRepository()->findOneBy(['id' => $query]);
        $request->attributes->set($configuration->getName(), $entity);
    }

    public function supports(ParamConverter $configuration)
    {
        return $configuration->getClass() === OrderInterface::class;
    }
}