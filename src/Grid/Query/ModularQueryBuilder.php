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

namespace Flavioski\Module\ModularSofas\Grid\Query;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use PrestaShop\PrestaShop\Core\Grid\Query\AbstractDoctrineQueryBuilder;
use PrestaShop\PrestaShop\Core\Grid\Query\DoctrineSearchCriteriaApplicatorInterface;
use PrestaShop\PrestaShop\Core\Grid\Search\SearchCriteriaInterface;

class ModularQueryBuilder extends AbstractDoctrineQueryBuilder
{
    /**
     * @var DoctrineSearchCriteriaApplicatorInterface
     */
    private $searchCriteriaApplicator;

    /**
     * @var int
     */
    private $languageId;

    /**
     * @var int
     */
    private $shopId;

    /**
     * @param Connection $connection
     * @param string $dbPrefix
     * @param DoctrineSearchCriteriaApplicatorInterface $searchCriteriaApplicator
     * @param int $languageId
     */
    public function __construct(
        Connection $connection,
        $dbPrefix,
        DoctrineSearchCriteriaApplicatorInterface $searchCriteriaApplicator,
        $languageId,
        $shopId
    ) {
        parent::__construct($connection, $dbPrefix);

        $this->searchCriteriaApplicator = $searchCriteriaApplicator;
        $this->languageId = $languageId;
        $this->shopId = $shopId;
    }

    /**
     * {@inheritdoc}
     */
    public function getSearchQueryBuilder(SearchCriteriaInterface $searchCriteria)
    {
        $qb = $this->getQueryBuilder($searchCriteria->getFilters());
        $qb
            ->select('q.id_modular, q.code, ml.name, q.active')
            ->groupBy('q.id_modular');

        $this->searchCriteriaApplicator
            ->applySorting($searchCriteria, $qb)
            ->applyPagination($searchCriteria, $qb)
        ;

        return $qb;
    }

    /**
     * {@inheritdoc}
     */
    public function getCountQueryBuilder(SearchCriteriaInterface $searchCriteria)
    {
        $qb = $this->getQueryBuilder($searchCriteria->getFilters())
            ->select('COUNT(DISTINCT q.id_modular)');

        return $qb;
    }

    /**
     * Get generic query builder.
     *
     * @param array $filters
     *
     * @return QueryBuilder
     */
    private function getQueryBuilder(array $filters)
    {
        $allowedFilters = [
            'id_modular',
            'code',
            'name',
            'active',
        ];

        $allowedFiltersMap = [
            'id_modular' => 'q.id_modular',
            'code' => 'q.code',
            'name' => 'ml.name',
            'active' => 'q.active',
        ];

        $qb = $this->connection->createQueryBuilder();
        $qb
            ->from($this->dbPrefix . 'modular', 'q')
            ->leftJoin('q',
                $this->dbPrefix . 'modular_lang',
                'ml',
                /* @phpstan-ignore-next-line */
                $qb->expr()->andX(
                    $qb->expr()->eq('ml.`id_modular`', 'q.`id_modular`'),
                    $qb->expr()->andX($qb->expr()->isNotNull('q.`id_modular`')),
                    $qb->expr()->andX($qb->expr()->eq('ml.`id_lang`', ':langId'))
                )
            )
            ->leftJoin('q',
                $this->dbPrefix . 'modular_shop',
                'ms',
                /* @phpstan-ignore-next-line */
                $qb->expr()->andX(
                    $qb->expr()->eq('ml.`id_modular`', 'q.`id_modular`'),
                    $qb->expr()->andX($qb->expr()->eq('ms.`id_shop`', ':shopId'))
                )
            )
        ;
        $qb->andWhere('q.`deleted` = 0');
        $qb->setParameter('shopId', $this->shopId);
        $qb->setParameter('langId', $this->languageId);

        foreach ($filters as $name => $value) {
            if (!in_array($name, $allowedFilters, true)) {
                continue;
            }

            if ('id_modular' === $name) {
                $qb->andWhere($allowedFiltersMap[$name] . ' = :' . $name);
                $qb->setParameter($name, $value);

                continue;
            }

            if ('active' === $name) {
                $qb->andWhere($allowedFiltersMap[$name] . ' = :' . $name);
                $qb->setParameter($name, $value);

                continue;
            }

            $qb->andWhere($allowedFiltersMap[$name] . ' LIKE :' . $name);
            $qb->setParameter($name, '%' . $value . '%');
        }

        return $qb;
    }
}
