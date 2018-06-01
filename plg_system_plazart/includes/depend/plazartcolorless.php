<?php

defined('JPATH_BASE') or die;

jimport('joomla.html.html');
jimport('joomla.form.formfield');
jimport('joomla.form.helper');
jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');
JFormHelper::loadFieldClass('list');

class JFormFieldPlazartcolorless extends JFormField
{
    public $type = 'Plazartcolorless';

    protected function getInput() {

        $theme  =   $this -> form -> getValue('theme','params');
        if(!$theme){
            $theme = $this -> form -> getFieldAttribute('theme', 'default', null, 'params');
        }
        if (JFile::exists(PLAZART_TEMPLATE_PATH.DIRECTORY_SEPARATOR.'less'.DIRECTORY_SEPARATOR.'import'.DIRECTORY_SEPARATOR.$theme.DIRECTORY_SEPARATOR.'color.less')) {
            $data   =   JFile::read(PLAZART_TEMPLATE_PATH.DIRECTORY_SEPARATOR.'less'.DIRECTORY_SEPARATOR.'import'.DIRECTORY_SEPARATOR.$theme.DIRECTORY_SEPARATOR.'color.less');
        } else {
            $data = '';
        }
        $html = '';
        if ($data) {
            preg_match_all('/@(.*?):(.*?);/i', $data, $colors);
            if (count($colors[0])) {
                $values     =   array();
                for ($i = 0; $i<count($colors[0]); $i++) {
                    $html .= '<div class="plazartcolorless_form">';
                    $html .= '<label class="color_less">'.JText::sprintf(strtoupper(PLAZART_TEMPLATE.'_'.$colors[1][$i])).'</label>';
                    $html .= '<input type="text" name="plazartcolorless['.$colors[1][$i].']" data-name="plazartcolorless" data-index="'.$colors[1][$i].'" class="plazartcolorpicker" value="'.trim($colors[2][$i]).'" />';
                    $html .= '</div>';
                    $values[$colors[1][$i]] = trim($colors[2][$i]);
                }
                $html .= '<div>';
                $html .= '<input type="hidden" name="'.$this->name.'" id="'.$this->id.'" value="' . htmlspecialchars(json_encode($values), ENT_COMPAT, 'UTF-8') . '" />';
                $html .=  '<a class="btn btn-info" id="plazartcolorless_update" style="color:#ffffff;" href="#"><i class="fas fa-spinner fa-spin" style="display: none;"></i>' . JText::_('PLAZART_UPDATE_COLOR') . '</a>';
                $html .=  '</div>';
            }
        }
        return $html;
    }
}