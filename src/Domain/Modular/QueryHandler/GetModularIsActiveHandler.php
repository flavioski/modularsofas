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

namespace Flavioski\Module\ModularSofas\Domain\Modular\QueryHandler;

use Flavioski\Module\ModularSofas\Domain\Modular\Exception\ModularNotFoundException;
use Flavioski\Module\ModularSofas\Domain\Modular\Query\GetModularIsActive;
use Flavioski\Module\ModularSofas\Repository\ModularRepository;

class GetModularIsActiveHandler extends AbstractModularHandler
{
    /**
     * @var ModularRepository
     */
    private $modularRepository;

    public function __construct(ModularRepository $modularRepository)
    {
        $this->modularRepository = $modularRepository;
    }

    public function handle(GetModularIsActive $query)
    {
        $modularId = $query->getModularId()->getValue();
        $modular = $this->modularRepository->find($modularId);

        if ($modular->getId() !== $modularId) {
            throw new ModularNotFoundException(sprintf('Modular with id "%d" was not found.', $modularId));
        }

        return (bool) $modular->isActive();
    }
}
