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

use Doctrine\ORM\EntityManagerInterface;
use Flavioski\Module\ModularSofas\Entity\Modular;
use Flavioski\Module\ModularSofas\Entity\ModularLang;
use Flavioski\Module\ModularSofas\Repository\ModularRepository;
use PrestaShop\PrestaShop\Core\Form\IdentifiableObject\DataHandler\FormDataHandlerInterface;
use PrestaShopBundle\Entity\Repository\LangRepository;

class ModularFormDataHandler implements FormDataHandlerInterface
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
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @param ModularRepository $modularRepository
     * @param LangRepository $langRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        ModularRepository $modularRepository,
        LangRepository $langRepository,
        EntityManagerInterface $entityManager
    ) {
        $this->modularRepository = $modularRepository;
        $this->langRepository = $langRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $data)
    {
        $modular = new Modular();
        $modular->setCode($data['code']);
        //$modular->setName($data['name']);
        //$modular->setPrice($data['price']);
        $modular->setActive($data['active']);
        //$modular->setProductId((int) $data['id_product']);
        //$modular->setProductAttributeId($data['id_product_attribute']);
        foreach ($data['name'] as $langId => $langName) {
            $lang = $this->langRepository->findOneById($langId);
            $modularLang = new ModularLang();
            $modularLang
                ->setLang($lang)
                ->setName($langName)
            ;
            $modular->addModularLang($modularLang);
        }
        foreach ($data['content'] as $langId => $langContent) {
            $lang = $this->langRepository->findOneById($langId);
            $modularLang = new ModularLang();
            $modularLang
                ->setLang($lang)
                ->setContent($langContent)
            ;
            $modular->addModularLang($modularLang);
        }

        $this->entityManager->persist($modular);
        $this->entityManager->flush();

        return $modular->getId();
    }

    /**
     * {@inheritdoc}
     */
    public function update($id, array $data)
    {
        $modular = $this->modularRepository->findOneById($id);
        $modular->setCode($data['code']);
        //$modular->setName($data['name']);
        //$modular->setPrice($data['price']);
        $modular->setActive($data['active']);
        //$modular->setProductId((int) $data['id_product']);
        //$modular->setProductAttributeId($data['id_product_attribute']);
        foreach ($data['name'] as $langId => $name) {
            $modularLang = $modular->getModularLangByLangId($langId);
            if (null === $modularLang) {
                continue;
            }
            $modularLang->setName($name);
        }
        foreach ($data['content'] as $langId => $content) {
            $modularLang = $modular->getModularLangByLangId($langId);
            if (null === $modularLang) {
                continue;
            }
            $modularLang->setContent($content);
        }
        $this->entityManager->flush();

        return $modular->getId();
    }
}
