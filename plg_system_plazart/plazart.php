<?php
/**
 *------------------------------------------------------------------------------
 * @package       Plazart Framework for Joomla!
 *------------------------------------------------------------------------------
 * @copyright     Copyright (C) 2012-2015 TemPlaza.com. All Rights Reserved.
 * @license       GNU General Public License version 2 or later; see LICENSE.txt
 * @authors       TemPlaza
 * @Link:         http://templaza.com
 *------------------------------------------------------------------------------
 */
/**
 *------------------------------------------------------------------------------
 * @package       T3 Framework for Joomla!
 *------------------------------------------------------------------------------
 * @copyright     Copyright (C) 2004-2013 JoomlArt.com. All Rights Reserved.
 * @license       GNU General Public License version 2 or later; see LICENSE.txt
 * @authors       JoomlArt, JoomlaBamboo, (contribute to this project at github
 *                & Google group to become co-author)
 * @Google group: https://groups.google.com/forum/#!forum/t3fw
 * @Link:         http://t3-framework.org
 *------------------------------------------------------------------------------
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

/**
 * Joomla! P3P Header Plugin
 *
 * @package		Joomla.Plugin
 * @subpackage	System.p3p
 */

class plgSystemPlazart extends JPlugin
{
    function __construct(&$subject,$config=array()){

        parent::__construct($subject,$config);
        include_once dirname(__FILE__) . '/includes/core/defines.php';
        include_once dirname(__FILE__) . '/includes/core/plazart.php';
        include_once dirname(__FILE__) . '/includes/core/bot.php';
    }

	//function onAfterInitialise(){
	function onAfterRoute(){

		PlazartBot::preload();
		$template = Plazart::detect();
		if($template){			
			PlazartBot::beforeInit();
			Plazart::init($template);
			PlazartBot::afterInit();
			Plazart::checkAction();
            Plazart::import('core/parser');
		}
	}
	
	function onBeforeRender(){
		if(Plazart::detect()){
			$japp = JFactory::getApplication();
			if($japp->isAdmin()){
				$plazartapp = Plazart::getApp();
                $plazartapp->configmanager();
				$plazartapp->addAssets();
			} else {

			}
		}
	}
	
	function onBeforeCompileHead () {
		$app = JFactory::getApplication();
		if(Plazart::detect() && !$app->isAdmin()){
			// call update head for replace css to less if in devmode

			$plazartapp = Plazart::getApp();

			if($plazartapp){
				$plazartapp->updateHead();
			}
		}
	}

	function onAfterRender ()
	{
        if(defined('PLAZART_PLUGIN') && Plazart::detect()){
            $plazartapp = Plazart::getApp();
            if ($plazartapp) {
                if (JFactory::getApplication()->isAdmin()) {
                    $plazartapp->render();
                } else {
                    $plazartapp->snippet();
//                    $optimized  =   Plazart::OptimizeCode();
//                    $optimized->OptimizeCode();

                    if (class_exists('TZRules')) {
                        $buf = TZRules::parseIt();
                        JResponse::setBody($buf);
                    }
                }
            }
        }
//		if($japp->isAdmin()){
//			if(Plazart::detect()){
//				$plazartapp = Plazart::getApp();
//				$plazartapp->render();
//			}
//		} else {
//            if(Plazart::detect()){
//                $optimized  =   Plazart::OptimizeCode();
//                $optimized->OptimizeCode();
//
//                if (class_exists('TZRules')) {
//                    $buf = TZRules::parseIt();
//                    JResponse::setBody($buf);
//                }
//            }
//        }
	}
	
