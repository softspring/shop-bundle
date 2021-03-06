<?php

namespace Softspring\ShopBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

abstract class Order implements OrderInterface
{
    /**
     * @var string|null
     */
    protected $number;

    /**
     * @var string|null
     */
    protected $status;

//    /**
//     * @var \DateTime|null
//     */
//    protected $date;

    /**
     * @var Collection|OrderEntryInterface[]
     */
    protected $entries;

    /**
     * @var int|null
     */
    protected $checkoutAt;

    /**
     * @var Collection|OrderTransitionInterface[]
     */
    protected $transitions;

    /**
     * @var float|null
     */
    protected $subtotalBeforeDiscounts;

    /**
     * @var float|null
     */
    protected $subtotal;

    /**
     * @var float|null
     */
    protected $taxes;

    /**
     * @var float|null
     */
    protected $shipping;

    /**
     * @var float|null
     */
    protected $total;

    /**
     * @var string|null
     */
    protected $currency;

    /**
     * Order constructor.
     */
    public function __construct()
    {
        $this->entries = new ArrayCollection();
        $this->transitions = new ArrayCollection();
    }

    /**
     * @return string|null
     */
    public function getNumber(): ?string
    {
        return $this->number;
    }

    /**
     * @param string|null $number
     */
    public function setNumber(?string $number): void
    {
        $this->number = $number;
    }

    /**
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @param string|null $status
     */
    public function setStatus(?string $status): void
    {
        $this->status = $status;
    }

//    /**
//     * @return \DateTime|null
//     */
//    public function getDate(): ?\DateTime
//    {
//        return $this->date;
//    }
//
//    /**
//     * @param \DateTime|null $date
//     */
//    public function setDate(?\DateTime $date): void
//    {
//        $this->date = $date;
//    }

    /**
     * @return Collection|OrderEntryInterface[]
     */
    public function getEntries(): Collection
    {
        if (!$this->entries instanceof Collection) {
            $this->entries = new ArrayCollection();
        }

        return $this->entries;
    }

    /**
     * @param OrderEntryInterface $entry
     */
    public function addEntry(OrderEntryInterface $entry): void
    {
        if (!$this->entries->contains($entry)) {
            $this->entries->add($entry);
            $entry->setOrder($this);
        }
    }

    /**
     * @param OrderEntryInterface $entry
     */
    public function removeEntry(OrderEntryInterface $entry): void
    {
        if ($this->entries->contains($entry)) {
            $this->entries->removeElement($entry);
        }
    }

    public function getEntryByItem(SalableItemInterface $item): ?OrderEntryInterface
    {
        $filteredEntries = $this->getEntries()->filter(function (OrderEntryInterface $entry) use ($item) {
            return $entry->getSalableItem() === $item;
        });

        $item = $filteredEntries->first();

        return $item instanceof OrderEntryInterface ? $item : null;
    }

    /**
     * @return \DateTime|null
     */
    public function getCheckoutAt(): ?\DateTime
    {
        return $this->checkoutAt ? \DateTime::createFromFormat("U", $this->checkoutAt) : null;
    }

    /**
     * @param \DateTime|null $checkoutAt
     */
    public function setCheckoutAt(?\DateTime $checkoutAt): void
    {
        $this->checkoutAt = $checkoutAt ? $checkoutAt->format('U') : null;
    }

    /**
     * @return float
     */
    public function getTotal(): float
    {
        return array_sum($this->entries->map(function (OrderEntryInterface $entry) {
            return $entry instanceof OrderEntryHasDiscountsInterface ? $entry->getTotalPriceWithDiscount() : $entry->getTotalPrice();
        })->toArray());
    }

    /**
     * @inheritDoc
     */
    public function getTransitions(): Collection
    {
        return $this->transitions;
    }

    /**
     * @inheritDoc
     */
    public function addTransition(OrderTransitionInterface $transition): void
    {
        if (!$this->getTransitions()->contains($transition)) {
            $this->getTransitions()->add($transition);
            $transition->setOrder($this);
        }
    }

    /**
     * @return string|null
     */
    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    /**
     * @param string|null $currency
     */
    public function setCurrency(?string $currency): void
    {
        $this->currency = $currency;
    }
}