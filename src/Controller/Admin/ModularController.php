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

namespace Flavioski\Module\ModularSofas\Controller\Admin;

use Flavioski\Module\ModularSofas\Grid\Definition\Factory\ModularGridDefinitionFactory;
use Flavioski\Module\ModularSofas\Grid\Filters\ModularFilters;
use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use PrestaShopBundle\Security\Annotation\AdminSecurity;
use PrestaShopBundle\Security\Annotation\DemoRestricted;
use PrestaShopBundle\Service\Grid\ResponseBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ModularController extends FrameworkBundleAdminController
{
    /**
     * List treatments
     *
     * @AdminSecurity(
     *     "is_granted(['read'], request.get('_legacy_controller'))",
     *     message="You do not have permission to read this.",
     *     redirectRoute="flavioski_modularsofas_modular_index"
     * )
     * @DemoRestricted(redirectRoute="flavioski_modularsofas_modular_index",
     *     message="You can't do this when demo mode is enabled.",
     *     domain="Admin.Global"
     * )
     *
     * @param Request $request
     * @param ModularFilters $filters
     *
     * @return Response
     */
    public function indexAction(Request $request, ModularFilters $filters)
    {
        $modularGridFactory = $this->get('flavioski.module.modularsofas.grid.factory.modulars');
        $modularGrid = $modularGridFactory->getGrid($filters);

        return $this->render(
            '@Modules/modularsofas/views/templates/admin/modular/index.html.twig',
            [
                'enableSidebar' => true,
                'layoutTitle' => $this->trans('Modulars', 'Modules.ModularSofas.Admin'),
                'layoutHeaderToolbarBtn' => $this->getToolbarButtons(),
                'modularGrid' => $this->presentGrid($modularGrid),
            ]
        );
    }

    /**
     * Generate modulars
     *
     * @AdminSecurity(
     *     "is_granted(['read','update'], request.get('_legacy_controller'))",
     *     message="You do not have permission to read this.",
     *     redirectRoute="flavioski_modularsofas_modular_index"
     * )
     * @DemoRestricted(redirectRoute="flavioski_modularsofas_modular_index",
     *     message="You can't do this when demo mode is enabled.",
     *     domain="Admin.Global"
     * )
     *
     * @param Request $request
     *
     * @return Response
     */
    public function generateAction(Request $request)
    {
        return $this->render(
            '@Modules/modularsofas/views/templates/admin/modular/generate.html.twig',
            [
                'enableSidebar' => true,
                'layoutTitle' => $this->trans('Modulars', 'Modules.ModularSofas.Admin'),
                'layoutHeaderToolbarBtn' => $this->getToolbarButtons(),
            ]
        );
    }

    /**
     * @return array[]
     */
    private function getToolbarButtons()
    {
        return [
            'demo' => [
                'desc' => $this->trans('Generate Modulars', 'Modules.ModularSofas.Admin'),
                'icon' => 'sync',
                'href' => $this->generateUrl('flavioski_modularsofas_modular_generate'),
            ],
        ];
    }
}
