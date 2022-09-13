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
 * @copyright Since 2021 Flavio Pellizzer
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
class ModularShop
{
    /**
     * @var Modular
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Flavioski\Module\ModularSofas\Entity\Modular", inversedBy="modularLangs")
     * @ORM\JoinColumn(name="id_modular", referencedColumnName="id_modular", nullable=false)
     */
    private $modular;

    /**
     * @var Shop
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="PrestaShopBundle\Entity\Shop")
     * @ORM\JoinColumn(name="id_shop", referencedColumnName="id_shop", nullable=false, onDelete="CASCADE")
     */
    private $shop;

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
}
