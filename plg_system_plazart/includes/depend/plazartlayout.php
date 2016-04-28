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
	 * @package Helix Framework
	 * @author JoomShaper http://www.joomshaper.com
	 * @copyright Copyright (c) 2010 - 2013 JoomShaper
	 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
	*/
defined('JPATH_PLATFORM') or die;

class JFormFieldPlazartLayout extends JFormField
{
    public $type = 'PlazartLayout';

    protected function getInput()
    {
        $template = $this->form->getValue('template');

        $theme_path = JPATH_SITE . '/templates/' . $template . '/';
        $plazart_layout_path = JPATH_SITE . '/plugins/system/plazart/base/generate/';

        $layoutsettings = $this->value;

        $modChromes = array();

        // check file over
        $fileOver   = Plazart::getFileOvClf();
        if(file_exists($theme_path . 'html/'.$fileOver.'modules.php')) {
            include_once($theme_path . 'html/'.$fileOver.'modules.php');
        }elseif (file_exists($theme_path . 'html/modules.php')) {
            include_once($theme_path . 'html/modules.php');
        }
        $positions = $this->getPositions();
        $data   =   '<input type="hidden" name="'.$this->name.'" />';
        $data   .=  '<div id="plazart-admin-device">';
        $data   .=  '<div class="plazart-admin-layout-header">'.JText::_('PLAZART_LAYOUTBUIDER_HEADER').'  <span>|</span>  <input type="checkbox" name="layoutbuiderdefault" value="1" />  <span>Default Data?</span></div>';
        $data   .=  '<button type="button" class="btn tz-admin-dv-lg active" data-device="lg"><i class="fa fa-desktop"></i>Large</button>';
        $data   .=  '<button type="button" class="btn tz-admin-dv-md" data-device="md" data-toggle="tooltip" title="Only for Bootstrap 3"><i class="fa fa-laptop"></i>Medium</button>';
        $data   .=  '<button type="button" class="btn tz-admin-dv-sm" data-device="sm" data-toggle="tooltip" title="Only for Bootstrap 3"><i class="fa fa-tablet"></i>Small</button>';
        $data   .=  '<button type="button" class="btn tz-admin-dv-xs" data-device="xs" data-toggle="tooltip" title="Only for Bootstrap 3"><i class="fa fa-mobile"></i>Extra small</button>';
        $data   .=  '</div>';

        if (is_array($layoutsettings)) {
            //legacy version 4.3
            $layoutsettings =   json_decode(json_encode($layoutsettings),true);
            $data   .=      $this->generateLayout($plazart_layout_path, $layoutsettings, $positions, $modChromes);
            $data   .=      '<input type="hidden" name="layout_id" />';

            return $data;
        } else {
            $layoutsettings =   json_decode($layoutsettings);
            if (isset($layoutsettings->styleid)) {
                JTable::addIncludePath(PLAZART_ADMIN_PATH.DIRECTORY_SEPARATOR.'includes'.DIRECTORY_SEPARATOR.'tables');
                $row    =   JTable::getInstance('plazart_styles');
                $row->load($layoutsettings->styleid);
                $generate   =   json_decode($row->style_content,true);
                $data   .=      $this->generateLayout($plazart_layout_path, $generate, $positions, $modChromes);
                $data   .=      '<input type="hidden" name="layout_id" value="'.$layoutsettings->styleid.'" />';
                return $data;
            }
            if (file_exists($theme_path.'config/default.json')) {
                $configure  =   file_get_contents($theme_path.'config/default.json');
                $object     =   new JRegistry($configure);
                $layoutsettings = json_encode($object->get('generate',json_decode(file_get_contents($plazart_layout_path . 'default.json'),true)));
                $layoutsettings =   json_decode($layoutsettings,true);
                if (!is_array($layoutsettings)) {
                    $layoutsettings = json_decode(file_get_contents($plazart_layout_path . 'default.json'),true);
                }
            } else {
                $layoutsettings = json_decode(file_get_contents($plazart_layout_path . 'default.json'),true);
            }
            $data   .=   $this->generateLayout($plazart_layout_path, $layoutsettings, $positions, $modChromes);
            $data   .=      '<input type="hidden" name="layout_id" />';
            return $data;
        }
    }


    private function generateLayout($path, $layout, $positions, $modChromes)
    {
        ob_start();
        if (file_exists($path . 'generated.php')) {
            include_once($path . 'generated.php');
        }
        $items = ob_get_clean();
        return $items;
    }


    public function getLabel()
    {
        return false;
    }


    public function getPositions()
    {
        $db = JFactory::getDBO();
        $query = 'SELECT `position` FROM `#__modules` WHERE  `client_id`=0 AND ( `published` !=-2 AND `published` !=0 ) GROUP BY `position` ORDER BY `position` ASC';

        $db->setQuery($query);
        $dbpositions = (array)$db->loadAssocList();


        $template = $this->form->getValue('template');
        $templateXML = JPATH_SITE . '/templates/' . $template . '/templateDetails.xml';
        $template = simplexml_load_file($templateXML);
        $options = array();

        foreach ($dbpositions as $positions) $options[] = $positions['position'];

        foreach ($template->positions[0] as $position) $options[] = (string)$position;

        $options = array_unique($options);

        $selectOption = array();
        sort($selectOption);

        foreach ($options as $option) $selectOption[] = $option;

        return $selectOption;
    }
}
