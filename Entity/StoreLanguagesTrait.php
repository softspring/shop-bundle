<?php

namespace Softspring\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Softspring\ShopBundle\Model\StoreLanguagesTrait as StoreLanguagesTraitModel;

trait StoreLanguagesTrait
{
    use StoreLanguagesTraitModel;

    /**
     * @var array
     * @ORM\Column(name="languages", type="simple_array", nullable=false)
     */
    protected $languages = [];
}