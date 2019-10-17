<?php

namespace Softspring\ShopBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

abstract class Order implements OrderInterface
{
    /**
     * @var CustomerInterface|null
     */
    protected $customer;

    /**
     * @var string|null
     */
    protected $number;

    /**
     * @var string|null
     */
    protected $status;

    /**
     * @var \DateTime|null
     */
    protected $date;

    /**
     * @var Collection|OrderEntryInterface[]
     */
    protected $entries;

    /**
     * Order constructor.
     */
    public function __construct()
    {
        $this->entries = new ArrayCollection();
    }

    /**
     * @return CustomerInterface|null
     */
    public function getCustomer(): ?CustomerInterface
    {
        return $this->customer;
    }

    /**
     * @param CustomerInterface|null $customer
     */
    public function setCustomer(?CustomerInterface $customer): void
    {
        $this->customer = $customer;
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

    /**
     * @return \DateTime|null
     */
    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    /**
     * @param \DateTime|null $date
     */
    public function setDate(?\DateTime $date): void
    {
        $this->date = $date;
    }

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
            return $entry->getItem() === $item;
        });

        $item = $filteredEntries->first();

        return $item instanceof OrderEntryInterface ? $item : null;
    }
}