<?php
/** 
 *------------------------------------------------------------------------------
 * @package       Plazart Framework for Joomla!
 *------------------------------------------------------------------------------
 * @copyright     Copyright (C) 2004-2013 JoomlArt.com. All Rights Reserved.
 * @license       GNU General Public License version 2 or later; see LICENSE.txt
 * @authors       JoomlArt, JoomlaBamboo, (contribute to this project at github 
 *                & Google group to become co-author)
 * @Google group: https://groups.google.com/forum/#!forum/plazartfw
 * @Link:         http://plazart-framework.org 
 *------------------------------------------------------------------------------
 */

defined('_JEXEC') or die;
?>

<div id="plazart-admin-toolbar" class="btn-toolbar">
	<?php
	if($input->getCmd('view') == 'style'):
	?>
  <div id="plazart-admin-tb-save" class="btn-group">
    <button id="plazart-admin-tb-style-save-save" class="btn btn-success"><i class="fa fa-floppy-o"></i><?php echo JText::_('JAPPLY'); ?></button>
    <button class="btn btn-success dropdown-toggle" data-toggle="dropdown">
      <span class="caret"></span>&nbsp;
    </button>
    <ul class="dropdown-menu">
      <li id="plazart-admin-tb-style-save-close"><a href="#"><?php echo JText::_('JTOOLBAR_SAVE') ?></a></li>
      <li id="plazart-admin-tb-style-save-clone"><a href="#"><?php echo JText::_('JTOOLBAR_SAVE_AS_COPY') ?></a></li>
    </ul>
  </div>
  <?php 
  endif;
  ?>

	<div class="btn-group">
		<a id="plazart-tb-global-config" href="#global-config" class="btn btn-config"><i class="fa fa-cog"></i><?php echo JText::_('PLAZART_GLOBAL_LABEL') ?></a>
        <a id="plazart-tb-preset-config" href="#preset-config" class="btn btn-config"><i class="fa fa-rocket"></i><?php echo JText::_('PLAZART_PRESET_LABEL') ?></a>
        <a id="plazart-tb-menu-config" href="#menu-config" class="btn btn-config"><i class="fa fa-bars"></i><?php echo JText::_('PLAZART_NAVIGATION_LABEL') ?></a>
        <a id="plazart-tb-layout-config" href="#layout-config" class="btn btn-config"><i class="fa fa-columns"></i><?php echo JText::_('PLAZART_LAYOUT_LABEL') ?></a>
        <a id="plazart-tb-advanced-config" href="#advanced-config" class="btn btn-config"><i class="fa fa-wrench"></i><?php echo JText::_('PLAZART_ADVANCED_LABEL') ?></a>
        <a id="plazart-tb-child-override-config" href="#child-override-config" class="btn btn-config"><i class="fa fa-files-o"></i><?php echo JText::_('PLAZART_OVERRIDE_LABEL') ?></a>
    </div>

	<div id="plazart-admin-tb-close" class="btn-group <?php echo $input->getCmd('view') ?>">
		<button class="btn "><i class="fa fa-times"></i><?php echo JText::_('PLAZART_TOOLBAR_CLOSE') ?></button>
	</div>
	<div id="plazart-admin-tb-help" class="btn-group <?php echo $input->getCmd('view') ?>">
		<button class="btn"><i class="fa fa-wheelchair"></i><?php echo JText::_('PLAZART_TOOLBAR_HELP') ?></button>
	</div>

</div>