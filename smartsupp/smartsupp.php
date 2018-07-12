<?php
/**
 * Smartsupp Live Chat integration module.
 * 
 * @package   Smartsupp
 * @author    Smartsupp <vladimir@smartsupp.com>
 * @link      http://www.smartsupp.com
 * @copyright 2015 Smartsupp.com
 * @license   GPL-2.0+
 *
 * Plugin Name:       Smartsupp Live Chat
 * Plugin URI:        http://www.smartsupp.com
 * Description:       Smartsupp live chat module for Prestashop 1.5 and 1.4.7
 * Version:           1.0.5
 * Author:            Smartsupp
 * Author URI:        http://www.smartsupp.com
 * Text Domain:       smartsupp
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

class Smartsupp extends Module
{
    public function __construct()
    {
        $this->name = 'smartsupp';
        $this->tab = 'advertising_marketing';
        $this->version = '1.0.6';
        $this->author = 'Smartsupp';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = array('min' => '1.4', 'max' => _PS_VERSION_);
        $this->bootstrap = true;
        $this->module_key = 'da5110815a9ea717be24a57b804d24fb';

        parent::__construct();

        $this->displayName = $this->l('Smartsupp Live Chat');
        $this->description = $this->l('Engage your customers in a faster and more personal way with Smartsupp Live Chat.');
        $this->confirmUninstall = $this->l('Are you sure you want to uninstall Smartsupp Live Chat? You will lose all the data related to this module.');

        if (version_compare(_PS_VERSION_, '1.5', '<')) {
            require(_PS_MODULE_DIR_.$this->name.'/backward_compatibility/backward.php');
        }

        if (!Configuration::get('SMARTSUPP_KEY')) {
            $this->warning = $this->l('No Smartsupp key provided.');
        }
    }

    public function install()
    {
        if (version_compare(_PS_VERSION_, '1.5', '>=') && Shop::isFeatureActive()) {
            Shop::setContext(Shop::CONTEXT_ALL);
        }

        if (!parent::install()
                    || !$this->registerHook('footer')
                    || !$this->registerHook('backOfficeHeader')
                    || !Configuration::updateValue('SMARTSUPP_KEY', '')
                    || !Configuration::updateValue('SMARTSUPP_OPTIONAL_API', '')
        ) {
            return false;
        }
                
        return true;
    }
        
    public function uninstall()
    {
        if (!parent::uninstall()
                    || !$this->unregisterHook('footer')
                    || !$this->unregisterHook('backOfficeHeader')
                    || !Configuration::deleteByName('SMARTSUPP_KEY')
                    || !Configuration::deleteByName('SMARTSUPP_OPTIONAL_API', '')
        ) {
            return false;
        }
                
        return true;
    }

    public function displayForm()
    {
        $default_lang = (int)Configuration::get('PS_LANG_DEFAULT');

        $helper = new HelperForm();

        // Module, token and currentIndex
        $helper->module = $this;
        $helper->name_controller = $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;

        // Language
        $helper->default_form_language = $default_lang;
        $helper->allow_employee_form_lang = $default_lang;

        // Title and toolbar
        $helper->title = $this->displayName;
        $helper->show_toolbar = true;
        $helper->toolbar_scroll = true;
        $helper->submit_action = 'submit'.$this->name;
        $helper->toolbar_btn = array(
            'save' =>
                array(
                    'desc' => $this->l('Save'),
                    'href' => AdminController::$currentIndex.'&configure='.$this->name.'&save'.$this->name.
                    '&token='.Tools::getAdminTokenLite('AdminModules'),
                ),
            'back' => array(
                'href' => AdminController::$currentIndex.'&token='.Tools::getAdminTokenLite('AdminModules'),
                'desc' => $this->l('Back to list')
            )
        );

        $fields_form = array();
        $fields_form[0]['form'] = array(
            'legend' => array(
                'title' => $this->l('Settings'),
            ),
            'input' => array(
                array(
                    'type' => 'text',
                    'label' => $this->l('Smartsupp key'),
                    'name' => 'SMARTSUPP_KEY',
                                        'desc' => $this->l('$Smartsupp Key$ assigned to your account.'),
                    'size' => 20,
                    'required' => true,
                ),
                                array(
                                        'type' => 'textarea',
                                        'label' => $this->l('Optional API'),
                                        'name' => 'SMARTSUPP_OPTIONAL_API',
                                        'desc' => $this->l('Advanced chat box modifications with $Smartsupp API$.'),
                                        'autoload_rte' => false,
                                        'rows' => 5,
                                ),
            ),
            'submit' => array(
                'title' => $this->l('Save'),
            )
        );
                
        $helper->fields_value['SMARTSUPP_KEY'] = Configuration::get('SMARTSUPP_KEY');
        $helper->fields_value['SMARTSUPP_OPTIONAL_API'] = Configuration::get('SMARTSUPP_OPTIONAL_API');

        return $helper->generateForm($fields_form);
    }

    public function getContent()
    {
        $output = '';
        if (Tools::isSubmit('submit'.$this->name)) {
            $smartsupp_key = Tools::getValue('SMARTSUPP_KEY');
            if (false && (!$smartsupp_key || empty($smartsupp_key))) {
                $output .= $this->displayError($this->l('Invalid Smartsupp Key value'));
            } else {
                Configuration::updateValue('SMARTSUPP_KEY', $smartsupp_key);
                $output .= $this->displayConfirmation($this->l('Settings updated successfully'));
            }
            Configuration::updateValue('SMARTSUPP_OPTIONAL_API', Tools::getValue('SMARTSUPP_OPTIONAL_API'));
        }

        if (version_compare(_PS_VERSION_, '1.5', '>=')) {
            $output .= $this->displayForm();
        } else {
            $this->context->smarty->assign(array(
                'smartsupp_key' => Configuration::get('SMARTSUPP_KEY'),
                'smartsupp_customer_id' => true,
                'smartsupp_customer_name' => true,
                'smartsupp_customer_email' => true,
                'smartsupp_customer_phone' => true,
                'smartsupp_customer_role' => true,
                'smartsupp_customer_spendings' => true,
                'smartsupp_customer_orders' => true,
                'smartsupp_optional_api' => Configuration::get('SMARTSUPP_OPTIONAL_API'),
            ));
            $output .= $this->display(__FILE__, 'views/templates/admin/form-ps14.tpl');
        }

        return $this->display(__FILE__, 'views/templates/admin/configuration.tpl').$output;
    }

    public function hookFooter()
    {
        $smartsupp_key = Configuration::get('SMARTSUPP_KEY');
                
        if ($smartsupp_key) {
            $this->context->smarty->assign('smartsupp_key', $smartsupp_key);
            $this->context->smarty->assign('smartsupp_cookie_domain', '.' . Tools::getHttpHost(false));

            $optional_api = trim(Configuration::get('SMARTSUPP_OPTIONAL_API'));
            if ($optional_api && !empty($optional_api)) {
                $this->context->smarty->assign('optional_api', trim(str_replace('\'', '"', $optional_api)));
            }
                    
            $customer = $this->context->customer;
            if ($customer->id) {
                $this->context->smarty->assign('smartsupp_dashboard_name', sprintf('"%s %s"', $customer->firstname, $customer->lastname));
                $this->context->smarty->assign('smartsupp_dashboard_email', sprintf('"%s"', $customer->email));
                            
                $variables_enabled = 1;
                $this->context->smarty->assign('smartsupp_variables_enabled', $variables_enabled);
                            
                if ($variables_enabled) {
                    $smartsupp_variables_js = '';

                    $smartsupp_variables_js .= 'id : {label: "' . $this->l('ID') . '", value: "' . $customer->id . '"},';

                    $smartsupp_variables_js .= 'name : {label: "' . $this->l('Name') . '", value: "' . $customer->firstname . ' ' . $customer->lastname . '"},';

                    $smartsupp_variables_js .= 'email : {label: "' . $this->l('Email') . '", value: "' . $customer->email . '"}, ';

                    $addresses = $this->context->customer->getAddresses($this->context->language->id);
                    $phone = $addresses[0]['phone_mobile'] ? $addresses[0]['phone_mobile'] : $addresses[0]['phone'];
                    $smartsupp_variables_js .= 'phone : {label: "' . $this->l('Phone') . '", value: "' . $phone . '"}, ';

                    $group = new Group($customer->id_default_group, $this->context->language->id, $this->context->shop->id);
                    $smartsupp_variables_js .= 'role : {label: "' . $this->l('Role') . '", value: "' . $group->name . '"}, ';

                    $orders = Order::getCustomerOrders($customer->id, true);
                    $count = 0;
                    $spendings = 0;
                    foreach ($orders as $order) {
                        if ($order['valid']) {
                            $count++;
                            $spendings += $order['total_paid_real'];
                        }
                    }
                    $smartsupp_variables_js .= 'spendings : {label: "' . $this->l('Spendings') . '", value: "' . Tools::displayPrice($spendings, $this->context->currency->id) . '"}, ';
                    $smartsupp_variables_js .= 'orders : {label: "' . $this->l('Orders') . '", value: "' . $count . '"}, ';

                    $this->context->smarty->assign('smartsupp_variables_js', trim($smartsupp_variables_js, ', '));
                }
            } else {
                $this->context->smarty->assign('smartsupp_dashboard_name', '""');
                $this->context->smarty->assign('smartsupp_dashboard_email', '""');
                $this->context->smarty->assign('smartsupp_variables_enabled', 0);
                $this->context->smarty->assign('smartsupp_variables_js', '');
            }
                    
            return $this->display(__FILE__, 'views/templates/hook/footer.tpl');
        }
    }

    public function hookBackOfficeHeader()
    {
        $js = '';
        if (strcmp(Tools::getValue('configure'), $this->name) === 0) {
            if (version_compare(_PS_VERSION_, '1.5', '>') == true) {
                $this->context->controller->addJquery();
                $this->context->controller->addJs($this->_path.'views/js/smartsupp.js');
                $this->context->controller->addCSS($this->_path.'views/css/smartsupp.css');
                if (version_compare(_PS_VERSION_, '1.6', '<') == true) {
                    $this->context->controller->addCSS($this->_path.'views/css/smartsupp-nobootstrap.css');
                }
            } else {
                $js .= '<link rel="stylesheet" href="'.$this->_path.'views/css/smartsupp.css" type="text/css" />'.
                       '<link rel="stylesheet" href="'.$this->_path.'views/css/smartsupp-nobootstrap.css" type="text/css" />';
            }
        }
        return $js;
    }
}
