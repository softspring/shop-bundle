<?php

namespace Softspring\ShopBundle\Form\Admin;

use Symfony\Component\OptionsResolver\OptionsResolver;

class StoreUpdateForm extends AbstractStoreForm implements StoreUpdateFormInterface
{
    /**
     * @inheritDoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'translation_domain' => 'sfs_shop',
            'label_format' => 'admin_stores.update.form.%name%.label',
        ]);
    }
}