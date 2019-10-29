<?php

namespace Softspring\ShopBundle\Model;

interface StoreLanguagesInterface
{
    /**
     * @return array
     */
    public function getLanguages(): array;

    /**
     * @param array $languages
     */
    public function setLanguages(array $languages): void;
}