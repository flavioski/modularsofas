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

namespace Flavioski\Module\ModularSofas\Domain\Modular\Query;

use Flavioski\Module\ModularSofas\Domain\Modular\ValueObject\ModularId;

/**
 * Get current status (enabled/disabled) for a given modular
 */
class GetModularIsActive
{
    /**
     * @var ModularId
     */
    private $modularId;

    /**
     * @param int $modularId
     *
     * @throws \Flavioski\Module\ModularSofas\Domain\Modular\Exception\InvalidModularIdException
     */
    public function __construct(int $modularId)
    {
        $this->modularId = new ModularId($modularId);
    }

    /**
     * @return ModularId
     */
    public function getModularId(): ModularId
    {
        return $this->modularId;
    }
}
