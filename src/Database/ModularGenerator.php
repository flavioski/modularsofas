<?php
/**
 * Modular Sofas
 * Copyright since 2021 Flavio Pellizzer and Contributors
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

namespace Flavioski\Module\ModularSofas\Database;

use Doctrine\ORM\EntityManagerInterface;
use Flavioski\Module\ModularSofas\Entity\Modular;
use Flavioski\Module\ModularSofas\Entity\ModularLang;
use Flavioski\Module\ModularSofas\Repository\ModularRepository;
use PrestaShopBundle\Entity\Lang;
use PrestaShopBundle\Entity\Shop;
use PrestaShopBundle\Entity\Repository\LangRepository;
use PrestaShopBundle\Entity\Repository\ShopRepository;

class ModularGenerator
{
    /**
     * @var ModularRepository
     */
    private $modularRepository;

    /**
     * @var LangRepository
     */
    private $langRepository;

    /**
     * @var ShopRepository
     */
    private $shopRepository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @param ModularRepository $modularRepository
     * @param LangRepository $langRepository
     * @param ShopRepository $shopRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        ModularRepository $modularRepository,
        LangRepository $langRepository,
        ShopRepository $shopRepository,
        EntityManagerInterface $entityManager
    ) {
        $this->modularRepository = $modularRepository;
        $this->langRepository = $langRepository;
        $this->shopRepository = $shopRepository;
        $this->entityManager = $entityManager;
    }

    public function generateModulars()
    {
        $this->removeAllModulars();
        $this->insertModulars();
    }

    private function removeAllModulars()
    {
        $modulars = $this->modularRepository->findAll();
        foreach ($modulars as $modular) {
            $this->entityManager->remove($modular);
        }
        $this->entityManager->flush();
    }

    private function insertModulars()
    {
        $languages = $this->langRepository->findAll();
        $shops = $this->shopRepository->findAll();
        $haveMultipleShops = $this->shopRepository->haveMultipleShops();

        $modularsDataFile = __DIR__ . '/../../Resources/data/modulars.json';
        $modularsData = json_decode(file_get_contents($modularsDataFile), true);
        foreach ($modularsData as $modularData) {
            $modular = new Modular();
            $modular->setCode($modularData['code']);
            $modular->setImage($modularData['code']);
            $modular->setActive((bool)rand(0, 1));
            /** @var Lang $language */
            foreach ($languages as $language) {
                $modularLang = new ModularLang();
                $modularLang->setLang($language);
                if (isset($modularData['name'][$language->getIsoCode()])) {
                    $modularLang->setName($modularData['name'][$language->getIsoCode()]);
                    $modularLang->setContent($modularData['name'][$language->getIsoCode()]);
                } else {
                    $modularLang->setName($modularData['name']['en']);
                    $modularLang->setContent($modularData['name']['en']);
                }
                $modular->addModularLang($modularLang);
            }
            if ($haveMultipleShops) {
                /** @var Shop $shop */
                foreach ($shops as $shop) {
                    $modularShop = new ModularShop();
                    $modularShop->setShop($shop);
                    if (isset($modularData['shop'][$shop->getId()])) {
                        $modularShop->setId($modularData['shop'][$shop->getId()]);
                } else {
                        $modularShop->setId($modularData['shop']['id']);
                    }
                    $modularShop->addModularShop($modularShop);
                }
            }
            $this->entityManager->persist($modular);
        }

        $this->entityManager->flush();
    }
}
