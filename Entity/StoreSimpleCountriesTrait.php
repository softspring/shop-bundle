<?php

namespace Softspring\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Softspring\ShopBundle\Model\StoreSimpleCountriesTrait as StoreSimpleCountriesTraitModel;

trait StoreSimpleCountriesTrait
{
    use StoreSimpleCountriesTraitModel;

    /**
     * @var array
     * @ORM\Column(name="countries", type="simple_array", nullable=false)
     */
    protected $countries = [];
}