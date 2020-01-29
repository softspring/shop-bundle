<?php

namespace Softspring\ShopBundle\Form\Admin;

use Softspring\CrudlBundle\Form\EntityListFilterForm;
use Softspring\ShopBundle\Manager\OrderManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderListFilterForm extends EntityListFilterForm implements OrderListFilterFormInterface
{
    /**
     * @var OrderManagerInterface
     */
    protected $orderManager;

    /**
     * OrderListFilterForm constructor.
     *
     * @param OrderManagerInterface $orderManager
     */
    public function __construct(OrderManagerInterface $orderManager)
    {
        $this->orderManager = $orderManager;
    }

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

        $statuses = $this->orderManager->getStatuses();

        $builder->add('status', ChoiceType::class, [
            'property_path' => '[status_in]',
            'multiple' => true,
            'expanded' => true,
            'choices' => $statuses,
        ]);

        $builder->add('search', SubmitType::class);
    }

    public function getRpp(Request $request): int
    {
        return 20;
    }

    public function getOrder(Request $request): array
    {
        return ['number' => 'DESC'];
    }
}