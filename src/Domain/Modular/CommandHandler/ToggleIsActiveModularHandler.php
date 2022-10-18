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

namespace Flavioski\Module\ModularSofas\Domain\Modular\CommandHandler;

use Doctrine\ORM\EntityManagerInterface;
use Flavioski\Module\ModularSofas\Domain\Modular\Command\ToggleIsActiveModularCommand;
use Flavioski\Module\ModularSofas\Domain\Modular\Exception\CannotToggleActiveModularStatusException;
use Flavioski\Module\ModularSofas\Domain\Modular\Exception\ModularNotFoundException;
use Flavioski\Module\ModularSofas\Repository\ModularRepository;

class ToggleIsActiveModularHandler extends AbstractModularHandler
{
    /**
     * @var ModularRepository
     */
    private $modularRepository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(ModularRepository $modularRepository, EntityManagerInterface $entityManager)
    {
        $this->modularRepository = $modularRepository;
        $this->entityManager = $entityManager;
    }

    public function handle(ToggleIsActiveModularCommand $command)
    {
        $modularId = $command->getModularId()->getValue();
        $modular = $this->modularRepository->find($modularId);

        if ($modular->getId() !== $modularId) {
            throw new ModularNotFoundException(sprintf('Modular with id "%id" was not found', $modularId));
        }

        if ($modular->isActive() != $command->getActive()) {
            $modular->setActive($command->getActive());

            if (false === $this->entityManager->flush()) {
                throw new CannotToggleActiveModularStatusException(sprintf('Failed to change status for modular with id "%s"', $command->getModularId()->getValue()));
            }
        }
    }
}
