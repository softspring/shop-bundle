<?php

namespace Softspring\ShopBundle\Twig\Extension;

use Doctrine\Common\Collections\Collection;
use Softspring\ShopBundle\Manager\StoreManagerInterface;
use Softspring\ShopBundle\Model\StoreLanguagesInterface;
use Softspring\ShopBundle\Model\StoreSimpleCountriesInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class ShopExtension extends AbstractExtension
{
    /**
     * @var StoreManagerInterface|null
     */
    protected $storeManager;

    /**
     * ShopExtension constructor.
     *
     * @param StoreManagerInterface|null $storeManager
     */
    public function __construct(?StoreManagerInterface $storeManager)
    {
        $this->storeManager = $storeManager;
    }


    /**
     * @inheritDoc
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('sfs_shop_store_has_languages', [$this, 'storeHasLanguages']),
            new TwigFunction('sfs_shop_store_has_countries', [$this, 'storeHasCountries']),
        ];
    }

    /**
     * @return bool
     */
    public function storeHasLanguages(): bool
    {
        if (!$this->storeManager instanceof StoreManagerInterface) {
            return false;
        }

        return $this->storeManager->getEntityClassReflection()->implementsInterface(StoreLanguagesInterface::class);
    }

    /**
     * @return bool
     */
    public function storeHasCountries(): bool
    {
        if (!$this->storeManager instanceof StoreManagerInterface) {
            return false;
        }

        return $this->storeManager->getEntityClassReflection()->implementsInterface(StoreSimpleCountriesInterface::class);
    }

}