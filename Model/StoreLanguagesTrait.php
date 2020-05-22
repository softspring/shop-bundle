<?php

namespace Softspring\ShopBundle\Model;

trait StoreLanguagesTrait
{
    /**
     * @var array
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