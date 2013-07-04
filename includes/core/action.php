<?php
/** 
 *------------------------------------------------------------------------------
 * @package       Plazart Framework for Joomla!
 *------------------------------------------------------------------------------
 * @copyright     Copyright (C) 2004-2013 JoomlArt.com. All Rights Reserved.
 * @license       GNU General Public License version 2 or later; see LICENSE.txt
 * @authors       JoomlArt, JoomlaBamboo, (contribute to this project at github 
 *                & Google group to become co-author)
 * @Google group: https://groups.google.com/forum/#!forum/plazartfw
 * @Link:         http://plazart-framework.org 
 *------------------------------------------------------------------------------
 */

// No direct access
defined('_JEXEC') or die();
/**
 * PlazartAction class
 *
 * @package Plazart
 */
class PlazartAction extends JObject
{
	public static function run ($action) {
		if (method_exists('PlazartAction', $action)) {
			$option = preg_replace('/[^A-Z0-9_\.-]/i', '', JFactory::getApplication()->input->getCmd('view'));

			if(!defined('JPATH_COMPONENT')){
				define('JPATH_COMPONENT', JPATH_BASE . '/components/' . $option);
			}

			if(!defined('JPATH_COMPONENT_SITE')){
				define('JPATH_COMPONENT_SITE', JPATH_SITE . '/components/' . $option);
			}

			if(!defined('JPATH_COMPONENT_ADMINISTRATOR')){
				define('JPATH_COMPONENT_ADMINISTRATOR', JPATH_ADMINISTRATOR . '/components/' . $option);
			}

			PlazartAction::$action();
		}
		exit;
	}

	public static function lessc () {
		$path = JFactory::getApplication()->input->getString ('s');

		Plazart::import ('core/less');
		$plazartless = new PlazartLess;
		$css = $plazartless->getCss($path);

		header("Content-Type: text/css");
		header("Content-length: ".strlen($css));
		echo $css;
	}

	public static function lesscall(){
		Plazart::import ('core/less');
		
		$result = array();
		try{
			PlazartLess::compileAll();
			$result['successful'] = JText::_('PLAZART_MSG_COMPILE_SUCCESS');
		}catch(Exception $e){
			$result['error'] = JText::sprintf('PLAZART_MSG_COMPILE_FAILURE', $e->getMessage());
		}
		
		echo json_encode($result);
	}

	public static function theme(){
		
		JFactory::getLanguage()->load('tpl_' . PLAZART_TEMPLATE, JPATH_SITE);

		if(!defined('PLAZART')) {
			die(json_encode(array(
				'error' => JText::_('PLAZART_MSG_PLUGIN_NOT_READY')
			)));
		}

		$user = JFactory::getUser();
		$action = JFactory::getApplication()->input->getCmd('plazarttask', '');

		if ($action != 'thememagic' && !$user->authorise('core.manage', 'com_templates')) {
		    die(json_encode(array(
				'error' => JText::_('PLAZART_MSG_NO_PERMISSION')
			)));
		}
		
		if(empty($action)){
			die(json_encode(array(
				'error' => JText::_('PLAZART_MSG_UNKNOW_ACTION')
			)));
		}

		Plazart::import('admin/theme');
		
		if(method_exists('PlazartAdminTheme', $action)){
			PlazartAdminTheme::$action(PLAZART_TEMPLATE_PATH);	
		} else {
			die(json_encode(array(
				'error' => JText::_('PLAZART_MSG_UNKNOW_ACTION')
			)));
		}
	}

	public static function positions(){
		self::cloneParam('plazartlayout');

		$japp = JFactory::getApplication();
		if(!$japp->isAdmin()){
			$tpl = $japp->getTemplate(true);
		} else {

			$tplid = JFactory::getApplication()->input->getCmd('view') == 'style' ? JFactory::getApplication()->input->getCmd('id', 0) : false;
			if(!$tplid){
				die(json_encode(array(
					'error' => JText::_('PLAZART_MSG_UNKNOW_ACTION')
					)));
			}

			$cache = JFactory::getCache('com_templates', '');
			if (!$templates = $cache->get('plazarttpl')) {
				// Load styles
				$db = JFactory::getDbo();
				$query = $db->getQuery(true);
				$query->select('id, home, template, s.params');
				$query->from('#__template_styles as s');
				$query->where('s.client_id = 0');
				$query->where('e.enabled = 1');
				$query->leftJoin('#__extensions as e ON e.element=s.template AND e.type='.$db->quote('template').' AND e.client_id=s.client_id');

				$db->setQuery($query);
				$templates = $db->loadObjectList('id');
				foreach($templates as &$template) {
					$registry = new JRegistry;
					$registry->loadString($template->params);
					$template->params = $registry;
				}
				$cache->store($templates, 'plazarttpl');
			}

			if (isset($templates[$tplid])) {
				$tpl = $templates[$tplid];
			}
			else {
				$tpl = $templates[0];
			}
		}

		$plazartapp = Plazart::getSite($tpl);
		$layout = $plazartapp->getLayout();
		$plazartapp->loadLayout($layout);
	}

