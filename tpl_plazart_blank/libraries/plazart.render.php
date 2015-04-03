<?php
/**
 *------------------------------------------------------------------------------
 * @package       Plazart Framework for Joomla!
 *------------------------------------------------------------------------------
 * @copyright     Copyright (C) 2012-2013 TemPlaza.com. All Rights Reserved.
 * @license       GNU General Public License version 2 or later; see LICENSE.txt
 * @authors       TemPlaza
 * @Link:         http://templaza.com
 *------------------------------------------------------------------------------
 */
 
// No direct access.
defined('_JEXEC') or die;

require_once(PLAZART_TEMPLATE_PATH . DIRECTORY_SEPARATOR . 'libraries' . DIRECTORY_SEPARATOR . 'helpers' . DIRECTORY_SEPARATOR . 'browser.php');

/*
* Main framework class
*/
class PlazartRender extends PlazartTemplate {
    // template name
    public $name = PLAZART_TEMPLATE;
    // access to the standard Joomla! template API
    public $API;
    // access to the helper classes
    public $bootstrap;
    public $social;
    public $utilities;
    // detected browser:
    public $browser;
    // page config
    public $config;
    // module styles
    public $module_styles;
    // page suffix
    public $page_suffix;
    
    // constructor
    public function __construct($tpl, $embed_mode = false) {
        parent::__construct($tpl);
        $browser = new TZBrowser();
        $this->browser = $browser->result;
        // get configured layout
        $layout = $this->getLayout();
        $this->loadLayout ($layout);
    }
}
// EOF