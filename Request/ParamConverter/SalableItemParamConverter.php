<?php

namespace Softspring\ShopBundle\Request\ParamConverter;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Softspring\ShopBundle\Manager\SalableItemManagerInterface;
use Softspring\ShopBundle\Model\SalableItemInterface;
use Symfony\Component\HttpFoundation\Request;

class SalableItemParamConverter implements ParamConverterInterface
{
    /**
     * @var SalableItemManagerInterface
     */
    protected $manager;

    /**
     * ModelParamConverter constructor.
     * @param SalableItemManagerInterface $manager
     */
    public function __construct(SalableItemManagerInterface $manager)
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
        return $configuration->getClass() === SalableItemInterface::class;
    }
}