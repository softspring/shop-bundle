<?php

namespace Softspring\ShopBundle\Form\Admin;

use Softspring\ShopBundle\Model\CustomerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CustomerCreateForm extends AbstractType implements CustomerCreateFormInterface
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CustomerInterface::class,
            'translation_domain' => 'sfs_shop',
            'label_format' => 'admin_customers.create.form.%name%.label',
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

    }
}