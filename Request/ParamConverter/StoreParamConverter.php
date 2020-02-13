<?php

namespace Softspring\ShopBundle\Request\ParamConverter;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Softspring\ShopBundle\Manager\StoreManagerInterface;
use Softspring\ShopBundle\Model\StoreInterface;
use Symfony\Component\HttpFoundation\Request;

class StoreParamConverter implements ParamConverterInterface
{
    /**
     * @var StoreManagerInterface
     */
    protected $manager;

    /**
     * StoreParamConverter constructor.
     *
     * @param StoreManagerInterface $manager
     */
    public function __construct(StoreManagerInterface $manager)
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
        return $configuration->getClass() === StoreInterface::class;
    }
}