<?php

namespace Softspring\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

trait StoreLanguagesTrait
{
    /**
     * @var array
     * @ORM\Column(name="languages", type="simple_array", nullable=false)
     */
    protected $languages = [];

    /**
     * @return array
     */
    public function getLanguages(): array
    {
        return $this->languages;
    }

    /**
     * @param array $languages
     */
    public function setLanguages(array $languages): void
    {
        $this->languages = $languages;
    }
}