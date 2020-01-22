<?php

namespace Softspring\ShopBundle\Model;

interface OrderTransitionInterface
{
    /**
     * @return OrderInterface|null
     */
    public function getOrder(): ?OrderInterface;

    /**
     * @param OrderInterface|null $order
     */
    public function setOrder(?OrderInterface $order): void;

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
}