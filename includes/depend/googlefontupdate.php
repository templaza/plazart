<?php

defined('JPATH_BASE') or die;

jimport('joomla.form.formfield');

class JFormFieldGoogleFontUpdate extends JFormField {
    protected $type = 'GoogleFontUpdate';

    protected function getInput() {
        $text  	= (string) $this->element['text'];

        return '<a class="btn btn-info" id="googlefontupdate" style="color:#ffffff;" href="#">' . JText::_($text) . '</a>';
    }
}

?>