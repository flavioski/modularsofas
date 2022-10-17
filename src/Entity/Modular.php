<?php
/**
 * Modular Sofas
 * Copyright since 2022 Flavio Pellizzer and Contributors
 * <Flavio Pellizzer> Property
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/MIT
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to flappio.pelliccia@gmail.com so we can send you a copy immediately.
 *
 * @author    Flavio Pellizzer
 * @copyright Since 2022 Flavio Pellizzer
 * @license   https://opensource.org/licenses/MIT
 */
declare(strict_types=1);

namespace Flavioski\Module\ModularSofas\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use PrestaShopBundle\Entity\Shop;

/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Flavioski\Module\ModularSofas\Repository\ModularRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Modular
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(name="id_modular", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="Flavioski\Module\ModularSofas\Entity\ModularProduct", cascade={"persist", "remove"}, mappedBy="modular")
     */
    private $modularProducts;

    /**
     * @ORM\OneToMany(targetEntity="Flavioski\Module\ModularSofas\Entity\ModularLang", cascade={"persist", "remove"}, mappedBy="modular")
     */
    private $modularLangs;

    /**
     * @ORM\ManyToMany(targetEntity="PrestaShopBundle\Entity\Shop", cascade={"persist"})
     * @ORM\JoinTable(
     *      joinColumns={@ORM\JoinColumn(name="id_modular", referencedColumnName="id_modular")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="id_shop", referencedColumnName="id_shop", onDelete="CASCADE")}
     * )
     */
    private $shops;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=128, nullable=false)
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=128, nullable=false)
     */
    private $image;

    /**
     * @var bool
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;

    /**
     * @var bool
     *
     * @ORM\Column(name="deleted", type="boolean")
     */
    private $deleted = false;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_add", type="datetime")
     */
    private $dateAdd;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_upd", type="datetime")
     */
    private $dateUpd;

    public function __construct()
    {
        $this->setDateAdd(new \DateTime());
        $this->setDateUpd(new \DateTime());
        $this->setActive(true);
        $this->setDeleted(false);
        $this->modularLangs = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return ArrayCollection
     */
    public function getModularProducts()
    {
        return $this->modularProducts;
    }

    /**
     * @return ArrayCollection
     */
    public function getModularLangs()
    {
        return $this->modularLangs;
    }

    /**
     * Get shops.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getShops()
    {
        return $this->shops;
    }

    /**
     * Add shop.
     *
     * @param \PrestaShopBundle\Entity\Shop $shop
     *
     * @return Modular
     */
    public function addShop(Shop $shop)
    {
        $this->shops[] = $shop;

        return $this;
    }

    /**
     * Remove shop.
     *
     * @param \PrestaShopBundle\Entity\Shop $shop
     */
    public function removeShop(Shop $shop)
    {
        $this->shops->removeElement($shop);
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     *
     * @return Modular
     */
    public function setCode(string $code): Modular
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return string
     */
    public function getImage(): string
    {
        return $this->image;
    }

    /**
     * @param string $image
     *
     * @return Modular
     */
    public function setImage(string $image): Modular
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Is active.
     *
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * Set active.
     *
     * @param bool $active
     *
     * @return Modular
     */
    public function setActive(bool $active): Modular
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Is deleted.
     *
     * @return bool
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Set deleted.
     *
     * @param bool $deleted
     *
     * @return Modular
     */
    public function setDeleted(bool $deleted): Modular
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * @param int $shopId
     * @param int $productId
     * @param int $attributeId
     *
     * @return ModularProduct|null
     */
    public function getModularProductByShopIdProductIdAttributeId(int $shopId, int $productId, int $attributeId)
    {
        foreach ($this->modularProducts as $modularProduct) {
            if (
                $shopId === $modularProduct->getShop->getId()
                && $productId === $modularProduct->getProduct->getId()
                && $attributeId === $modularProduct->getAttribute->getId()
            ) {
                return $modularProduct;
            }
        }

        return null;
    }

    /**
     * @param ModularProduct $modularProduct
     *
     * @return $this
     */
    public function addModularProduct(ModularProduct $modularProduct)
    {
        $modularProduct->setModular($this);
        $this->modularProducts->add($modularProduct);

        return $this;
    }

    /**
     * @return int
     */
    public function getModularProductPosition()
    {
        if ($this->modularProducts->count() <= 0) {
            return 1;
        }

        $modularProduct = $this->modularProducts->first();

        return $modularProduct->getPosition();
    }

    /**
     * @param int $langId
     *
     * @return ModularLang|null
     */
    public function getModularLangByLangId(int $langId)
    {
        foreach ($this->modularLangs as $modularLang) {
            if ($langId === $modularLang->getLang()->getId()) {
                return $modularLang;
            }
        }

        return null;
    }

    /**
     * @param ModularLang $modularLang
     *
     * @return $this
     */
    public function addModularLang(ModularLang $modularLang)
    {
        $modularLang->setModular($this);
        $this->modularLangs->add($modularLang);

        return $this;
    }

    /**
     * @return string
     */
    public function getModularName()
    {
        if ($this->modularLangs->count() <= 0) {
            return '';
        }

        $modularLang = $this->modularLangs->first();

        return $modularLang->getName();
    }

    /**
     * @return string
     */
    public function getModularContent()
    {
        if ($this->modularLangs->count() <= 0) {
            return '';
        }

        $modularLang = $this->modularLangs->first();

        return $modularLang->getContent();
    }

    /**
     * Get date add
     *
     * @return \DateTime
     */
    public function getDateAdd(): DateTime
    {
        return $this->dateAdd;
    }

    /**
     * Date is stored in UTC timezone
     *
     * @param DateTime $dateAdd
     *
     * @return $this
     */
    public function setDateAdd(DateTime $dateAdd)
    {
        $this->dateAdd = $dateAdd;

        return $this;
    }

    /**
     * Get date upd
     *
     * @return DateTime
     */
    public function getDateUpd(): DateTime
    {
        return $this->dateUpd;
    }

    /**
     * Date is stored in UTC timezone
     *
     * @param DateTime $dateUpd
     *
     * @return $this
     */
    public function setDateUpd(DateTime $dateUpd)
    {
        $this->dateUpd = $dateUpd;

        return $this;
    }

    /**
     * Now we tell doctrine that before we persist or update we call the updatedTimestamps() function.
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps()
    {
        $this->setDateUpd(new DateTime());

        if ($this->getDateAdd() == null) {
            $this->setDateAdd(new DateTime());
        }
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'id_modular' => $this->getId(),
            'code' => $this->getCode(),
            'image' => $this->getImage(),
            'active' => $this->isActive(),
            'deleted' => $this->isDeleted(),
            'date_add' => $this->dateAdd->format(\DateTime::ATOM),
            'date_upd' => $this->dateUpd->format(\DateTime::ATOM),
        ];
    }
}
