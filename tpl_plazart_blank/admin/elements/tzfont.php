<?php

defined('JPATH_BASE') or die;

jimport('joomla.html.html');
jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');
jimport('joomla.form.formfield');
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

class JFormFieldTzfont extends JFormField
{
	public $type = 'Tzfont';

	protected function getInput() {
		$options_type = array(
								JHTML::_('select.option', 'standard', 'Standard'),
								JHTML::_('select.option', 'google', 'Google Fonts'),
								JHTML::_('select.option', 'edge', 'Adobe Edge Fonts'),
								JHTML::_('select.option', 'squirrel', 'Squirrel')
							);
							
		$options_normal = array(
								JHTML::_('select.option', 'Verdana', 'Verdana'),
								JHTML::_('select.option', 'Georgia', 'Georgia'),
								JHTML::_('select.option', 'Arial', 'Arial'),
								JHTML::_('select.option', 'Impact', 'Impact'),
								JHTML::_('select.option', 'Tahoma', 'Tahoma'),
								JHTML::_('select.option', 'Trebuchet MS', 'Trebuchet MS'),
								JHTML::_('select.option', 'Arial Black', 'Arial Black'),
								JHTML::_('select.option', 'Times', 'Times'),
								JHTML::_('select.option', 'Palatino Linotype', 'Palatino Linotype'),
								JHTML::_('select.option', 'Lucida Sans Unicode', 'Lucida Sans Unicode'),
								JHTML::_('select.option', 'MS Serif', 'MS Serif'),
								JHTML::_('select.option', 'Comic Sans MS', 'Comic Sans MS'),
								JHTML::_('select.option', 'Courier New', 'Courier New'),
								JHTML::_('select.option', 'Lucida Console', 'Lucida Console')
							);
		
		$options_squirrel = array();
		// Get the path in which to search for file options.
		$path = (string) $this->element['directory'];

		if (!is_dir($path)) {
			$path = JPATH_ROOT.DIRECTORY_SEPARATOR.$path;
		}
		// Get a list of folders in the search path with the given filter.
		$folders = JFolder::folders($path, null);
		// Build the options list from the list of folders.
		if (is_array($folders)) {
			foreach($folders as $folder) {
				$options_squirrel[] = JHtml::_('select.option', $folder, $folder);
			}
		}

        $value      =   htmlspecialchars($this->value, ENT_COMPAT, 'UTF-8');
        $slash = strpos($value, ';');
        $type = substr($value,0, $slash);
        $normal = substr($value, $slash+1, strlen($value));

		$html = '<div class="tzfont_form">';
		$html .= JHtml::_('select.genericlist', $options_type, 'name', '', 'value', 'text', $type, $this->name . '_type');
		$html .= JHtml::_('select.genericlist', $options_normal, 'name', '', 'value', 'text', $normal, $this->name . '_normal');
		
		if(count($options_squirrel)) {
			$html .= JHtml::_('select.genericlist', $options_squirrel, 'name', '', 'value', 'text', $normal, $this->name . '_squirrel');
		} else {
			$html .= JHtml::_('select.genericlist', array(JHTML::_('select.option', 'Arial, Helvetica, sans-serif', '- - - ' . JText::_('TPL_TZ_LANG_NO_SQUIRREL') . ' - - -')), 'name', '', 'value', 'text', 'default', $this->name . '_squirrel');
		}

		$html .= '<input type="text" name="'.$this->name.'" id="'.$this->id.'" class="tzFormHide" value="' . htmlspecialchars($this->value, ENT_COMPAT, 'UTF-8') . '" />';
		$html .= '<span class="tz-label" id="'.str_replace(array('[', ']'), '', $this->name).'_google_own_link_label"><strong>'.JText::_('TPL_TZ_LANG_OWN_GOOGLE_FONT_LINK').'</strong><input type="text" id="'.str_replace(array('[', ']'), '', $this->name).'_google_own_link" size="40" /></span>';
		$html .= '<span class="tz-label" id="'.str_replace(array('[', ']'), '', $this->name).'_google_own_font_label"><strong>'.JText::_('TPL_TZ_LANG_OWN_GOOGLE_FONT_FAMILY').'</strong><input type="text" id="'.str_replace(array('[', ']'), '', $this->name).'_google_own_font" size="40" /></span>';
		
		$html .= '<span class="tz-label" id="'.str_replace(array('[', ']'), '', $this->name).'_edge_own_link_label"><strong>'.JText::_('TPL_TZ_LANG_OWN_EDGE_FONT_LINK').'</strong><input type="text" id="'.str_replace(array('[', ']'), '', $this->name).'_edge_own_link" size="40" /></span>';
		$html .= '<span class="tz-label" id="'.str_replace(array('[', ']'), '', $this->name).'_edge_own_font_label"><strong>'.JText::_('TPL_TZ_LANG_OWN_EDGE_FONT_FAMILY').'</strong><input type="text" id="'.str_replace(array('[', ']'), '', $this->name).'_edge_own_font" size="40" /></span>';
		
		$html .= '</div>';

		return $html;
	}
}