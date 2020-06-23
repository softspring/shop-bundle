<?php

namespace Softspring\ShopBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Softspring\PaymentBundle\Model\DiscountRuleInterface;
use Softspring\ShopBundle\Model\OrderEntryHasDiscountsTrait as OrderEntryHasDiscountsTraitModel;

trait OrderEntryHasDiscountsTrait
{
    use OrderEntryHasDiscountsTraitModel;

    /**
     * @var DiscountRuleInterface[]|Collection
     * @ORM\ManyToMany(targetEntity="Softspring\PaymentBundle\Model\DiscountRuleInterface")
     * @ORM\JoinTable(name="shop_order_entry_discount_rules",
     *      joinColumns={@ORM\JoinColumn(name="shop_order_entry_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="discount_rule_id", referencedColumnName="id")}
     * )
     */
    protected $discountRules;

    /**
     * @var float
     * @ORM\Column(name="price_with_discount", type="float", precision=10, scale=2, nullable=false)
     */
    protected $priceWithDiscount = 0;

    /**
     * @var float
     * @ORM\Column(name="price_total_with_discount", type="float", precision=10, scale=2, nullable=false)
     */
    protected $totalPriceWithDiscount = 0;
}