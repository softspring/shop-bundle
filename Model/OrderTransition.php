<?php

namespace Softspring\ShopBundle\Model;

abstract class OrderTransition implements OrderTransitionInterface
{
    /**
     * @var OrderInterface|null
     */
    protected $order;

    /**
     * @var int|null
     */
    protected $date;

    /**
     * @var string|null
     */
    protected $status;

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
        return $this->date ? \DateTime::createFromFormat("U", $this->date) : null;
    }

    /**
     * @param \DateTime|null $date
     */
    public function setDate(?\DateTime $date): void
    {
        $this->date = $date ? $date->format('U') : null;
    }
}