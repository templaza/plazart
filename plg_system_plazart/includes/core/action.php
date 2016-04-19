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


    ////////////////////////////////////////////////// Child template //////////////////////////////////////////////////

    public static function getParams() {

        $app    = JFactory::getApplication();
        $tpl    = $app->getTemplate(true);
        $params = $tpl -> params;

        return $params;
    }

    public static function copy_file(){

        $params     = self::getParams();
        $clfFile    = $params->get('ov_clr_file','plz_child_');

        $mess       = array();
        $data       = array();

        $getValue   = $_POST['fieldvalue'];
        $fileValue  = json_decode($getValue);
        $fileName   = $fileValue -> name;
        $filePath   = $fileValue -> id;

        $fileCopy   = JPath::clean($filePath);
        $fileChild  = str_replace($fileName,$clfFile.$fileName,$filePath);
        // check file child
        if(is_file($fileChild)) {
            $mess[]             = 'The file exists. You can\'t create a new one.';
            $data['status']     = 0;
        }else {
            JFile::copy($fileCopy, $fileChild);
            $mess[] = 'The file copy success';
            $data['status'] = 1;
            $data['newFile']    = str_replace($fileName,$clfFile.$fileName,$getValue);
        }
        $data['mess'] = $mess;

        echo json_encode($data);

    }

    public static function delete_file() {

        $params     = self::getParams();
        $clfFile    = $params->get('ov_clr_file','plz_child_');

        $mess       = array();
        $data       = array();

        $getFile    = $_POST['fileDelete'];
        $fileDelete = json_decode($getFile);
        $fileName   = $fileDelete->name;
        $filePath   = $fileDelete->id;

        $deleteFile = JPath::clean($filePath);

        if(is_file($deleteFile)) {

            $statusDel  = JFile::delete($deleteFile);

            if (!$statusDel)
            {
                $mess[]             = 'Can not delete file';
                $data['status']     = 0;
            }else {
                $mess[]             = 'Delete file success';
                $data['status']     = 1;

                // name file old
                $fileNameO          = str_replace($clfFile,'',$fileName);
                $fileOld            = str_replace($fileName,$fileNameO,$getFile);
                $data['fileOld']    = $fileOld;

            }

        }else {
            $mess[]             = 'File '.$fileName.' not exists';
            $data['status']     = 0;
        }

        $data['mess'] = $mess;

        echo json_encode($data);
    }

    public static function edit_file() {

        $params     = self::getParams();
        $clfFile    = $params->get('ov_clr_file','plz_child_');

        $mess       = array();
        $data       = array();

        $getFile    = $_POST['fileEdit'];
        $fileEdit   = json_decode($getFile);
        $fileName   = $fileEdit->name;
        $fileID     = $fileEdit->id;
        $filePath   = $fileEdit->short_path;

        // check file
        if(is_file($fileID)) {
            $data['fileContent']    = htmlspecialchars(JFile::read($fileID));
            $data['status']         = 1;
            $mess[]                 = '';
        }else {
            $data['fileContent']    = '';
            $data['status']         = 0;
            $mess[]                 = 'File not edit';
        }
        $data['filePath']          = $filePath;
        $data['mess'] = $mess;

        echo json_encode($data);

    }

    public static function save_file() {

        $params     = self::getParams();
        $clfFile    = $params->get('ov_clr_file','plz_child_');

        $mess       = array();
        $data       = array();

        $getFile    = $_POST['fileSave'];
        $fileSave   = json_decode($getFile);
        $fileName   = $fileSave->name;
        $fileID     = $fileSave->id;
        $filePath   = $fileSave->short_path;
        $newfile    = $_POST['newData'];

        // check file in class subfix
        $check      = strpos($fileName,$clfFile);
        if($check === false) {
            $mess[]         = 'You can not write file root';
            $data['status'] = 0;
        }else {
            if(isset($newfile) && $newfile != '') {
                if (!JFile::write($fileID, $newfile)) {
                    $mess[]         = 'File not write';
                    $data['status'] = 0;
                }else {
                    $mess[]         = 'File saved successfully';
                    $data['status'] = 1;
                }
            }
        }

        $data['mess'] = $mess;

        echo json_encode($data);

    }

    public static function saveAjaxLayout() {

        $getValue       = $_POST['fieldvalue'];
        $idTemplate     = $_GET['id'];
        $paramGenerate  = $getValue['jform']['params']['generate'];
        $generate       = json_encode($paramGenerate);

        $db = JFactory::getDBO();
        $query = $db->getQuery(true);

        $query
            ->update('#__plazart_styles')
            ->set('style_content =' . $db->quote($generate))
            ->where('style_id =' . (int)$idTemplate);

        $db->setQuery($query);
        $db->execute();
        $data       = array();
        if($db->execute()) {
            $data['status'] = true;
        }else {
            $data['status'] = false;
        }

        echo json_encode($data);
    }

}









