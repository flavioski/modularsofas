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

namespace Flavioski\Module\ModularSofas\Domain\Modular\ValueObject;

use Flavioski\Module\ModularSofas\Domain\Modular\Exception\InvalidModularIdException;

class ModularId
{
    private $modularId;

    /**
     * ModularId constructor.
     *
     * @param int $modularId
     *
     * @throws InvalidModularIdException
     */
    public function __construct($modularId)
    {
        $this->assertIntegerIsGreaterThanZero($modularId);

        $this->modularId = $modularId;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->modularId;
    }

    /**
     * @param int $modularId
     *
     * @throws InvalidModularIdException
     */
    private function assertIntegerIsGreaterThanZero($modularId)
    {
        if (!is_numeric($modularId) || 0 > $modularId) {
            throw new InvalidModularIdException(sprintf('Invalid modular id %s supplied. modular id must be positive integer.', var_export($modularId, true)));
        }
    }
}
