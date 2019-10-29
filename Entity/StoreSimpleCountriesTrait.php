<?php

namespace Softspring\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

trait StoreSimpleCountriesTrait
{
    /**
     * @var array
     * @ORM\Column(name="countries", type="simple_array", nullable=false)
     */
    protected $countries = [];

    /**
     * @return array
     */
    public function getCountries(): array
    {
        return $this->countries;
    }

    /**
     * @param array $countries
     */
    public function setCountries(array $countries): void
    {
        $this->countries = $countries;
    }
}