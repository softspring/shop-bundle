<?php

namespace Softspring\ShopBundle\Model;

use Softspring\PaymentBundle\Model\DiscountInterface;

abstract class OrderEntry implements OrderEntryInterface
{
    /**
     * @var OrderInterface|null
     */
    protected $order;

    /**
     * @var SalableItemInterface|null
     */
    protected $item;

    /**
     * @var float
     */
    protected $price = 0;

    /**
     * @var int
     */
    protected $quantity = 0;

    /**
     * @var float
     */
    protected $totalPrice = 0;

    /**
     * @return OrderInterface|null
     */
    public function getOrder(): ?OrderInterface
    {
        return $this->order;
    }

    /**
     * @param OrderInterface|null $order
     */
    public function setOrder(?OrderInterface $order): void
    {
        $this->order = $order;
    }

    /**
     * @return SalableItemInterface|null
     */
    public function getItem(): ?SalableItemInterface
    {
        return $this->item;
    }

    /**
     * @param SalableItemInterface|null $item
     */
    public function setItem(?SalableItemInterface $item): void
    {
        $this->item = $item;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
        $this->updatePrices();
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price): void
    {
        $this->price = $price;
        $this->updatePrices();
    }

    /**
     * @return float
     */
    public function getTotalPrice(): float
    {
        return (float) $this->totalPrice;
    }

    protected function updatePrices()
    {
        if ($this instanceof OrderEntryHasDiscountsInterface) {
            $this->priceWithDiscount = $this->getPrice();

            foreach ($this->getDiscountRules() as $discountRule) {
                $discount = $discountRule->getDiscount();

                switch ($discount->getType()) {
                    case DiscountInterface::TYPE_PERCENTAGE:
                        $this->priceWithDiscount = $this->getPrice() - ($this->getPrice() * $discount->getValue() / 100);
                        break;

                    case DiscountInterface::TYPE_FIXED_AMOUNT:
                        $this->priceWithDiscount = $this->getPrice() - $discount->getValue();
                        break;
                }
            }

            $this->totalPriceWithDiscount = $this->getPriceWithDiscount() * $this->getQuantity();
        }

        $this->totalPrice = $this->getPrice() * $this->getQuantity();
    }
}