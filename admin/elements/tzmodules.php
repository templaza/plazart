<?php
/**
 * ------------------------------------------------------------------------
 * TZ tz System Plugin
 * ------------------------------------------------------------------------
 * Copyright (C) 2004-2011 J.O.O.M Solutions Co., Ltd. All Rights Reserved.
 * @license - GNU/GPL, http://www.gnu.org/licenses/gpl.html
 * Author: J.O.O.M Solutions Co., Ltd
 * Websites: http://www.templaza.com - http://www.joomlancers.com
 * ------------------------------------------------------------------------
 */

// No direct access
defined('_JEXEC') or die();

/**
 * Radio List Element
 *
 * @package  TZT3.Core.Element
 */
class JFormFieldTZModules extends JFormField
{
    /**
     * Element name
     *
     * @access    protected
     * @var        string
     */
    protected $type = 'TZModules';

	/**
	 * Check and load assets file if needed
	 */
	function loadAsset(){
		if (!defined ('_TZ_DEPEND_ASSET_')) {
			define ('_TZ_DEPEND_ASSET_', 1);
			$uri = str_replace('\\', '/', str_replace( JPATH_SITE, JURI::base(), dirname(__FILE__) ));
			$uri = str_replace('/administrator/', '', $uri);
			
			if(!defined('TZ')){
                $jdoc = JFactory::getDocument();
                $jdoc->addStyleSheet($uri.'/css/tzdepend.css');
                $jdoc->addScript($uri.'/js/tzdepend.js');    
            }
		}
	}
	
    /**
     * Method to get the field input markup.
     *
     * @return  string  The field input markup.
     */
    function getInput()
    {
        $this->loadAsset();

        $db = JFactory::getDBO();
        $query = "SELECT e.extension_id, a.id, a.title, a.note, a.position, a.module, a.language,a.checked_out,
                    a.checked_out_time, a.published, a.access, a.ordering, a.publish_up, a.publish_down,
                    l.title AS language_title,uc.name AS editor,ag.title AS access_level,
                    MIN(mm.menuid) AS pages,e.name AS name
                    FROM `#__modules` AS a
                    LEFT JOIN `#__languages` AS l ON l.lang_code = a.language
                    LEFT JOIN #__users AS uc ON uc.id=a.checked_out
                    LEFT JOIN #__viewlevels AS ag ON ag.id = a.access
                    LEFT JOIN #__modules_menu AS mm ON mm.moduleid = a.id
                    LEFT JOIN #__extensions AS e ON e.element = a.module
                    WHERE (a.published IN (0, 1)) AND a.client_id = 0
                    GROUP BY a.id";
					
        $db->setQuery($query);
        $groups = $db->loadObjectList();
        $groupHTML = array();

        if($this->element['show_default']){
            $groupHTML[] = JHTML::_('select.option', 'default', JText::_('JDEFAULT'));
        }

        if($this->element['show_none']){
            $groupHTML[] = JHTML::_('select.option', 'none', JText::_('JNONE'));
        } 

        if ($groups && count($groups)) {
            foreach ($groups as $v => $t) {
                $groupHTML[] = JHTML::_('select.option', $t->id, $t->title);
            }
        }

        $lists = JHTML::_('select.genericlist', $groupHTML, "{$this->name}" . ($this->element['multiple'] == 1 ? '[]' : ''), ($this->element['multiple'] == 1 ? 'multiple="multiple" size="10" ' : '') . ($this->element['disabled'] ? 'disabled="disabled"' : ''), 'value', 'text', $this->value);

        return $lists;
    }
}