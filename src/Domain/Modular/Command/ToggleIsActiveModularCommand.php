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

namespace Flavioski\Module\ModularSofas\Domain\Modular\Command;

use Flavioski\Module\ModularSofas\Domain\Modular\Exception\InvalidModularIdException;
use Flavioski\Module\ModularSofas\Domain\Modular\ValueObject\ModularId;

class ToggleIsActiveModularCommand
{
    /**
     * @var ModularId
     */
    private $modularId;

    /**
     * @var bool
     */
    private $active;

    /**
     * ToggleIsActiveModularCommand constructor.
     *
     * @param int $modularId
     * @param bool $active
     *
     * @throws InvalidModularIdException
     */
    public function __construct(int $modularId, bool $active)
    {
        $this->modularId = new ModularId($modularId);
        $this->active = $active;
    }

    /**
     * @return ModularId
     */
    public function getModularId(): ModularId
    {
        return $this->modularId;
    }

    /**
     * @return bool
     */
    public function getActive(): bool
    {
        return $this->active;
    }
}
