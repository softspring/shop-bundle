<?php

namespace Softspring\ShopBundle\Model;

use Doctrine\Common\Collections\Collection;

interface OrderInterface
{
    /**
     * @return CustomerInterface|null
     */
    public function getCustomer(): ?CustomerInterface;

    public function setCustomer(?CustomerInterface $customer): void;

    /**
     * @return string|null
     */
    public function getNumber(): ?string;

    /**
     * @param string|null $number
     */
    public function setNumber(?string $number): void;

    /**
     * @return string|null
     */
    public function getStatus(): ?string;

    /**
     * @param string|null $status
     */
    public function setStatus(?string $status): void;

    /**
     * @return \DateTime|null
     */
    public function getDate(): ?\DateTime;

    /**
     * @param \DateTime|null $date
     */
    public function setDate(?\DateTime $date): void;

    /**
     * @return Collection|OrderEntryInterface[]
     */
    public function getEntries(): Collection;

    /**
     * @param OrderEntryInterface $entry
     */
    public function addEntry(OrderEntryInterface $entry): void;

    /**
     * @param OrderEntryInterface $entry
     */
    public function removeEntry(OrderEntryInterface $entry): void;

    /**
     * @param SalableItemInterface $item
     *
     * @return OrderEntryInterface|null
     */
    public function getEntryByItem(SalableItemInterface $item): ?OrderEntryInterface;
}