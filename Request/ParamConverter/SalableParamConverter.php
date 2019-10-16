<?php

namespace Softspring\ShopBundle\Request\ParamConverter;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Softspring\ShopBundle\Manager\SalableManagerInterface;
use Softspring\ShopBundle\Model\SalableInterface;
use Symfony\Component\HttpFoundation\Request;

class SalableParamConverter implements ParamConverterInterface
{
    /**
     * @var SalableManagerInterface
     */
    protected $manager;

    /**
     * ModelParamConverter constructor.
     * @param SalableManagerInterface $manager
     */
    public function __construct(SalableManagerInterface $manager)
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
        return $configuration->getClass() === SalableInterface::class;
    }
}