<?php

namespace Softspring\ShopBundle\Form\Admin;

use Softspring\ShopBundle\Model\ShopCustomerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CustomerDeleteForm extends AbstractType implements CustomerDeleteFormInterface
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ShopCustomerInterface::class,
            'translation_domain' => 'sfs_shop',
            'label_format' => 'admin_customers.delete.form.%name%.label',
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

    }
}