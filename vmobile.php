<?php
/**
* 2007-2024 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2024 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

use PrestaShop\PrestaShop\Core\DependencyInjection\LegacyCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;
use PrestaShop\Module\Vmobile\Repository\ValaMobileRepository;



if (!defined('_PS_VERSION_')) {
    exit;
}

class Vmobile extends Module
{
    protected $config_form = false;
    private $valaMobileRepository;


    public function __construct()
    {
        $this->name = 'vmobile';
        $this->tab = 'administration';
        $this->version = '1.0.0';
        $this->author = 'Achraf Moreau';
        $this->need_instance = 0;

        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('vmobile');
        $this->description = $this->l('this module is use to filter your products (mobile)');

        $this->ps_versions_compliancy = array('min' => '8.0', 'max' => _PS_VERSION_);

        // i try to load service configuration here but it fials ------
        // $this->loadServiceConfiguration();

    }


    public function install()
    {
        Configuration::updateValue('VMOBILE_LIVE_MODE', false);

        if(!$this->createDatabaseTabels()) return false;

        return parent::install() &&
            $this->registerHook('displayHeader') &&
            $this->loadServiceConfiguration() &&
            $this->registerHook('displayHome') &&
            $this->registerHook('actionFrontControllerSetMedia');
    }

    public function uninstall()
    {
        Configuration::deleteByName('VMOBILE_LIVE_MODE');
        if( !$this->deleteTables() ||
            !$this->unregisterHook('displayHome') ||
            !$this->unregisterHook('displayHeader') ||
            !$this->unregisterHook('actionFrontControllerSetMedia')
        ) return false;

        return parent::uninstall();
    }

    /**
     * Load the configuration form
     */
    public function getContent()
    {
        /**
         * If values have been submitted in the form, process.
         */
        if (((bool)Tools::isSubmit('submitVmobileModule')) == true) {
            $this->postProcess();
        }

        $this->context->smarty->assign('module_dir', $this->_path);

        $output = $this->context->smarty->fetch($this->local_path.'views/templates/admin/configure.tpl');

        return $output.$this->renderForm();
    }

    /**
     * Create the form that will be displayed in the configuration of your module.
     */
    protected function renderForm()
    {
        $helper = new HelperForm();

        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);

        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitVmobileModule';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
            .'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');

        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFormValues(), /* Add values for your inputs */
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );

        return $helper->generateForm(array($this->getConfigForm()));
    }

    /**
     * Create the structure of your form.
     */
    protected function getConfigForm()
    {
        return array(
            'form' => array(
                'legend' => array(
                'title' => $this->l('Settings'),
                'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Live mode'),
                        'name' => 'VMOBILE_LIVE_MODE',
                        'is_bool' => true,
                        'desc' => $this->l('Use this module in live mode'),
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            )
                        ),
                    ),
                    array(
                        'col' => 3,
                        'type' => 'text',
                        'prefix' => '<i class="icon icon-envelope"></i>',
                        'desc' => $this->l('Enter a valid email address'),
                        'name' => 'VMOBILE_ACCOUNT_EMAIL',
                        'label' => $this->l('Email'),
                    ),
                    array(
                        'type' => 'password',
                        'name' => 'VMOBILE_ACCOUNT_PASSWORD',
                        'label' => $this->l('Password'),
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                ),
            ),
        );
    }

    /**
     * Set values for the inputs.
     */
    protected function getConfigFormValues()
    {
        return array(
            'VMOBILE_LIVE_MODE' => Configuration::get('VMOBILE_LIVE_MODE', true),
            'VMOBILE_ACCOUNT_EMAIL' => Configuration::get('VMOBILE_ACCOUNT_EMAIL', 'contact@prestashop.com'),
            'VMOBILE_ACCOUNT_PASSWORD' => Configuration::get('VMOBILE_ACCOUNT_PASSWORD', null),
        );
    }

    /**
     * Save form data.
     */
    protected function postProcess()
    {
        $form_values = $this->getConfigFormValues();

        foreach (array_keys($form_values) as $key) {
            Configuration::updateValue($key, Tools::getValue($key));
        }
    }



    public function hookDisplayHeader()
    {
        $this->context->controller->addJS($this->_path.'/views/js/front.js');
        $this->context->controller->addCSS($this->_path.'/views/css/front.css');
    }

    public function hookDisplayHome()
    {

        $mobiles = [];


        if (Tools::isSubmit('search_mobile')) {
            $criteria = [
                'type' => Tools::getValue('type'),
                'marque' => Tools::getValue('marque'),
                'annee' => Tools::getValue('annee'),
                'modele' => Tools::getValue('modele')
            ];

            // it's always false cuse there's no vmobile_repository service --------
            if ($this->getContainer()->has('vmobile_repository')) {
                $valaMobileRepository = $this->getContainer()->get('vmobile_repository');
                $mobiles = $valaMobileRepository->findByCriteria($criteria);
            } else {
                \PrestaShopLogger::addLog('The vmobile_repository is not available in the container.');
            }

        }

        // i was trying to fetch the select option and send them on the template (i remove the function that call the service to retrive the data)-----
        $this->context->smarty->assign([
            'mobiles' => $mobiles,
            // 'marque' => $marques,
            // 'types' => $types,
            // 'manufacturer' => $manufacturers
        ]);
        $this->context->smarty->assign('mobiles', $mobiles);

        return $this->display(__FILE__, 'views/templates/front/filter.tpl');

    }

    public function hookActionFrontControllerSetMedia()
    {
        $this->context->controller->registerStylesheet(
            'vmobile-style',
            'modules/' . $this->name . '/views/css/vmobile.css',
            [
                'media' => 'all',
                'priority' => 1000,
            ]
        );

        $this->context->controller->registerJavascript(
            'vmobile-javascript',
            'modules/' . $this->name . '/views/js/vmobile.js',
            [
                'position' => 'bottom',
                'priority' => 1000,
            ]
        );
    }


    private function createDatabaseTabels()
    {
        $sqlFile = _PS_MODULE_DIR_ . $this->name . '/sql/ex-mobile.sql';

        if (!file_exists($sqlFile)) {
            return false;
        }

        $sql = file_get_contents($sqlFile);
        $sqlQueries = preg_split('/;\s*[\r\n]+/', $sql);

         foreach ($sqlQueries as $query) {
            if (!empty($query)) {
                $result = Db::getInstance()->execute(trim($query));
                if (!$result) {
                    PrestaShopLogger::addLog('SQL Error: ' . Db::getInstance()->getMsgError(), 3);
                    return false;
                }
            }
        }

        return true;
    }

    public function deleteTables()
    {
        return Db::getInstance()->execute('
			DROP TABLE IF EXISTS
			`' . _DB_PREFIX_ . 'vala_mobile`,
			`' . _DB_PREFIX_ . 'vala_compatibility`,
			`' . _DB_PREFIX_ . 'vala_manufacturer`,
			`' . _DB_PREFIX_ . 'vala_mobile_lang`,
			`' . _DB_PREFIX_ . 'vala_mobile_type`,
			`' . _DB_PREFIX_ . 'vala_mobile_type_lang`' );
    }

    // doesn't work
    private function loadServiceConfiguration()
    {
        // if (method_exists(LegacyCompilerPass::class, 'getContainer')) {
        //     $container = LegacyCompilerPass::getContainer();
        //     if ($container instanceof ContainerBuilder) {
        //         $locator = new FileLocator(__DIR__ . '/config');
        //         $loader = new YamlFileLoader($container, $locator);
        //         try {
        //             $loader->load('services.yml');
        //         } catch (\Exception $e) {
        //             \PrestaShopLogger::addLog($e->getMessage());
        //             return $e->getMessage();
        //         }
        //     }
        // }
        $file = __DIR__.'/config/services.yml';
        if (file_exists($file)) {
            $yaml = Yaml::parse(file_get_contents($file));
            $container = new ContainerBuilder();
            $container->register('vmobile_service', Vmobile\Repository\VmobileRepository::class)
                ->addArgument($this->get('doctrine.orm.entity_manager'));
        }
    }



}
