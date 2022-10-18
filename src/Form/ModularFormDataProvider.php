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
 * @author    Flavio Pellizzer <flappio.pelliccia@gmail.com>
 * @copyright Since 2022 Flavio Pellizzer
 * @license   https://opensource.org/licenses/MIT
 */
declare(strict_types=1);

namespace Flavioski\Module\ModularSofas\Form;

use Flavioski\Module\ModularSofas\Repository\ModularRepository;
use PrestaShop\PrestaShop\Core\Form\IdentifiableObject\DataProvider\FormDataProviderInterface;

class ModularFormDataProvider implements FormDataProviderInterface
{
    /**
     * @var ModularRepository
     */
    private $modularRepository;

    /**
     * @param ModularRepository $modularRepository
     */
    public function __construct(
        ModularRepository $modularRepository
    ) {
        $this->modularRepository = $modularRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function getData($modularId)
    {
        $modular = $this->modularRepository->findOneById($modularId);

        $modularData = [
            'code' => $modular->getCode(),
            'name' => $modular->getName(),
            //'price' => $modular->getPrice(),
            //'id_product' => $modular->getProductId(),
            //'id_product_attribute' => $modular->getProductAttributeId(),
            'active' => $modular->isActive(),
        ];

        foreach ($modular->getModularLangs() as $modularLang) {
            $modularData['name'][$modularLang->getLang()->getId()] = $modularLang->getName();
            $modularData['content'][$modularLang->getLang()->getId()] = $modularLang->getContent();
        }

        return $modularData;
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultData()
    {
        return [
            'code' => '',
            'name' => [],
            'content' => [],
            //'price' => 0,
            //'id_product' => 0,
            //'id_product_attribute' => null,
            'active' => false,
        ];
    }
}
