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

use Flavioski\Module\ModularSofas\Database\ModularSofasInstaller;

if (!defined('_PS_VERSION_')) {
    exit;
}

if (!defined('_CAN_LOAD_FILES_')) {
    exit;
}

if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
}

class ModularSofas extends Module
{
    public $configurationList = [
        'MODULARSOFAS_CONFIGURATION_TEST' => '1',
        'MODULARSOFAS_CONFIGURATION_PRODUCTION' => '0',
    ];

    /** @var array */
    private array $hookList;

    /** @var array */
    private array $layoutList;

    public function __construct()
    {
        $this->name = 'modularsofas';
        $this->tab = 'administrator';
        $this->version = '1.0.0';
        $this->author = 'Flavio Pellizzer';
        $this->need_instance = 0;

        parent::__construct();

        $this->displayName = $this->getTranslator()->trans(
            'Modular Sofas',
            [],
            'Modules.ModularSofas.Admin'
        );

        $this->description =
            $this->getTranslator()->trans(
                'Create modular fabric, leather coated sofas as plugin for PrestaShop solution.',
                [],
                'Modules.ModularSofas.Admin'
            );

        $this->ps_versions_compliancy = [
            'min' => '1.7.8.4',
            'max' => _PS_VERSION_,
        ];

        $this->hookList = [];

        $this->layoutList = [];
    }

    /**
     * This function is required in order to make module compatible with new translation system.
     *
     * @return bool
     */
    public function isUsingNewTranslationSystem()
    {
        return true;
    }

    /**
     * Install module and register hooks to allow grid modification.
     *
     * @see https://devdocs.prestashop.com/1.7/modules/concepts/hooks/use-hooks-on-modern-pages/
     *
     * @return bool
     */
    public function install()
    {
        return $this->installTables() &&
            $this->installConfiguration() && parent::install() &&
            $this->registerHooks() &&
            $this->installTab()
            ;
    }

    /**
     * Uninstall module and detach hooks
     *
     * @return bool
     */
    public function uninstall()
    {
        return $this->removeTables() &&
            $this->uninstallConfiguration() && parent::uninstall() &&
            $this->unregisterHooks() &&
            $this->uninstallTab()
            ;
    }

    /**
     * enable
     *
     * @param bool $force_all
     *
     * @return bool
     *
     * @throws PrestaShopDatabaseException
     * @throws PrestaShopException
     */
    public function enable($force_all = false)
    {
        return parent::enable($force_all)
            && $this->registerHooks()
            && $this->installTab()
            ;
    }

    /**
     * disable
     *
     * @param bool $force_all
     *
     * @return bool
     *
     * @throws PrestaShopDatabaseException
     * @throws PrestaShopException
     */
    public function disable($force_all = false)
    {
        return parent::disable($force_all)
            && $this->unregisterHooks()
            && $this->uninstallTab()
            ;
    }

    /**
     * @return bool
     */
    private function installTables()
    {
        /** @var ModularSofasInstaller $installer */
        $installer = $this->getInstaller();
        $errors = $installer->createTables();

        return empty($errors);
    }

    /**
     * @return bool
     */
    private function removeTables()
    {
        /** @var ModularSofasInstaller $installer */
        $installer = $this->getInstaller();
        $errors = $installer->dropTables();

        return empty($errors);
    }

    /**
     * @return ModularSofasInstaller
     */
    private function getInstaller()
    {
        try {
            $installer = $this->get('flavioski.module.modularsofas.modularsofas.install');
        } catch (Exception $e) {
            // Catch exception in case container is not available, or service is not available
            $installer = null;
        }

        // During install process the module's service is not available yet, so we build it manually
        if (!$installer) {
            $installer = new ModularSofasInstaller(
                $this->get('doctrine.dbal.default_connection'),
                $this->getContainer()->getParameter('database_prefix')
            );
        }

        return $installer;
    }

