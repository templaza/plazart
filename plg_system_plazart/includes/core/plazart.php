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

/**
 * Plazart Class
 * Singleton class for Plazart
 */
class Plazart {
	
	protected static $plazartapp = null;

	/**
	 * Import Plazart Library
	 *
	 * @param string $package    Object path that seperate by backslash (/)
	 *
	 * @return void
	 */
	public static function import($package){

        $path = PLAZART_ADMIN_PATH . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . strtolower($package) . '.php';

		if (file_exists($path)) {
			include_once $path;
		} else {
			trigger_error('Plazart::import not found object: ' . $package, E_USER_ERROR);
		}
	}

	public static function getApp($tpl = null){
		if(empty(self::$plazartapp)){	
			$japp = JFactory::getApplication();
			self::$plazartapp = $japp->isAdmin() ? self::getAdmin() : self::getSite($tpl); 
		}

		return self::$plazartapp;
	}

	/**
	 * Initialize Plazart
	 */
	public static function init ($xml) {
		$app = JFactory::getApplication();
		$input = $app->input;
		$templateobj = $app->getTemplate(true);
		$coretheme = isset($xml->plazart) && isset($xml->plazart->base) ? trim($xml->plazart->base) : 'base';
		// check coretheme in media/plazart/themes folder
		// if not exists, use default base theme in Plazart
		if ($coretheme && is_dir(JPATH_ROOT.'/media/plazart/themes/'.$coretheme)){
			define ('PLAZART', $coretheme);
			define ('PLAZART_URL', JURI::base(true).'/media/plazart/themes/' . PLAZART);
			define ('PLAZART_PATH', JPATH_ROOT . '/media/plazart/themes/' . PLAZART);
			define ('PLAZART_REL', 'media/plazart/themes/' . PLAZART);
		} else {
			define ('PLAZART', 'base');
			define ('PLAZART_URL', PLAZART_ADMIN_URL.'/'.PLAZART);
			define ('PLAZART_PATH', PLAZART_ADMIN_PATH . '/' . PLAZART);
			define ('PLAZART_REL', PLAZART_ADMIN_REL.'/'.PLAZART);
		}

		define ('PLAZART_TEMPLATE', $xml->tplname);
		define ('PLAZART_TEMPLATE_URL', JURI::root(true).'/templates/'.PLAZART_TEMPLATE);
		define ('PLAZART_TEMPLATE_PATH', JPATH_ROOT . '/templates/' . PLAZART_TEMPLATE);
		define ('PLAZART_TEMPLATE_REL', 'templates/' . PLAZART_TEMPLATE);

		//load Plazart Framework language
		JFactory::getLanguage()->load(PLAZART_PLUGIN, JPATH_ADMINISTRATOR);
		
		if ($input->getCmd('themer', 0)){
			define ('PLAZART_THEMER', 1);
		}

		if (!JFactory::getApplication()->isAdmin()) {
			$plazartassets = $templateobj->params->get ('plazart-assets', 'plazart-assets');
			define ('PLAZART_DEV_FOLDER', $plazartassets . '/dev');
		}

		if($input->getCmd('plazartlock', '')){
			JFactory::getSession()->set('Plazart.plazartlock', $input->getCmd('plazartlock', ''));
			$input->set('plazartlock', null);
		}

		// load core library
		Plazart::import ('core/path');
		
		$app = JFactory::getApplication();
		if (!$app->isAdmin()) {
			$jversion  = new JVersion;
			if($jversion->isCompatible('3.0')){
				// override core joomla class
				// JViewLegacy
				if (!class_exists('JViewLegacy', false)) Plazart::import ('joomla30/viewlegacy');
                // JViewLegacy
                if (!class_exists('JDocumentError', false)) Plazart::import ('joomla30/document/error');
                // JViewLegacy
                if (!class_exists('JDocumentPlazartHTML', false)) Plazart::import ('joomla30/document/html');
				// JModuleHelper
				if (!class_exists('JModuleHelper', false)) Plazart::import ('joomla30/modulehelper');
				// JPagination
				if (!class_exists('JPagination', false)) Plazart::import ('joomla30/pagination');

			} else {
				// override core joomla class
				// JViewLegacy
				if (!class_exists('JView', false)) Plazart::import ('joomla25/view');
				// JModuleHelper
				if (!class_exists('JModuleHelper', false)) Plazart::import ('joomla25/modulehelper');
				// JPagination
				if (!class_exists('JPagination', false)) Plazart::import ('joomla25/pagination');
			}
		} else {
            // checkversion
		}
	}

	public static function checkAction () {
		// excute action by Plazart
		if ($action = JFactory::getApplication()->input->getCmd ('plazartaction')) {
			Plazart::import ('core/action');
			PlazartAction::run ($action);
		}
	}

	public static function getAdmin(){
		Plazart::import ('core/admin');
		return new PlazartAdmin();
	}

	public static function getSite($tpl){
		//when on site, the JDocumentHTML parameter must be pass

		if(empty($tpl)){
			return false;
		}

		$type = 'Template';
		Plazart::import ('core/'.$type);

		// create global plazart template object 
		$class = 'Plazart'.$type;
		return new $class($tpl);
	}

	public static function error($msg, $code = 500){
        if (JError::$legacy) {
			JError::setErrorHandling(E_ERROR, 'die');
			JError::raiseError($code, $msg);
			
			exit;
		} else {
			throw new Exception($msg, $code);
		}
	}

