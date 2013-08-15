<?php
/*
 * BitSHOK Starter Module
 * 
 * @author BitSHOK <office@bitshok.net>
 * @copyright 2012 BitSHOK
 * @version 1.0
 * @license http://creativecommons.org/licenses/by/3.0/ CC BY 3.0
 */

if (!defined('_PS_VERSION_')) exit;

class StarterPsModule extends Module{
   
    public function __construct(){
        $this->name = 'starterpsmodule'; // internal identifier, unique and lowercase
        $this->tab = 'other'; // backend module coresponding category
        $this->version = '1.0'; // version number for the module
        $this->author = 'BitSHOK'; // module author
        $this->need_instance = 0; // load the module when displaying the "Modules" page in backend

        parent::__construct();

        $this->displayName = $this->l('Starter PrestaShop Module'); // public name
        $this->description = $this->l('Starter Module for PrestaShop 1.5.x'); // public description
        
        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?'); // confirmation message at uninstall
    }

    /**
     * Install this module
     * @return boolean
     */
    public function install(){
        if (!parent::install() ||
            !$this->registerHook('displayHeader') ||
            !$this->registerHook('displayHome') )
                return false;
        
        $this->initConfiguration(); // set default values for settings
        
        return true;
    }

    /**
     * Uninstall this module
     * @return boolean
     */
    public function uninstall(){
        if (!parent::uninstall())
            return false;
        
        $this->deleteConfiguration(); // delete settings
        
        return true;
    }

    /**
     * Header of pages hook (Technical name: displayHeader)
     */
    public function hookHeader(){
        $this->context->controller->addCSS($this->_path.'style.css');
        $this->context->controller->addJS($this->_path.'script.js');
    }

    /**
     * Homepage content hook (Technical name: displayHome)
     */
    public function hookDisplayHome(){
        $settings = unserialize( Configuration::get($this->name.'_settings') );
        
        $this->context->smarty->assign(array(
            'quote'     =>  $settings['quote'],
            'qauthor'   =>  $settings['author']
        ));
       
        return $this->display(__FILE__, $this->name.'.tpl');
    }
   
    /**
     * Configuration page
     */
    public function getContent(){
        $message = $this->processForm();
        $settings = unserialize( Configuration::get($this->name.'_settings') );
        
        $this->context->smarty->assign(array(
            'message'   => $message,
            'quote'     => $settings['quote'],
            'author'    => $settings['author']
        ));
        
        return $this->display(__FILE__, 'settings.tpl');
    }
    
    /**
     * Process data from Configuration page after form submition
     * @return string message
     */
    protected function processForm(){
        if(Tools::isSubmit('saveBtn')){ // save data
            // get submited values
            $settings = array(
                'quote' => Tools::getValue('quote'),
                'author' => Tools::getValue('author')
            );
            Configuration::updateValue($this->name.'_settings', serialize($settings));
            
            // display success message
            return $this->displayConfirmation($this->l('The settings have been successfully saved!'));
        }
        
        return '';
    }
    
    /**
     * Set the default values for Configuration page settings
     */
    protected function initConfiguration(){
        $settings = array(
            'quote' => 'The secret of getting ahead is getting started. The secret of getting started is breaking your complex overwhelming tasks into small manageable tasks, and then starting on the first one.',
            'author' => 'Mark Twain'
        );
        Configuration::updateValue($this->name.'_settings', serialize($settings)); // create a prestashop variable with the settings
    }
    
    /**
     * Delete configuration from database
     */
    protected function deleteConfiguration(){
        Configuration::deleteByName($this->name.'_settings');
    }
    
}
