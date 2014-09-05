<?php

defined('JPATH_BASE') or die;

jimport('joomla.form.formfield');

class JFormFieldPlazartUrl extends JFormField {
	protected $type = 'PlazartUrl';

	protected function getInput() {
		$url	= (string) $this->element['url'];
		$text  	= (string) $this->element['text'];

		return '<a class="btn btn-info" style="color:#ffffff;" href="' . $url . '" target="_blank" rel="nofollow">' . JText::_($text) . '</a>';
	}
}

?>