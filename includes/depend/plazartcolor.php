<?php

defined('JPATH_BASE') or die;

jimport('joomla.html.html');
jimport('joomla.form.formfield');
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

class JFormFieldPlazartcolor extends JFormField
{
    public $type = 'Plazartcolor';

    protected function getInput() {
        $options_type = array(
            JHTML::_('select.option', 'background-color', 'Background Color'),
            JHTML::_('select.option', 'color', 'Font Color'),
            JHTML::_('select.option', 'border-color', 'Border Color'),
            JHTML::_('select.option', 'column-rule-color', 'Column Rule Color'),
            JHTML::_('select.option', 'outline-color', 'Outline Color'),
            JHTML::_('select.option', 'text-decoration-color', 'Text Decoration Color')
        );

        $value      =   htmlspecialchars($this->value, ENT_COMPAT, 'UTF-8');
        $slash = strpos($value, ';');
        $type = substr($value,0, $slash);
        $normal = substr($value, $slash+1, strlen($value));

        $html = '<div class="plazartcolor_form">';
        $html .= '<input type="text" class="plazartcolorpicker" value="'.$normal.'" />';
        $html .= JHtml::_('select.genericlist', $options_type, 'name', '', 'value', 'text', $type, $this->name . '_type');

        $html .= '<input type="text" name="'.$this->name.'" id="'.$this->id.'" class="tzFormHide" value="' . htmlspecialchars($this->value, ENT_COMPAT, 'UTF-8') . '" />';

        $html .= '</div>';

        return $html;
    }
}