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
    protected $salableItem;

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
    public function getSalableItem(): ?SalableItemInterface
    {
        return $this->salableItem;
    }

    /**
     * @param SalableItemInterface|null $salableItem
     */
    public function setSalableItem(?SalableItemInterface $salableItem): void
    {
        $this->salableItem = $salableItem;
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

    /**
     * @param float $totalPrice
     */
    public function setTotalPrice(float $totalPrice): void
    {
        $this->totalPrice = $totalPrice;
    }

    protected function updatePrices()
    {
        if ($this instanceof OrderEntryHasDiscountsInterface) {
            $this->setPriceWithDiscount($this->getPrice());

            foreach ($this->getDiscountRules() as $discountRule) {
                $discount = $discountRule->getDiscount();

                switch ($discount->getType()) {
                    case DiscountInterface::TYPE_PERCENTAGE:
                        $this->setPriceWithDiscount($this->getPrice() - ($this->getPrice() * $discount->getValue() / 100));
                        break;

                    case DiscountInterface::TYPE_FIXED_AMOUNT:
                        $this->setPriceWithDiscount($this->getPrice() - $discount->getValue());
                        break;
                }
            }

            $this->setTotalPriceWithDiscount($this->getPriceWithDiscount() * $this->getQuantity());
        }

        $this->setTotalPrice($this->getPrice() * $this->getQuantity());
    }
}