<?php

namespace Softspring\ShopBundle\Form\Admin;

use Softspring\AdminBundle\Form\AdminEntityListFilterForm;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderListFilterForm extends AdminEntityListFilterForm implements OrderListFilterFormInterface
{
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'translation_domain' => 'sfs_shop',
            'label_format' => 'admin_orders.list.filter_form.%name%.label',
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add('number', TextType::class, [
            'property_path' => '[number_like]',
        ]);

        $builder->add('status', ChoiceType::class, [
            'property_path' => '[status_in]',
            'multiple' => true,
            'expanded' => true,
            'choices' => [
                'cart' => 'cart',
                'cart_addressed' => 'cart_addressed',
                'cart_payment_selected' => 'cart_payment_selected',
                'reset' => 'reset',
                'new' => 'new',
                'shipped' => 'shipped',
                'closed' => 'closed',
            ],
        ]);
    }
}