	public static function detect(){
		static $plazart;
		if (!isset($plazart)) {
			$plazart = false; // set false
			$app = JFactory::getApplication();
			$input = JFactory::getApplication()->input;
			// get template name
			$tplname = '';
			if($input->getCmd ('plazartaction') && ($styleid = $input->getInt('styleid', ''))) {
				$db = JFactory::getDbo();
				$query = $db->getQuery(true);
				$query->select('template, params');
				$query->from('#__template_styles');
				$query->where('client_id = 0');
				$query->where('id = '.$styleid);

				$db->setQuery($query);
				$template = $db->loadObject();
				if ($template) {
					$tplname = $template->template;
					$registry = new JRegistry;
					$registry->loadString($template->params);					
					$input->set ('tplparams', $registry);
				}
			} elseif ($app->isAdmin()) {
				// if not login, do nothing
				$user = JFactory::getUser();
				if (!$user->id){
					return false;
				}
				if($input->getCmd('option') == 'com_templates' && 
					(preg_match('/style\./', $input->getCmd('task')) || $input->getCmd('view') == 'style' || $input->getCmd('view') == 'template')
					){
					$db = JFactory::getDBO();
					$query = $db->getQuery(true);
					$id = $input->getInt('id');

					//when in POST the view parameter does not set
					if ($input->getCmd('view') == 'template') {
						$query
						->select('element')
						->from('#__extensions')
						->where('extension_id='.(int)$id . ' AND type=' . $db->quote('template'));
					} else {
						$query
						->select('template')
						->from('#__template_styles')
						->where('id='.(int)$id);
					}

					$db->setQuery($query);
					$tplname = $db->loadResult();
				}
			} else {
				$tplname = $app->getTemplate(false);					
			}

			if ($tplname) {				
					// parse xml
				$filePath = JPath::clean(JPATH_ROOT.'/templates/'.$tplname.'/templateDetails.xml');
				if (is_file ($filePath)) {
					$xml = simplexml_load_file($filePath);
					// check plazart or group=plazart (compatible with previous definition)
					if (isset($xml->plazart) || (isset($xml->group) && strtolower($xml->group) == 'plazart')) {
						$xml->tplname = $tplname;
						$plazart = $xml;
					}
				}
			}
		}
		return $plazart;
	}

    /**
     *
     * Ge default template style
     */
    public static function getDefaultTemplate(){
        static $defaultTemplate;

        if (!isset($defaultTemplate)) {

            $db = JFactory::getDbo();
            $query = $db->getQuery(true);
            $query
                ->select('id, template, s.params')
                ->from('#__template_styles as s')
                ->where('s.client_id = 0')
                ->where('s.home = 1')
                ->where('e.enabled = 1')
                ->leftJoin('#__extensions as e ON e.element=s.template AND e.type='.$db->quote('template').' AND e.client_id=s.client_id');

            $db->setQuery($query);
            $result = $db->loadObject();

            $defaultTemplate = !empty($result) ? $result->template : false;
        }

        return $defaultTemplate;
    }

    /**
     *
     * Ge template style params
     */
    public static function getTemplateParams()
    {
        $app    = JFactory::getApplication();
        $input  = $app->input;
        $params = $input->get('tplparams', '', 'raw'); //check for tplparams first

        if(!($params instanceof JRegistry)){
            $id = $input->getCmd('styleid', $input->getCmd('id'));
            if($id){
                $db    = JFactory::getDbo();
                $query = $db->getQuery(true);
                $query
                    ->select('template, params')
                    ->from('#__template_styles')
                    ->where('client_id = 0')
                    ->where('id = ' . $id);
                $db->setQuery($query);
                $template = $db->loadObject();

                if ($template) {
                    $params = new JRegistry;
                    $params->loadString($template->params);
                }
            }
        }

        return $params instanceof JRegistry ? $params : null;
    }

    public static function OptimizeCode() {
        Plazart::import ('core/scriptsdown');
        return new PlazartScriptsDown();
    }

    // Get clearfix File
    public static function getFileOvClf() {

        // get params template
        $app =  JFactory::getApplication('site');
        $getTemplate    = $app -> getTemplate(true);
        $paramsTem      = $getTemplate -> params;
        $fileOvClf      = $paramsTem -> get('ov_clr_file','plz_child_');

        return $fileOvClf;

    }

    public static function OverriderFile($fileRoot) {

        $fileOvClf  = self::getFileOvClf();
        $nameFile   = JFile::getName($fileRoot);
        $fileCheck  = $fileOvClf.JFile::getName($fileRoot);
        $pathCheck  = str_replace($nameFile,$fileCheck,$fileRoot);

        if(is_file($pathCheck))
        {
            return $pathCheck;

        }else{

            return false;
        }
    }

    public static function addChildAddFile($file,$type) {

        $doc = JFactory::getDocument();
//        $uri    = JUri::getInstance();
//        $uri    -> parse(JUri::root().$file);
//        $basePathFile   = $uri -> getPath();

        $fileRoot   = JPATH_SITE.DIRECTORY_SEPARATOR.$file;
        $nameFile   = JFile::getName($fileRoot);
        $fileChild  = self::OverriderFile($fileRoot);
        $fileOvClf  = self::getFileOvClf();
        $fileCheck  = $fileOvClf.$nameFile;
        if($fileChild) {
            $fileEnd    = str_replace($nameFile,$fileCheck,$file);
            if($type == 'js') {
                $doc -> addScript($fileEnd);
            }
            if($type == 'css') {
                $doc -> addStyleSheet($fileEnd);
            }
        }else {
            if($type == 'js') {
                $doc -> addScript($file);
            }
            if($type == 'css') {
                $doc -> addStyleSheet($file);
            }
        }

    }
}
