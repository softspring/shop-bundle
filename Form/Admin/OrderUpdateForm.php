<?php

namespace Softspring\ShopBundle\Form\Admin;

use Softspring\ShopBundle\Model\OrderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderUpdateForm extends AbstractType implements OrderUpdateFormInterface
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => OrderInterface::class,
            'translation_domain' => 'sfs_shop',
            'label_format' => 'admin_orders.update.form.%name%.label',
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    }
}