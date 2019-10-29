<?php

namespace Softspring\ShopBundle\Form\Admin;

use Symfony\Component\OptionsResolver\OptionsResolver;

class StoreCreateForm extends AbstractStoreForm implements StoreCreateFormInterface
{
    /**
     * @inheritDoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'label_format' => 'admin_stores.create.form.%name%.label',
        ]);
    }
}