	/**
	 * Add JA Extended menu parameter in administrator
	 *
	 * @param   JForm   $form   The form to be altered.
	 * @param   array   $data   The associated data for the form
	 *
	 * @return  null
	 */
	function onContentPrepareForm($form, $data)
	{
		// extra option for menu item
		/*if ($form->getName() == 'com_menus.item') {
			$this->loadLanguage();
			JForm::addFormPath(PLAZART_PATH . DIRECTORY_SEPARATOR . 'params');
			$form->loadFile('megaitem', false);

			$jversion = new JVersion;
			if(!$jversion->isCompatible('3.0')){
				$jdoc = JFactory::getDocument();
				$jdoc->addScript(PLAZART_ADMIN_URL . '/admin/js/jquery-1.8.0.min.js');
				$jdoc->addScript(PLAZART_ADMIN_URL . '/admin/js/jquery.noconflict.js');
			}

		} else 
		*/
		if(Plazart::detect() && $form->getName() == 'com_templates.style'){
			$this->loadLanguage();
			JForm::addFormPath(PLAZART_PATH . DIRECTORY_SEPARATOR . 'params');
			$form->loadFile('template', false);
		}
	}

    function onExtensionBeforeSave($option, $data) {
        if(Plazart::detect() && $option == 'com_templates.style' && !empty($data->id)){
            //get new params value
            $params = new JRegistry;
            $params->loadString($data->params);

            //get App
            $plazartapp = Plazart::getApp();
            if ($plazartapp) {
                if (JFactory::getApplication()->isAdmin()) {
                    // save preset
                    $plazartapp->save_preset($params,$data);

                    // save default style
                    $plazartapp->save_default_config($params);

                    // save plazart styles
                    $plazartapp->save_style($params, $data);
                }
            }


        }
    }
	
	function onExtensionAfterSave($option, $data){
		if(Plazart::detect() && $option == 'com_templates.style' && !empty($data->id)){
			//get new params value
			$japp = JFactory::getApplication();
			$params = new JRegistry;
			$params->loadString($data->params);
			$oparams = $japp->getUserState('oparams');
			//check for changed params
			$pchanged = array();
			foreach($oparams as $oparam){
				if($params->get($oparam['name']) != $oparam['value']){
					$pchanged[] = $oparam['name'];
				}
			}

			//if we have any changed, we will update to global
			if(count($pchanged)){
				//g et all other styles that have thesame template
				$db = JFactory::getDBO();
				$query = $db->getQuery(true);
				$query
					->select('*')
					->from('#__template_styles')
					->where('template=' . $db->quote($data->template));

				$db->setQuery($query);
				$themes = $db->loadObjectList();
				
				//update all global parameters
				foreach($themes as $theme){
					$registry = new JRegistry;
					$registry->loadString($theme->params);

					foreach($pchanged as $pname){
						$registry->set($pname, $params->get($pname)); //overwrite with new value
					}

					$query = $db->getQuery(true);
					$query
						->update('#__template_styles')
						->set('params =' . $db->quote($registry->toString()))
						->where('id =' . (int)$theme->id)
						->where('id <>' . (int)$data->id);

					$db->setQuery($query);
					$db->query();
				}
			}
		}
	}

	/**
	 * Implement event onRenderModule to include the module chrome provide by Plazart
	 * This event is fired by overriding ModuleHelper class
	 * Return false for continueing render module
	 *
	 * @param   object  &$module   A module object.
	 * @param   array   $attribs   An array of attributes for the module (probably from the XML).
	 *
	 * @return  bool
	 */
//	function onRenderModule (&$module, $attribs)
//	{
//		static $chromed = false;
//		// Detect layout path in Plazart themes
//		if (Plazart::detect()) {
//			// Chrome for module
//			if (!$chromed) {
//				$chromed = true;
//				// We don't need chrome multi times
//				$chromePath = PlazartPath::getPath('html/modules.php');
//				if (file_exists($chromePath)) {
//					include_once $chromePath;
//				}
//			}
//		}
//		return false;
//	}

	/**
	 * Implement event onGetLayoutPath to return the layout which override by Plazart & Plazart templates
	 * This event is fired by overriding ModuleHelper class
	 * Return path to layout if found, false if not
	 *
	 * @param   string  $module  The name of the module
	 * @param   string  $layout  The name of the module layout. If alternative
	 *                           layout, in the form template:filename.
	 *
	 * @return  null
	 */
//	function onGetLayoutPath($module, $layout)
//	{
//		// Detect layout path in Plazart themes
//		if (Plazart::detect()) {
//			$tPath = PlazartPath::getPath('html/' . $module . '/' . $layout . '.php');
//			if ($tPath)
//				return $tPath;
//		}
//		return false;
//	}
}
