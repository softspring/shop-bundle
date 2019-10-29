<?php

namespace Softspring\ShopBundle\Form\Admin;

use Softspring\ShopBundle\Model\StoreInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StoreDeleteForm extends AbstractType implements StoreDeleteFormInterface
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => StoreInterface::class,
            'translation_domain' => 'sfs_shop',
            'label_format' => 'admin_stores.delete.form.%name%.label',
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

    }
}