    /**
     * install Tab
     *
     * @return bool
     *
     * @throws PrestaShopDatabaseException
     * @throws PrestaShopException
     */
    private function installTab()
    {
        // Main
        $MainTabId = (int) Tab::getIdFromClassName('AdminModularSofas');
        if (!$MainTabId) {
            $MainTabId = null;
        }

        $MainTab = new Tab($MainTabId);
        $MainTab->active = true;
        $MainTab->class_name = 'AdminModularSofas';
        $MainTab->name = [];
        foreach (Language::getLanguages(true) as $lang) {
            $MainTab->name[$lang['id_lang']] = 'Modular Sofas';
        }
        $MainTab->id_parent = 0;
        $MainTab->module = $this->name;
        $MainTab->save();

        // Sub for "Configuration"
        $ConfigurationTabId = (int) Tab::getIdFromClassName('AdminModularSofasConfiguration');
        if (!$ConfigurationTabId) {
            $ConfigurationTab = null;
        }

        $ConfigurationTab = new Tab($ConfigurationTabId);
        $ConfigurationTab->active = true;
        $ConfigurationTab->class_name = 'AdminModularSofasConfiguration';
        $ConfigurationTab->name = [];
        foreach (Language::getLanguages(true) as $lang) {
            $ConfigurationTab->name[$lang['id_lang']] = 'Configuration';
        }
        $ConfigurationTab->id_parent = $MainTab->id;
        $ConfigurationTab->module = $this->name;
        $ConfigurationTab->save();

        // Sub for "Modular"
        $ModularTabId = (int) Tab::getIdFromClassName('AdminModularSofasModular');
        if (!$ModularTabId) {
            $ModularTab = null;
        }

        $ModularTab = new Tab($ModularTabId);
        $ModularTab->active = true;
        $ModularTab->class_name = 'AdminModularSofasModular';
        $ModularTab->name = [];
        foreach (Language::getLanguages(true) as $lang) {
            $ModularTab->name[$lang['id_lang']] = 'Modular';
        }
        $ModularTab->id_parent = $MainTab->id;
        $ModularTab->module = $this->name;
        $ModularTab->save();

        return true;
    }

    /**
     * uninstall Tab
     *
     * @return bool
     *
     * @throws PrestaShopDatabaseException
     * @throws PrestaShopException
     */
    private function uninstallTab()
    {
        // Main
        $MainTabId = (int) Tab::getIdFromClassName('AdminModularSofas');
        if ($MainTabId) {
            $Maintab = new Tab($MainTabId);
            $Maintab->delete();
        }

        $ConfigurationTabId = (int) Tab::getIdFromClassName('AdminModularSofasConfiguration');
        if (!$ConfigurationTabId) {
            return true;
        }
        $ConfigurationTab = new Tab($ConfigurationTabId);
        $ConfigurationTab->delete();

        $ModularTabId = (int) Tab::getIdFromClassName('AdminModularSofasModular');
        if (!$ModularTabId) {
            return true;
        }
        $ModularTab = new Tab($ModularTabId);
        $ModularTab->delete();

        return true;
    }

    /**
     * @return bool
     */
    private function registerHooks()
    {
        if (count($this->hookList)) {
            foreach ($this->hookList as $hookName) {
                if (!$this->registerHook($hookName)) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * @return bool
     */
    private function unregisterHooks()
    {
        if (count($this->hookList)) {
            foreach ($this->hookList as $hookName) {
                if (!$this->unregisterHook($hookName)) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Install configuration for each shop
     *
     * @return bool
     */
    public function installConfiguration()
    {
        $result = true;

        foreach (\Shop::getShops(false, null, true) as $shopId) {
            foreach ($this->configurationList as $name => $value) {
                if (false === Configuration::hasKey($name, null, null, (int) $shopId)) {
                    $result = $result && (bool) Configuration::updateValue(
                            $name,
                            $value,
                            false,
                            null,
                            (int) $shopId
                        );
                }
            }
        }

        return $result;
    }

    /**
     * Uninstall configuration
     *
     * @return bool
     */
    public function uninstallConfiguration()
    {
        foreach($this->configurationList as $name => $value) {
            if (!Configuration::deleteByName($name)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @return void
     */
    public function getContent()
    {
        // This controller actually does not exist, it is used in the tab
        // and is accessible thanks to routing settings with _legacy_link
        //Tools::redirectAdmin(
        //    Context::getContext()->link->getAdminLink('AdminModularsofasConfiguration')
        //);
    }

}
