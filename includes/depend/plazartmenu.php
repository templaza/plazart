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

defined('JPATH_PLATFORM') or die;

/**
 * Supports an HTML select list of menus
 *
 * @package     Joomla.Libraries
 * @subpackage  Form
 * @since       1.6
 */
class JFormFieldPlazartMenu extends JFormField
{
    /**
     * The form field type.
     *
     * @var    string
     * @since  1.6
     */
    public $type = 'PlazartMenu';

    /**
     * Method to get the list of menus for the field options.
     *
     * @return  array  The field option objects.
     *
     * @since   1.6
     */
    protected function getInput()
    {
        $menus =  $this->menus();

        $html = '<select name="'.$this->name.'" id="jform_params_mm_type">';
        if (count($menus)) {
            foreach ($menus as $menu) {
                $selected = ($this->value == $menu->value) ? ' selected' : '';
                $html .= '<option value="'.$menu->value.'" data-language="'.$menu->language.'" '.$selected.'>'.$menu->text.'</option>';
            }
        }
        $html .= '</select>';
        return $html;
    }

    /**
     * Get a list of the available menus.
     *
     * @return  string
     *
     * @since   1.6
     */
    public static function menus()
    {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true)
            ->select('menutype AS value, title AS text')
            ->from($db->quoteName('#__menu_types'))
            ->order('title');
        $db->setQuery($query);
        $menus = $db->loadObjectList();

        $query = $db->getQuery(true)
            ->select('menutype, language')
            ->from($db->quoteName('#__menu'));
            //->where('home = 1');
        $db->setQuery($query);
        $menulangs = $db->loadAssocList('menutype');

        if(is_array($menus) && is_array($menulangs)){
            foreach ($menus as $menu) {
                $menu->text = $menu->text . ' [' . $menu->value . ']';
                $menu->language = isset($menulangs[$menu->value]) ? $menulangs[$menu->value]['language'] : '*';
            }
        }

        return is_array($menus) ? $menus : array();
    }

    /**
     * Method to get the field options.
     *
     * @return  array  The field option objects.
     *
     * @since   11.1
     */
    protected function getOptions()
    {
        $options = array();

        foreach ($this->element->children() as $option)
        {

            // Only add <option /> elements.
            if ($option->getName() != 'option')
            {
                continue;
            }

            // Create a new option object based on the <option /> element.
            $tmp = JHtml::_(
                'select.option', (string) $option['value'],
                JText::alt(trim((string) $option), preg_replace('/[^a-zA-Z0-9_\-]/', '_', $this->fieldname)), 'value', 'text',
                ((string) $option['disabled'] == 'true')
            );

            // Set some option attributes.
            $tmp->class = (string) $option['class'];

            // Set some JavaScript option attributes.
            $tmp->onclick = (string) $option['onclick'];

            // Add the option object to the result set.
            $options[] = $tmp;
        }

        reset($options);

        return $options;
    }
}
