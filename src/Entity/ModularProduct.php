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

use Doctrine\ORM\Mapping as ORM;
use PrestaShopBundle\Entity\Shop;

/**
 * @ORM\Table()
 * @ORM\Entity()
 */
class ModularProduct
{
    /**
     * @var Modular
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Flavioski\Module\ModularSofas\Entity\Modular", inversedBy="modularProducts")
     * @ORM\JoinColumn(name="id_modular", referencedColumnName="id_modular", nullable=false)
     */
    private $modular;

    /**
     * @var int
     *
     * @ORM\Column(name="id_product", type="integer", options={"unsigned"=true}, nullable=false)
     */
    private $productId;

    /**
     * @var int
     *
     * @ORM\Column(name="id_product_attribute", type="integer", options={"unsigned"=true}, nullable=false)
     */
    private $productAttributeId;

    /**
     * @var Shop
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="PrestaShopBundle\Entity\Shop")
     * @ORM\JoinColumn(name="id_shop", referencedColumnName="id_shop", nullable=false, onDelete="CASCADE")
     */
    private $shop;

    /**
     * @var int
     * @ORM\Column(name="position", type="integer", options={"unsigned"=true}, nullable=false)
     */
    private $position;

    /**
     * @var int
     * @ORM\Column(name="length", type="integer", options={"unsigned"=true}, nullable=true)
     */
    private $length;

    /**
     * @var int
     * @ORM\Column(name="depth", type="integer", options={"unsigned"=true}, nullable=true)
     */
    private $depth;

    /**
     * @var int
     * @ORM\Column(name="height", type="integer", options={"unsigned"=true}, nullable=true)
     */
    private $height;

    /**
     * @return Modular
     */
    public function getModular()
    {
        return $this->modular;
    }

    /**
     * @param Modular $modular
     *
     * @return $this
     */
    public function setModular(Modular $modular)
    {
        $this->modular = $modular;

        return $this;
    }

    /**
     * @return int
     */
    public function getProductId()
    {
        return $this->productId;
    }

    /**
     * @param int $productId
     *
     * @return ModularProduct
     */
    public function setProductId(int $productId): ModularProduct
    {
        $this->productId = $productId;

        return $this;
    }

    /**
     * @return int
     */
    public function getProductAttributeId(): ?int
    {
        return $this->productAttributeId;
    }

    /**
     * @param int|null $productAttributeId
     *
     * @return ModularProduct
     */
    public function setProductAttributeId(?int $productAttributeId): self
    {
        $this->productAttributeId = $productAttributeId;

        return $this;
    }

    /**
     * @return Shop
     */
    public function getShop()
    {
        return $this->shop;
    }

    /**
     * @param Shop $shop
     *
     * @return $this
     */
    public function setShop(Shop $shop)
    {
        $this->shop = $shop;

        return $this;
    }

    /**
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param int $position
     *
     * @return $this
     */
    public function setPosition(int $position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @return int
     */
    public function getLength(): ?int
    {
        return $this->length;
    }

    /**
     * @param int|null $length
     *
     * @return ModularProduct
     */
    public function setLength(?int $length): self
    {
        $this->length = $length;

        return $this;
    }

    /**
     * @return int
     */
    public function getDepth(): ?int
    {
        return $this->depth;
    }

    /**
     * @param int|null $depth
     *
     * @return ModularProduct
     */
    public function setDepth(?int $depth): self
    {
        $this->depth = $depth;

        return $this;
    }

    /**
     * @return int
     */
    public function getHeight(): ?int
    {
        return $this->height;
    }

    /**
     * @param int|null $height
     *
     * @return ModularProduct
     */
    public function setHeight(?int $height): self
    {
        $this->height = $height;

        return $this;
    }
}
