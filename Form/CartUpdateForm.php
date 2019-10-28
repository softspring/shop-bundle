<?php

namespace Softspring\ShopBundle\Form;

use Softspring\ShopBundle\Model\OrderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CartUpdateForm extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => OrderInterface::class,
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('entries', CollectionType::class, [
            'entry_type' => CartEntryQuantityType::class,
        ]);
    }
}