	public static function layout(){
		self::cloneParam('plazartlayout');

		if(!defined('PLAZART')) {
			die(json_encode(array(
				'error' => JText::_('PLAZART_MSG_PLUGIN_NOT_READY')
			)));
		}

		$action = JFactory::getApplication()->input->get('plazarttask', '');
		if(empty($action)){
			die(json_encode(array(
				'error' => JText::_('PLAZART_MSG_UNKNOW_ACTION')
			)));
		}

		if($action != 'display'){
			$user = JFactory::getUser();
			if (!$user->authorise('core.manage', 'com_templates')) {
			    die(json_encode(array(
					'error' => JText::_('PLAZART_MSG_NO_PERMISSION')
				)));
			}
		}

		Plazart::import('admin/layout');
		
		if(method_exists('PlazartAdminLayout', $action)){
			PlazartAdminLayout::$action(PLAZART_TEMPLATE_PATH);	
		} else {
			die(json_encode(array(
				'error' => JText::_('PLAZART_MSG_UNKNOW_ACTION')
			)));
		}
	}

	public static function megamenu() {
		self::cloneParam('plazartmenu');

		if(!defined('PLAZART')) {
			die(json_encode(array(
				'error' => JText::_('PLAZART_MSG_PLUGIN_NOT_READY')
			)));
		}

		$action = JFactory::getApplication()->input->get('plazarttask', '');
		if(empty($action)){
			die(json_encode(array(
				'error' => JText::_('PLAZART_MSG_UNKNOW_ACTION')
			)));
		}

		if($action != 'display'){
			$user = JFactory::getUser();
			if (!$user->authorise('core.manage', 'com_templates')) {
			    die(json_encode(array(
					'error' => JText::_('PLAZART_MSG_NO_PERMISSION')
				)));
			}
		}

		Plazart::import('admin/megamenu');
		
		if(method_exists('PlazartAdminMegamenu', $action)){
			PlazartAdminMegamenu::$action();	
			exit;
		} else {
			die(json_encode(array(
				'error' => JText::_('PLAZART_MSG_UNKNOW_ACTION')
			)));
		}
	}

	public static function module () {
		$input = JFactory::getApplication()->input;
		$id = $input->getInt ('mid');
		$module = null;
		if ($id) {
			// load module
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('m.id, m.title, m.module, m.position, m.content, m.showtitle, m.params');
			$query->from('#__modules AS m');
			$query->where('m.id = '.$id);
			$query->where('m.published = 1');
			$db->setQuery($query);
			$module = $db->loadObject ();
		}

		if (!empty ($module)) {
			$style = $input->getCmd ('style', 'PlazartXhtml');
			$buffer = JModuleHelper::renderModule($module, array('style'=>$style));
			// replace relative images url
			$base   = JURI::base(true).'/';
			$protocols = '[a-zA-Z0-9]+:'; //To check for all unknown protocals (a protocol must contain at least one alpahnumeric fillowed by :
			$regex     = '#(src)="(?!/|' . $protocols . '|\#|\')([^"]*)"#m';
			$buffer    = preg_replace($regex, "$1=\"$base\$2\"", $buffer);

		}

		//remove invisibile content, there are more ... but ...
		$buffer = preg_replace(array( '@<style[^>]*?>.*?</style>@siu', '@<script[^>]*?.*?</script>@siu'), array('', ''), $buffer);

		echo $buffer;
	}

	//translate param name to new name, from jvalue => to desired param name
	public static function cloneParam($param = '', $from = 'jvalue'){
		$input = JFactory::getApplication()->input;

		if(!empty($param) && $input->getWord($param, '') == ''){
			$input->set($param, $input->getCmd($from));
		}
	}

	public static function unittest () {
		$app = JFactory::getApplication();
		$tpl = $app->getTemplate(true);
		$plazartapp = Plazart::getApp($tpl);
		$layout = JFactory::getApplication()->input->getCmd('layout', 'default');
		ob_start();
		$plazartapp->loadLayout ($layout);
		ob_clean();
		echo "Positions for layout [$layout]: <br />";
		var_dump ($plazartapp->getPositions());
	}
}