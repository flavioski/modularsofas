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

namespace Flavioski\Module\ModularSofas\Domain\Product\QueryHandler;

use Flavioski\Module\ModularSofas\Domain\Product\ProductRequiredFieldsProviderInterface;
use Flavioski\Module\ModularSofas\Domain\Product\Query\GetProductRequiredFields;
use Flavioski\Module\ModularSofas\Domain\Product\QueryResult\ProductRequiredFields;

/**
 * Handles and provides product attribute requirements
 */
final class GetProductRequiredFieldsHandler implements GetProductRequiredFieldsHandlerInterface
{
    /** @var ProductRequiredFieldsProviderInterface */
    private $requiredFieldsProvider;

    /**
     * @param ProductRequiredFieldsProviderInterface $requiredFieldsProvider
     */
    public function __construct(ProductRequiredFieldsProviderInterface $requiredFieldsProvider)
    {
        $this->requiredFieldsProvider = $requiredFieldsProvider;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(GetProductRequiredFields $query): ProductRequiredFields
    {
        return new ProductRequiredFields(
            $this->requiredFieldsProvider->isCombinationsRequired($query->getProductId())
        );
    }
}
