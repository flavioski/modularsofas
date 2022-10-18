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

use Flavioski\Module\ModularSofas\Grid\Filters\ModularFilters;
use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use PrestaShopBundle\Security\Annotation\AdminSecurity;
use PrestaShopBundle\Security\Annotation\DemoRestricted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ModularController extends FrameworkBundleAdminController
{
    /**
     * List modulars
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
        if ($request->isMethod('POST')) {
            $generator = $this->get('flavioski.module.modularsofas.modulars.generator');
            $generator->generateModulars();
            $this->addFlash('success', $this->trans('Modulars were successfully generated.', 'Modules.ModularSofas.Admin'));

            return $this->redirectToRoute('flavioski_modularsofas_modular_index');
        }

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
     * Create modular
     *
     * @AdminSecurity(
     *     "is_granted(['create', 'update'], request.get('_legacy_controller'))",
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
    public function createAction(Request $request)
    {
        $modularFormBuilder = $this->get('flavioski.module.modularsofas.form.identifiable_object.builder.modular_form_builder');
        $formData = [];
        // Product needs to be preset before building form type because it is used to build combinations field choices
        if ($request->request->has('modular') && isset($request->request->get('modular')['id_product'])) {
            $formProductId = (int) $request->request->get('modular')['id_product'];
            $formData['id_product'] = $formProductId;
        }
        $modularForm = $modularFormBuilder->getForm($formData);
        $modularForm->handleRequest($request);

        $modularFormHandler = $this->get('flavioski.module.modularsofas.form.identifiable_object.handler.modular_form_handler');
        $result = $modularFormHandler->handle($modularForm);

        if (null !== $result->getIdentifiableObjectId()) {
            $this->addFlash(
                'success',
                $this->trans('Successful creation.', 'Admin.Notifications.Success')
            );

            return $this->redirectToRoute('flavioski_modularsofas_modular_index');
        }

        return $this->render('@Modules/modularsofas/views/templates/admin/modular/create.html.twig', [
            'modularForm' => $modularForm->createView(),
        ]);
    }

    /**
     * Edit modular
     *
     * @AdminSecurity(
     *     "is_granted(['update'], request.get('_legacy_controller'))",
     *     message="You do not have permission to read this.",
     *     redirectRoute="flavioski_modularsofas_modular_index"
     * )
     * @DemoRestricted(redirectRoute="flavioski_modularsofas_modular_index",
     *     message="You can't do this when demo mode is enabled.",
     *     domain="Admin.Global"
     * )
     *
     * @param Request $request
     * @param int $treatmentId
     *
     * @return Response
     */
    public function editAction(Request $request, $modularId)
    {
        $modularFormBuilder = $this->get('flavioski.module.modularsofas.form.identifiable_object.builder.modular_form_builder');
        $formData = [];
        // Product needs to be preset before building form type because it is used to build combinations field choices
        if ($request->request->has('modular') && isset($request->request->get('modular')['id_product'])) {
            $formProductId = (int) $request->request->get('modular')['id_product'];
            $formData['id_product'] = $formProductId;
        }
        $modularForm = $modularFormBuilder->getFormFor((int) $modularId, $formData);
        $modularForm->handleRequest($request);

        $modularFormHandler = $this->get('flavioski.module.modularsofas.form.identifiable_object.handler.modular_form_handler');
        $result = $modularFormHandler->handleFor((int) $modularId, $modularForm);

        if ($result->isSubmitted() && $result->isValid()) {
            $this->addFlash('success', $this->trans('Successful update.', 'Admin.Notifications.Success'));

            return $this->redirectToRoute('flavioski_modularsofas_modular_index');
        }

        return $this->render('@Modules/modularsofas/views/templates/admin/modular/edit.html.twig', [
            'modularForm' => $modularForm->createView(),
        ]);
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
