<?php
/**
 * @package     Joomla.Platform
 * @subpackage  Form
 *
 * @copyright   Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
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
class JFormFieldTZFileList extends JFormFieldFileList
{

	/**
	 * The form field type.
	 *
	 * @var    string
	 * @since  11.1
	 */
	public $type = 'FileList';

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
			$this->element['directory'] =  PLAZART_TEMPLATE_PATH . DIRECTORY_SEPARATOR . $path;
		}

		if($this->element['atzx']):

			$colon = '';
			?>
			<script type="text/tzvascript">
				//<![CDATA[
				jQuery(window).on('load', function(){
					TZDepend.addatzx('<?php echo $this->name ?>', {
						<?php if ($this->element['url']):
							$colon = ',';
						?>
						url: '<?php echo $this->element['url'] ?>'
						<?php
							 endif;
						?>
						<?php if ($this->element['query']): 
							echo $colon;
							$colon = ',';
						?>
						query: '<?php echo $this->element['query'] ?>'
						<?php
							endif;
						?>
						<?php if ($this->element['func']): 
							echo $colon;
							$colon = ',';
						?>
						func: '<?php echo $this->element['func'] ?>'
						<?php
							endif;
						?>
					});
				});
				//]]>
			</script>
			<?php
		endif;
		
 		return parent::getOptions();
	}
}
?>