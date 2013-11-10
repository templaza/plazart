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

defined('JPATH_PLATFORM') or die;

JFormHelper::loadFieldClass('filelist');

/**
 * Supports an HTML select list of files
 *
 * @package     Joomla.Platform
 * @subpackage  Form
 * @since       11.1
 */
class JFormFieldPlazartFileList extends JFormFieldFileList
{

	/**
	 * The form field type.
	 *
	 * @var    string
	 * @since  11.1
	 */
	public $type = 'PlazartFileList';

	/**
	 * The initialised state of the document object.
	 *
	 * @var    boolean
	 * @since  1.6
	 */
	protected static $initialised = false;

	/**
	 * Method to get the list of files for the field options.
	 * Specify the target directory with a directory attribute
	 * Attributes allow an exclude mask and stripping of extensions from file name.
	 * Default attribute may optionally be set to null (no file) or -1 (use a default).
	 *
	 * @return  array  The field option objects.
	 *
	 * @since   11.1
	 */
	protected function getOptions()
	{
		// update path to this template 
		$path = (string) $this->element['directory'];
		if (!is_dir($path)) {
			$this->element['directory'] = PLAZART_TEMPLATE_PATH . DIRECTORY_SEPARATOR . $path;
		}

        $this->filter  = (string) $this->element['filter'];
        $this->exclude = (string) $this->element['exclude'];

        $hideNone       = (string) $this->element['hide_none'];
        $this->hideNone = ($hideNone == 'true' || $hideNone == 'hideNone' || $hideNone == '1');

        $hideDefault       = (string) $this->element['hide_default'];
        $this->hideDefault = ($hideDefault == 'true' || $hideDefault == 'hideDefault' || $hideDefault == '1');

        $stripExt       = (string) $this->element['stripext'];
        $this->stripExt = ($stripExt == 'true' || $stripExt == 'stripExt' || $stripExt == '1');

        // Get the path in which to search for file options.
        $this->directory = (string) $this->element['directory'];

 		return parent::getOptions();
	}
}
?>