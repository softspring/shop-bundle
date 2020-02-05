<?php

namespace Softspring\ShopBundle\Form\Admin;

use Softspring\DoctrineTemplates\Model\NamedInterface;
use Softspring\ShopBundle\Manager\StoreManagerInterface;
use Softspring\ShopBundle\Model\StoreInterface;
use Softspring\ShopBundle\Model\StoreLanguagesInterface;
use Softspring\ShopBundle\Model\StoreSimpleCountriesInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\CurrencyType;
use Symfony\Component\Form\Extension\Core\Type\LocaleType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class AbstractStoreForm extends AbstractType
{
    /**
     * @var StoreManagerInterface
     */
    protected $manager;

    /**
     * StoreCreateForm constructor.
     *
     * @param StoreManagerInterface $manager
     */
    public function __construct(StoreManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @inheritDoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => StoreInterface::class,
            'translation_domain' => 'sfs_shop',
        ]);
    }

    /**
     * @inheritDoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('id');
        $builder->add('enabled');
        $builder->add('currency', CurrencyType::class);

        if ($this->manager->getEntityClassReflection()->implementsInterface(NamedInterface::class)) {
            $builder->add('name');
        }

        if ($this->manager->getEntityClassReflection()->implementsInterface(StoreLanguagesInterface::class)) {
            $builder->add('languages', LocaleType::class, [
                'multiple' => true,
            ]);
        }

        if ($this->manager->getEntityClassReflection()->implementsInterface(StoreSimpleCountriesInterface::class)) {
            $builder->add('countries', CountryType::class, [
                'multiple' => true,
            ]);
        }
    }
}