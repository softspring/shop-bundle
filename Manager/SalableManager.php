<?php

namespace Softspring\ShopBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Softspring\ShopBundle\Model\SalableInterface;

class SalableManager implements SalableManagerInterface
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * CustomerManager constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getClass(): string
    {
        return SalableInterface::class;
    }

    public function getRepository(): EntityRepository
    {
        return $this->em->getRepository($this->getClass());
    }

    public function createEntity()
    {
        $metadata = $this->em->getClassMetadata($this->getClass());
        $class = $metadata->getReflectionClass()->name;
        return new $class;
    }

    public function saveEntity($entity): void
    {
        if (!$entity instanceof SalableInterface) {
            throw new \InvalidArgumentException(sprintf('$entity must be an instance of %s', SalableInterface::class));
        }

        $this->em->persist($entity);
        $this->em->flush();
    }
}