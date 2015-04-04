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
class JFormFieldPlazartPreset extends JFormField
{
    /**
     * The form field type.
     *
     * @var    string
     * @since  1.6
     */
    public $type = 'PlazartPreset';

    /**
     * Method to get the list of menus for the field options.
     *
     * @return  array  The field option objects.
     *
     * @since   1.6
     */
    protected function getInput()
    {
        jimport('joomla.filesystem.file');
        $profiles    =   JFolder::files(PLAZART_TEMPLATE_PATH . DIRECTORY_SEPARATOR . 'config', '\.json$', false, false);
        for ($i = 0; $i<count($profiles); $i++){
            // Convert back slashes to forward slashes
            $slash = strrpos($profiles[$i], '.');
            if ($slash !== false)
            {
                $profiles[$i] = substr($profiles[$i],0, $slash);
            }
        }
        $html = '';

        for ($i = 0; $i < count($profiles); $i++) {
            //get new params value
            $params = new JRegistry;
            $params->loadString(JFile::read(PLAZART_TEMPLATE_PATH . DIRECTORY_SEPARATOR . 'config'.DIRECTORY_SEPARATOR.$profiles[$i].'.json'));
            $imagename  =   $params->get('preset_image','');
            $presetname =   $params->get('presetname','');
            $demolink   =   $params->get('demo_link','');
            $doclink    =   $params->get('doc_link','');
            $imagepath  =   trim($imagename) ? PLAZART_TEMPLATE_URL.'/images/presets/'.$imagename : 'http://placehold.it/350x270';
            $presetname =   trim($presetname) ? $presetname : $profiles[$i];
            $demolink   =   trim($demolink) ? '<a href="'.$demolink.'" class="btn btn-success" target="_blank">'.JText::_('PLAZART_LIVE_PREVIEW').'</a>' : '';
            $doclink    =   trim($doclink) ? '<a href="'.$doclink.'" class="btn btn-primary" target="_blank">'.JText::_('PLAZART_DOCUMENTATION').'</a>' : '';
            $preset_demo_link   =   ($demolink || $doclink) ? '<div class="preset-demo-link">'.$doclink.'   '.$demolink.'</div>' : '';
            $active =   ($this->value == $profiles[$i]) ? ' active' : '';
            $html.= '<div class="preset'.$active.'"><div class="preset-screenshot"><img alt="'.$presetname.'" src="'.$imagepath.'" /></div><span class="load-preset" data-toggle="modal" data-target="#loadPreset" data-preset="'.$profiles[$i].'">'.JText::_('PLAZART_ACTIVE').'</span><h3 class="preset-name">' . $presetname . '</h3>'.$preset_demo_link.'<i class="fa fa-times removepreset" title="Remove this Preset?" data-toggle="modal" data-target="#removePreset" data-preset="'.$profiles[$i].'"></i></div>';
        }
        $html.= '<input type="hidden" name="'.$this->name.'" id="config_manager_load_filename" value="'.$this->value.'" />';
        $html.= '<!-- Load Preset Modal -->
<div class="modal fade" id="loadPreset" tabindex="-1" role="dialog" aria-labelledby="myLoadPresetTitle" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myLoadPresetTitle">'.JText::_('PLAZART_LOADPRESETTITLE_LABEL').'</h4>
      </div>
      <div class="modal-body">
        '.JText::_('PLAZART_LOADPRESETDESC_LABEL').'
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">'.JText::_('PLAZART_TOOLBAR_CLOSE').'</button>
        <button type="button" class="btn btn-warning" id="loadPresetAccept">'.JText::_('PLAZART_ACCEPT_PRESET_LABEL').'</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- Remove Preset Modal -->
<div class="modal fade" id="removePreset" tabindex="-1" role="dialog" aria-labelledby="myRemovePresetTitle" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myRemovePresetTitle">'.JText::_('PLAZART_REMOVEPRESETTITLE_LABEL').'</h4>
      </div>
      <div class="modal-body">
        '.JText::_('PLAZART_REMOVEPRESETDESC_LABEL').'
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">'.JText::_('PLAZART_TOOLBAR_CLOSE').'</button>
        <button type="button" class="btn btn-danger" id="removePresetAccept">'.JText::_('PLAZART_REMOVE_PRESET_LABEL').'</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->';
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
            ->from($db->quoteName('#__menu'))
            ->where('home = 1');
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
